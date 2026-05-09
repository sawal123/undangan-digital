<?php

namespace App\Livewire\DashboardDemo;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function render()
    {
        $dataUndangan = Auth::user()->data()->latest()->get();

        return view('livewire.dashboard.index', [
            'dataUndangan' => $dataUndangan
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Daftar Undangan'
        ]);
    }
}
