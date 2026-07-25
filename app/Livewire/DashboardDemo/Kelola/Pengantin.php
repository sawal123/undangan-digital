<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use Livewire\Component;

class Pengantin extends Component
{
    use LoadsOwnedInvitation;

    public $dataId;

    public function mount($id)
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.pengantin')->layout('components.layouts.user-new', [
            'headerTitle' => 'Data Pengantin',
        ]);
    }
}
