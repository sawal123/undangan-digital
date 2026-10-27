<?php

namespace Tests\Feature;

use App\Livewire\AdminDemo\GiftPayDemo;
use App\Models\GiftPay;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GiftPayDemoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        if (!is_dir(storage_path('framework/testing/disks/tmp-for-tests/livewire-tmp'))) {
            @mkdir(storage_path('framework/testing/disks/tmp-for-tests/livewire-tmp'), 0777, true);
        }
    }

    private function adminUser(): User
    {
        Role::findOrCreate('Owner');
        $user = User::factory()->create();
        $user->assignRole('Owner');

        return $user;
    }

    public function test_admin_can_access_gift_pay_page(): void
    {
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)->get(route('admin.gift.pay'));

        $response->assertOk();
        $response->assertSee('Gift Pay Hadiah');
        $response->assertSee('Metode Pembayaran (Transaksi)');
    }

    public function test_gift_pay_list_and_search_filter(): void
    {
        $admin = $this->adminUser();

        GiftPay::create(['nama_pay' => 'Bank Mandiri', 'icon' => 'gift/mandiri.png']);
        GiftPay::create(['nama_pay' => 'GoPay Digital', 'icon' => 'gift/gopay.png']);

        Livewire::actingAs($admin)
            ->test(GiftPayDemo::class)
            ->assertSee('Bank Mandiri')
            ->assertSee('GoPay Digital')
            ->set('search', 'Mandiri')
            ->assertSee('Bank Mandiri')
            ->assertDontSee('GoPay Digital');
    }

    public function test_gift_pay_store_validates_required_fields(): void
    {
        $admin = $this->adminUser();

        Livewire::actingAs($admin)
            ->test(GiftPayDemo::class)
            ->set('nama_pay', '')
            ->set('icon', null)
            ->call('store')
            ->assertHasErrors(['nama_pay', 'icon']);
    }

    public function test_admin_can_create_gift_pay_with_icon(): void
    {
        Storage::fake('public');
        $admin = $this->adminUser();

        $file = UploadedFile::fake()->image('bsi.png');

        Livewire::actingAs($admin)
            ->test(GiftPayDemo::class)
            ->set('nama_pay', 'Bank Syariah Indonesia')
            ->set('icon', $file)
            ->call('store')
            ->assertHasNoErrors()
            ->assertDispatched('close-modal', name: 'gift-modal');

        $this->assertDatabaseHas('gift_pays', [
            'nama_pay' => 'Bank Syariah Indonesia',
        ]);

        $created = GiftPay::where('nama_pay', 'Bank Syariah Indonesia')->firstOrFail();
        Storage::disk('public')->assertExists($created->icon);
    }

    public function test_admin_can_edit_and_update_gift_pay(): void
    {
        Storage::fake('public');
        $admin = $this->adminUser();

        $gift = GiftPay::create([
            'nama_pay' => 'Bank Permata Lama',
            'icon' => 'gift/permata.png',
        ]);

        $newFile = UploadedFile::fake()->image('permata_baru.png');

        Livewire::actingAs($admin)
            ->test(GiftPayDemo::class)
            ->call('edit', $gift->id)
            ->assertSet('nama_pay', 'Bank Permata Lama')
            ->assertSet('isEdit', true)
            ->set('nama_pay', 'Bank Permata Updated')
            ->set('icon', $newFile)
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched('close-modal', name: 'gift-modal');

        $this->assertDatabaseHas('gift_pays', [
            'id' => $gift->id,
            'nama_pay' => 'Bank Permata Updated',
        ]);

        $gift->refresh();
        Storage::disk('public')->assertExists($gift->icon);
    }

    public function test_admin_can_delete_gift_pay(): void
    {
        Storage::fake('public');
        $admin = $this->adminUser();

        $iconPath = 'gift/test-delete.png';
        Storage::disk('public')->put($iconPath, 'dummy');

        $gift = GiftPay::create([
            'nama_pay' => 'Bank Test Hapus',
            'icon' => $iconPath,
        ]);

        Livewire::actingAs($admin)
            ->test(GiftPayDemo::class)
            ->call('delete', $gift->id);

        $this->assertDatabaseMissing('gift_pays', [
            'id' => $gift->id,
        ]);

        Storage::disk('public')->assertMissing($iconPath);
    }

    public function test_gift_pay_duplicate_name_is_rejected(): void
    {
        Storage::fake('public');
        $admin = $this->adminUser();

        GiftPay::create([
            'nama_pay' => 'Bank Central Asia',
            'icon' => 'gift/bca.png',
        ]);

        Livewire::actingAs($admin)
            ->test(GiftPayDemo::class)
            ->set('nama_pay', 'Bank Central Asia')
            ->set('icon', UploadedFile::fake()->image('bca2.png'))
            ->call('store')
            ->assertHasErrors(['nama_pay']);
    }
}
