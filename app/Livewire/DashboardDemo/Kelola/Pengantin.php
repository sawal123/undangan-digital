<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Data;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class Pengantin extends Component
{
    public $dataId;

    public function mount($id)
    {
        $this->dataId = Data::where('uid', $id)->firstOrFail()->id;
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.pengantin')->layout('components.layouts.user-new', [
            'headerTitle' => 'Data Pengantin'
        ]);
    }
}
