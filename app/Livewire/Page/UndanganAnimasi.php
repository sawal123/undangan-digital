<?php

namespace App\Livewire\Page;

use App\Models\Admin\Animation;
use Livewire\Component;

class UndanganAnimasi extends Component
{
    public $animasi;
    public function mount(){
        $this->animasi = Animation::all();
    }
    public function render()
    {
        return view('livewire.page.undangan-animasi')->layout('layouts.landing');
    }
}
