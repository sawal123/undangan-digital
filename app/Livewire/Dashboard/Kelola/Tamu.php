<?php

namespace App\Livewire\Dashboard\Kelola;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\KelolaUndangan\Tamu as Tamus;
use App\Models\KelolaUndangan\Tamu as KelolaUndanganTamu;

class Tamu extends Component
{
    use WithPagination;
    public $dataId;
    public $nama;
    public $whatsapp;
    public $query;
    public $undang;
    public $idTamu = null;
    public $slug = "";
    public $invite = [];
    public $title = 'Add Tamu';
    public function close()
    {
       
        $this->dispatch('closeDelModal');
        
 
    }
 


    public function shareWA($id)
    {
        $this->undang = Tamus::find($id);
        if ($this->undang) {
            $namaTamu = $this->undang->nama; // Nama tamu dari database
            $linkUndangan = url('/') . '/' . $this->undang->data->slug . '/241025189525'; // Link undangan

            // Membuat teks undangan
            $pesan = "Kepada {$namaTamu}, Kami mengundang saudara/(i) untuk menghadiri acara pernikahan kami *dsd & d*.
    Pesan ini merupakan undangan resmi dari kami.
    Silahkan kunjungi link berikut untuk membuka undangan anda: {$linkUndangan}
    Atas kehadiran & doa restu dari saudara, kami ucapkan terimakasih.
    ===========================
    _Pesan ini dikirim melalui_ wevitation.com";

            // Mengonversi teks pesan ke URL encoded
            $pesanEncoded = urlencode($pesan);
            $whatsappUrl = "https://wa.me/{$this->undang->nomor}/?text={$pesanEncoded}";

            $this->dispatch('open-new-tab', ['url' => $whatsappUrl]);
        }
    }
    public function delete($kode)
    {
        $tamu = Tamus::where('kode', $kode)->first();
        $tamu->delete();
        session()->flash('message', 'Tamu Berhasil Didelete.');
    }
    public function shareTamu($id)
    {
        $this->undang = Tamus::find($id);
        if ($this->undang) {
            $this->invite = [$this->undang->nama, $this->undang->kode];
        }
        $this->slug = url('/') . '/' . $this->undang->data->slug . '/' . $this->undang->kode;
    }
    public function EditTamu($id)
    {
        $this->undang = Tamus::find($id);

        $this->idTamu = $this->undang->id;
        $this->nama = $this->undang->nama;
        $this->whatsapp = $this->undang->nomor;

        // $this->dispatch('openModalEdit');
        $this->title = "Edit Tamu";
    }
    public function save()
    {
        $tamu = KelolaUndanganTamu::where('id', $this->idTamu)->first();
        if ($tamu) {
            $tamu->update([
                'nama' => $this->nama,
                'nomor' => $this->whatsapp
            ]);
            session()->flash('message', 'Tamu Berhasil DiUpdate.');
            $this->dispatch('closeEditTamu');
        } else {
            $kode = rand(99, 9999);
            KelolaUndanganTamu::create([
                'data_id' => $this->dataId,
                'nama' => $this->nama,
                'kode' => $kode,
                'nomor' => $this->whatsapp,
                'slug' => Str::slug($this->nama)
            ]);
            session()->flash('message', 'Tamu Berhasil Ditambahkan.');
            $this->dispatch('closeAddTamu');
        }

        KelolaUndanganTamu::where('data_id', $this->dataId)->get();
        $this->resetField();
        
    }
    public function resetField()
    {
        $this->nama = '';
        $this->whatsapp = '';
    }

    public function render()
    {
        $tamu = empty($this->query)
            ? KelolaUndanganTamu::orderBy('id', 'desc')->paginate(5)
            : KelolaUndanganTamu::where('nama', 'LIKE', '%' . $this->query . '%')
            ->orWhere('kode', 'LIKE', '%' . $this->query . '%')
            ->orWhere('nomor', 'LIKE', '%' . $this->query . '%')
            ->orderBy('id', 'desc')->paginate(5);
        return view('livewire.dashboard.kelola.tamu', [
            'tamu' => $tamu
        ]);
    }
}
