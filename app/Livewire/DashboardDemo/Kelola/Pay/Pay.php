<?php

namespace App\Livewire\DashboardDemo\Kelola\Pay;

use App\Models\Admin\Harga;
use App\Models\Admin\PaySetting;
use App\Models\Data;
use App\Models\Transaction;
use App\Services\PaymentCalculator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class Pay extends Component
{
    #[Locked]
    public $dataId;

    public $pay;

    public $nama;

    public $email;

    public $wa;

    public $code;

    public $codee;

    public $harga;

    public $total = 0;

    public $promo = 0;

    public $fee;

    public $channel;

    public $manual;

    public $paymentGateway;

    public $paymentGatewayId;

    public function ifee($id)
    {
        $this->authorizeInvitation();
        $this->paymentGateway = PaySetting::where('isActive', true)->findOrFail($id);
        $this->paymentGatewayId = $this->paymentGateway->id;
        $this->manual = $this->paymentGateway->category;
        $this->channel = $this->paymentGateway->midtrans_code;
        $amounts = app(PaymentCalculator::class)->calculate($this->code ?: null, $this->paymentGateway);
        $this->harga = $amounts['base_price'];
        $this->promo = $amounts['discount_amount'];
        $this->fee = $amounts['fee_amount'];
        $this->total = $amounts['gross_amount'];
    }

    public function redeem()
    {
        $this->authorizeInvitation();

        // Kode promo tidak wajib — abaikan jika kosong
        if (empty(trim($this->code ?? ''))) {
            return;
        }

        if (! $this->paymentGatewayId) {
            $this->promo = 0;
            $this->total = $this->harga;
            session()->flash('message', 'Pilih metode pembayaran terlebih dahulu.');

            return;
        }

        try {
            $this->paymentGateway = PaySetting::where('isActive', true)->findOrFail($this->paymentGatewayId);
            $amounts = app(PaymentCalculator::class)->calculate($this->code ?: null, $this->paymentGateway);
            $this->codee = $amounts['promo'];
            $this->harga = $amounts['base_price'];
            $this->promo = $amounts['discount_amount'];
            $this->fee = $amounts['fee_amount'];
            $this->total = $amounts['gross_amount'];
            session()->flash('message', 'Kode Berhasil Dipasang');
        } catch (ValidationException $exception) {
            $this->promo = 0;
            $this->total = $this->harga;
            $this->codee = null;
            session()->flash('message', $exception->getMessage());
        }
    }

    public function checkOut()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'wa' => 'required|numeric|digits_between:9,15',
            'paymentGatewayId' => 'required|integer|exists:pay_settings,id',
            'channel' => 'nullable|string|max:50',
        ], [
            'nama.required' => 'Nama pembeli wajib diisi.',
            'email.required' => 'Email pembeli wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'wa.required' => 'Nomor WhatsApp wajib diisi.',
            'wa.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'wa.digits_between' => 'Nomor WhatsApp harus 9-15 digit.',
            'paymentGatewayId.required' => 'Pilih metode pembayaran terlebih dahulu.',
        ]);

        $data = $this->authorizeInvitation();

        $paymentMethod = PaySetting::query()
            ->where('isActive', true)
            ->findOrFail($this->paymentGatewayId);

        if ($paymentMethod->category !== 'manual') {
            if ($this->channel !== $paymentMethod->midtrans_code) {
                throw ValidationException::withMessages(['channel' => 'Kanal pembayaran tidak valid.']);
            }
        }

        $amounts = app(PaymentCalculator::class)->calculate($this->code ?: null, $paymentMethod);

        $transactions = DB::transaction(function () use ($data, $paymentMethod, $amounts) {
            return Transaction::create([
                'invoice' => $this->generateInvoice(),
                'user_id' => Auth::id(),
                'data_id' => $data->id,
                'link_snap' => '',
                'kode' => $amounts['promo']?->kode ?? '',
                'price' => $amounts['base_price'],
                'promo' => $amounts['discount_amount'],
                'discount_amount' => $amounts['discount_amount'],
                'fee_amount' => $amounts['fee_amount'],
                'gross_amount' => $amounts['gross_amount'],
                'payment_status' => 'PENDING',
                'payment_type' => (string) $paymentMethod->id,
                'payment_method_id' => $paymentMethod->id,
            ]);
        });

        if ($paymentMethod->category === 'manual') {
            return $this->redirectRoute('dashboard.tunai', ['id' => $data->uid]);
        }

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // midtrans parameter
        $midtrans_params = [
            'transaction_details' => [
                'order_id' => $transactions->invoice,
                'gross_amount' => $amounts['gross_amount'],
            ],
            'customer_details' => [
                'first_name' => $this->nama,
                'email' => $this->email,
                'phone' => $this->wa,
            ],
            'enabled_payments' => [$paymentMethod->midtrans_code],
            'credit_card' => [
                'secure' => true,
            ],
        ];

        // link snap payment_url
        try {
            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
            // update link payment
            $transactions->update([
                'link_snap' => $paymentUrl,
            ]);

            // redirect to payment gateway midtrans
            return $this->redirect($paymentUrl);
        } catch (\Exception $e) {
            report($e);
            session()->flash('message', 'Gagal membuat pembayaran Midtrans. Silakan coba lagi.');
        }

        return $this->redirect(request()->header('Referer'));
    }

    public function mount($id = null)
    {
        if ($id !== null) {
            $this->dataId = $id;
        }

        $this->authorizeInvitation();

        $this->pay = PaySetting::where('isActive', true)->get();
        $this->nama = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->wa = Auth::user()->phone;
        $this->harga = (int) (Harga::query()->latest('id')->value('harga') ?? 0);
        $this->total = $this->harga;
    }

    private function generateInvoice(): string
    {
        do {
            $invoice = 'INV-' . Str::upper(Str::random(12));
        } while (Transaction::where('invoice', $invoice)->exists());

        return $invoice;
    }

    public function render()
    {
        $this->authorizeInvitation();

        return view('livewire.dashboard.kelola.pay.pay')
            ->layout('components.layouts.user-new', [
                'headerTitle' => 'Pembayaran',
            ]);
    }

    private function authorizeInvitation(): Data
    {
        return Data::query()
            ->where('user_id', Auth::id())
            ->where('uid', $this->dataId)
            ->firstOrFail();
    }
}
