<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Kado;
use App\Models\KelolaUndangan\KisahCinta;
use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Rundown;
use App\Models\KelolaUndangan\Ucapan;
use App\Models\KelolaUndangan\Wanita;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CelebrateThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_celebrate_route_renders_successfully(): void
    {
        $response = $this->get('/demo/temademo.celebrate');

        $response->assertStatus(200);
        $response->assertSee('Vino &amp; Ivelle', false);
        $response->assertSee('Buka Undangan', false);
        $response->assertSee('Akad Nikah', false);
        $response->assertSee('Resepsi Pernikahan', false);
        $response->assertSee('tema/celebrate/assets/images/couple-hero.webp', false);
        $response->assertSee('tema/celebrate/assets/images/groom.webp', false);
        $response->assertSee('tema/celebrate/assets/images/bride.webp', false);
    }

    public function test_demo_celebrate_legacy_slug_renders_successfully(): void
    {
        $response = $this->get('/demo/celebrate');

        $response->assertStatus(200);
        $response->assertSee('Vino &amp; Ivelle', false);
        $response->assertSee('step-inside-btn', false);
    }

    public function test_celebrate_theme_is_registered_in_database(): void
    {
        $this->artisan('migrate');

        $theme = Theme::where('nama', 'Celebrate')->first();

        $this->assertNotNull($theme);
        $this->assertEquals('tema.celebrate', $theme->path);
        $this->assertEquals('temademo.celebrate', $theme->demo);
        $this->assertEquals('tema/celebrate/assets/images/couple-hero.webp', $theme->thumbnail);
    }

    public function test_celebrate_theme_renders_dynamic_invitation_with_complete_wedding_data(): void
    {
        $weddingType = EventType::where('key', 'wedding')->first();
        if (! $weddingType) {
            $weddingType = EventType::create([
                'name' => 'Pernikahan',
                'key' => 'wedding',
                'description' => 'Acara Pernikahan',
            ]);
        }

        $category = Category::firstOrCreate(['id' => 1], [
            'name' => 'Nikah',
            'status' => 'active',
        ]);

        $theme = Theme::create([
            'nama' => 'Celebrate',
            'category_id' => $category->id,
            'event_type_id' => $weddingType->id,
            'path' => 'tema.celebrate',
            'demo' => 'temademo.celebrate',
            'thumbnail' => 'tema/celebrate/assets/images/couple-hero.webp',
        ]);

        $data = Data::factory()->active()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $weddingType->id,
            'title' => 'The Wedding of Kevin & Sheila',
            'slug' => 'kevin-sheila',
            'urutan_mempelai' => 'pria_wanita',
        ]);

        Pria::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Kevin Sanjaya, S.T.',
            'nama_panggilan' => 'Kevin',
            'deskripsi' => 'Putra pertama dari Bpk. Hendra & Ibu Liliana',
            'instagram' => 'kevinsanjaya',
            'image' => 'pengantin/pria.jpg',
        ]);

        Wanita::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Sheila Maharani, S.Ds.',
            'nama_panggilan' => 'Sheila',
            'deskripsi' => 'Putri kedua dari Bpk. Surya & Ibu Ratna',
            'instagram' => 'sheilamhrn',
            'image' => 'pengantin/wanita.jpg',
        ]);

        $acara = Acara::create([
            'data_id' => $data->id,
            'nama_acara' => 'Akad Nikah Suci',
            'date' => now()->addDays(20)->format('Y-m-d'),
            'jam_start' => '08:00',
            'jam_end' => '10:00',
            'zona_waktu' => 'WIB',
            'vanue' => 'Masjid Raya Al-Hikmah',
            'alamat' => 'Jl. Mawar No. 12, Surabaya',
            'maps' => 'https://maps.google.com',
        ]);

        Rundown::create([
            'data_id' => $data->id,
            'acara_id' => $acara->id,
            'nama_kegiatan' => 'Ijab Qobul & Doa Bersama',
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:15',
            'lokasi' => 'Ruang Utama',
            'keterangan' => 'Hadir 15 menit sebelum acara dimulai',
            'is_active' => true,
        ]);

        KisahCinta::create([
            'data_id' => $data->id,
            'title' => 'Pertemuan di Bangku Kuliah',
            'deskripsi' => 'Kami pertama kali bertemu pada tahun 2018 di perpustakaan kampus.',
        ]);

        FiturKado::create([
            'data_id' => $data->id,
            'isActive' => true,
            'alamat' => 'Jl. Raya Darmo Indah No. 45, Surabaya',
        ]);

        $giftPay = \App\Models\GiftPay::create([
            'nama_pay' => 'BCA',
            'icon' => 'kado/bca.png',
        ]);

        Kado::create([
            'data_id' => $data->id,
            'gift_id' => $giftPay->id,
            'namaPay' => 'Kevin Sanjaya',
            'nomorPay' => '8291039481',
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
            'nama' => 'Budi Santoso',
            'ucapan' => 'Selamat menempuh hidup baru Kevin & Sheila!',
            'status' => 'hadir',
        ]);

        $response = $this->get('/u/kevin-sheila');

        $response->assertStatus(200);
        $response->assertSee('Kevin', false);
        $response->assertSee('Sheila', false);
        $response->assertSee('Kevin Sanjaya, S.T.', false);
        $response->assertSee('Sheila Maharani, S.Ds.', false);
        $response->assertSee('Akad Nikah Suci', false);
        $response->assertSee('Ijab Qobul &amp; Doa Bersama', false);
        $response->assertSee('Masjid Raya Al-Hikmah', false);
        $response->assertSee('Pertemuan di Bangku Kuliah', false);
        $response->assertSee('8291039481', false);
        $response->assertSee('Selamat menempuh hidup baru Kevin &amp; Sheila!', false);
    }
}
