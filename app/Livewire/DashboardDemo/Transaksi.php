<?php

namespace App\Livewire\DashboardDemo;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Transaksi extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $transactions = Transaction::query()
            ->where('user_id', Auth::id())
            ->with(['data', 'payment'])
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('invoice', 'like', $searchTerm)
                        ->orWhere('payment_status', 'like', $searchTerm)
                        ->orWhere('payment_type', 'like', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.dashboard.transaksi', [
            'transactions' => $transactions,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Riwayat Transaksi',
        ]);
    }
}
