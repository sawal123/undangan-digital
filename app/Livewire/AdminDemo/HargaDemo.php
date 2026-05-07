<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\Harga;
use App\Models\Admin\Promo;
use Livewire\Component;

class HargaDemo extends Component
{
    public $harga_list, $promo_list;
    public $promoName, $promoType, $promoDiscount, $promo_id;
    public $hargaDasar, $flashSale, $harga_id;
    public $isEditPromo = false;
    public $isEditHarga = false;

    public function render()
    {
        return view('livewire.admin-demo.harga-demo', [
            'harga' => Harga::all(),
            'promo' => Promo::all(),
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->promoName = '';
        $this->promoType = '';
        $this->promoDiscount = '';
        $this->promo_id = null;
        $this->hargaDasar = '';
        $this->flashSale = '';
        $this->harga_id = null;
        $this->isEditPromo = false;
        $this->isEditHarga = false;
    }

    public function editHarga($id)
    {
        $h = Harga::findOrFail($id);
        $this->harga_id = $id;
        $this->hargaDasar = $h->harga;
        $this->flashSale = $h->flashsale;
        $this->isEditHarga = true;
        $this->dispatch('open-modal', name: 'harga-modal');
    }

    public function updateHarga()
    {
        Harga::findOrFail($this->harga_id)->update([
            'harga' => $this->hargaDasar,
            'flashsale' => $this->flashSale,
        ]);
        session()->flash('message', 'Harga successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'harga-modal');
    }

    public function editPromo($id)
    {
        $p = Promo::findOrFail($id);
        $this->promo_id = $id;
        $this->promoName = $p->kode;
        $this->promoType = $p->type;
        $this->promoDiscount = $p->promo;
        $this->isEditPromo = true;
        $this->dispatch('open-modal', name: 'promo-modal');
    }

    public function storePromo()
    {
        $this->validate([
            'promoName' => 'required',
            'promoType' => 'required',
            'promoDiscount' => 'required|numeric',
        ]);

        Promo::create([
            'kode' => $this->promoName,
            'type' => $this->promoType,
            'promo' => $this->promoDiscount,
        ]);

        session()->flash('message', 'Promo successfully created.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'promo-modal');
    }

    public function updatePromo()
    {
        Promo::findOrFail($this->promo_id)->update([
            'kode' => $this->promoName,
            'type' => $this->promoType,
            'promo' => $this->promoDiscount,
        ]);

        session()->flash('message', 'Promo successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'promo-modal');
    }

    public function deletePromo($id)
    {
        Promo::findOrFail($id)->delete();
        session()->flash('message', 'Promo successfully deleted.');
    }
}
