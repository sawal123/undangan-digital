<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class BukuTamu extends Component
{
    use LoadsOwnedInvitation;

    #[Locked]
    public int $dataId;

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
    }

    public function render(): View
    {
        $invitation = $this->authorizeInvitationState();

        return view('livewire.dashboard.kelola.buku-tamu', [
            'invitation' => $invitation,
            'dataId' => $this->dataId,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Buku Tamu Digital (Hari-H)',
        ]);
    }
}
