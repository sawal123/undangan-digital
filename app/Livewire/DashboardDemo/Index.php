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

    public function togglePreview(int $dataId): void
    {
        $data = Data::query()
            ->where('user_id', Auth::id())
            ->findOrFail($dataId);

        // Toggle preview/active status
        $data->update(['isActive' => !$data->isActive]);

        $message = $data->isActive 
            ? 'Preview diaktifkan! Anda sekarang bisa melihat preview tema dengan data anda sendiri.'
            : 'Preview dinonaktifkan.';
        
        session()->flash('message', $message);
    }

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
