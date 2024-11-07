<?php

namespace App\Livewire\Dashboard\Kelola;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Ucapan as KelolaUndanganUcapan;

class Ucapan extends Component
{
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
        $this->dispatch('closeDelModal');
    }
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('openDelModal');
    }


    public function tanggapi($id)
    {
        $balas = $this->balas[$id] ?? null;
        $ucapan = KelolaUndanganUcapan::find($id);
        if ($ucapan) {
            if (!$ucapan->balas || $ucapan->balas) {
                $ucapan->balas = $balas;
                $ucapan->save();
            }
        }
        $this->balas = [];
        $ucapan = KelolaUndanganUcapan::where('id', $id)->first();
    }

    public function mount()
    {
        $this->fitUcapan = FiturUcapan::where('data_id', $this->dataId)->first();
    }
    public function data($id)
    {
        $this->fitUcapan = FiturUcapan::where('data_id', $id)->first();
    }
    public function updateFiturUcapan($id, $isFitur, $column)
    {
        $fitur = FiturUcapan::where('data_id', $id)->first();
        if (!$fitur) {
            FiturUcapan::create([
                'data_id' => $id,
                $column => true,
            ]);
        } else {
            $fitur->update([
                $column => $isFitur,
            ]);
        }
        $this->data($id);
    }

    public function delete()
    {
        // dd($id);
        $delete = KelolaUndanganUcapan::find($this->deleteId);
        $delete->delete();
        $ucapan = KelolaUndanganUcapan::where('data_id', $delete->data_id)->get();
        session()->flash('message', 'Ucapan & Doa ' . $delete->tamu->nama . ' Dihapus Permanen');
        $this->dispatch('closeDelModal');  // Menutup modal setelah penghapusan
    }
    public function render()
    {
        $ucapan = empty($this->query)
            ? KelolaUndanganUcapan::paginate(5)
            : KelolaUndanganUcapan::with('tamu')  // Memuat relasi tamu
            ->when($this->query, function ($query) {
                $query->where(function ($query) {   // Membungkus kondisi pencarian
                    $query->where('ucapan', 'LIKE', '%' . $this->query . '%')
                        ->orWhere('status', 'LIKE', '%' . $this->query . '%')
                        ->orWhere('balas', 'LIKE', '%' . $this->query . '%')
                        ->orWhereHas('tamu', function ($query) { // Menambahkan pencarian relasi tamu
                            $query->where('nama', 'LIKE', '%' . $this->query . '%');
                        });
                });
            })
            ->paginate(5);

        return view('livewire.dashboard.kelola.ucapan', compact('ucapan'));
    }
}
