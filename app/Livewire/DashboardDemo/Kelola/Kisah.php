<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\KelolaUndangan\ImgKisahCinta;
use App\Models\KelolaUndangan\KisahCinta;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
// use App\Models\KelolaUndangan\KisahCinta;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kisah extends Component
{
    use WithFileUploads;

    public $title = '';

    public $idKisah;

    public $judul = '';

    public $cerita = '';

    public $dataId;

    public $kisahCInta;

    public $image;

    public $poto = [];

    public $modal;

    public function mount($id)
    {
        $this->dataId = Crypt::decryptString($id);
        $this->kisahCInta = KisahCinta::where('data_id', $this->dataId)->get();
        $this->image = ImgKisahCinta::where('data_id', $this->dataId)->first();
    }

    public function resetField()
    {
        $this->idKisah = null;
        $this->judul = '';
        $this->cerita = '';
    }

    public function modalAddKisah()
    {
        $this->resetField();
        $this->dispatch('open-modal', name: 'kisah-modal');
    }

    public function modalEditKisah($id)
    {
        $this->idKisah = $id;
        $kisah = KisahCinta::find($id);
        $this->judul = $kisah->title;
        $this->cerita = $kisah->deskripsi;
        $this->title = "Edit Kisah";
        $this->dispatch('open-modal', name: 'kisah-modal');
    }

    public function close()
    {
        $this->dispatch('close-modal', name: 'kisah-modal');
        $this->resetField();
    }

    public function delete($id)
    {
        $k = KisahCinta::find($id);
        $k->delete();
        session()->flash('message', 'Kisah Cinta Telah Dihapus.');
        $this->kisahCInta = KisahCinta::where('data_id', $this->dataId)->get();
    }

    public function updatedPhotos($value, $itemId)
    {
        // Tangani file yang diunggah untuk item tertentu
        $this->poto[$itemId] = $value;
    }

    public function triggerFileInput($itemId)
    {
        $this->dispatch('triggerFileInput', ['itemId' => $itemId]);
    }

    public function saveImage($id)
    {
        // dd($this->poto);
        if (! $this->poto) {
            session()->flash('message', 'Upload Gambar Terlebih Dahulu!');

            return;
        }
        $imagePath = $this->poto[$id]->store('kisah', 'public');  // Menyimpan gambar di folder 'kisah' pada storage 'public'

        // Mengambil data gambar dari database berdasarkan ID
        $img = ImgKisahCinta::where('kisah_id', $id)->first();

        if (! $img) {
            ImgKisahCinta::create([
                'data_id' => $this->dataId,
                'kisah_id' => $id,
                'image' => $imagePath,
            ]);
            $this->kisahCInta = KisahCinta::where('data_id', $this->dataId)->get();
            $this->image = ImgKisahCinta::where('data_id', $this->dataId)->first();
            session()->flash('message', 'Gambar Kisah Cinta Kamu Berhasil Dibuat.');
        } else {
            if ($img->image) {
                Storage::delete('public/'.$img->image);  // Hapus gambar lama
            }
            $img->update([
                'image' => $imagePath,
            ]);
            $this->kisahCInta = KisahCinta::where('data_id', $this->dataId)->get();
            $this->image = ImgKisahCinta::where('data_id', $this->dataId)->first();
            session()->flash('message', 'Gambar Kisah Cinta Kamu Berhasil Diupdate.');
        }
    }

    public function save()
    {
        if ($this->idKisah) {
            $kisah = KisahCinta::find($this->idKisah);
            if ($kisah) {
                $kisah->update([
                    'title' => $this->judul,
                    'deskripsi' => $this->cerita,
                ]);
                session()->flash('message', 'Kisah Cinta Kamu Berhasil Diperbarui.');
            }
        } else {
            KisahCinta::create([
                'data_id' => $this->dataId,
                'title' => $this->judul,
                'deskripsi' => $this->cerita,
            ]);
            session()->flash('message', 'Kisah Cinta Kamu Berhasil Dibuat.');
        }
        $this->kisahCInta = KisahCinta::where('data_id', $this->dataId)->get();
        $this->close();
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.kisah')->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Kisah Cinta',
        ]);
    }
}
