<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\Acara as KelolaUndanganAcara;
use App\Models\KelolaUndangan\Rundown as RundownModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Rundown extends Component
{
    use LoadsOwnedInvitation;

    #[Locked]
    public int $dataId;

    public string $invitationUid = '';

    public ?int $selectedRundownId = null;

    public ?int $acara_id = null;

    public string $waktu_mulai = '';

    public string $waktu_selesai = '';

    public bool $sampai_selesai = false;

    public string $nama_kegiatan = '';

    public string $keterangan = '';

    public string $lokasi = '';

    public bool $is_active = true;

    public string $filterAcara = 'all';

    protected array $rules = [
        'nama_kegiatan' => 'required|string|max:255',
        'waktu_mulai' => 'required|string|max:50',
        'waktu_selesai' => 'nullable|string|max:50',
        'acara_id' => 'nullable|integer',
        'keterangan' => 'nullable|string|max:1000',
        'lokasi' => 'nullable|string|max:255',
        'is_active' => 'boolean',
    ];

    protected array $messages = [
        'nama_kegiatan.required' => 'Nama kegiatan susunan acara wajib diisi.',
        'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
    ];

    public function mount(string $id): void
    {
        $data = $this->ownedInvitationByUid($id);
        $this->dataId = $data->id;
        $this->invitationUid = $data->uid;
    }

    public function openCreateModal(): void
    {
        $this->resetInputFields();
        $this->dispatch('open-modal', name: 'rundown-modal');
    }

    public function edit(int $id): void
    {
        $this->authorizeInvitationState();
        $item = RundownModel::where('data_id', $this->dataId)->findOrFail($id);

        $this->selectedRundownId = $item->id;
        $this->acara_id = $item->acara_id;
        $this->waktu_mulai = $item->waktu_mulai;
        $this->waktu_selesai = $item->waktu_selesai ?? '';
        $this->sampai_selesai = ($item->waktu_selesai === 'Selesai');
        $this->nama_kegiatan = $item->nama_kegiatan;
        $this->keterangan = $item->keterangan ?? '';
        $this->lokasi = $item->lokasi ?? '';
        $this->is_active = (bool) $item->is_active;

        $this->resetValidation();
        $this->dispatch('open-modal', name: 'rundown-modal');
    }

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'rundown-modal');
        $this->dispatch('close-modal', name: 'delete-modal');
        $this->resetInputFields();
    }

    public function save(): void
    {
        $this->authorizeInvitationState();
        $this->validate();

        $waktuSelesaiValue = ($this->sampai_selesai || empty(trim($this->waktu_selesai)))
            ? 'Selesai'
            : trim($this->waktu_selesai);

        if ($this->selectedRundownId) {
            $item = RundownModel::where('data_id', $this->dataId)->findOrFail($this->selectedRundownId);
            $item->update([
                'acara_id' => $this->acara_id ?: null,
                'waktu_mulai' => trim($this->waktu_mulai),
                'waktu_selesai' => $waktuSelesaiValue,
                'nama_kegiatan' => trim($this->nama_kegiatan),
                'keterangan' => trim($this->keterangan) ?: null,
                'lokasi' => trim($this->lokasi) ?: null,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Jadwal rundown berhasil diperbarui.');
        } else {
            $maxSort = RundownModel::where('data_id', $this->dataId)->max('sort') ?? 0;

            RundownModel::create([
                'data_id' => $this->dataId,
                'acara_id' => $this->acara_id ?: null,
                'waktu_mulai' => trim($this->waktu_mulai),
                'waktu_selesai' => $waktuSelesaiValue,
                'nama_kegiatan' => trim($this->nama_kegiatan),
                'keterangan' => trim($this->keterangan) ?: null,
                'lokasi' => trim($this->lokasi) ?: null,
                'is_active' => $this->is_active,
                'sort' => $maxSort + 1,
            ]);

            session()->flash('message', 'Jadwal rundown berhasil ditambahkan.');
        }

        $this->resetInputFields();
        $this->dispatch('close-modal', name: 'rundown-modal');
    }

    public function toggleActive(int $id): void
    {
        $this->authorizeInvitationState();
        $item = RundownModel::where('data_id', $this->dataId)->findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        $statusLabel = $item->is_active ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('message', "Rundown '{$item->nama_kegiatan}' berhasil {$statusLabel}.");
    }

    public function delete(int $id): void
    {
        $this->authorizeInvitationState();

        DB::transaction(function () use ($id) {
            $item = RundownModel::where('data_id', $this->dataId)->lockForUpdate()->findOrFail($id);
            $item->delete();

            $remaining = RundownModel::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();
            foreach ($remaining as $index => $row) {
                $row->update(['sort' => $index + 1]);
            }
        });

        session()->flash('message', 'Rundown berhasil dihapus.');
    }

    public function moveUp(int $sort): void
    {
        $this->authorizeInvitationState();
        $this->moveItem($sort, 'up');
    }

    public function moveDown(int $sort): void
    {
        $this->authorizeInvitationState();
        $this->moveItem($sort, 'down');
    }

    private function moveItem(int $sort, string $direction): void
    {
        DB::transaction(function () use ($sort, $direction) {
            $current = RundownModel::where('data_id', $this->dataId)
                ->where('sort', $sort)
                ->lockForUpdate()
                ->first();

            if (!$current) {
                return;
            }

            $neighborQuery = RundownModel::where('data_id', $this->dataId)->lockForUpdate();

            $neighbor = $direction === 'up'
                ? $neighborQuery->where('sort', '<', $current->sort)->orderByDesc('sort')->first()
                : $neighborQuery->where('sort', '>', $current->sort)->orderBy('sort')->first();

            if (!$neighbor) {
                return;
            }

            $currentSort = $current->sort;
            $neighborSort = $neighbor->sort;

            $current->update(['sort' => $neighborSort]);
            $neighbor->update(['sort' => $currentSort]);
        });
    }

    public function resetInputFields(): void
    {
        $this->selectedRundownId = null;
        $this->acara_id = null;
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
        $this->sampai_selesai = false;
        $this->nama_kegiatan = '';
        $this->keterangan = '';
        $this->lokasi = '';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function render(): View
    {
        $data = $this->authorizeInvitationState(['eventType']);

        $acaras = KelolaUndanganAcara::where('data_id', $this->dataId)
            ->orderBy('id', 'asc')
            ->get();

        $rundowns = RundownModel::where('data_id', $this->dataId)
            ->with(['acara'])
            ->when($this->filterAcara !== 'all', function ($query) {
                if ($this->filterAcara === 'general') {
                    $query->whereNull('acara_id');
                } else {
                    $query->where('acara_id', (int) $this->filterAcara);
                }
            })
            ->orderBy('sort', 'asc')
            ->get();

        return view('livewire.dashboard.kelola.rundown', [
            'acaras' => $acaras,
            'rundowns' => $rundowns,
            'invitationUid' => $this->invitationUid,
            'isBirthday' => ($data->eventType?->key === 'birthday'),
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Susunan Acara (Rundown)',
        ]);
    }
}
