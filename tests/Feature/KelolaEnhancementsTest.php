<?php

namespace Tests\Feature;

use App\Livewire\DashboardDemo\Kelola\Acara as AcaraComponent;
use App\Livewire\DashboardDemo\Kelola\Setting as SettingComponent;
use App\Livewire\DashboardDemo\Kelola\Tamu as TamuComponent;
use App\Livewire\DashboardDemo\Kelola\Tema as TemaComponent;
use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Wanita;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class KelolaEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithInvitation(): array
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');

        $cat = Category::firstOrCreate(['category' => 'Wedding']);
        $ev = EventType::where('key', 'wedding')->first() ?? EventType::create(['name' => 'Pernikahan', 'key' => 'wedding']);

        $theme = Theme::create([
            'nama' => 'Test Theme',
            'category_id' => $cat->id,
            'event_type_id' => $ev->id,
            'path' => 'tema.wedding_blue',
            'demo' => 'theme-test',
        ]);

        $data = Data::create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'event_type_id' => $ev->id,
            'category_id' => $cat->id,
            'title' => 'The Wedding Putri & Jimmi',
            'slug' => 'putri-dan-jimmi-' . \Illuminate\Support\Str::random(6),
            'isActive' => true,
        ]);

        Pria::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Jimmi Hendrix',
            'nama_panggilan' => 'Jimmi',
            'deskripsi' => 'Putra Bpk Polan & Ibu Paulani',
            'image' => 'pria.jpg',
        ]);

        Wanita::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Putri Ayu',
            'nama_panggilan' => 'Putri',
            'deskripsi' => 'Putri Bpk Polan & Ibu Paulani',
            'image' => 'wanita.jpg',
        ]);

        return [$user, $data];
    }

    public function test_acara_maps_iframe_embed_is_automatically_sanitized(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        $iframeInput = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345!2d106.8!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sen!2sid!4v123456789" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';

        Livewire::test(AcaraComponent::class, ['id' => $data->uid])
            ->set('acara', 'Akad Nikah')
            ->set('vanue', 'Masjid Agung')
            ->set('alamat', 'Jl. Sudirman No. 1')
            ->set('date', '2026-12-12')
            ->set('start', '08:00')
            ->set('maps', $iframeInput)
            ->call('save')
            ->assertHasNoErrors();

        $savedAcara = Acara::where('data_id', $data->id)->first();
        $this->assertNotNull($savedAcara);
        $this->assertStringNotContainsString('<iframe', $savedAcara->maps);
        $this->assertStringStartsWith('https://www.google.com/maps/embed', $savedAcara->maps);
    }

    public function test_acara_generate_maps_from_address_helper(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        Livewire::test(AcaraComponent::class, ['id' => $data->uid])
            ->set('vanue', 'Hotel Mulia Senayan')
            ->set('alamat', 'Jl. Asia Afrika, Jakarta Pusat')
            ->call('generateMapsFromAddress')
            ->assertSet('maps', 'https://www.google.com/maps/search/?api=1&query=Hotel+Mulia+Senayan%2C+Jl.+Asia+Afrika%2C+Jakarta+Pusat');
    }

    public function test_tamu_export_csv_downloads_valid_stream(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        Tamu::create([
            'data_id' => $data->id,
            'nama' => 'Budi Santoso',
            'kode' => 'abc123xyz789',
            'nomor' => '628123456789',
            'slug' => 'budi-santoso',
        ]);

        $response = Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->call('exportCsv');

        $response->assertFileDownloaded();
    }

    public function test_tamu_import_csv_creates_guests_correctly(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        $csvContent = "Nama,WhatsApp\nAgus Supriadi,081234567890\nDewi Sartika,628987654321\n";
        $file = UploadedFile::fake()->createWithContent('guests.csv', $csvContent);

        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->set('csvFile', $file)
            ->call('importCsv')
            ->assertHasNoErrors()
            ->assertSee('Berhasil mengimpor 2 tamu baru.');

        $this->assertDatabaseHas('tamus', [
            'data_id' => $data->id,
            'nama' => 'Agus Supriadi',
            'nomor' => '6281234567890',
        ]);

        $this->assertDatabaseHas('tamus', [
            'data_id' => $data->id,
            'nama' => 'Dewi Sartika',
            'nomor' => '628987654321',
        ]);
    }

    public function test_setting_auto_generate_slug_creates_unique_slug(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        Livewire::test(SettingComponent::class, ['id' => $data->uid])
            ->call('generateSlug')
            ->assertSet('slug', 'jimmi-putri');

        // Create an existing collision
        Data::create([
            'user_id' => $user->id,
            'title' => 'Other',
            'slug' => 'jimmi-putri',
            'isActive' => true,
        ]);

        Livewire::test(SettingComponent::class, ['id' => $data->uid])
            ->call('generateSlug')
            ->assertSet('slug', 'jimmi-putri-1');
    }

    public function test_tema_category_filtering(): void
    {
        [$user, $data] = $this->createUserWithInvitation();
        $this->actingAs($user);

        $cat1 = Category::firstOrCreate(['category' => 'Wedding']);
        $cat2 = Category::firstOrCreate(['category' => 'Floral']);

        Theme::create(['nama' => 'Theme A', 'category_id' => $cat1->id, 'path' => 'tema.wedding_blue', 'demo' => 'theme-a']);
        Theme::create(['nama' => 'Theme B', 'category_id' => $cat2->id, 'path' => 'tema.flowerone', 'demo' => 'theme-b']);

        Livewire::test(TemaComponent::class, ['id' => $data->uid])
            ->call('setCategory', (string) $cat2->id)
            ->assertSet('selectedCategory', (string) $cat2->id)
            ->assertViewHas('tema', function ($themes) use ($cat2) {
                return $themes->every(fn($t) => $t->category_id === $cat2->id);
            });
    }
}
