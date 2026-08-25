<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class ThemeMigrationRollbackSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_rollback_seed_migration_keeps_user_invitations(): void
    {
        $category = Category::factory()->create();
        $eventTypeId = EventType::query()->where('key', 'wedding')->value('id');

        // Tema dari migrasi seeder (path sudah didaftarkan migrasi saat migrate fresh).
        $theme = Theme::query()->where('path', 'tema.wedding_blue')->firstOrFail();

        // Undangan user memakai tema tersebut.
        $data = Data::factory()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $eventTypeId,
            'title' => 'Undangan ' . Str::random(6),
            'slug' => 'undangan-' . Str::lower(Str::random(8)),
        ]);

        // Simulasi rollback migrasi seeder: down() hanya boleh melepas theme_id,
        // bukan menghapus undangan (FK cascade).
        $migration = require database_path('migrations/2026_08_25_000000_seed_quinceanera_wedding_blue_themes.php');
        $migration->down();

        // Tema dihapus (tidak ada lagi di tabel themes)...
        $this->assertDatabaseMissing('themes', ['id' => $theme->id]);

        // ...tetapi undangan user tetap ada, hanya kehilangan pilihan tema.
        $this->assertDatabaseHas('data', ['id' => $data->id]);
        $this->assertDatabaseHas('data', ['id' => $data->id, 'theme_id' => null]);

        $data->refresh();
        $this->assertNull($data->theme_id);
        $this->assertNotNull($data->title);
    }
}
