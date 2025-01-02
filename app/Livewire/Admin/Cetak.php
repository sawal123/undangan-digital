<?php

namespace App\Livewire\Admin;

use App\Models\Admin\UndanganCetak as AdminUndanganCetak;
use Livewire\Component;

class Cetak extends Component
{
    public $undangan;
    public $isModalOpen = false;
    public $judul ; 

    public function openModal(){
        $this->isModalOpen = true;
        $this->judul = "Tambah";

    }
    public function saveUndangan(){
        
    }

    public function confirmDel($id){
        
    }

    public function closeModal(){
        $this->isModalOpen = false;
    }
    public function mount(){
        $this->undangan = AdminUndanganCetak::all();
    }
    public function render()
    {
        return view('livewire.admin.undangancetak');
    }
}
