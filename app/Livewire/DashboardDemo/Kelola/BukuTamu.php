<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class BukuTamu extends Component
{
    use LoadsOwnedInvitation;
    use WithPagination;

    #[Locked]
    public int $dataId;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
    }

    public function render(): View
    {
        $this->authorizeInvitationState();

        $data = \App\Models\KelolaUndangan\Ucapan::where('data_id', $this->dataId)
            ->with('tamu')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->whereHas('tamu', function ($tamuQuery) {
                        $tamuQuery->where('nama', 'like', '%'.$this->search.'%');
                    })->orWhere('ucapan', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.dashboard.kelola.buku-tamu', [
            'data' => $data,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Buku Tamu',
        ]);
    }
}
