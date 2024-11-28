<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\Theme;
use Livewire\Component;

class Tema extends Component
{
    public $dataId;
    public $tema;

    public function mount(){
        $this->tema = Theme::all();

    }
    public function render()
    {
        return view('livewire.dashboard.kelola.tema');
    }
}
