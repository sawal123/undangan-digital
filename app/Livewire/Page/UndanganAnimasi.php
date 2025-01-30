<?php

namespace App\Livewire\Page;

use App\Models\Admin\Animation;
use Livewire\Component;

class UndanganAnimasi extends Component
{
    public $animasi;
    public $select = [];
    // public $undangan = [];
    public $perPage = 12; // Jumlah awal data
    public $loadAmount = 12; // Jumlah data yang ditambahkan setiap kali tombol "Load More" diklik
    public $query = null;
   
    public function loadMore()
    {
        $this->perPage += $this->loadAmount;
        $this->loadData();
    }


    public function search($item)
    {
        $this->query = $item; // Simpan kategori yang dipilih
        $this->perPage = 12; // Reset jumlah data saat pencarian baru
        $this->loadData();
    }
    public function loadData()
    {
        $query = Animation::query();
        if ($this->query) {
            $query->where('thumbnail', 'like', '%' . $this->query . '%');
        }
        $this->animasi = $query->limit($this->perPage)->get();
    }
    public function mount()
    {
        $this->select = ['3D', 'Islamic', 'General', 'Cute Floral', 'Simple', 'Majestic', 'Veiled', 'Garden', 'Baper Floral', 'Bloom', 'Bucin', 'Adat', 'Khitan', 'Anak-Anak', 'Idul Fitri'];
        $this->loadData();
    }
    public function render()
    {
        return view('livewire.page.undangan-animasi')->layout('layouts.landing');
    }
}
