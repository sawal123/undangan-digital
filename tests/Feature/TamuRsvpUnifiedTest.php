<?php

namespace Tests\Feature;

use App\Livewire\DashboardDemo\Kelola\BukuTamu;
use App\Livewire\DashboardDemo\Kelola\Tamu as TamuComponent;
use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TamuRsvpUnifiedTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithInvitation(bool $isActive = true): array
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
            'title' => 'Romeo & Juliet',
            'slug' => 'romeo-juliet',
            'isActive' => $isActive,
        ]);

        return [$user, $data];
    }

    public function test_user_can_access_unified_tamu_rsvp_page(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $this->actingAs($user);

        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->assertOk()
            ->assertSee('Tamu & RSVP', false)
            ->assertSee('Daftar Tamu')
            ->assertSee('Rekap Kehadiran (RSVP)')
            ->assertSee('Doa & Ucapan', false);
    }

    public function test_user_can_switch_tabs(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $this->actingAs($user);

        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->assertSet('activeTab', 'daftar')
            ->call('setTab', 'rsvp')
            ->assertSet('activeTab', 'rsvp')
            ->assertSee('Total Diundang')
            ->assertSee('Konfirmasi Hadir')
            ->call('setTab', 'ucapan')
            ->assertSet('activeTab', 'ucapan')
            ->assertSee('Pengaturan Fitur Ucapan');
    }

    public function test_user_can_add_edit_and_delete_guest(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $this->actingAs($user);

        // Add guest
        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->set('nama', 'Bpk. Hendra Gunawan')
            ->set('whatsapp', '081234567890')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('tamus', [
            'data_id' => $data->id,
            'nama' => 'Bpk. Hendra Gunawan',
            'nomor' => '6281234567890',
        ]);

        $guest = Tamu::where('data_id', $data->id)->first();

        // Edit guest
        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->call('EditTamu', $guest->id)
            ->assertSet('nama', 'Bpk. Hendra Gunawan')
            ->set('nama', 'Bpk. Hendra Gunawan S.T.')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('tamus', [
            'id' => $guest->id,
            'nama' => 'Bpk. Hendra Gunawan S.T.',
        ]);

        // Delete guest
        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->call('delete', $guest->kode);

        $this->assertDatabaseMissing('tamus', [
            'id' => $guest->id,
        ]);
    }

    public function test_guest_list_displays_rsvp_status(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $guest = Tamu::create([
            'data_id' => $data->id,
            'nama' => 'Siti Nurhaliza',
            'kode' => 'siti12345678',
            'nomor' => '628123456789',
            'slug' => 'siti-nurhaliza',
        ]);

        Ucapan::create([
            'data_id' => $data->id,
            'tamu_id' => $guest->id,
            'ucapan' => 'Selamat menempuh hidup baru!',
            'status' => 'Hadir',
        ]);

        $this->actingAs($user);

        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->assertSee('Siti Nurhaliza')
            ->assertSee('Hadir');
    }

    public function test_user_can_reply_and_delete_ucapan(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $guest = Tamu::create([
            'data_id' => $data->id,
            'nama' => 'Ahmad Dani',
            'kode' => 'ahmad1234567',
            'nomor' => '628123456788',
            'slug' => 'ahmad-dani',
        ]);

        $wish = Ucapan::create([
            'data_id' => $data->id,
            'tamu_id' => $guest->id,
            'ucapan' => 'Semoga bahagia selalu dunia akhirat.',
            'status' => 'Hadir',
        ]);

        $this->actingAs($user);

        // Reply to wish
        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->call('setTab', 'ucapan')
            ->set('balas.' . $wish->id, 'Terima kasih banyak atas doanya!')
            ->call('tanggapi', $wish->id);

        $this->assertDatabaseHas('ucapans', [
            'id' => $wish->id,
            'balas' => 'Terima kasih banyak atas doanya!',
        ]);

        // Delete wish
        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->call('deleteUcapan', $wish->id);

        $this->assertDatabaseMissing('ucapans', [
            'id' => $wish->id,
        ]);
    }

    public function test_user_can_update_fitur_ucapan_settings(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $this->actingAs($user);

        Livewire::test(TamuComponent::class, ['id' => $data->uid])
            ->call('updateFiturUcapan', $data->id, true, 'isActive')
            ->call('updateFiturUcapan', $data->id, false, 'viewIsActive');

        $this->assertDatabaseHas('fitur_ucapans', [
            'data_id' => $data->id,
            'isActive' => true,
            'viewIsActive' => false,
        ]);
    }

    public function test_buku_tamu_displays_digital_qr_checkin_coming_soon(): void
    {
        [$user, $data] = $this->createUserWithInvitation();

        $this->actingAs($user);

        Livewire::test(BukuTamu::class, ['id' => $data->uid])
            ->assertOk()
            ->assertSee('Buku Tamu Digital & QR Check-in', false)
            ->assertSee('Fitur Hari-H • Segera Hadir')
            ->assertSee('QR Code Check-in')
            ->assertSee('Layar Sambutan (Welcome Screen)');
    }
}
