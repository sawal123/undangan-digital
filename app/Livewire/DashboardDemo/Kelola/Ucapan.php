<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Ucapan as KelolaUndanganUcapan;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Ucapan extends Component
{
    use LoadsOwnedInvitation;
    use WithPagination;

    #[Locked]
    public int $dataId;

    public ?FiturUcapan $fitUcapan = null;

    public bool $isFitur = false;

    public bool $isPublic = false;

    public bool $isView = false;

    public array $balas = [];

    public string $query = '';

    public ?int $deleteId = null;

    public function updatedQuery(): void
    {
        $this->resetPage();
    }

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'delete-modal');
    }

    public function tanggapi(int $id): void
    {
        $this->authorizeInvitationState();

        $this->validate([
            'balas.' . $id => 'nullable|string|max:1000',
        ], [
            'balas.' . $id . '.max' => 'Balasan tidak boleh melebihi 1000 karakter.',
        ]);

        $balas = trim((string) ($this->balas[$id] ?? ''));
        $ucapan = KelolaUndanganUcapan::where('data_id', $this->dataId)->findOrFail($id);
        $ucapan->balas = $balas !== '' ? $balas : null;
        $ucapan->save();

        unset($this->balas[$id]);
        session()->flash('message', 'Balasan ucapan berhasil disimpan.');
    }

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->loadFeatureSettings();
    }

    public function loadFeatureSettings(): void
    {
        $this->authorizeInvitationState();
        $this->fitUcapan = FiturUcapan::where('data_id', $this->dataId)->first();
    }

    public function updateFiturUcapan(int $id, bool $isFitur, string $column): void
    {
        $this->authorizeInvitationState();
        abort_unless(in_array($column, ['isActive', 'publicIsActive', 'viewIsActive'], true), 422);

        FiturUcapan::updateOrCreate(
            ['data_id' => $this->dataId],
            [$column => $isFitur]
        );

        $this->loadFeatureSettings();
        session()->flash('message', 'Fitur ucapan berhasil diperbarui.');
    }

    public function delete(int $id): void
    {
        $this->authorizeInvitationState();
        $delete = KelolaUndanganUcapan::with('tamu')->where('data_id', $this->dataId)->findOrFail($id);
        $namaTamu = $delete->tamu?->nama ?? 'Tamu';
        $delete->delete();
        session()->flash('message', 'Ucapan & Doa dari ' . $namaTamu . ' berhasil dihapus.');
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $ucapan = KelolaUndanganUcapan::with('tamu')
            ->where('data_id', $this->dataId)
            ->when(!empty(trim($this->query)), function ($query) {
                $searchTerm = '%' . trim($this->query) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('ucapan', 'LIKE', $searchTerm)
                        ->orWhere('status', 'LIKE', $searchTerm)
                        ->orWhere('balas', 'LIKE', $searchTerm)
                        ->orWhereHas('tamu', function ($q) use ($searchTerm) {
                            $q->where('nama', 'LIKE', $searchTerm);
                        });
                });
            })
            ->latest('id')
            ->paginate(5);

        return view('livewire.dashboard.kelola.ucapan', [
            'ucapan' => $ucapan,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Ucapan',
        ]);
    }
}
