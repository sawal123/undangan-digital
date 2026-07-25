<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\GiftPay;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\Kado as KelolaUndanganKado;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kado extends Component
{
    use LoadsOwnedInvitation;
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

    public $codeId = 0;

    public function close()
    {
        $this->dispatch('close-modal', name: 'delete-modal');
    }

    public function AddKado()
    {
        // Handled by UI
    }

    public function inputReset()
    {
        $this->namaPay = '';
        $this->nomorPay = '';
        $this->qris = '';
        $this->giftId = '';
    }

    public function barcodePreview($id)
    {
        $kado = KelolaUndanganKado::where('data_id', $this->dataId)->findOrFail($id);
        $this->barcode = $kado->qris;
        $this->codeId = $id;
        $this->dispatch('open-modal', name: 'preview-modal');
    }

    public function mount($id)
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->kado = KelolaUndanganKado::where('data_id', $this->dataId)->get();
        $this->fitur = FiturKado::where('data_id', $this->dataId)->first();
        $this->giftPay = GiftPay::all();

        // dd($this->fitur);
    }

    public function delete($id)
    {
        $kado = KelolaUndanganKado::where('data_id', $this->dataId)->findOrFail($id);
        if ($kado && $kado->qris) {
            // Hapus gambar dari storage
            Storage::delete('public/'.$kado->qris);
        }
        $kado->delete();
        $this->kado = KelolaUndanganKado::where('data_id', $this->dataId)->get();
    }

    public function switch($id, $isChecked)
    {
        $this->isChecked = $isChecked;
        $fitur = FiturKado::where('data_id', $this->dataId)->first();
        if ($fitur) {
            $fitur->update([
                'isActive' => $this->isChecked,
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
        $this->validate([
            'giftId' => 'required|exists:gift_pays,id',
            'namaPay' => 'required|string|max:255',
            'nomorPay' => 'required|string|max:255',
            'qris' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = is_object($this->qris) ? $this->qris->store('qris', 'public') : null;
        // dd($imagePath);
        KelolaUndanganKado::create([
            'data_id' => $this->dataId,
            'gift_id' => $this->giftId,
            'namaPay' => $this->namaPay,
            'nomorPay' => $this->nomorPay,
            'qris' => $imagePath,
        ]);
        $this->inputReset();
        $this->kado = KelolaUndanganKado::where('data_id', $this->dataId)->get();
        session()->flash('message', 'Payment Kado Anda Berhasil Dibuat');
        $this->close();
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.kado')->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Kado',
        ]);
    }
}
