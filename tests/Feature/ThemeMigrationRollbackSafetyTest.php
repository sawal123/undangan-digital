<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ThemeMigrationRollbackSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_up_does_not_overwrite_theme_created_manually_before_migration(): void
    {
        $category = Category::factory()->create();
        $eventTypeId = EventType::query()->where('key', 'wedding')->value('id');

        // Simulasikan environment "sebelum migration": hapus permanen theme
        // hasil migrate fresh agar path tema.wedding_blue belum pernah ada.
        Theme::query()->where('path', 'tema.wedding_blue')->forceDelete();

        // Theme Wedding Blue dibuat manual oleh admin, lengkap dengan thumbnail.
        $manualTheme = Theme::create([
            'nama' => 'Wedding Blue (Manual)',
            'category_id' => $category->id,
            'event_type_id' => $eventTypeId,
            'path' => 'tema.wedding_blue',
            'demo' => 'temademo.wedding_blue',
            'thumbnail' => 'thumbnail/manual.png',
        ]);

        // Undangan user sudah memakai theme manual tersebut.
        $data = Data::factory()->create([
            'theme_id' => $manualTheme->id,
            'event_type_id' => $eventTypeId,
            'title' => 'Undangan ' . Str::random(6),
            'slug' => 'undangan-' . Str::lower(Str::random(8)),
        ]);

        // Jalankan up(): tidak boleh menimpa record existing.
        $migration = require database_path('migrations/2026_08_25_000000_seed_quinceanera_wedding_blue_themes.php');
        $migration->up();

        // Record manual tidak berubah (nama & thumbnail tetap), tidak diduplikasi.
        $this->assertDatabaseHas('themes', [
            'id' => $manualTheme->id,
            'nama' => 'Wedding Blue (Manual)',
            'path' => 'tema.wedding_blue',
            'thumbnail' => 'thumbnail/manual.png',
        ]);

        $this->assertSame(1, Theme::query()->where('path', 'tema.wedding_blue')->count());

        // Undangan tetap terhubung ke theme yang sama.
        $this->assertDatabaseHas('data', ['id' => $data->id, 'theme_id' => $manualTheme->id]);
    }

    public function test_down_is_noop_and_keeps_theme_and_invitations_intact(): void
    {
        $category = Category::factory()->create();
        $eventTypeId = EventType::query()->where('key', 'wedding')->value('id');

        // Theme dari hasil up() migration (atau dibuat manual sebelumnya).
        $theme = Theme::create([
            'nama' => 'Wedding Blue',
            'category_id' => $category->id,
            'event_type_id' => $eventTypeId,
            'path' => 'tema.wedding_blue',
            'demo' => 'temademo.wedding_blue',
            'thumbnail' => null,
        ]);

        // Undangan user memakai tema tersebut.
        $data = Data::factory()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $eventTypeId,
            'title' => 'Undangan ' . Str::random(6),
            'slug' => 'undangan-' . Str::lower(Str::random(8)),
        ]);

        // Jalankan down(): no-op, tidak menghapus atau mengubah apa pun.
        $migration = require database_path('migrations/2026_08_25_000000_seed_quinceanera_wedding_blue_themes.php');
        $migration->down();

        // Theme tetap ada.
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'path' => 'tema.wedding_blue',
        ]);

        // Undangan tetap ada dan theme_id tetap terhubung.
        $this->assertDatabaseHas('data', [
            'id' => $data->id,
            'theme_id' => $theme->id,
        ]);

        $data->refresh();
        $this->assertSame($theme->id, $data->theme_id);
        $this->assertNotNull($data->title);
    }

    public function test_up_reactivates_soft_deleted_theme_instead_of_skipping_or_duplicating(): void
    {
        $category = Category::factory()->create();
        $eventTypeId = EventType::query()->where('key', 'wedding')->value('id');

        // Simulasikan environment "sebelum migration": hapus permanen theme
        // hasil migrate fresh agar path tema.wedding_blue belum pernah ada.
        Theme::query()->where('path', 'tema.wedding_blue')->forceDelete();

        // Theme Wedding Blue pernah ada, lalu di-soft-delete.
        $softDeletedTheme = Theme::create([
            'nama' => 'Wedding Blue (Lama)',
            'category_id' => $category->id,
            'event_type_id' => $eventTypeId,
            'path' => 'tema.wedding_blue',
            'demo' => 'temademo.wedding_blue',
            'thumbnail' => null,
        ]);
        $softDeletedTheme->delete();

        $this->assertNotNull($softDeletedTheme->fresh()->deleted_at);

        // Undangan user masih memakai theme yang soft-deleted tersebut.
        $data = Data::factory()->create([
            'theme_id' => $softDeletedTheme->id,
            'event_type_id' => $eventTypeId,
            'title' => 'Undangan ' . Str::random(6),
            'slug' => 'undangan-' . Str::lower(Str::random(8)),
        ]);

        // Jalankan up(): guard harus menganggap soft-deleted sebagai belum
        // terdaftar dan mengaktifkan kembali record lama (bukan insert baru).
        $migration = require database_path('migrations/2026_08_25_000000_seed_quinceanera_wedding_blue_themes.php');
        $migration->up();

        // Tidak ada duplikat: hanya satu theme dengan path tersebut.
        $this->assertSame(1, Theme::query()->withTrashed()->where('path', 'tema.wedding_blue')->count());

        // Record soft-deleted di-restore (deleted_at null) dengan id yang sama.
        $this->assertDatabaseHas('themes', [
            'id' => $softDeletedTheme->id,
            'path' => 'tema.wedding_blue',
            'deleted_at' => null,
        ]);

        // Undangan tetap terhubung ke theme yang sama (relasi data.theme_id aman).
        $this->assertDatabaseHas('data', ['id' => $data->id, 'theme_id' => $softDeletedTheme->id]);
    }
}
