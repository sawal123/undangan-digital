<?php

namespace Tests\Feature;

use App\Livewire\AdminDemo\SystemSettingDemo;
use App\Models\SystemSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Tests\TestCase;

class SystemSettingContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::forget('system_settings.main');
    }

    protected function tearDown(): void
    {
        Cache::forget('system_settings.main');
        parent::tearDown();
    }

    public function test_landing_page_renders_when_contact_info_is_empty(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee('wa.me/', false);
        $response->assertDontSee('mailto:', false);
        $response->assertDontSee('instagram.com', false);
        $response->assertDontSee('facebook.com', false);
        $response->assertDontSee('tiktok.com', false);
    }

    public function test_landing_page_shows_contact_info_from_system_setting(): void
    {
        $setting = SystemSetting::current();
        $setting->update([
            'whatsapp' => '6281234567890',
            'email' => 'halo@wayaenikah.id',
            'address' => 'Jl. Contoh No. 1, Yogyakarta',
            'instagram' => 'wayaenikah',
            'facebook' => 'https://facebook.com/wayaenikah',
            'tiktok' => null,
        ]);
        Cache::forget('system_settings.main');

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('https://wa.me/6281234567890', false);
        $response->assertSee('mailto:halo@wayaenikah.id', false);
        $response->assertSee('Jl. Contoh No. 1, Yogyakarta', false);
        $response->assertSee('https://instagram.com/wayaenikah', false);
        $response->assertSee('https://facebook.com/wayaenikah', false);
        $response->assertDontSee('tiktok.com', false);
    }

    public function test_landing_page_shows_only_filled_social_media(): void
    {
        $setting = SystemSetting::current();
        $setting->update([
            'whatsapp' => '6281234567890',
            'email' => null,
            'address' => null,
            'instagram' => null,
            'facebook' => null,
            'tiktok' => 'wayaenikah',
        ]);
        Cache::forget('system_settings.main');

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('https://wa.me/6281234567890', false);
        $response->assertSee('https://tiktok.com/@wayaenikah', false);
        $response->assertDontSee('mailto:', false);
        $response->assertDontSee('instagram.com', false);
        $response->assertDontSee('facebook.com', false);
    }

    public function test_admin_can_save_contact_info(): void
    {
        Cache::forget('system_settings.main');
        $setting = SystemSetting::current();

        Livewire::test(SystemSettingDemo::class)
            ->set('whatsapp', '6281234567890')
            ->set('email', 'admin@wayaenikah.id')
            ->set('address', 'Jl. Admin No. 2, Bandung')
            ->set('instagram', 'https://instagram.com/wayaenikah')
            ->set('facebook', '')
            ->set('tiktok', 'wayaenikah')
            ->call('save')
            ->assertHasNoErrors();

        Cache::forget('system_settings.main');

        $this->assertDatabaseHas('system_settings', [
            'id' => $setting->id,
            'whatsapp' => '6281234567890',
            'email' => 'admin@wayaenikah.id',
            'address' => 'Jl. Admin No. 2, Bandung',
            'instagram' => 'https://instagram.com/wayaenikah',
            'facebook' => null,
            'tiktok' => 'wayaenikah',
        ]);
    }

    public function test_admin_validation_rejects_invalid_contact_input(): void
    {
        Cache::forget('system_settings.main');
        SystemSetting::current();

        Livewire::test(SystemSettingDemo::class)
            ->set('email', 'bukan-email')
            ->set('whatsapp', 'abc123')
            ->call('save')
            ->assertHasErrors(['email', 'whatsapp']);
    }
}
