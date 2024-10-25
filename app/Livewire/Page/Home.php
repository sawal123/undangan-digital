<?php

namespace App\Livewire\Page;

use Livewire\Component;

class Home extends Component
{

   
    public function render()
    {
        // setActiveLink();
        return view('landingpage.home')->layout('layouts.landing');
    }
}
