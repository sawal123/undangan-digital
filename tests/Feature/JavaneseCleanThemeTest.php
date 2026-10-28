<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\GiftPay;
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

class JavaneseCleanThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_javanese_clean_route_renders_successfully(): void
    {
        $response = $this->get('/demo/temademo.javanese-clean');

        $response->assertStatus(200);
        $response->assertSee('Aditya &amp; Kirana', false);
        $response->assertSee('Buka Undangan', false);
        $response->assertSee('Akad Nikah &amp; Upacara Panggih', false);
        $response->assertSee('Pahargyan Resepsi', false);
        $response->assertSee('Tata Lampah Adicara', false);
        $response->assertSee('Cariyos Katresnan', false);
        $response->assertSee('Pawartos Foto &amp; Galeri', false);
        $response->assertSee('Amplop Digital &amp; Kado', false);
        $response->assertSee('Matur Nuwun', false);
    }

    public function test_demo_javanese_clean_legacy_slug_renders_successfully(): void
    {
        $response = $this->get('/demo/javanese-clean');

        $response->assertStatus(200);
        $response->assertSee('Aditya &amp; Kirana', false);
        $response->assertSee('btn-open-invitation', false);
    }

    public function test_javanese_clean_theme_is_registered_in_database(): void
    {
        $this->artisan('migrate');

        $theme = Theme::where('nama', 'Javanese Clean')->first();

        $this->assertNotNull($theme);
        $this->assertEquals('tema.javanese-clean', $theme->path);
        $this->assertEquals('temademo.javanese-clean', $theme->demo);
        $this->assertEquals('tema/javanese-clean/assets/images/couple-hero.webp', $theme->thumbnail);
    }

    public function test_javanese_clean_theme_renders_dynamic_invitation_with_complete_wedding_data(): void
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
            'nama' => 'Javanese Clean',
            'category_id' => $category->id,
            'event_type_id' => $weddingType->id,
            'path' => 'tema.javanese-clean',
            'demo' => 'temademo.javanese-clean',
            'thumbnail' => 'tema/javanese-clean/assets/images/couple-hero.webp',
        ]);

        $data = Data::factory()->active()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $weddingType->id,
            'title' => 'Pawiwahan Ageng Dimas & Anindya',
            'slug' => 'dimas-anindya',
            'urutan_mempelai' => 'pria_wanita',
        ]);

        Pria::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Raden Mas Dimas Prakoso, S.T.',
            'nama_panggilan' => 'Dimas',
            'deskripsi' => 'Putra pertama dari Bpk. Suryo & Ibu Endang',
            'instagram' => 'dimasprakoso',
            'image' => 'pengantin/dimas.jpg',
        ]);

        Wanita::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Raden Ajeng Anindya Larasati, S.Ked.',
            'nama_panggilan' => 'Anindya',
            'deskripsi' => 'Putri bungsu dari Bpk. Hartono & Ibu Sri',
            'instagram' => 'anindyalaras',
            'image' => 'pengantin/anindya.jpg',
        ]);

        $acara = Acara::create([
            'data_id' => $data->id,
            'nama_acara' => 'Ijab Qobul & Panggih Keraton',
            'date' => now()->addDays(25)->format('Y-m-d'),
            'jam_start' => '08:30',
            'jam_end' => '11:00',
            'zona_waktu' => 'WIB',
            'vanue' => 'Pendopo Ndalem Danurejan',
            'alamat' => 'Jl. Bausasran No. 10, Danurejan, Yogyakarta',
            'maps' => 'https://maps.google.com/?q=Danurejan',
        ]);

        Rundown::create([
            'data_id' => $data->id,
            'acara_id' => $acara->id,
            'nama_kegiatan' => 'Pasrah Panampi & Ijab Qobul',
            'waktu_mulai' => '08:30',
            'waktu_selesai' => '09:30',
            'lokasi' => 'Bale Utama',
            'keterangan' => 'Dimohon hadir tepat waktu',
            'is_active' => true,
        ]);

        KisahCinta::create([
            'data_id' => $data->id,
            'title' => 'Perjumpaan di Malioboro',
            'deskripsi' => 'Pertemuan tak sengaja di kala senja Jogja yang membekas di hati.',
        ]);

        FiturKado::create([
            'data_id' => $data->id,
            'isActive' => true,
            'alamat' => 'Ndalem Danurejan, Jl. Bausasran No. 10, Yogyakarta',
        ]);

        $giftPay = GiftPay::create([
            'nama_pay' => 'BCA',
            'icon' => 'kado/bca.png',
        ]);

        Kado::create([
            'data_id' => $data->id,
            'gift_id' => $giftPay->id,
            'namaPay' => 'Dimas Prakoso',
            'nomorPay' => '7391028472',
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
            'nama' => 'Gusti Kanjeng Ratu',
            'ucapan' => 'Nderek mangayubagyo, mugi dados kulawarga ingkang tansah pinaringan berkah lan tentrem.',
            'status' => 'hadir',
        ]);

        $response = $this->get('/u/dimas-anindya');

        $response->assertStatus(200);
        $response->assertSee('Dimas', false);
        $response->assertSee('Anindya', false);
        $response->assertSee('Raden Mas Dimas Prakoso, S.T.', false);
        $response->assertSee('Raden Ajeng Anindya Larasati, S.Ked.', false);
        $response->assertSee('Ijab Qobul &amp; Panggih Keraton', false);
        $response->assertSee('Pasrah Panampi &amp; Ijab Qobul', false);
        $response->assertSee('Pendopo Ndalem Danurejan', false);
        $response->assertSee('Perjumpaan di Malioboro', false);
        $response->assertSee('7391028472', false);
        $response->assertSee('Ndalem Danurejan', false);
        $response->assertSee('Nderek mangayubagyo', false);
    }

    public function test_javanese_clean_theme_renders_safely_with_minimal_data(): void
    {
        $weddingType = EventType::where('key', 'wedding')->first() ?? EventType::create([
            'name' => 'Pernikahan',
            'key' => 'wedding',
            'description' => 'Acara Pernikahan',
        ]);

        $category = Category::firstOrCreate(['id' => 1], [
            'name' => 'Nikah',
            'status' => 'active',
        ]);

        $theme = Theme::create([
            'nama' => 'Javanese Clean',
            'category_id' => $category->id,
            'event_type_id' => $weddingType->id,
            'path' => 'tema.javanese-clean',
            'demo' => 'temademo.javanese-clean',
            'thumbnail' => 'tema/javanese-clean/assets/images/couple-hero.webp',
        ]);

        $data = Data::factory()->active()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $weddingType->id,
            'title' => 'Pernikahan Minimal',
            'slug' => 'pernikahan-minimal',
        ]);

        $response = $this->get('/u/pernikahan-minimal');

        $response->assertStatus(200);
        $response->assertSee('Buka Undangan', false);
        $response->assertSee('Memayu Hayuning Bawana', false);
    }

    public function test_javanese_clean_theme_respects_wanita_first_order(): void
    {
        $weddingType = EventType::where('key', 'wedding')->first() ?? EventType::create([
            'name' => 'Pernikahan',
            'key' => 'wedding',
            'description' => 'Acara Pernikahan',
        ]);

        $category = Category::firstOrCreate(['id' => 1], [
            'name' => 'Nikah',
            'status' => 'active',
        ]);

        $theme = Theme::create([
            'nama' => 'Javanese Clean',
            'category_id' => $category->id,
            'event_type_id' => $weddingType->id,
            'path' => 'tema.javanese-clean',
            'demo' => 'temademo.javanese-clean',
            'thumbnail' => 'tema/javanese-clean/assets/images/couple-hero.webp',
        ]);

        $data = Data::factory()->active()->create([
            'theme_id' => $theme->id,
            'event_type_id' => $weddingType->id,
            'title' => 'Pernikahan Wanita Pertama',
            'slug' => 'wanita-pertama',
            'urutan_mempelai' => 'wanita_pria',
        ]);

        Pria::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Bagus Wicaksono',
            'nama_panggilan' => 'Bagus',
            'deskripsi' => 'Putra pertama dari Bpk. Wicaksono & Ibu Endang',
            'image' => 'pengantin/bagus.jpg',
        ]);

        Wanita::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Sekar Kinanti',
            'nama_panggilan' => 'Sekar',
            'deskripsi' => 'Putri bungsu dari Bpk. Hartono & Ibu Sri',
            'image' => 'pengantin/sekar.jpg',
        ]);

        $response = $this->get('/u/wanita-pertama');

        $response->assertStatus(200);
        $content = $response->getContent();

        $posSekar = strpos($content, 'Sekar Kinanti');
        $posBagus = strpos($content, 'Bagus Wicaksono');

        $this->assertNotFalse($posSekar);
        $this->assertNotFalse($posBagus);
        $this->assertLessThan($posBagus, $posSekar, 'Nama mempelai wanita harus muncul sebelum mempelai pria ketika urutan_mempelai adalah wanita_pria');
    }
}
