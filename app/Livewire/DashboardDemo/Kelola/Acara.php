<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\Acara as KelolaUndanganAcara;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Acara extends Component
{
    use LoadsOwnedInvitation;

    #[Locked]
    public int $dataId;

    public string $acara = '';

    public string $vanue = '';

    public string $alamat = '';

    public string $date = '';

    public string $start = '';

    public string $end = '';

    public bool $selesai = false;

    public string $zona = 'WIB';

    public string $maps = '';

    public ?int $selectedAcaraId = null;

    protected array $rules = [
        'acara' => 'required|string|max:255',
        'vanue' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'date' => 'required|string|max:255',
        'start' => 'required|string|max:255',
        'zona' => 'nullable|string|max:255',
        'maps' => 'nullable|string|max:500',
    ];

    protected array $messages = [
        'acara.required' => 'Nama acara wajib diisi.',
        'vanue.required' => 'Nama lokasi/venue wajib diisi.',
        'alamat.required' => 'Alamat lokasi wajib diisi.',
        'date.required' => 'Tanggal acara wajib diisi.',
        'start.required' => 'Waktu mulai wajib diisi.',
    ];

    public function edit(int $id): void
    {
        $this->authorizeInvitationState();
        $acara = KelolaUndanganAcara::where('data_id', $this->dataId)->findOrFail($id);

        $this->selectedAcaraId = $acara->id;
        $this->acara = $acara->nama_acara;
        $this->vanue = $acara->vanue;
        $this->alamat = $acara->alamat;
        $this->date = $acara->date;
        $this->start = $acara->jam_start;
        $this->end = $acara->jam_end;
        $this->selesai = ($acara->jam_end === 'Selesai');
        $this->zona = $acara->zona_waktu ?? 'WIB';
        $this->maps = $acara->maps ?? '';
        $this->resetValidation();

        $this->dispatch('open-modal', name: 'acara-modal');
    }

    public function delete(int $id): void
    {
        $this->authorizeInvitationState();
        $acara = KelolaUndanganAcara::where('data_id', $this->dataId)->findOrFail($id);
        $acara->delete();

        session()->flash('message', 'Data acara berhasil dihapus.');
    }

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'acara-modal');
        $this->resetInputFields();
    }

    public function save(): void
    {
        $this->authorizeInvitationState();
        $this->validate();

        $jamEndValue = ($this->selesai || empty(trim($this->end))) ? 'Selesai' : trim($this->end);

        if ($this->selectedAcaraId) {
            $acara = KelolaUndanganAcara::where('data_id', $this->dataId)->findOrFail($this->selectedAcaraId);
            $acara->update([
                'nama_acara' => trim($this->acara),
                'vanue' => trim($this->vanue),
                'alamat' => trim($this->alamat),
                'date' => trim($this->date),
                'jam_start' => trim($this->start),
                'jam_end' => $jamEndValue,
                'zona_waktu' => trim($this->zona),
                'maps' => trim($this->maps),
            ]);
            session()->flash('message', 'Data acara berhasil diperbarui.');
        } else {
            KelolaUndanganAcara::create([
                'data_id' => $this->dataId,
                'nama_acara' => trim($this->acara),
                'vanue' => trim($this->vanue),
                'alamat' => trim($this->alamat),
                'date' => trim($this->date),
                'jam_start' => trim($this->start),
                'jam_end' => $jamEndValue,
                'zona_waktu' => trim($this->zona),
                'maps' => trim($this->maps),
            ]);
            session()->flash('message', 'Data acara berhasil disimpan.');
        }

        $this->resetInputFields();
        $this->dispatch('close-modal', name: 'acara-modal');
    }

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
    }

    public function resetInputFields(): void
    {
        $this->acara = '';
        $this->vanue = '';
        $this->alamat = '';
        $this->date = '';
        $this->start = '';
        $this->end = '';
        $this->selesai = false;
        $this->zona = 'WIB';
        $this->maps = '';
        $this->selectedAcaraId = null;
        $this->resetValidation();
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $dataAcara = KelolaUndanganAcara::where('data_id', $this->dataId)->orderBy('id')->get();

        return view('livewire.dashboard.kelola.acara', [
            'dataAcara' => $dataAcara,
        ]);
    }
}
