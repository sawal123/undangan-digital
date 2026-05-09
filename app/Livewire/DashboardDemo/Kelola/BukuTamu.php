<?php

namespace App\Livewire\DashboardDemo\Kelola;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class BukuTamu extends Component
{
    public $dataId;
    public $search = '';

    public function mount($id)
    {
        $this->dataId = Crypt::decryptString($id);
    }

    public function render()
    {
        $data = \App\Models\KelolaUndangan\Ucapan::where('data_id', $this->dataId)
            ->with('tamu')
            ->when($this->search, function($q) {
                $q->whereHas('tamu', function($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%');
                })->orWhere('ucapan', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.dashboard.kelola.buku-tamu', [
            'data' => $data
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Buku Tamu'
        ]);
    }
}
