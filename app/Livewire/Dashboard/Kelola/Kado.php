<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\GiftPay;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\Kado as KelolaUndanganKado;

class Kado extends Component
{
    use WithFileUploads;
    public $dataId;
    public $kado;
    public $fitur;
    public $isChecked;

    public $giftId;
    public $namaPay;
    public $nomorPay;
    public $qris = null;
    public $giftPay;
    public $barcode;

    public function close()
    {
        $this->dispatch('closeDelModal');
        $this->dispatch('closeEditModal');
    }

    public function inputReset()
    {
        $this->namaPay = '';
        $this->nomorPay = '';
        $this->qris = '';
        $this->giftId = '';
    }
    public function barcodePreview($id){
        $kado = KelolaUndanganKado::find($id);
        $this->barcode = $kado->qris;

        $this->dispatch('openModalCode');
    }

    public function mount()
    {
        $this->kado = KelolaUndanganKado::where('data_id', $this->dataId)->get();
        $this->fitur = FiturKado::where('data_id', $this->dataId)->first();
        $this->giftPay = GiftPay::all();

        // dd($this->fitur);
    }

    public function delete($id)
    {
        $kado = KelolaUndanganKado::where('id', $id)->first();
        if ($kado && $kado->qris) {
            // Hapus gambar dari storage
            Storage::delete('public/' . $kado->qris);
        }
        $kado->delete();
        $this->mount();
    }
    public function switch($id, $isChecked)
    {
        $this->isChecked = $isChecked;
        // dd($id);
        $fitur = FiturKado::where('data_id', $id)->first();
        if ($fitur) {
            $fitur->update([
                'isActive' => $this->isChecked
            ]);
        } else {
            FiturKado::create([
                'data_id' => $this->dataId,
                'isActive' => $this->isChecked,
            ]);
        }
        $this->fitur = FiturKado::where('data_id', $this->dataId)->first();
    }
    public function save()
    {
        $kado = KelolaUndanganKado::where('data_id', $this->dataId)->get();
        $fitur = FiturKado::where('data_id', $this->dataId)->first();

        
        $imagePath = is_object($this->qris) ? $this->qris->store('qris', 'public') : null;
        // dd($imagePath);
        KelolaUndanganKado::create([
            'data_id' => $this->dataId,
            'gift_id' => $this->giftId,
            'namaPay' => $this->namaPay,
            'nomorPay' => $this->nomorPay,
            'qris' =>  $imagePath
        ]);
        $this->inputReset();
        $this->mount();
        session()->flash('message', 'Payment Kado Anda Berhasil Dibuat');
        $this->close();
    }
    public function render()
    {
        return view('livewire.dashboard.kelola.kado');
    }
}
