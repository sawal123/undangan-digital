<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\Theme;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Tema extends Component
{
    use LoadsOwnedInvitation;

    #[Locked]
    public int $dataId;

    public bool $canPreview = false;

    public bool $canShareInvitation = false;

    public function mount(string $id): void
    {
        $data = $this->ownedInvitationByUid($id);
        $this->dataId = $data->id;
        // Internal preview tidak perlu pembayaran
        $this->canPreview = $data->canBePreviewed();
        // Public link perlu pembayaran/premium
        $this->canShareInvitation = $data->canBeShared();
    }

    public function previewUrl(string $themePath): string
    {
        // Token mengikat path tema, data, dan pemilik agar preview hanya bisa dibuka oleh user itu sendiri
        $token = Crypt::encryptString(json_encode([
            'path' => $themePath,
            'data_id' => $this->dataId,
            'user_id' => auth()->id(),
        ]));

        return route('dashboard.demo', ['token' => $token]);
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

        // Validate theme is compatible with current event type
        if ($theme->event_type_id && $theme->event_type_id !== $data->event_type_id) {
            abort(403, 'Tema ini tidak kompatibel dengan tipe acara Anda.');
        }

        $data->theme_id = $theme->id;
        $data->save();

        session()->flash('message', 'Tema ' . $theme->nama . ' berhasil dipilih.');
    }

    public function review(): void
    {
        $data = $this->ownedInvitationById($this->dataId);

        if (!$data?->canBeShared()) {
            session()->flash('error', 'Link publik belum bisa dibagikan. Silakan upgrade ke premium untuk membagikan undangan.');
            return;
        }

        if (!$data->theme_id) {
            session()->flash('error', 'Pilih tema terlebih dahulu sebelum melakukan review.');
            return;
        }

        $this->dispatch('open-new-tab', url: route('visit', ['slug' => $data->slug]));
    }

    public function render(): View
    {
        $data = $this->ownedInvitationById($this->dataId, ['eventType']);
        // Internal preview tidak perlu pembayaran
        $this->canPreview = $data?->canBePreviewed() ?? false;
        // Public link perlu pembayaran/premium
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
