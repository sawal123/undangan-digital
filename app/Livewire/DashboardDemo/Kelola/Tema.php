<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\Theme;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Tema extends Component
{
    use LoadsOwnedInvitation;

    #[Locked]
    public int $dataId;

    public bool $canShareInvitation = false;

    public function mount(string $id): void
    {
        $data = $this->ownedInvitationByUid($id);
        $this->dataId = $data->id;
        $this->canShareInvitation = $data->canBeShared();
    }

    public function choose(int $id): void
    {
        $data = $this->ownedInvitationById($this->dataId, ['eventType']);

        $theme = Theme::query()
            ->when($data->event_type_id, function ($query) use ($data) {
                $query->where(function ($sub) use ($data) {
                    $sub->where('event_type_id', $data->event_type_id)
                        ->orWhereNull('event_type_id');
                });
            })
            ->findOrFail($id);

        $data->theme_id = $theme->id;
        $data->save();

        session()->flash('message', 'Tema ' . $theme->nama . ' berhasil dipilih.');
    }

    public function review(): void
    {
        $data = $this->ownedInvitationById($this->dataId);

        if (!$data?->canBeShared()) {
            session()->flash('error', 'Undangan belum aktif, review dengan data pengantin belum bisa dibuka.');
            return;
        }

        if (!$data->theme_id) {
            session()->flash('error', 'Pilih tema terlebih dahulu sebelum melakukan review.');
            return;
        }

        $this->dispatch('open-new-tab', url: route('visit', ['slug' => $data->slug]));
    }

    public function render()
    {
        $data = $this->ownedInvitationById($this->dataId, ['eventType']);
        $this->canShareInvitation = $data?->canBeShared() ?? false;

        $themes = Theme::with(['category', 'eventType'])
            ->when($data->event_type_id, function ($query) use ($data) {
                $query->where(function ($sub) use ($data) {
                    $sub->where('event_type_id', $data->event_type_id)
                        ->orWhereNull('event_type_id');
                });
            })
            ->get();

        return view('livewire.dashboard.kelola.tema', [
            'data' => $data,
            'tema' => $themes,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Pilih Tema',
        ]);
    }
}
