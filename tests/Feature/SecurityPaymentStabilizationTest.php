<?php

namespace Tests\Feature;

use App\Livewire\AdminDemo\PaySettingDemo;
use App\Livewire\DashboardDemo\Kelola\Acara;
use App\Livewire\DashboardDemo\Kelola\Birthday;
use App\Livewire\DashboardDemo\Kelola\EventDetail;
use App\Livewire\DashboardDemo\Kelola\Galery;
use App\Livewire\DashboardDemo\Kelola\Kado;
use App\Livewire\DashboardDemo\Kelola\Kisah;
use App\Livewire\DashboardDemo\Kelola\Pay\Pay;
use App\Livewire\DashboardDemo\Kelola\Setting;
use App\Livewire\DashboardDemo\Kelola\Sound;
use App\Livewire\DashboardDemo\Kelola\Tamu as TamuComponent;
use App\Livewire\DashboardDemo\Kelola\Ucapan as UcapanComponent;
use App\Models\Admin\Harga;
use App\Models\Admin\PaySetting;
use App\Models\Data;
use App\Models\GiftPay;
use App\Models\KelolaUndangan\Acara as AcaraModel;
use App\Models\KelolaUndangan\BirthdayProfile;
use App\Models\KelolaUndangan\EventDetail as EventDetailModel;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Galery as GalleryModel;
use App\Models\KelolaUndangan\Kado as KadoModel;
use App\Models\KelolaUndangan\KisahCinta;
use App\Models\KelolaUndangan\Sound as SoundModel;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan as UcapanModel;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PaymentCalculator;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\ViewException;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SecurityPaymentStabilizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['midtrans.serverKey' => 'test-server-key']);
    }

    private function userWithInvitation(): array
    {
        Role::findOrCreate('User');

        $user = User::factory()->create();
        $user->assignRole('User');

        $data = Data::factory()->for($user)->create();

        return [$user, $data];
    }

    private function signedMidtransPayload(string $invoice, int $grossAmount, array $overrides = []): array
    {
        $payload = array_merge([
            'order_id' => $invoice,
            'status_code' => '200',
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'transaction_id' => 'midtrans-transaction-1',
            'fraud_status' => 'accept',
            'gross_amount' => number_format($grossAmount, 2, '.', ''),
        ], $overrides);

        $payload['signature_key'] = hash(
            'sha512',
            $payload['order_id'].$payload['status_code'].$payload['gross_amount'].config('midtrans.serverKey')
        );

        return $payload;
    }

    private function assertDataIdTamperingIsRejected(
        User $user,
        string $component,
        array $parameters,
        int $victimDataId,
        Closure $action,
        Closure $assertUnchanged
    ): void {
        $rejected = false;

        try {
            $test = Livewire::actingAs($user)->test($component, $parameters);
            $test->set('dataId', $victimDataId);
            $action($test);
        } catch (CannotUpdateLockedPropertyException) {
            $rejected = true;
        } finally {
            $assertUnchanged();
        }

        $this->assertTrue($rejected, 'dataId tampering should be rejected by Livewire locked property.');
    }

    private function rerunPaymentSplitMigration(): void
    {
        $migration = require database_path('migrations/2026_07_26_000003_split_payment_method_and_midtrans_fields.php');

        $migration->up();
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

        $this->expectException(ViewException::class);

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
        $this->postJson('/midtrans/callback', $this->signedMidtransPayload('INV-UNKNOWN', 100000))
            ->assertNotFound();
    }

    public function test_midtrans_callback_without_signature_is_rejected(): void
    {
        [, $data] = $this->userWithInvitation();
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'gross_amount' => 100000,
        ]);

        $this->postJson('/midtrans/callback', [
            'order_id' => $transaction->invoice,
            'status_code' => '200',
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'gross_amount' => '100000.00',
        ])->assertForbidden();

        $this->assertSame('PENDING', $transaction->fresh()->payment_status);
        $this->assertFalse($data->fresh()->canBeShared());
    }

    public function test_midtrans_callback_with_wrong_signature_is_rejected(): void
    {
        [, $data] = $this->userWithInvitation();
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'gross_amount' => 100000,
        ]);

        $payload = $this->signedMidtransPayload($transaction->invoice, 100000);
        $payload['signature_key'] = 'wrong-signature';

        $this->postJson('/midtrans/callback', $payload)->assertForbidden();

        $this->assertSame('PENDING', $transaction->fresh()->payment_status);
        $this->assertFalse($data->fresh()->canBeShared());
    }

    public function test_midtrans_callback_with_valid_signature_activates_invitation(): void
    {
        [, $data] = $this->userWithInvitation();
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'gross_amount' => 100000,
        ]);

        $this->postJson('/midtrans/callback', $this->signedMidtransPayload($transaction->invoice, 100000))
            ->assertOk();

        $this->assertSame('SUCCESS', $transaction->fresh()->payment_status);
        $this->assertTrue($data->fresh()->canBeShared());
    }

    public function test_midtrans_callback_rejects_wrong_gross_amount(): void
    {
        [, $data] = $this->userWithInvitation();
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'gross_amount' => 100000,
        ]);

        $this->postJson('/midtrans/callback', $this->signedMidtransPayload($transaction->invoice, 99999))
            ->assertStatus(422);

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

        $payload = $this->signedMidtransPayload($transaction->invoice, 100000);

        $this->postJson('/midtrans/callback', $payload)->assertOk();
        $this->postJson('/midtrans/callback', $payload)->assertOk();

        $this->assertSame('SUCCESS', $transaction->fresh()->payment_status);
        $this->assertTrue($data->fresh()->canBeShared());
    }

    public function test_midtrans_pending_after_success_does_not_downgrade_transaction(): void
    {
        [, $data] = $this->userWithInvitation();
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'gross_amount' => 100000,
        ]);

        $this->postJson('/midtrans/callback', $this->signedMidtransPayload($transaction->invoice, 100000))
            ->assertOk();

        $this->postJson('/midtrans/callback', $this->signedMidtransPayload($transaction->invoice, 100000, [
            'status_code' => '201',
            'transaction_status' => 'pending',
            'fraud_status' => null,
        ]))->assertOk();

        $this->assertSame('SUCCESS', $transaction->fresh()->payment_status);
        $this->assertTrue($data->fresh()->canBeShared());
    }

    public function test_payment_relation_remains_valid_after_midtrans_callback(): void
    {
        [, $data] = $this->userWithInvitation();
        $payment = PaySetting::factory()->create([
            'category' => 'bank_transfer',
            'midtrans_code' => 'bank_transfer',
        ]);
        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'payment_method_id' => $payment->id,
            'payment_type' => (string) $payment->id,
            'gross_amount' => 100000,
        ]);

        $this->postJson('/midtrans/callback', $this->signedMidtransPayload($transaction->invoice, 100000, [
            'payment_type' => 'bank_transfer',
        ]))->assertOk();

        $transaction->refresh();

        $this->assertTrue($transaction->payment->is($payment));
        $this->assertSame($payment->id, $transaction->payment_method_id);
        $this->assertSame('bank_transfer', $transaction->midtrans_payment_type);
    }

    public function test_ewallet_category_calculates_percentage_fee(): void
    {
        Harga::factory()->create(['harga' => 100000]);
        $payment = PaySetting::factory()->create([
            'category' => 'ewallet',
            'fee' => '2.5',
            'midtrans_code' => 'gopay',
        ]);

        $amounts = app(PaymentCalculator::class)->calculate(null, $payment);

        $this->assertSame(2500, $amounts['fee_amount']);
        $this->assertSame(102500, $amounts['gross_amount']);
    }

    public function test_manual_payment_does_not_call_midtrans(): void
    {
        [$user, $data] = $this->userWithInvitation();
        Harga::factory()->create(['harga' => 125000]);
        $payment = PaySetting::factory()->create([
            'category' => 'manual',
            'fee' => '0',
            'midtrans_code' => 'manual',
        ]);

        Livewire::actingAs($user)
            ->test(Pay::class, ['dataId' => $data->id])
            ->call('ifee', $payment->id)
            ->call('checkOut')
            ->assertRedirect(route('dashboard.tunai', $data->uid));

        $this->assertSame('', Transaction::firstOrFail()->link_snap);
    }

    public function test_payment_split_migration_normalizes_legacy_categories(): void
    {
        $bankTransfer = PaySetting::factory()->create([
            'category' => 'Bank Transfer',
            'slug' => 'bca',
            'midtrans_code' => null,
        ]);
        $ewallet = PaySetting::factory()->create([
            'category' => 'E-Wallet',
            'slug' => 'ovo',
            'midtrans_code' => null,
        ]);

        $this->rerunPaymentSplitMigration();

        $this->assertDatabaseHas('pay_settings', [
            'id' => $bankTransfer->id,
            'category' => 'bank_transfer',
            'midtrans_code' => 'bank_transfer',
        ]);
        $this->assertDatabaseHas('pay_settings', [
            'id' => $ewallet->id,
            'category' => 'ewallet',
            'midtrans_code' => 'gopay',
        ]);
    }

    public function test_payment_split_migration_leaves_orphan_legacy_payment_type_null(): void
    {
        [, $data] = $this->userWithInvitation();
        $deletedPayment = PaySetting::factory()->create();
        $deletedPaymentId = $deletedPayment->id;
        $deletedPayment->delete();

        $transaction = Transaction::factory()->create([
            'data_id' => $data->id,
            'user_id' => $data->user_id,
            'payment_type' => (string) $deletedPaymentId,
            'payment_method_id' => null,
        ]);

        $this->rerunPaymentSplitMigration();

        $this->assertNull($transaction->fresh()->payment_method_id);
    }

    public function test_pay_setting_demo_validates_ewallet_fee_and_midtrans_code(): void
    {
        Livewire::test(PaySettingDemo::class)
            ->set('bank', 'OVO')
            ->set('category', 'ewallet')
            ->set('fee', 101)
            ->set('midtrans_code', 'bca_va')
            ->call('store')
            ->assertHasErrors(['fee', 'midtrans_code']);
    }

    public function test_tamu_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        $victim = Tamu::factory()->create(['data_id' => $victimData->id, 'nama' => 'Korban']);

        $this->assertDataIdTamperingIsRejected(
            $user,
            TamuComponent::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->call('delete', $victim->kode),
            fn () => $this->assertDatabaseHas('tamus', ['id' => $victim->id, 'nama' => 'Korban'])
        );
    }

    public function test_galery_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        $victim = GalleryModel::factory()->for($victimData, 'data')->create(['poto' => 'galery/victim.jpg']);

        $this->assertDataIdTamperingIsRejected(
            $user,
            Galery::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->call('delete', $victim->id),
            fn () => $this->assertDatabaseHas('galeries', ['id' => $victim->id, 'poto' => 'galery/victim.jpg'])
        );
    }

    public function test_gallery_previous_on_first_item_keeps_sort_unchanged(): void
    {
        [$user, $data] = $this->userWithInvitation();
        $first = GalleryModel::factory()->for($data, 'data')->create(['sort' => 1]);
        $second = GalleryModel::factory()->for($data, 'data')->create(['sort' => 2]);

        Livewire::actingAs($user)
            ->test(Galery::class, ['id' => $data->uid])
            ->call('previous', 1);

        $this->assertSame(1, (int) $first->fresh()->sort);
        $this->assertSame(2, (int) $second->fresh()->sort);
    }

    public function test_gallery_next_on_last_item_keeps_sort_unchanged(): void
    {
        [$user, $data] = $this->userWithInvitation();
        $first = GalleryModel::factory()->for($data, 'data')->create(['sort' => 1]);
        $second = GalleryModel::factory()->for($data, 'data')->create(['sort' => 2]);

        Livewire::actingAs($user)
            ->test(Galery::class, ['id' => $data->uid])
            ->call('next', 2);

        $this->assertSame(1, (int) $first->fresh()->sort);
        $this->assertSame(2, (int) $second->fresh()->sort);
    }

    public function test_gallery_reorder_with_invalid_sort_keeps_items_unchanged(): void
    {
        [$user, $data] = $this->userWithInvitation();
        $first = GalleryModel::factory()->for($data, 'data')->create(['sort' => 1]);
        $second = GalleryModel::factory()->for($data, 'data')->create(['sort' => 2]);

        Livewire::actingAs($user)
            ->test(Galery::class, ['id' => $data->uid])
            ->call('previous', 99)
            ->call('next', 99);

        $this->assertSame(1, (int) $first->fresh()->sort);
        $this->assertSame(2, (int) $second->fresh()->sort);
    }

    public function test_setting_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();

        $this->assertDataIdTamperingIsRejected(
            $user,
            Setting::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->set('title', 'Changed')->call('update', $victimData->id),
            fn () => $this->assertDatabaseMissing('data', ['id' => $victimData->id, 'title' => 'Changed'])
        );
    }

    public function test_acara_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        $victim = AcaraModel::create([
            'data_id' => $victimData->id,
            'nama_acara' => 'Akad Korban',
            'vanue' => 'Gedung',
            'alamat' => 'Jalan',
            'date' => '2026-08-01',
            'jam_start' => '09:00',
            'jam_end' => '10:00',
            'zona_waktu' => 'WIB',
        ]);

        $this->assertDataIdTamperingIsRejected(
            $user,
            Acara::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->call('delete', $victim->id),
            fn () => $this->assertDatabaseHas('acaras', ['id' => $victim->id, 'nama_acara' => 'Akad Korban'])
        );
    }

    public function test_sound_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        $victim = SoundModel::create([
            'data_id' => $victimData->id,
            'sound' => 'victim.mp3',
            'start' => '0',
            'isActive' => true,
        ]);

        $this->assertDataIdTamperingIsRejected(
            $user,
            Sound::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->call('delete', $victim->id),
            fn () => $this->assertDatabaseHas('sounds', ['id' => $victim->id, 'sound' => 'victim.mp3'])
        );
    }

    public function test_kado_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        $gift = GiftPay::create(['nama_pay' => 'Bank', 'icon' => 'bank.png']);
        $victim = KadoModel::create([
            'data_id' => $victimData->id,
            'gift_id' => $gift->id,
            'namaPay' => 'Korban',
            'nomorPay' => '123',
        ]);

        $this->assertDataIdTamperingIsRejected(
            $user,
            Kado::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->call('delete', $victim->id),
            fn () => $this->assertDatabaseHas('kados', ['id' => $victim->id, 'namaPay' => 'Korban'])
        );
    }

    public function test_kisah_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        $victim = KisahCinta::create([
            'data_id' => $victimData->id,
            'title' => 'Kisah Korban',
            'deskripsi' => 'Tetap aman',
        ]);

        $this->assertDataIdTamperingIsRejected(
            $user,
            Kisah::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->call('delete', $victim->id),
            fn () => $this->assertDatabaseHas('kisah_cintas', ['id' => $victim->id, 'title' => 'Kisah Korban'])
        );
    }

    public function test_ucapan_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        $guest = Tamu::factory()->create(['data_id' => $victimData->id]);
        $victim = UcapanModel::factory()->create([
            'data_id' => $victimData->id,
            'tamu_id' => $guest->id,
            'ucapan' => 'Ucapan korban',
        ]);

        $this->assertDataIdTamperingIsRejected(
            $user,
            UcapanComponent::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->call('delete', $victim->id),
            fn () => $this->assertDatabaseHas('ucapans', ['id' => $victim->id, 'ucapan' => 'Ucapan korban'])
        );
    }

    public function test_birthday_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        BirthdayProfile::create(['data_id' => $victimData->id, 'name' => 'Korban']);

        $this->assertDataIdTamperingIsRejected(
            $user,
            Birthday::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->set('name', 'Changed')->call('save'),
            fn () => $this->assertDatabaseHas('birthday_profiles', ['data_id' => $victimData->id, 'name' => 'Korban'])
        );
    }

    public function test_event_detail_data_id_manipulation_is_rejected(): void
    {
        [$user, $data] = $this->userWithInvitation();
        [, $victimData] = $this->userWithInvitation();
        EventDetailModel::create(['data_id' => $victimData->id, 'headline' => 'Korban']);

        $this->assertDataIdTamperingIsRejected(
            $user,
            EventDetail::class,
            ['id' => $data->uid],
            $victimData->id,
            fn ($component) => $component->set('headline', 'Changed')->call('save'),
            fn () => $this->assertDatabaseHas('event_details', ['data_id' => $victimData->id, 'headline' => 'Korban'])
        );
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

    public function test_public_comment_duplicate_check_uses_normalized_guest_identity(): void
    {
        $data = Data::factory()->active()->create();
        FiturUcapan::create([
            'data_id' => $data->id,
            'isActive' => true,
            'publicIsActive' => true,
            'viewIsActive' => true,
        ]);

        $payload = [
            'dataId' => $data->id,
            'nama' => 'Publik Sama',
            'ucapan' => 'Selamat untuk acaranya',
            'status' => 'Datang Dong',
        ];

        $this->postJson(route('savedoa'), $payload)->assertOk();
        $this->postJson(route('savedoa'), $payload)->assertTooManyRequests();

        $this->assertDatabaseCount('ucapans', 1);
        $this->assertDatabaseHas('ucapans', [
            'data_id' => $data->id,
            'status' => 'hadir',
        ]);
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
