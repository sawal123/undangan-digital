<?php

namespace App\Livewire\Dashboard\Kelola\Pay;

use Livewire\Component;
use App\Models\Admin\PaySetting;
use Illuminate\Support\Facades\Auth;

class Pay extends Component
{
    public $dataId;
    public $pay;
    public $nama;
    public $email;
    public $wa;

    public $code;
    public $codee = "CODE12";

    public $harga = 50000;
    public $total =0;
    public $promo =0;

    public $channel;
    

    public function redeem(){
        if($this->code  === $this->codee){
            $this->total = $this->harga - 10000;
            $this->promo = 10000;
            session()->flash('message', 'Kode Berhasil Dipasang');
        }else{
            $this->promo = 0;
            $this->total = $this->harga;
            session()->flash('message', 'Kode Tidak Berlaku');
        }

    }

    public function checkOut(){
        dd($this->channel);
         // Konfigurasi midtrans
         konfig::$clientKey = config('services.midtrans.clientKey');
         konfig::$serverKey = config('services.midtrans.serverKey');
         konfig::$isProduction = config('services.midtrans.isProduction');
         konfig::$isSanitized = config('services.midtrans.isSanitized');
         konfig::$is3ds = config('services.midtrans.is3ds');
    }


    
    public function mount(){
        $this->pay = PaySetting::all();
        $this->nama = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->wa = Auth::user()->phone;


    }
    public function render()
    {
        return view('livewire.dashboard.kelola.pay.pay');
    }
}
