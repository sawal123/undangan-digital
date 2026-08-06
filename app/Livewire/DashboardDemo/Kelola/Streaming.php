<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\Streaming as KelolaUndanganStreaming;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Streaming extends Component
{
    use LoadsOwnedInvitation;

    #[Locked]
    public int $dataId;

    public $link = null;

    public $isActive = false;

    public $fiturStreaming;

    public function updateFiturStreaming(bool $isActive): void
    {
        $this->authorizeInvitationState();

        $streaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
        if ($streaming) {
            $streaming->update([

                'isActive' => $isActive,
            ]);
        } else {
            KelolaUndanganStreaming::create([
                'data_id' => $this->dataId,
                'isActive' => $isActive,
            ]);
        }
        // $this->fiturStreaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
    }

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->fiturStreaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->value('isActive') ?? false;
        $streaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
        if ($streaming) {
            $this->link = $streaming->link;
        }
    }

    public function save(): void
    {
        try {
            $this->authorizeInvitationState();

            // Validate URL if provided
            if (!empty($this->link)) {
                if (!filter_var($this->link, FILTER_VALIDATE_URL)) {
                    session()->flash('error', 'URL streaming tidak valid.');
                    return;
                }
            }

            $streaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
            if ($streaming) {
                $streaming->update([
                    'link' => $this->link,
                ]);
                session()->flash('message', 'Streaming Berhasil Diubah.');
            } else {
                KelolaUndanganStreaming::create([
                    'data_id' => $this->dataId,
                    'link' => $this->link,
                ]);
                session()->flash('message', 'Streaming Berhasil Ditambahkan.');
            }
        } catch (\Exception $e) {
            \Log::error('Streaming save error', ['data_id' => $this->dataId, 'error' => $e->getMessage()]);
            session()->flash('error', 'Terjadi kesalahan saat menyimpan streaming.');
        }
    }

    public function render(): View
    {
        $this->authorizeInvitationState();

        return view('livewire.dashboard.kelola.streaming')->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Streaming',
        ]);
    }
}
