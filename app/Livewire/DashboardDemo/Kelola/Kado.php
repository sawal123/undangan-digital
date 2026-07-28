<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\GiftPay;
use App\Models\KelolaUndangan\FiturKado;
use App\Models\KelolaUndangan\Kado as KelolaUndanganKado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kado extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    #[Locked]
    public int $dataId;

    public bool $isChecked = false;

    public string $giftId = '';

    public string $namaPay = '';

    public string $nomorPay = '';

    public $qris = null;

    public ?string $barcode = null;

    public int $codeId = 0;

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'delete-modal');
        $this->inputReset();
    }

    public function inputReset(): void
    {
        $this->namaPay = '';
        $this->nomorPay = '';
        $this->qris = null;
        $this->giftId = '';
        $this->resetValidation();
    }

    public function barcodePreview(int $id): void
    {
        $this->authorizeInvitationState();
        $kado = KelolaUndanganKado::where('data_id', $this->dataId)->findOrFail($id);
        $this->barcode = $kado->qris;
        $this->codeId = $id;
        $this->dispatch('open-modal', name: 'preview-modal');
    }

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $fitur = FiturKado::where('data_id', $this->dataId)->first();
        $this->isChecked = $fitur ? (bool) $fitur->isActive : false;
    }

    public function delete(int $id): void
    {
        $this->authorizeInvitationState();

        DB::transaction(function () use ($id) {
            $kado = KelolaUndanganKado::where('data_id', $this->dataId)->findOrFail($id);
            $qrisPath = $kado->qris;

            $kado->delete();

            if ($qrisPath && Storage::disk('public')->exists($qrisPath)) {
                Storage::disk('public')->delete($qrisPath);
            }
        });

        session()->flash('message', 'Data kado berhasil dihapus.');
    }

    public function switch(bool $isChecked): void
    {
        $this->authorizeInvitationState();
        $this->isChecked = $isChecked;

        FiturKado::updateOrCreate(
            ['data_id' => $this->dataId],
            ['isActive' => $this->isChecked]
        );

        session()->flash('message', 'Status fitur kado berhasil diperbarui.');
    }

    public function save(): void
    {
        $this->authorizeInvitationState();

        $this->validate([
            'giftId' => 'required|exists:gift_pays,id',
            'namaPay' => 'required|string|max:255',
            'nomorPay' => 'required|string|max:255',
            'qris' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'giftId.required' => 'Pilih jenis rekening/e-wallet.',
            'namaPay.required' => 'Nama pemilik rekening/e-wallet wajib diisi.',
            'nomorPay.required' => 'Nomor rekening/e-wallet wajib diisi.',
        ]);

        $imagePath = null;
        if ($this->qris) {
            $imagePath = $this->qris->store('qris', 'public');
        }

        try {
            DB::transaction(function () use ($imagePath) {
                KelolaUndanganKado::create([
                    'data_id' => $this->dataId,
                    'gift_id' => $this->giftId,
                    'namaPay' => trim($this->namaPay),
                    'nomorPay' => trim($this->nomorPay),
                    'qris' => $imagePath,
                ]);
            });

            session()->flash('message', 'Data kado berhasil ditambahkan.');
            $this->inputReset();
            $this->dispatch('close-modal', name: 'kado-modal');
        } catch (\Throwable $e) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            session()->flash('error', 'Gagal menyimpan data kado: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $kadoList = KelolaUndanganKado::where('data_id', $this->dataId)->latest('id')->get();
        $giftPayList = GiftPay::orderBy('nama_pay')->get();
        $fitur = FiturKado::where('data_id', $this->dataId)->first();

        return view('livewire.dashboard.kelola.kado', [
            'kado' => $kadoList,
            'giftPay' => $giftPayList,
            'fitur' => $fitur,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Kado',
        ]);
    }
}
