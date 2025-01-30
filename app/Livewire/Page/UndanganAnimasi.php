<?php

namespace App\Livewire\Page;

use App\Models\Admin\Animation;
use Livewire\Component;

class UndanganAnimasi extends Component
{
    public $animasi;
    public $select = [];
    public function search($item){
        $this->animasi = Animation::where('thumbnail', 'like', '%' . $item . '%')->get();
        // ->orWhere('jenis', 'like', '%' . $this->search . '%')
    }
    public function mount()
    {
        $this->animasi = Animation::all();

        $this->select = ['3D', 'Islamic', 'General', 'Cute Floral', 'Simple', 'Majestic', 'Veiled', 'Garden', 'Baper Floral', 'Bloom', 'Bucin', 'Adat', 'Khitan'];
    }
    public function render()
    {
        return view('livewire.page.undangan-animasi')->layout('layouts.landing');
    }
}
