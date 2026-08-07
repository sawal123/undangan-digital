<?php

namespace App\Livewire\DashboardDemo;

use App\Models\Data;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        $dataUndangan = Data::query()
            ->where('user_id', Auth::id())
            ->with('eventType')
            ->withExists([
                'transaction as has_pending_transaction' => function ($query) {
                    $query->where('payment_status', Transaction::STATUS_PENDING);
                },
            ])
            ->latest('id')
            ->paginate(10);

        return view('livewire.dashboard.index', [
            'dataUndangan' => $dataUndangan,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Daftar Undangan',
        ]);
    }
}
