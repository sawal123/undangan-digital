<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\Data;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\teksWhatsApp;
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
        $data = Data::find($this->undang->data_id);
        if ($this->undang) {
            $namaTamu = $this->undang->nama; // Nama tamu dari database

            // Membuat teks undangan
            $pesan = teksWhatsApp::where('data_id', $this->undang->data_id)->first()->pesan;

            $dataPengganti = [
                'tamu' => $this->undang->nama,
                'nama_mempelai1' => $data->wanita->nama_panggilan,
                'nama_mempelai2' => $data->pria->nama_panggilan,
                'link' => url('/u') . '/' . $data->slug . '/' . $this->undang->kode,
            ];
            $pesanFinal = str_replace(
                ['{{tamu}}', '{{nama_mempelai1}}', '{{nama_mempelai2}}', '{{link}}'],
                [$dataPengganti['tamu'], $dataPengganti['nama_mempelai1'], $dataPengganti['nama_mempelai2'], $dataPengganti['link']],
                $pesan
            );
            // dd($pesanFinal);

            

            // Mengonversi teks pesan ke URL encoded
            $pesanEncoded = urlencode($pesanFinal);
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
            ? KelolaUndanganTamu::orderBy('id', 'desc')->where('data_id', $this->dataId)->paginate(5)
            : KelolaUndanganTamu::where('nama', 'LIKE', '%' . $this->query . '%')->where('data_id', $this->dataId)
            ->orWhere('kode', 'LIKE', '%' . $this->query . '%')
            ->orWhere('nomor', 'LIKE', '%' . $this->query . '%')
            ->orderBy('id', 'desc')->paginate(5);
        return view('livewire.dashboard.kelola.tamu', [
            'tamu' => $tamu
        ]);
    }
}
