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
    public $selesai;
    public $zona;
    public $maps = '';

    public $deleteId;

    public $selectedAcaraId;

    public $dataAcara;

    protected $rules = [
        'acara' => 'required|string|max:255',
        'vanue' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'date' => 'required|string|max:255',
        'start' => 'required|string|max:255',
        'zona' => 'required|string|max:255',
        'maps' => 'string|max:255',
    ];
    protected $messages = [
        'zona.required' => 'Zona Waktu Belum Diisi',
        'acara.required' => 'Nama Acara wajib diisi!',
        'vanue.required' => 'Nama Vanue wajib diisi!',
        'vanue.required' => 'Nama Vanue wajib diisi!',
        'zona.required' => 'Nama Vanue wajib diisi!',
        // Tambah pesan lain sesuai kebutuhan
    ];


    public function edit($id)
    {
        $acara = KelolaUndanganAcara::findOrFail($id);


        $this->selectedAcaraId = $acara->id;
        $this->acara = $acara->nama_acara;
        $this->vanue = $acara->vanue;
        $this->alamat = $acara->alamat;
        $this->date = $acara->date;
        $this->start = $acara->jam_start;
        $this->end = $acara->jam_end;
        $this->selesai = $acara->jam_end == 'Selesai' ? true : false;
        $this->zona = $acara->zona_waktu;
        $this->maps = $acara->maps;
        $this->dispatch('openEditModal');
        // dd($acara);
    }



    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('openDeleteModal');
        // $this->dispatch('open-delete-modal'); 
    }


    public function delete()
    {
        KelolaUndanganAcara::find($this->deleteId)->delete();
        $this->dataAcara = KelolaUndanganAcara::where('data_id', $this->dataId)->get();
        session()->flash('message', 'Data Acara Berhasil Dihapus.');
        $this->dispatch('close-hapus');
    }
    public function close()
    {
        $this->dispatch('tutup-modal');
        $this->dispatch('close-modal');
        $this->dispatch('close-hapus');
        $this->resetInputFields();
    }
    public function save()
    {
        $this->validate();

        if ($this->selectedAcaraId) {
            // Update jika ada `selectedAcaraId`
            $acara = KelolaUndanganAcara::find($this->selectedAcaraId);
            $acara->update([
                'nama_acara' => $this->acara,
                'vanue' => $this->vanue,
                'alamat' => $this->alamat,
                'date' => $this->date,
                'jam_start' => $this->start,
                'jam_end' => $this->selesai == 1 || $this->end == '' ? 'Selesai' : $this->end,
                'zona_waktu' => $this->zona,
                'maps' => $this->maps,
            ]);
            session()->flash('message', 'Data acara berhasil diperbarui.');
            $this->dispatch('tutup-modal');
        } else {
            // Create jika `selectedAcaraId` kosong
            KelolaUndanganAcara::create([
                'data_id' => $this->dataId,
                'nama_acara' => $this->acara,
                'vanue' => $this->vanue,
                'alamat' => $this->alamat,
                'date' => $this->date,
                'jam_start' => $this->start,
                'jam_end' =>  $this->selesai == 1 || $this->end == '' ? 'Selesai' : $this->end,
                'zona_waktu' => $this->zona,
                'maps' => $this->maps,
            ]);
            $this->resetInputFields();
            session()->flash('message', 'Data acara berhasil disimpan.');
            $this->dispatch('close-modal');
        }
        // session()->flash('message', 'Data Acara Berhasil Disimpan.');
        $this->dataAcara = KelolaUndanganAcara::where('data_id', $this->dataId)->get();
    }

    public function mount($dataId)
    {
        $this->dataId = $dataId;
        $this->dataAcara = KelolaUndanganAcara::where('data_id', $this->dataId)->get();
    }

    private function resetInputFields()
    {
        $this->acara = '';
        $this->vanue = '';
        $this->alamat = '';
        $this->date = '';
        $this->start = '';
        $this->end = '';
        $this->selesai = false;
        $this->zona = '';
        $this->maps = '';
        $this->selectedAcaraId = null;
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.acara', [
            'dataAcara' => $this->dataAcara
        ]);
    }
}
