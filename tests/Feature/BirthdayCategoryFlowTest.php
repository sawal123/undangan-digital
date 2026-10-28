<?php

namespace Tests\Feature;

use App\Livewire\DashboardDemo\Kelola\Acara as AcaraComponent;
use App\Livewire\DashboardDemo\Kelola\Birthday as BirthdayComponent;
use App\Livewire\DashboardDemo\Kelola\Pengantin as PengantinComponent;
use App\Livewire\DashboardDemo\Kelola\Rundown as RundownComponent;
use App\Livewire\DashboardDemo\Kelola\Setting as SettingComponent;
use App\Livewire\DashboardDemo\Kelola\Tema as TemaComponent;
use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\BirthdayProfile;
use App\Models\KelolaUndangan\Qoute;
use App\Models\TeksUndangan;
use App\Models\teksWhatsApp;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BirthdayCategoryFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createBirthdayUserAndInvitation(): array
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');

        $bdayCat = Category::firstOrCreate(['category' => 'Ulang Tahun'], ['icon' => 'cake']);
        $bdayEvent = EventType::firstOrCreate(['key' => 'birthday'], ['name' => 'Ulang Tahun']);

        $theme = Theme::create([
            'nama' => 'Quinceanera',
            'category_id' => $bdayCat->id,
            'event_type_id' => $bdayEvent->id,
            'path' => 'tema.quinceanera',
            'demo' => 'temademo.quinceanera',
        ]);

        $data = Data::create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'event_type_id' => $bdayEvent->id,
            'title' => 'Ulang Tahun Keisha Adelia',
            'slug' => 'keisha-adelia-' . strtolower(\Illuminate\Support\Str::random(6)),
            'isActive' => true,
        ]);

        $profile = BirthdayProfile::create([
            'data_id' => $data->id,
            'name' => 'Keisha Adelia',
            'nickname' => 'Keisha',
            'age' => 7,
            'parent_name' => 'Bpk. Hendra & Ibu Rini',
            'description' => 'Yuk hadir di pesta ulang tahun ke-7 Keisha!',
        ]);

        return [$user, $data, $profile, $theme, $bdayCat, $bdayEvent];
    }

    public function test_data_controller_store_seeds_birthday_quote_and_tailored_whatsapp_message(): void
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');

        $bdayEvent = EventType::firstOrCreate(['key' => 'birthday'], ['name' => 'Ulang Tahun']);

        $response = $this->actingAs($user)->post(route('dashboard.data.store'), [
            'title' => 'Ulang Tahun Kevin',
            'slug' => 'kevin-7th-' . \Illuminate\Support\Str::random(4),
            'event_type_id' => $bdayEvent->id,
        ]);

        $response->assertRedirect(route('dashboard.index'));

        $data = Data::where('title', 'Ulang Tahun Kevin')->first();
        $this->assertNotNull($data);
        $this->assertSame($bdayEvent->id, $data->event_type_id);

        // Pastikan quote adalah doa usia bukan Ar-Rum: 21 nikah
        $quote = Qoute::where('data_id', $data->id)->first();
        $this->assertNotNull($quote);
        $this->assertStringContainsString('Doa & Berkah Usia', $quote->subtitle);
        $this->assertStringContainsString('memberkahi umurmu', $quote->qoute);

        // Pastikan template WA mengandung {{nama_ulang_tahun}}
        $wa = teksWhatsApp::where('data_id', $data->id)->first();
        $this->assertNotNull($wa);
        $this->assertStringContainsString('{{nama_ulang_tahun}}', $wa->pesan);
    }

    public function test_setting_generate_slug_uses_birthday_profile_name(): void
    {
        [$user, $data, $profile] = $this->createBirthdayUserAndInvitation();

        Livewire::actingAs($user)
            ->test(SettingComponent::class, ['id' => $data->uid])
            ->call('generateSlug')
            ->assertSet('slug', 'ultah-keisha');
    }

    public function test_setting_renders_birthday_adaptive_context(): void
    {
        [$user, $data] = $this->createBirthdayUserAndInvitation();

        Livewire::actingAs($user)
            ->test(SettingComponent::class, ['id' => $data->uid])
            ->assertSee('{{nama_ulang_tahun}}')
            ->assertSee('{{usia}}')
            ->assertSee('Doa Berkah Usia / Harapan');
    }

    public function test_tema_defaults_category_to_birthday_and_can_choose_quinceanera(): void
    {
        [$user, $data, $profile, $theme, $bdayCat] = $this->createBirthdayUserAndInvitation();

        Livewire::actingAs($user)
            ->test(TemaComponent::class, ['id' => $data->uid])
            ->assertSet('selectedCategory', (string) $bdayCat->id)
            ->call('choose', $theme->id)
            ->assertHasNoErrors();

        $data->refresh();
        $this->assertSame($theme->id, $data->theme_id);
    }

    public function test_birthday_component_guards_against_non_birthday_invitation(): void
    {
        Role::findOrCreate('User');
        $user = User::factory()->create();
        $user->assignRole('User');

        $weddingEvent = EventType::firstOrCreate(['key' => 'wedding'], ['name' => 'Pernikahan']);
        $weddingData = Data::create([
            'user_id' => $user->id,
            'event_type_id' => $weddingEvent->id,
            'title' => 'The Wedding Romeo & Juliet',
            'slug' => 'romeo-juliet-' . \Illuminate\Support\Str::random(4),
        ]);

        Livewire::actingAs($user)
            ->test(BirthdayComponent::class, ['id' => $weddingData->uid])
            ->assertRedirect(route('dashboard.undangan.kelola', ['id' => $weddingData->uid]));
    }

    public function test_pengantin_component_guards_against_birthday_invitation(): void
    {
        [$user, $data] = $this->createBirthdayUserAndInvitation();

        Livewire::actingAs($user)
            ->test(PengantinComponent::class, ['id' => $data->uid])
            ->assertRedirect(route('dashboard.undangan.kelola', ['id' => $data->uid]));
    }

    public function test_acara_and_rundown_views_receive_is_birthday_flag(): void
    {
        [$user, $data] = $this->createBirthdayUserAndInvitation();

        Livewire::actingAs($user)
            ->test(AcaraComponent::class, ['id' => $data->uid])
            ->assertViewHas('isBirthday', true);

        Livewire::actingAs($user)
            ->test(RundownComponent::class, ['id' => $data->uid])
            ->assertViewHas('isBirthday', true);
    }

    public function test_check_name_endpoint_validates_slug_availability(): void
    {
        [$user, $data] = $this->createBirthdayUserAndInvitation();

        // Cek slug yang sudah terpakai
        $responseTaken = $this->postJson(route('checkName'), ['name' => $data->slug]);
        $responseTaken->assertJson(['success' => false]);

        // Cek slug yang masih tersedia
        $responseAvailable = $this->postJson(route('checkName'), ['name' => 'arashnayaka-' . \Illuminate\Support\Str::random(6)]);
        $responseAvailable->assertJson(['success' => true]);
    }
}
