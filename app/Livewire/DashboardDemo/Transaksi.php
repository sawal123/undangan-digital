<?php

namespace App\Livewire\DashboardDemo;

use Livewire\Component;

class Transaksi extends Component
{
    public function render()
    {
        $transactions = \App\Models\Transaction::where('user_id', auth()->id())
            ->with('data')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.dashboard.transaksi', [
            'transactions' => $transactions
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Riwayat Transaksi'
        ]);
    }
}
