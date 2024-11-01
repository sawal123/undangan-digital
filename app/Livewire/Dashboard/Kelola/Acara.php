<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\KelolaUndangan\Acara as KelolaUndanganAcara;
use Livewire\Component;

class Acara extends Component
{
    public $dataId;
    public $acara;
    public $vanue;
    public $alamat;
    public $date;
    public $start;
    public $end;
    public $zona;
    public $maps='';

    public $dataAcara;

    protected $rules = [
        'acara' => 'required|string|max:255',
        'vanue' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'date' => 'required|string|max:255',
        'start' => 'required|string|max:255',
        'end' => 'required|string|max:255',
        'zona' => 'required|string|max:255',
        'maps' => 'string|max:255',
    ];
    

    public function save()
    {
        $this->validate();
        KelolaUndanganAcara::create([
            'data_id' => $this->dataId,
            'nama_acara' => $this->acara,
            'vanue' => $this->vanue,
            'alamat' => $this->alamat,
            'date' => $this->date,
            'jam_start' => $this->start,
            'jam_end' => $this->end,
            'zona_waktu' => $this->zona,
            'maps' => $this->maps,
        ]);
        session()->flash('message', 'Data Acara Berhasil Disimpan.');
        $this->dataAcara = KelolaUndanganAcara::where('data_id', $this->dataId)->get();
        $this->dispatch('close-modal');

    }

    public function mount($dataId)
    {
        $this->dataId = $dataId;
        $this->dataAcara = KelolaUndanganAcara::where('data_id', $this->dataId)->get();
      
    }
    
    public function render()
    {
        return view('livewire.dashboard.kelola.acara', [
            'dataAcara'=> $this->dataAcara
        ]);
    }
}
