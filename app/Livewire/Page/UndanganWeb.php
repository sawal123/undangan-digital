<?php

namespace App\Livewire\Page;

use App\Models\Theme;
use Livewire\Component;

class UndanganWeb extends Component
{
    public $undanganWeb;
    public function mount()
    {
        $this->undanganWeb = Theme::all();
    }
    public function render()
    {
        return view('livewire.page.undangan-web')->layout('layouts.landing');
    }
}
