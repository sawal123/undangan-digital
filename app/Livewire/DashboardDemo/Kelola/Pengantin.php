<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Pengantin extends Component
{
    use LoadsOwnedInvitation;

    #[Locked]
    public int $dataId;

    public string $urutanMempelai = 'pria_wanita';

    public function mount(string $id)
    {
        $data = $this->ownedInvitationByUid($id, ['eventType']);
        if ($data->eventType?->key === 'birthday') {
            return redirect()->route('dashboard.undangan.kelola', ['id' => $data->uid]);
        }
        $this->dataId = $data->id;
        $this->urutanMempelai = $data->urutan_mempelai ?? 'pria_wanita';
    }

    public function setUrutan(string $urutan): void
    {
        abort_unless(in_array($urutan, ['pria_wanita', 'wanita_pria'], true), 422);

        $data = $this->authorizeInvitationState();
        $data->urutan_mempelai = $urutan;
        $data->save();

        $this->urutanMempelai = $urutan;
        session()->flash('message', 'Urutan tampilan mempelai berhasil disimpan: ' . ($urutan === 'wanita_pria' ? 'Mempelai Wanita di depan' : 'Mempelai Pria di depan'));
    }

    public function render()
    {
        $data = $this->authorizeInvitationState(['pria', 'wanita']);
        $this->urutanMempelai = $data->urutan_mempelai ?? 'pria_wanita';

        return view('livewire.dashboard.kelola.pengantin', [
            'data' => $data,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Data Pengantin',
        ]);
    }
}
