<?php

namespace App\Livewire\DashboardDemo\Kelola;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class Pengantin extends Component
{
    public $dataId;

    public function mount($id)
    {
        $this->dataId = Crypt::decryptString($id);
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.pengantin')->layout('components.layouts.user-new', [
            'headerTitle' => 'Data Pengantin'
        ]);
    }
}
