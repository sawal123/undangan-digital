<?php

namespace Tests\Feature;

use App\Livewire\AdminDemo\TransaksiDemo;
use App\Livewire\AdminDemo\UndanganDemo;
use App\Models\Admin\PaySetting;
use App\Models\Category;
use App\Models\Data;
use App\Models\EventType;
use App\Models\KelolaUndangan\Acara;
use App\Models\Theme;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UndanganDemoTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        Role::findOrCreate('Owner');
        $user = User::factory()->create();
        $user->assignRole('Owner');

        return $user;
    }

    private function makeTheme(string $nama, string $demo): Theme
    {
        $cat = Category::firstOrCreate(['category' => 'Wedding']);
        $ev = EventType::where('key', 'wedding')->first() ?? EventType::create(['name' => 'Pernikahan', 'key' => 'wedding']);

        return Theme::create([
            'nama' => $nama,
            'category_id' => $cat->id,
            'event_type_id' => $ev->id,
            'path' => 'tema.wedding_blue',
            'demo' => $demo,
            'thumbnail' => null,
        ]);
    }

    public function test_transaksi_page_displays_theme_name_and_invitation_url(): void
    {
        $admin = $this->adminUser();
        $user = User::factory()->create(['name' => 'Budi Santoso']);
        $theme = $this->makeTheme('Blue Romance', 'wedding_blue');

        $data = Data::factory()->create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'title' => 'Pernikahan Budi & Ani',
            'slug' => 'budi-ani',
            'isActive' => true,
        ]);

        $payment = PaySetting::create([
            'bank' => 'Bank Mandiri',
            'category' => 'bank_transfer',
            'fee' => 4000,
            'deskripsi' => 'Transfer Mandiri',
            'image' => 'paysetting/mandiri.png',
            'isActive' => true,
            'slug' => 'mandiri',
            'midtrans_code' => 'echannel',
        ]);

        Transaction::create([
            'invoice' => 'INV-TEST-001',
            'user_id' => $user->id,
            'data_id' => $data->id,
            'link_snap' => '',
            'kode' => '',
            'price' => 100000,
            'promo' => 0,
            'gross_amount' => 104000,
            'payment_status' => 'SUCCESS',
            'payment_type' => 'bank_transfer',
            'payment_method_id' => $payment->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.transaksi'));
        $response->assertOk();
        $response->assertSee('Blue Romance');
        $response->assertSee('/u/budi-ani');
        $response->assertSee('Bank Mandiri');
    }

    public function test_admin_can_access_status_undangan_page(): void
    {
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)->get(route('admin.undangan'));

        $response->assertOk();
        $response->assertSee('Masih Berjalan');
        $response->assertSee('Pesta Selesai');
        $response->assertSee('Total Undangan');
    }

    public function test_undangan_filter_ongoing_vs_finished(): void
    {
        $admin = $this->adminUser();
        $user = User::factory()->create();

        // 1. Ongoing invitation (acara date in future)
        $dataOngoing = Data::factory()->create([
            'user_id' => $user->id,
            'title' => 'Pernikahan Mendatang',
            'slug' => 'mendatang',
        ]);
        Acara::create([
            'data_id' => $dataOngoing->id,
            'nama_acara' => 'Resepsi',
            'vanue' => 'Hotel Mulia',
            'alamat' => 'Jakarta',
            'date' => now()->addDays(10)->format('Y-m-d'),
            'jam_start' => '10:00',
            'jam_end' => '13:00',
            'zona_waktu' => 'WIB',
        ]);

        // 2. Finished invitation (acara date in past)
        $dataFinished = Data::factory()->create([
            'user_id' => $user->id,
            'title' => 'Pernikahan Lewat',
            'slug' => 'lewat',
        ]);
        Acara::create([
            'data_id' => $dataFinished->id,
            'nama_acara' => 'Resepsi Selesai',
            'vanue' => 'Balai Kartini',
            'alamat' => 'Jakarta',
            'date' => now()->subDays(5)->format('Y-m-d'),
            'jam_start' => '10:00',
            'jam_end' => '13:00',
            'zona_waktu' => 'WIB',
        ]);

        // Test filter 'ongoing'
        Livewire::actingAs($admin)
            ->test(UndanganDemo::class)
            ->set('statusFilter', 'ongoing')
            ->assertSee('Pernikahan Mendatang')
            ->assertDontSee('Pernikahan Lewat');

        // Test filter 'finished'
        Livewire::actingAs($admin)
            ->test(UndanganDemo::class)
            ->set('statusFilter', 'finished')
            ->assertSee('Pernikahan Lewat')
            ->assertDontSee('Pernikahan Mendatang');
    }

    public function test_admin_can_toggle_undangan_activation(): void
    {
        $admin = $this->adminUser();
        $user = User::factory()->create();

        $data = Data::factory()->create([
            'user_id' => $user->id,
            'title' => 'Undangan Aktivasi Test',
            'isActive' => false,
        ]);

        Livewire::actingAs($admin)
            ->test(UndanganDemo::class)
            ->call('toggleActive', $data->id);

        $this->assertTrue((bool) $data->fresh()->isActive);
    }
}
