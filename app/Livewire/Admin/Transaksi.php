<?php

namespace App\Livewire\Admin;

use App\Models\Data;
use Livewire\Component;
use App\Models\Transaction;

class Transaksi extends Component
{
    public $transaksi;
    public $statusTrans;
    public $typeTrans = 'cash';
    public $idTrans;
    public $isModalOpenTrans = false;


    public function closeModal()
    {
        $this->isModalOpenTrans = false;
        $this->modalDelete = false;

    }
    public function mount()
    {
        $this->transaksi = Transaction::all();
    }

    public function editTransaksi($id)
    {
        $this->isModalOpenTrans = true;
        $transaksi = Transaction::find($id);
        $this->idTrans = $transaksi->id;
        $this->statusTrans = $transaksi->payment_status;
        $this->typeTrans = $transaksi->payment_type;

        // dd($transaksi);
    }
    public function updateTrans($id)
    {
        $transaksi = Transaction::find($id);
        $transaksi->update([
            'payment_status' => $this->statusTrans,
            'payment_type' => $this->typeTrans,
        ]);
        $data = Data::find($transaksi->data_id);
        $data->isActive = 1;
        $data->save();
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('message', 'Transaksi berhasil diUpdate!');
        $this->mount();
    }
    public $modalDelete = false;
    public function confirmDel($id)
    {
        $this->idTrans = $id;
        $this->modalDelete = true;
    }
    public function delTransaksi($id)
    {
        $transaksi = Transaction::find($id);
        $transaksi->delete();
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('message', 'Transaksi berhasil diDelete!');
        $this->mount();
    }
    public function render()
    {
        return view('livewire.admin.transaksi');
    }
}
