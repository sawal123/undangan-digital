<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\BirthdayProfile;
use App\Models\KelolaUndangan\EventDetail;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\GiftPay;
use App\Models\KelolaUndangan\Kado;
use App\Models\KelolaUndangan\Rundown;
use App\Models\KelolaUndangan\Ucapan;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AstronotThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_astronot_route_renders_successfully(): void
    {
        $response = $this->get('/demo/temademo.astronot');

        $response->assertStatus(200);
        $response->assertSee('Kapten Leo Pratama', false);
        $response->assertSee('Buka Akses Kontrol', false);
        $response->assertSee('Starlight Kids Cafe', false);
        $response->assertSee('Check-In Astronot', false);
        $response->assertSee('tema/astronot/assets/images/captain-avatar.webp', false);
        $response->assertSee('tema/astronot/assets/images/moon-cake.webp', false);
        $response->assertSee('tema/astronot/assets/images/rocket-launch.webp', false);
    }

    public function test_demo_astronot_legacy_slug_renders_successfully(): void
    {
        $response = $this->get('/demo/astronot');

        $response->assertStatus(200);
        $response->assertSee('Kapten Leo Pratama', false);
        $response->assertSee('openInvitationBtn', false);
    }

    public function test_astronot_theme_is_registered_in_database(): void
    {
        $this->artisan('migrate');

        $theme = Theme::where('nama', 'Astronot')->first();

        $this->assertNotNull($theme);
        $this->assertEquals('tema.astronot', $theme->path);
        $this->assertEquals('temademo.astronot', $theme->demo);
        $this->assertEquals(2, $theme->event_type_id);
        $this->assertEquals('tema/astronot/assets/images/captain-avatar.webp', $theme->thumbnail);
    }

    public function test_astronot_theme_renders_dynamic_invitation_with_complete_birthday_data(): void
    {
        $birthdayType = EventType::where('key', 'birthday')->first();
        if (! $birthdayType) {
            $birthdayType = EventType::create([
                'name' => 'Ulang Tahun',
                'key' => 'birthday',
                'description' => 'Acara Ulang Tahun',
            ]);
        }

        $category = Category::firstOrCreate(['category' => 'Ulang Tahun'], [
            'category' => 'Ulang Tahun',
            'icon' => 'cake',
        ]);

        $theme = Theme::create([
            'nama' => 'Astronot',
            'category_id' => $category->id,
            'event_type_id' => $birthdayType->id,
            'path' => 'tema.astronot',
            'demo' => 'temademo.astronot',
            'thumbnail' => 'tema/astronot/assets/images/captain-avatar.webp',
        ]);

        $data = Data::factory()->active()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $birthdayType->id,
            'title' => 'Misi Ulang Tahun Kenzie',
            'slug' => 'misi-kenzie-6',
        ]);

        BirthdayProfile::create([
            'data_id' => $data->id,
            'name' => 'Kenzie Rafandra',
            'nickname' => 'Kenzie',
            'age' => 6,
            'parent_name' => 'Bunda Sarah & Ayah Dimas',
            'description' => 'Ayo kawan-kawan, bergabung ke stasiun pesta luar angkasa Kenzie!',
            'photo' => 'birthday/kenzie.jpg',
        ]);

        EventDetail::create([
            'data_id' => $data->id,
            'headline' => 'Petualangan Antariksa Cilik',
            'dress_code' => 'Kaos Biru Kosmik',
        ]);

        $acara = Acara::create([
            'data_id' => $data->id,
            'nama_acara' => 'Pesta Peluncuran Roket',
            'date' => now()->addDays(15)->format('Y-m-d'),
            'jam_start' => '14:00',
            'jam_end' => '17:00',
            'zona_waktu' => 'WIB',
            'vanue' => 'Planetarium Mini Kidz',
            'alamat' => 'Jl. Galaksi Raya No. 10, Jakarta Selatan',
            'maps' => 'https://maps.google.com/?q=planetarium',
        ]);

        Rundown::create([
            'data_id' => $data->id,
            'acara_id' => $acara->id,
            'nama_kegiatan' => 'Lomba Desain Roket Bintang',
            'waktu_mulai' => '14:30',
            'waktu_selesai' => '15:15',
            'lokasi' => 'Area Main Utama',
            'keterangan' => 'Semua peserta mendapatkan miniatur roket',
            'is_active' => true,
        ]);

        FiturKado::create([
            'data_id' => $data->id,
            'isActive' => true,
            'alamat' => 'Jl. Perumahan Kosmik Indah Blok C2, Jakarta',
        ]);

        $giftPay = GiftPay::create([
            'nama_pay' => 'BCA',
            'icon' => 'kado/bca.png',
        ]);

        Kado::create([
            'data_id' => $data->id,
            'gift_id' => $giftPay->id,
            'namaPay' => 'Sarah Melinda',
            'nomorPay' => '7192830192',
            'qris' => null,
        ]);

        FiturUcapan::create([
            'data_id' => $data->id,
            'status' => true,
            'isActive' => true,
            'publicIsActive' => true,
        ]);

        Ucapan::create([
            'data_id' => $data->id,
            'nama' => 'Om Reno & Tante Dita',
            'ucapan' => 'Selamat ulang tahun ke-6 Kenzie sayang! Semoga selalu sehat & berprestasi!',
            'status' => 'hadir',
        ]);

        $response = $this->get('/u/misi-kenzie-6');

        $response->assertStatus(200);
        $response->assertSee('Kenzie Rafandra', false);
        $response->assertSee('Bunda Sarah &amp; Ayah Dimas', false);
        $response->assertSee('Petualangan Antariksa Cilik', false);
        $response->assertSee('Planetarium Mini Kidz', false);
        $response->assertSee('Kaos Biru Kosmik', false);
        $response->assertSee('Lomba Desain Roket Bintang', false);
        $response->assertSee('7192830192', false);
        $response->assertSee('Sarah Melinda', false);
        $response->assertSee('Selamat ulang tahun ke-6 Kenzie sayang!', false);
    }

    public function test_astronot_theme_renders_safely_with_minimal_data(): void
    {
        $birthdayType = EventType::where('key', 'birthday')->first();
        if (! $birthdayType) {
            $birthdayType = EventType::create([
                'name' => 'Ulang Tahun',
                'key' => 'birthday',
                'description' => 'Acara Ulang Tahun',
            ]);
        }

        $category = Category::firstOrCreate(['category' => 'Ulang Tahun'], [
            'category' => 'Ulang Tahun',
            'icon' => 'cake',
        ]);

        $theme = Theme::create([
            'nama' => 'Astronot',
            'category_id' => $category->id,
            'event_type_id' => $birthdayType->id,
            'path' => 'tema.astronot',
            'demo' => 'temademo.astronot',
            'thumbnail' => 'tema/astronot/assets/images/captain-avatar.webp',
        ]);

        $data = Data::factory()->active()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $birthdayType->id,
            'title' => 'Ulang Tahun Sederhana',
            'slug' => 'ultah-sederhana',
        ]);

        $response = $this->get('/u/ultah-sederhana');

        $response->assertStatus(200);
        $response->assertSee('Ulang Tahun Sederhana', false);
        $response->assertSee('openInvitationBtn', false);
    }
}
