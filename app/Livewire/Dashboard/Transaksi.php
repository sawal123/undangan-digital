<?php

namespace App\Livewire\Dashboard;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Transaksi extends Component
{
    use WithPagination;

    public function render()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.dashboard.transaksi', [
            'transactions' => $transactions,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Riwayat Transaksi',
        ]);
    }
}
