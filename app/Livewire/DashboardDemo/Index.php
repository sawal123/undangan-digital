<?php

namespace App\Livewire\DashboardDemo;

use App\Models\Data;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function render()
    {
        $dataUndangan = Auth::user()->data()->latest()->get();
        $dataUndangan->each(function ($item) {
            if (blank($item->uid)) {
                $item->update(['uid' => Data::generateUniqueUid()]);
            }
        });

        return view('livewire.dashboard.index', [
            'dataUndangan' => $dataUndangan
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Daftar Undangan'
        ]);
    }
}
