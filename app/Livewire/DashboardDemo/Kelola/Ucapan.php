<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Ucapan as KelolaUndanganUcapan;
use Livewire\Component;
use Livewire\WithPagination;

class Ucapan extends Component
{
    use LoadsOwnedInvitation;
    use WithPagination;

    public $dataId;

    public $fitUcapan;

    public $isFitur;

    public $isPublic;

    public $isView;

    public $balas = [];

    public $query;

    public $deleteId;

    public function close()
    {
        $this->dispatch('close-modal', name: 'delete-modal');
    }

    public function tanggapi($id)
    {
        $balas = $this->balas[$id] ?? null;
        $ucapan = KelolaUndanganUcapan::where('data_id', $this->dataId)->find($id);
        // dd($balas);
        if ($ucapan) {
            if (! $ucapan->balas || $ucapan->balas) {
                $ucapan->balas = $balas;
                $ucapan->save();
            }
        }
        $this->balas = [];
        $ucapan = KelolaUndanganUcapan::where('id', $id)->first();
    }

    public function mount($id)
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->fitUcapan = FiturUcapan::where('data_id', $this->dataId)->first();
    }

    public function data($id)
    {
        $this->fitUcapan = FiturUcapan::where('data_id', $this->dataId)->first();
    }

    public function updateFiturUcapan($id, $isFitur, $column)
    {
        abort_unless(in_array($column, ['isActive', 'publicIsActive', 'viewIsActive'], true), 422);

        $fitur = FiturUcapan::where('data_id', $this->dataId)->first();
        if (! $fitur) {
            FiturUcapan::create([
                'data_id' => $this->dataId,
                $column => true,
            ]);
        } else {
            $fitur->update([
                $column => $isFitur,
            ]);
        }
        $this->data($this->dataId);
    }

    public function delete($id)
    {
        $delete = KelolaUndanganUcapan::with('tamu')->where('data_id', $this->dataId)->find($id);
        if ($delete) {
            $delete->delete();
            $ucapan = KelolaUndanganUcapan::where('data_id', $delete->data_id)->get();
            session()->flash('message', 'Ucapan & Doa '.$delete->tamu->nama.' Dihapus Permanen');
        }
    }

    public function render()
    {
        $ucapan = empty($this->query)
            ? KelolaUndanganUcapan::where('data_id', $this->dataId)->paginate(5)
            : KelolaUndanganUcapan::with('tamu')->where('data_id', $this->dataId) // Memuat relasi tamu
                ->when($this->query, function ($query) {
                    $query->where(function ($query) {   // Membungkus kondisi pencarian
                        $query->where('ucapan', 'LIKE', '%'.$this->query.'%')
                            ->orWhere('status', 'LIKE', '%'.$this->query.'%')
                            ->orWhere('balas', 'LIKE', '%'.$this->query.'%')
                            ->orWhereHas('tamu', function ($query) { // Menambahkan pencarian relasi tamu
                                $query->where('nama', 'LIKE', '%'.$this->query.'%');
                            });
                    });
                })
                ->paginate(5);

        return view('livewire.dashboard.kelola.ucapan', compact('ucapan'))->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Ucapan',
        ]);
    }
}
