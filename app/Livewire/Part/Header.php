<?php

namespace App\Livewire\Part;

use Livewire\Component;

class Header extends Component
{
    public $activeLink = ''; 
    public function setActiveLink($link)
    {
        $this->activeLink = $link;
        
    }
    public function render()
    {
        
        return view('livewire.part.header',['active'=>$this->activeLink]);
    }
}
