<?php

namespace App\Livewire\DashboardDemo\Kelola\Pay;

use App\Models\Data;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tunai extends Component
{
    public $dataId;

    public function mount($id = null)
    {
        $this->dataId = $id;
        // Authorize: pastikan data milik user yang login, query by UID
        Data::query()
            ->where('user_id', Auth::id())
            ->where('uid', $this->dataId)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.pay.tunai')
            ->layout('components.layouts.user-new', [
                'headerTitle' => 'Pembayaran Tunai',
            ]);
    }
}
