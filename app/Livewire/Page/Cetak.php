<?php

namespace App\Livewire\Page;

use App\Models\Admin\UndanganCetak;
use Livewire\Component;

class Cetak extends Component
{
    public $isOpenModal = false;
    public $mainImage;
    public $gambar = [];
    public $undang;

    public $isExpanded = false; // Properti untuk mengontrol tampilan teks
    public $deskripsi;
    public $yes = [];

    // public $undangan = [];
    public $perPage = 8; // Jumlah awal data
    public $loadAmount = 8; // Jumlah data yang ditambahkan setiap kali tombol "Load More" diklik
    public $search = ''; // Menyimpan nilai pencarian



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
    public function closeModal()
    {
        $this->isOpenModal = false;
    }
    public function openModal($id)
    {
        $this->undang = UndanganCetak::find($id);
        $this->yes = json_decode($this->undang->gambar);
        $this->deskripsi = $this->undang->deskripsi;
        $this->mainImage = $this->yes[0];
        $this->isOpenModal = true;
    }
    public function updateMainImage($image)
    {
        $this->mainImage = $image;
    }
    public $undangan;
    public function updateData()
    {
        $this->undangan = UndanganCetak::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('jenis', 'like', '%' . $this->search . '%')
            ->orWhere('harga', 'like', '%' . $this->search . '%')
            ->limit($this->perPage)
            ->get();
        if ($this->search != '') {
            // dd($this->undangan);
        }
    }
    public function loadMore()
    {
        $this->perPage += $this->loadAmount;
        $this->updateData();
    }
    public function mount()
    {
        $this->updateData();
    }
    public function render()
    {
        $this->undangan = UndanganCetak::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('jenis', 'like', '%' . $this->search . '%')
            ->limit($this->perPage)
            ->get();
        error_reporting(0);
        $this->dispatch('slider');

        return view('landingpage.cetak')->layout('layouts.landing');
    }
}
