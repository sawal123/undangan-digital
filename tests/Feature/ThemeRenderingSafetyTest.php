<?php

namespace Tests\Feature;

use App\Livewire\AdminDemo\ThemeDemo;
use App\Models\Category;
use App\Models\Data;
use App\Models\DataFonts;
use App\Models\Fonts;
use App\Models\GiftPay;
use App\Models\KelolaUndangan\Acara;
use App\Models\KelolaUndangan\BirthdayProfile;
use App\Models\KelolaUndangan\EventDetail;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Galery;
use App\Models\KelolaUndangan\ImgKisahCinta;
use App\Models\KelolaUndangan\Kado;
use App\Models\KelolaUndangan\KisahCinta;
use App\Models\KelolaUndangan\Pria;
use App\Models\KelolaUndangan\Qoute;
use App\Models\KelolaUndangan\Sound;
use App\Models\KelolaUndangan\Streaming;
use App\Models\KelolaUndangan\ThumbnailWa;
use App\Models\KelolaUndangan\Wanita;
use App\Models\Setting;
use App\Models\teksPenutup;
use App\Models\TeksUndangan;
use App\Models\Theme;
use App\Models\coverUndangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class ThemeRenderingSafetyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Path Blade untuk seluruh 10 theme yang wajib tetap render.
     */
    protected function themePaths(): array
    {
        return [
            'darksweet' => 'tema.darksweet.darksweet',
            'darkpre' => 'tema.darkpre.darkpre',
            'whitepre' => 'tema.whitepre.whitepre',
            'flowerone' => 'tema.flowerone.flowerone',
            'standtheme' => 'tema.standtheme.standtheme',
            'deepone' => 'tema.deepone',
            'deepone-pink' => 'tema.deepone-pink',
            'logangold' => 'tema.logangold',
            'mahligai' => 'tema.mahligai',
            'spiderman' => 'tema.spiderman.ultah-induk',
        ];
    }

    protected function createTheme(string $path): Theme
    {
        $category = Category::factory()->create();
        $eventTypeId = \App\Models\EventType::query()->where('key', 'wedding')->value('id');

        return Theme::create([
            'nama' => 'Tema ' . Str::afterLast($path, '.'),
            'category_id' => $category->id,
            'event_type_id' => $eventTypeId,
            'path' => $path,
            'demo' => $path,
            'thumbnail' => null,
        ]);
    }

    protected function createData(string $themePath, bool $active = true): Data
    {
        $theme = $this->createTheme($themePath);

        $factory = Data::factory();
        if ($active) {
            $factory = $factory->active();
        }

        return $factory->create([
            'theme_id' => $theme->id,
            'title' => 'Undangan ' . Str::afterLast($themePath, '.'),
            'slug' => 'undangan-' . Str::lower(Str::random(8)),
        ]);
    }

    protected function createCompleteRelations(Data $data): void
    {
        Model::unguard();

        Pria::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Teddy Prakarsa',
            'nama_panggilan' => 'Teddy',
            'deskripsi' => 'Putra pertama',
            'image' => 'pengantin/pria.jpg',
        ]);

        Wanita::create([
            'data_id' => $data->id,
            'nama_lengkap' => 'Ajeng Febian',
            'nama_panggilan' => 'Ajeng',
            'deskripsi' => 'Putri pertama',
            'image' => 'pengantin/wanita.jpg',
        ]);

        Acara::create([
            'data_id' => $data->id,
            'nama_acara' => 'Akad Nikah',
            'vanue' => 'Gedung Mawar',
            'alamat' => 'Jl. Mawar No. 1',
            'date' => '2026-08-14',
            'jam_start' => '09:00',
            'jam_end' => '11:00',
            'zona_waktu' => 'WIB',
            'maps' => 'https://maps.google.com/?q=jakarta',
        ]);

        Acara::create([
            'data_id' => $data->id,
            'nama_acara' => 'Resepsi',
            'vanue' => 'Gedung Melati',
            'alamat' => 'Jl. Melati No. 2',
            'date' => '2026-08-15',
            'jam_start' => '13:00',
            'jam_end' => 'Selesai',
            'zona_waktu' => 'WIB',
            'maps' => null,
        ]);

        Galery::create(['data_id' => $data->id, 'poto' => 'gallery/a.jpg', 'video' => null]);
        Galery::create(['data_id' => $data->id, 'poto' => 'gallery/b.jpg', 'video' => null]);
        Galery::create(['data_id' => $data->id, 'poto' => null, 'video' => 'https://www.youtube.com/embed/abc123']);

        Sound::create(['data_id' => $data->id, 'sound' => 'https://youtu.be/sound', 'start' => 0, 'isActive' => true]);

        FiturUcapan::create([
            'data_id' => $data->id,
            'isActive' => true,
            'publicIsActive' => true,
            'viewIsActive' => true,
        ]);

        Streaming::create(['data_id' => $data->id, 'link' => 'https://youtube.com/live/stream', 'isActive' => true]);

        FiturKado::create(['data_id' => $data->id, 'isActive' => true]);

        $giftPay = GiftPay::create(['nama_pay' => 'BCA', 'icon' => 'kado/bca.png']);
        Kado::create([
            'data_id' => $data->id,
            'gift_id' => $giftPay->id,
            'namaPay' => 'Teddy',
            'nomorPay' => '1234567890',
            'qris' => 'kado/qris.png',
        ]);

        $kisah = KisahCinta::create([
            'data_id' => $data->id,
            'title' => 'Pertama Bertemu',
            'deskripsi' => 'Kisah pertama kami.',
        ]);
        ImgKisahCinta::create(['data_id' => $data->id, 'kisah_id' => $kisah->id, 'image' => 'kisah/kisah.jpg']);

        $titleFont = Fonts::create(['nama' => 'Dancing Script', 'link' => 'https://fonts.googleapis.com/css2?family=Dancing+Script', 'is_active' => true]);
        $subFont = Fonts::create(['nama' => 'Capriola', 'link' => 'https://fonts.googleapis.com/css2?family=Capriola', 'is_active' => true]);
        DataFonts::create([
            'data_id' => $data->id,
            'f_title' => $titleFont->id,
            'f_sub' => $subFont->id,
            's_title' => 40,
            's_sub' => 16,
        ]);

        ThumbnailWa::create(['data_id' => $data->id, 'thumbnail' => 'thumbnail/wa.jpg']);
        TeksUndangan::create([
            'data_id' => $data->id,
            'pembuka' => 'Assalamualaikum warahmatullahi wabarakatuh.',
            'acara' => 'Kami mengundang anda ke acara kami.',
            'penutup' => 'Terima kasih.',
        ]);
        coverUndangan::create(['data_id' => $data->id, 'cover_satu' => 'cover/satu.jpg', 'cover_dua' => 'cover/dua.jpg']);
        Setting::create(['data_id' => $data->id, 'acara' => 'The Wedding', 'subacara' => 'Akad & Resepsi']);
        Qoute::create([
            'data_id' => $data->id,
            'title' => 'بِسْمِ اللهِ الرَّحْمٰنِ الرَّحِيْمِ',
            'qoute' => 'Dan di antara tanda-tanda kebesaran-Nya...',
            'subtitle' => 'QS. Ar-Rum: 21',
        ]);
        teksPenutup::create(['data_id' => $data->id, 'hormat_kami' => 'Keluarga Besar', 'mengundang' => 'Keluarga besar kedua mempelai']);
        BirthdayProfile::create([
            'data_id' => $data->id,
            'name' => 'Teddy',
            'nickname' => 'Teddy',
            'age' => 1,
            'parent_name' => 'Orang Tua',
            'description' => null,
            'photo' => 'birthday/photo.jpg',
        ]);
        EventDetail::create([
            'data_id' => $data->id,
            'headline' => 'Happy Birthday',
            'host_name' => 'Keluarga',
            'speaker_name' => null,
            'dress_code' => null,
            'description' => null,
            'image' => null,
        ]);

        Model::reguard();
    }

    protected function visitSlug(Data $data): string
    {
        return route('visit', ['slug' => $data->slug]);
    }

    public function test_all_ten_themes_render_with_minimal_data(): void
    {
        foreach ($this->themePaths() as $name => $path) {
            $data = $this->createData($path);

            $response = $this->get($this->visitSlug($data));

            $this->assertSame(200, $response->getStatusCode(), "Theme {$name} gagal render dengan data minimal: {$response->getContent()}");
        }
    }

    public function test_all_ten_themes_render_with_partial_data(): void
    {
        foreach ($this->themePaths() as $name => $path) {
            $data = $this->createData($path);

            Model::unguard();
            Pria::create([
                'data_id' => $data->id,
                'nama_lengkap' => 'Teddy Prakarsa',
                'nama_panggilan' => 'Teddy',
                'deskripsi' => 'Putra pertama',
                'image' => 'pengantin/pria.jpg',
            ]);
            Wanita::create([
                'data_id' => $data->id,
                'nama_lengkap' => 'Ajeng Febian',
                'nama_panggilan' => 'Ajeng',
                'deskripsi' => 'Putri pertama',
                'image' => 'pengantin/wanita.jpg',
            ]);
            Acara::create([
                'data_id' => $data->id,
                'nama_acara' => 'Akad Nikah',
                'vanue' => 'Gedung Mawar',
                'alamat' => 'Jl. Mawar No. 1',
                'date' => '2026-08-14',
                'jam_start' => '09:00',
                'jam_end' => '11:00',
                'zona_waktu' => 'WIB',
                'maps' => null,
            ]);
            Model::reguard();

            $response = $this->get($this->visitSlug($data));

            $this->assertSame(200, $response->getStatusCode(), "Theme {$name} gagal render dengan data partial: {$response->getContent()}");
        }
    }

    public function test_all_ten_themes_render_with_complete_data(): void
    {
        foreach ($this->themePaths() as $name => $path) {
            $data = $this->createData($path);
            $this->createCompleteRelations($data);

            $response = $this->get($this->visitSlug($data));

            $this->assertSame(200, $response->getStatusCode(), "Theme {$name} gagal render dengan data lengkap: {$response->getContent()}");
        }
    }

    public function test_darksweet_renders_with_gallery_of_zero_to_three_photos(): void
    {
        foreach ([0, 1, 2, 3] as $count) {
            $data = $this->createData('tema.darksweet.darksweet');

            Model::unguard();
            for ($i = 1; $i <= $count; $i++) {
                Galery::create(['data_id' => $data->id, 'poto' => "gallery/p{$i}.jpg", 'video' => null]);
            }
            Model::reguard();

            $response = $this->get($this->visitSlug($data));

            $this->assertSame(200, $response->getStatusCode(), "darksweet gagal render dengan {$count} foto: {$response->getContent()}");
            $this->assertStringNotContainsString('Undefined array key', (string) $response->getContent());
            $this->assertStringNotContainsString('Attempt to read property', (string) $response->getContent());
        }
    }

    public function test_sparse_gallery_indexes_are_normalized(): void
    {
        $data = $this->createData('tema.darksweet.darksweet');

        // Baris kosong, baris khusus video, lalu dua foto => sebelum values(),
        // index $poto dimulai dari 2 sehingga $poto[0] tidak terdefinisi.
        Model::unguard();
        Galery::create(['data_id' => $data->id, 'poto' => null, 'video' => null]);
        Galery::create(['data_id' => $data->id, 'poto' => null, 'video' => 'https://www.youtube.com/embed/sparse1']);
        Galery::create(['data_id' => $data->id, 'poto' => 'gallery/p1.jpg', 'video' => null]);
        Galery::create(['data_id' => $data->id, 'poto' => 'gallery/p2.jpg', 'video' => null]);
        Model::reguard();

        $response = $this->get($this->visitSlug($data));

        $this->assertSame(200, $response->getStatusCode(), 'darksweet gagal render dengan galeri sparse: ' . $response->getContent());
        $this->assertStringContainsString('storage/gallery/p1.jpg', $response->getContent());
        $this->assertStringContainsString('storage/gallery/p2.jpg', $response->getContent());
        $this->assertStringContainsString('https://www.youtube.com/embed/sparse1', $response->getContent());
    }

    public function test_theme_store_and_update_reject_invalid_view_paths(): void
    {
        $category = Category::factory()->create();
        $eventTypeId = \App\Models\EventType::query()->where('key', 'wedding')->value('id');

        Livewire::test(ThemeDemo::class)
            ->set('nama', 'Tema Baru')
            ->set('category_id', $category->id)
            ->set('event_type_id', (string) $eventTypeId)
            ->set('path', 'tema.tidak.ada')
            ->set('demo', 'temademo.darksweet')
            ->call('store')
            ->assertHasErrors(['path']);

        $this->assertDatabaseMissing('themes', ['nama' => 'Tema Baru']);

        // Demo dynamic theme (tema.*) ditolak walau view-nya ada.
        Livewire::test(ThemeDemo::class)
            ->set('nama', 'Tema Baru')
            ->set('category_id', $category->id)
            ->set('event_type_id', (string) $eventTypeId)
            ->set('path', 'tema.darksweet.darksweet')
            ->set('demo', 'tema.darkpre.darkpre')
            ->call('store')
            ->assertHasErrors(['demo']);

        $this->assertDatabaseMissing('themes', ['nama' => 'Tema Baru']);

        // Demo temademo.* yang tidak ada tetap ditolak.
        Livewire::test(ThemeDemo::class)
            ->set('nama', 'Tema Baru')
            ->set('category_id', $category->id)
            ->set('event_type_id', (string) $eventTypeId)
            ->set('path', 'tema.darksweet.darksweet')
            ->set('demo', 'temademo.tidak.ada')
            ->call('store')
            ->assertHasErrors(['demo']);

        $this->assertDatabaseMissing('themes', ['nama' => 'Tema Baru']);

        $theme = $this->createTheme('tema.darksweet.darksweet');

        Livewire::test(ThemeDemo::class)
            ->set('theme_id', $theme->id)
            ->set('nama', 'Tema Diubah')
            ->set('category_id', $category->id)
            ->set('event_type_id', (string) $eventTypeId)
            ->set('path', 'tema.tidak.ada.lagi')
            ->set('demo', '')
            ->call('update')
            ->assertHasErrors(['path']);

        $this->assertDatabaseHas('themes', ['id' => $theme->id, 'path' => 'tema.darksweet.darksweet']);
    }

    public function test_theme_store_accepts_valid_view_paths(): void
    {
        $category = Category::factory()->create();
        $eventTypeId = \App\Models\EventType::query()->where('key', 'wedding')->value('id');

        $this->assertDatabaseCount('themes', 1); // hanya theme bawaan seeder migrasi spiderman

        Livewire::test(ThemeDemo::class)
            ->set('nama', 'Tema Valid')
            ->set('category_id', $category->id)
            ->set('event_type_id', (string) $eventTypeId)
            ->set('path', 'tema.darksweet.darksweet')
            ->set('demo', 'temademo.darksweet')
            ->call('store')
            ->assertHasNoErrors(['path', 'demo']);

        $this->assertDatabaseHas('themes', [
            'nama' => 'Tema Valid',
            'path' => 'tema.darksweet.darksweet',
            'demo' => 'temademo.darksweet',
        ]);
    }

    /**
     * Theme yang wajib mendukung player musik bersama.
     */
    protected function musicThemePaths(): array
    {
        return [
            'deepone' => 'tema.deepone',
            'deepone-pink' => 'tema.deepone-pink',
            'logangold' => 'tema.logangold',
            'mahligai' => 'tema.mahligai',
        ];
    }

    protected function createSound(Data $data, ?string $sound, int $start = 0, bool $isActive = true): void
    {
        Sound::create([
            'data_id' => $data->id,
            'sound' => $sound,
            'start' => $start,
            'isActive' => $isActive,
        ]);
    }

    public function test_music_themes_render_when_sound_missing_or_inactive(): void
    {
        foreach ($this->musicThemePaths() as $name => $path) {
            $data = $this->createData($path);
            $response = $this->get($this->visitSlug($data));
            $this->assertSame(200, $response->getStatusCode(), "{$name} gagal render tanpa sound: " . $response->getContent());
            $this->assertStringNotContainsString('id="musicToggle"', (string) $response->getContent());

            $this->createSound($data, 'musik/lagu.mp3', 0, false);
            $response = $this->get($this->visitSlug($data));
            $this->assertSame(200, $response->getStatusCode(), "{$name} gagal render dengan sound nonaktif: " . $response->getContent());
            $this->assertStringNotContainsString('id="musicToggle"', (string) $response->getContent());
        }
    }

    public function test_music_themes_render_direct_audio_url_without_storage_prefix(): void
    {
        foreach ($this->musicThemePaths() as $name => $path) {
            $data = $this->createData($path);
            $this->createSound($data, 'https://cdn.example.com/lagu.mp3', 15);

            $response = $this->get($this->visitSlug($data));
            $content = (string) $response->getContent();

            $this->assertSame(200, $response->getStatusCode(), "{$name} gagal render dengan direct audio URL: " . $content);
            $this->assertStringContainsString('id="bgMusic"', $content);
            $this->assertStringContainsString('src="https://cdn.example.com/lagu.mp3"', $content);
            $this->assertStringContainsString('data-start="15"', $content);
            $this->assertStringNotContainsString('storage/https://cdn.example.com', $content);
        }
    }

    public function test_music_themes_use_storage_url_for_local_audio_path(): void
    {
        foreach ($this->musicThemePaths() as $name => $path) {
            $data = $this->createData($path);
            $this->createSound($data, 'musik/lagu.mp3', 0);

            $response = $this->get($this->visitSlug($data));
            $content = (string) $response->getContent();

            $this->assertSame(200, $response->getStatusCode(), "{$name} gagal render dengan local audio path: " . $content);
            $this->assertStringContainsString('id="bgMusic"', $content);
            $this->assertStringContainsString('/storage/musik/lagu.mp3', $content);
        }
    }

    public function test_music_themes_do_not_put_youtube_embed_url_into_audio_tag(): void
    {
        foreach ($this->musicThemePaths() as $name => $path) {
            $data = $this->createData($path);
            $this->createSound($data, 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0);

            $response = $this->get($this->visitSlug($data));
            $content = (string) $response->getContent();

            $this->assertSame(200, $response->getStatusCode(), "{$name} gagal render dengan URL embed YouTube: " . $content);
            $this->assertStringNotContainsString('<audio', $content);
            $this->assertStringContainsString('id="bgMusicFrame"', $content);
            $this->assertStringContainsString('youtube.com/embed/dQw4w9WgXcQ', $content);
        }
    }

    public function test_music_themes_youtube_source_produces_valid_player(): void
    {
        foreach ($this->musicThemePaths() as $name => $path) {
            $data = $this->createData($path);
            $this->createSound($data, 'https://youtu.be/dQw4w9WgXcQ', 45);

            $response = $this->get($this->visitSlug($data));
            $content = (string) $response->getContent();

            $this->assertSame(200, $response->getStatusCode(), "{$name} gagal render dengan URL YouTube pendek: " . $content);
            $this->assertStringNotContainsString('<audio', $content);
            $this->assertStringContainsString('id="bgMusicFrame"', $content);
            $this->assertStringContainsString('youtube.com/embed/dQw4w9WgXcQ?start=45', $content);
        }
    }
}
