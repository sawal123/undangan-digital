<?php

namespace App\Livewire\Admin;

use App\Models\Admin\Harga as AdminHarga;
use App\Models\Admin\Promo;
use App\Models\Data;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Harga extends Component
{
    public $harga;
    public $promo;
    // public $transaksi;

    public $isModalOpen = false;
    public $isModalOpenFlash = false;
    public $isModalOpenTrans = false;

    public $promoName;
    public $promoType;
    public $promoDiscount;
    public $checkUpdate = false;

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isModalOpenFlash = false;
        $this->isModalOpenTrans = false;
        // $this->modalDelete = false;
        
    }
    public function mount()
    {
        $this->harga = AdminHarga::all();
        $this->promo = Promo::all();
        // $this->transaksi = Transaction::all();
        Promo::all();
        AdminHarga::all();
    }


    // public $statusTrans;
    // public $typeTrans = 'cash';
    // public $idTrans;

    // public function editTransaksi($id){
    //     $this->isModalOpenTrans = true;
    //     $transaksi = Transaction::find($id);
    //     $this->idTrans = $transaksi->id;
    //     $this->statusTrans = $transaksi->payment_status;
    //     $this->typeTrans = $transaksi->payment_type;

    //     // dd($transaksi);
    // }

    // public function updateTrans($id){
    //     $transaksi = Transaction::find($id);
    //     $transaksi->update([
    //         'payment_status' => $this->statusTrans,
    //         'payment_type' => $this->typeTrans,
    //     ]);
    //     $data = Data::find($transaksi->data_id);
    //     $data->isActive = 1;
    //     $data->save();
    //     $this->closeModal(); // Tutup modal setelah penyimpanan
    //     session()->flash('message', 'Transaksi berhasil diUpdate!');
    //     $this->mount();
    // }
    // public $modalDelete = false;
    // public function confirmDel($id){
    //     $this->idTrans = $id;
    //     $this->modalDelete = true;
    // }
    // public function delTransaksi($id){
    //     $transaksi = Transaction::find($id);
    //     $transaksi->delete();
    //     $this->closeModal(); // Tutup modal setelah penyimpanan
    //     session()->flash('message', 'Transaksi berhasil diDelete!');
    //     $this->mount();
    // }

    // ==========HARGA FLASHSALE
    // ======================

    public $hargaDasar;
    public $flashSale;
    public $idFlash;
    public function editFlashSale($id){
        $this->isModalOpenFlash = true;
        $harga = AdminHarga::find($id);
        $this->idFlash = $harga->id;
        $this->hargaDasar = $harga->harga;
        $this->flashSale = $harga->flashsale;
    }
    public function updateFlashSale($id){
        $harga = AdminHarga::find($id);
        $harga->update([
            'harga'=> $this->hargaDasar,
            'flashsale' => $this->flashSale,
        ]);
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('message', 'Harga berhasil diUpdate!');
        $this->mount();
    }


    // =======Promo===============
    // =========================================
    public $idPromo;
    public function editPromo($id)
    {
        $this->openModal();
        $promo = Promo::find($id);
        $this->idPromo = $promo->id;
        $this->promoName = $promo->kode;
        $this->promoDiscount =  $promo->promo;
        $this->promoType =  $promo->type;
        $this->checkUpdate = true;
    }
    public function updatePromo($id)
    {
        $up = Promo::find($id);
        $up->update([
            'kode' => $this->promoName,
            'promo' => $this->promoDiscount,
            'type' => $this->promoType
        ]);
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('message', 'Promo berhasil diUpdate!');
        $this->mount();
        $this->checkUpdate = false;
        
    }

    public function savePromo()
    {
        $promo = Promo::create([
            'kode' => $this->promoName,
            'promo' => $this->promoDiscount,
            'type' => $this->promoType
        ]);
        // Validasi dan logika penyimpanan data
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('message', 'Promo berhasil disimpan!');
        $this->mount();
    }

    // =================End Promo=================
    public function render()
    {
        return view('livewire.admin.harga');
    }
}
