<?php

namespace App\Livewire\Page;

use App\Models\Admin\UndanganCetak;
use Livewire\Component;

class Cetak extends Component
{
    public $isOpenModal = false;
    public $mainImage;
    public $gambar;
    public $undang;

    public $isExpanded = false; // Properti untuk mengontrol tampilan teks
    public $deskripsi;
    public $yes;
    public function toggleDescription($id)
    {
        $s = UndanganCetak::find($id);
        $this->deskripsi = $s->deskripsi;
        $this->isExpanded = true;

    }
    public function toggleDownDescription($id)
    {
        $s = UndanganCetak::find($id);
        $this->deskripsi = $s->deskripsi;
        $this->isExpanded = false;
    }
    public function closeModal(){
        $this->isOpenModal = false;
    }
    public function openModal($id)
    {
        $this->undang = UndanganCetak::find($id);
        $this->gambar = json_decode($this->undang->gambar);
        $this->deskripsi = $this->undang->deskripsi;
        $this->mainImage = $this->gambar[0];
        $this->isOpenModal = true;
    }
    public function updateMainImage($image)
    {
        $this->mainImage = $image;
    }
    public $undangan;
    public function mount()
    {
        $this->undangan = UndanganCetak::all();
    }
    public function render()
    {
        error_reporting(0);
        $this->dispatch('slider');

        return view('landingpage.cetak')->layout('layouts.landing');
    }
}