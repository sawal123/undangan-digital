<?php

namespace App\Livewire\Dashboard\Kelola\Pay;

use App\Models\Admin\Harga;
use Midtrans\Snap;
use Midtrans\Config;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Admin\PaySetting;
use App\Models\Admin\Promo;
use Illuminate\Support\Facades\Auth;

class Pay extends Component
{
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


    public function ifee($id)
    {
        $fe = PaySetting::find($id);
        if ($fe->category === "ewallet") {
            $this->total = $this->harga + ($this->harga * $fe->fee / 100);
            $this->fee = $this->harga * $fe->fee / 100;
        }else{
            $this->fee =  $fe->fee;
            $this->total  = $this->harga + $fe->fee;
        }
    }
    public function redeem()
    {
        $this->codee = Promo::where('kode', $this->code)->first();
        if ($this->codee) {
            $this->total = $this->harga - $this->codee->promo;
            $this->promo = $this->codee->promo;
            session()->flash('message', 'Kode Berhasil Dipasang');
        } else {
            $this->promo = 0;
            $this->total = $this->harga;
            session()->flash('message', 'Kode Tidak Berlaku');
        }
    }

    public function checkOut()
    {
        // ambil data DataId
        $selectedDataId = $this->dataId;
        // dd($selectedDataId);

        // create Transaction 
        $transactions = Transaction::create([
            'invoice' => 'INV-' . Str::random(8),
            'user_id' => Auth::user()->id,
            'data_id' => $selectedDataId,
            'link_snap' => '',
            'kode' => $this->codee ? $this->codee->kode : '',
            'price' => $this->harga,
            'promo' => $this->promo,
            'gross_amount' => $this->total == 0 ? $this->harga : $this->total,
            'payment_status' => 'PENDING',
            'payment_type' => '',
        ]);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // midtrans parameter
        $midtrans_params = [
            'transaction_details' => [
                'order_id' => $transactions->invoice,
                'gross_amount' => (int) $this->total == 0 ? $this->harga : $this->total,
            ],
            'customer_details' => [
                'first_name' => $this->nama,
                'email' => $this->email,
                'phone' => $this->wa,
            ],
            'enabled_payments' => [$this->channel],
            "credit_card" => [
                "secure" => true
            ]
        ];


        // link snap payment_url 
        try {
            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
            // update link payment
            $transactions->update([
                'link_snap' => $paymentUrl,
            ]);

            // redirect to payment gateway midtrans
            return redirect()->away($paymentUrl);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return redirect()->back();
    }



    public function mount()
    {
        error_reporting(0);
        $this->pay = PaySetting::all();
        $this->nama = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->wa = Auth::user()->phone;
        $harga = Harga::all();
        $this->harga = $harga[0]->harga;
        // dd($this->harga);
    }
    public function render()
    {
        return view('livewire.dashboard.kelola.pay.pay');
    }
}
