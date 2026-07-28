<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\Harga;
use App\Models\Admin\Promo;
use Livewire\Component;

class HargaDemo extends Component
{
    public string $promoName = '';

    public string $promoType = 'percentage';

    public string $promoDiscount = '';

    public ?int $promo_id = null;

    public string $hargaDasar = '';

    public string $flashSale = '';

    public ?int $harga_id = null;

    public bool $isEditPromo = false;

    public bool $isEditHarga = false;

    public function render()
    {
        return view('livewire.admin-demo.harga-demo', [
            'harga' => Harga::all(),
            'promo' => Promo::latest('id')->get(),
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->promoName = '';
        $this->promoType = 'percentage';
        $this->promoDiscount = '';
        $this->promo_id = null;
        $this->hargaDasar = '';
        $this->flashSale = '';
        $this->harga_id = null;
        $this->isEditPromo = false;
        $this->isEditHarga = false;
        $this->resetValidation();
    }

    public function createPromo(): void
    {
        $this->resetInput();
        $this->dispatch('open-modal', name: 'promo-modal');
    }

    public function editHarga(int $id): void
    {
        $h = Harga::findOrFail($id);
        $this->harga_id = $h->id;
        $this->hargaDasar = (string) $h->harga;
        $this->flashSale = (string) ($h->flashsale ?? '');
        $this->isEditHarga = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'harga-modal');
    }

    public function updateHarga(): void
    {
        if (!$this->harga_id) {
            return;
        }

        $this->validate([
            'hargaDasar' => 'required|numeric|min:0',
            'flashSale' => 'nullable|numeric|min:0',
        ], [
            'hargaDasar.required' => 'Harga dasar wajib diisi.',
            'hargaDasar.min' => 'Harga dasar minimal 0.',
        ]);

        $h = Harga::findOrFail($this->harga_id);
        $h->update([
            'harga' => (int) $this->hargaDasar,
            'flashsale' => !empty($this->flashSale) ? (int) $this->flashSale : 0,
        ]);

        session()->flash('message', 'Harga berhasil diperbarui.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'harga-modal');
    }

    public function editPromo(int $id): void
    {
        $p = Promo::findOrFail($id);
        $this->promo_id = $p->id;
        $this->promoName = $p->kode;
        $this->promoType = $p->type ?? 'percentage';
        $this->promoDiscount = (string) $p->promo;
        $this->isEditPromo = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'promo-modal');
    }

    public function storePromo(): void
    {
        $discountRules = $this->promoType === 'percentage' ? 'required|numeric|min:0|max:100' : 'required|numeric|min:0';

        $this->validate([
            'promoName' => 'required|string|max:100',
            'promoType' => 'required|in:percentage,fixed,nominal',
            'promoDiscount' => $discountRules,
        ], [
            'promoName.required' => 'Kode promo wajib diisi.',
            'promoDiscount.max' => 'Diskon persentase tidak boleh melebihi 100%.',
        ]);

        Promo::create([
            'kode' => strtoupper(trim($this->promoName)),
            'type' => $this->promoType,
            'promo' => (int) $this->promoDiscount,
        ]);

        session()->flash('message', 'Kode promo berhasil dibuat.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'promo-modal');
    }

    public function updatePromo(): void
    {
        if (!$this->promo_id) {
            return;
        }

        $discountRules = $this->promoType === 'percentage' ? 'required|numeric|min:0|max:100' : 'required|numeric|min:0';

        $this->validate([
            'promoName' => 'required|string|max:100',
            'promoType' => 'required|in:percentage,fixed,nominal',
            'promoDiscount' => $discountRules,
        ], [
            'promoName.required' => 'Kode promo wajib diisi.',
            'promoDiscount.max' => 'Diskon persentase tidak boleh melebihi 100%.',
        ]);

        $p = Promo::findOrFail($this->promo_id);
        $p->update([
            'kode' => strtoupper(trim($this->promoName)),
            'type' => $this->promoType,
            'promo' => (int) $this->promoDiscount,
        ]);

        session()->flash('message', 'Kode promo berhasil diperbarui.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'promo-modal');
    }

    public function deletePromo(int $id): void
    {
        Promo::findOrFail($id)->delete();
        session()->flash('message', 'Kode promo berhasil dihapus.');
    }
}
