<?php

namespace App\Livewire\DashboardDemo\Kelola\Pay;

use App\Models\Data;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tunai extends Component
{
    public $dataId;

    public function mount($dataId = null)
    {
        $this->dataId = $dataId;
        // Authorize: pastikan data milik user yang login
        Data::query()
            ->where('user_id', Auth::id())
            ->findOrFail((int) $this->dataId);
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.pay.tunai')
            ->layout('components.layouts.user-new', [
                'headerTitle' => 'Pembayaran Tunai',
            ]);
    }
}
