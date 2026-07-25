<?php

namespace Tests\Feature;

use App\Livewire\DashboardDemo\Kelola\Galery;
use App\Livewire\DashboardDemo\Kelola\Pay\Pay;
use App\Livewire\DashboardDemo\Kelola\Sound;
use App\Livewire\DashboardDemo\Kelola\Tamu as TamuComponent;
use App\Models\Admin\Harga;
use App\Models\Admin\PaySetting;
use App\Models\Data;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Galery as GalleryModel;
use App\Models\KelolaUndangan\Tamu;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SecurityPaymentStabilizationTest extends TestCase
{
    use RefreshDatabase;

    private function userWithInvitation(): array
    {
        Role::findOrCreate('User');

        $user = User::factory()->create();
        $user->assignRole('User');

        $data = Data::factory()->for($user)->create();

        return [$user, $data];
    }

    public function test_user_cannot_manage_another_users_invitation(): void
    {
        [$user] = $this->userWithInvitation();
        [, $otherData] = $this->userWithInvitation();

        $this->actingAs($user)
            ->get(route('dashboard.undangan.kelola', $otherData->uid))
            ->assertNotFound();
    }

    public function test_user_cannot_open_another_users_invitation_settings(): void
    {
        [$user] = $this->userWithInvitation();
        [, $otherData] = $this->userWithInvitation();

        $this->actingAs($user)
            ->get(route('dashboard.undangan.setting', $otherData->uid))
            ->assertNotFound();
    }

    public function test_user_cannot_delete_another_invitations_gallery(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $otherData] = $this->userWithInvitation();
        $gallery = GalleryModel::factory()->for($otherData, 'data')->create();

        $this->expectException(ModelNotFoundException::class);

        Livewire::actingAs($user)
            ->test(Galery::class, ['id' => $data->uid])
            ->call('delete', $gallery->id);
    }

    public function test_user_cannot_edit_another_invitations_guest(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $otherData] = $this->userWithInvitation();
        $guest = Tamu::factory()->create(['data_id' => $otherData->id]);

        $this->expectException(ModelNotFoundException::class);

        Livewire::actingAs($user)
            ->test(TamuComponent::class, ['id' => $data->uid])
            ->call('EditTamu', $guest->id);
    }

    public function test_user_cannot_delete_another_invitations_guest(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $otherData] = $this->userWithInvitation();
        $guest = Tamu::factory()->create(['data_id' => $otherData->id]);

        $this->expectException(ModelNotFoundException::class);

        Livewire::actingAs($user)
            ->test(TamuComponent::class, ['id' => $data->uid])
            ->call('delete', $guest->kode);
    }

    public function test_guest_search_does_not_return_guests_from_other_invitations(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $otherData] = $this->userWithInvitation();
        Tamu::factory()->create(['data_id' => $data->id, 'nama' => 'Budi Aman']);
        Tamu::factory()->create(['data_id' => $otherData->id, 'nama' => 'Rahasia Bocor']);

        Livewire::actingAs($user)
            ->test(TamuComponent::class, ['id' => $data->uid])
            ->set('query', 'Rahasia')
            ->assertDontSee('Rahasia Bocor');
    }

    public function test_inactive_invitation_cannot_be_shared(): void
    {
        $data = Data::factory()->create(['isActive' => null]);

        $this->assertFalse($data->canBeShared());
    }

    public function test_false_is_active_value_is_not_shareable(): void
    {
        $data = Data::factory()->create(['isActive' => false]);

        $this->assertFalse($data->fresh()->canBeShared());
    }

    public function test_invitation_slug_must_be_unique(): void
    {
        [$user] = $this->userWithInvitation();
        Data::factory()->create(['slug' => 'duplikat']);

        $this->actingAs($user)
            ->post(route('dashboard.data.store'), [
                'title' => 'Undangan Baru',
                'slug' => 'duplikat',
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_checkout_recalculates_price_from_database(): void
    {
        [$user, $data] = $this->userWithInvitation();
        Harga::factory()->create(['harga' => 125000]);
        $payment = PaySetting::factory()->create(['category' => 'manual', 'fee' => '0', 'slug' => 'cash']);

        Livewire::actingAs($user)
            ->test(Pay::class, ['dataId' => $data->id])
            ->call('ifee', $payment->id)
            ->set('harga', 1)
            ->set('total', 1)
            ->set('promo', 999999)
            ->call('checkOut')
            ->assertRedirect(route('dashboard.tunai', $data->uid));

        $transaction = Transaction::firstOrFail();

        $this->assertSame(125000, (int) $transaction->price);
        $this->assertSame(125000, (int) $transaction->gross_amount);
    }

    public function test_checkout_rejects_another_users_invitation(): void
    {
        [$user] = $this->userWithInvitation();
        [, $otherData] = $this->userWithInvitation();
        Harga::factory()->create(['harga' => 125000]);
        $payment = PaySetting::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        Livewire::actingAs($user)
            ->test(Pay::class, ['dataId' => $otherData->id])
            ->call('ifee', $payment->id)
            ->call('checkOut');
    }

    public function test_checkout_ignores_client_modified_total(): void
    {
        $this->test_checkout_recalculates_price_from_database();
    }

    public function test_midtrans_callback_handles_unknown_invoice(): void
    {
        $this->postJson('/midtrans/callback', [
            'order_id' => 'INV-UNKNOWN',
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'gross_amount' => '100000.00',
        ])->assertNotFound();
    }

    public function test_midtrans_callback_rejects_wrong_gross_amount(): void
    {
        [, $data] = $this->userWithInvitation();
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'gross_amount' => 100000,
        ]);

        $this->postJson('/midtrans/callback', [
            'order_id' => $transaction->invoice,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'gross_amount' => '99999.00',
        ])->assertStatus(422);

        $this->assertFalse($data->fresh()->canBeShared());
    }

    public function test_midtrans_callback_is_idempotent(): void
    {
        [, $data] = $this->userWithInvitation();
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'gross_amount' => 100000,
        ]);

        $payload = [
            'order_id' => $transaction->invoice,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'gross_amount' => '100000.00',
        ];

        $this->postJson('/midtrans/callback', $payload)->assertOk();
        $this->postJson('/midtrans/callback', $payload)->assertOk();

        $this->assertSame('SUCCESS', $transaction->fresh()->payment_status);
        $this->assertTrue($data->fresh()->canBeShared());
    }

    public function test_public_comment_cannot_enable_comment_feature(): void
    {
        $data = Data::factory()->active()->create();

        $this->post(route('savedoa'), [
            'dataId' => $data->id,
            'nama' => 'Publik',
            'ucapan' => 'Selamat',
            'status' => 'hadir',
        ])->assertRedirect();

        $this->assertDatabaseMissing('fitur_ucapans', ['data_id' => $data->id]);
        $this->assertDatabaseMissing('ucapans', ['data_id' => $data->id]);
    }

    public function test_public_comment_requires_active_invitation(): void
    {
        $data = Data::factory()->create(['isActive' => false]);
        FiturUcapan::create([
            'data_id' => $data->id,
            'isActive' => true,
            'publicIsActive' => true,
            'viewIsActive' => true,
        ]);

        $this->post(route('savedoa'), [
            'dataId' => $data->id,
            'nama' => 'Publik',
            'ucapan' => 'Selamat',
            'status' => 'hadir',
        ])->assertRedirect();

        $this->assertDatabaseMissing('ucapans', ['data_id' => $data->id]);
    }

    public function test_invalid_youtube_url_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();

        Livewire::actingAs($user)
            ->test(Sound::class, ['id' => $data->uid])
            ->set('youtube', 'https://evil.example/watch?v=dQw4w9WgXcQ')
            ->call('save')
            ->assertHasErrors('youtube');
    }

    public function test_invalid_upload_type_is_rejected(): void
    {
        Storage::fake('public');
        [$user, $data] = $this->userWithInvitation();

        Livewire::actingAs($user)
            ->test(Galery::class, ['id' => $data->uid])
            ->set('poto', UploadedFile::fake()->create('bad.svg', 10, 'image/svg+xml'))
            ->call('save')
            ->assertHasErrors('poto');
    }
}
