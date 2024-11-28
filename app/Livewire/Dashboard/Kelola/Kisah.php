<?php

namespace App\Livewire\Dashboard\Kelola;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\KelolaUndangan\KisahCinta;
use App\Models\KelolaUndangan\ImgKisahCinta;

class Kisah extends Component
{
    use WithFileUploads;
    public $title = '';

    public $judul = '';
    public $cerita = '';
    public $dataId;
    public $kisahCInta;
    public $image;
    public $poto = [];

    public $modal;
    public function mount()
    {
        $this->kisahCInta = KisahCinta::where('data_id', $this->dataId)->get();
        $this->image = ImgKisahCinta::where('data_id', $this->dataId)->first();
    }

    public function resetField()
    {
        $this->judul = '';
        $this->cerita = '';
    }
    public function modalEditKisah($id){
        $k = KisahCinta::where('id', $id)->first();
        $this->judul = $k->title;
        $this->cerita = $k->deskripsi;
        $this->modal = "EditKisah";
    }
    public function modalAddKisah()
    {   
        $this->modal = "AddKisah";

        $this->title = "Tambah Kisah Cinta Kamu!";
    }
    public function close()
    {
        $this->dispatch('closeAddKisah');
        $this->resetField();
    }

    public function delete($id){
        $k = KisahCinta::find($id);
        $k->delete();
        session()->flash('message', 'Kisah Cinta Telah Dihapus.');
        $this->mount();
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
        if (!$this->poto) {
            session()->flash('message', 'Upload Gambar Terlebih Dahulu!');
            return;
        }
        $imagePath = $this->poto[$id]->store('kisah', 'public');  // Menyimpan gambar di folder 'kisah' pada storage 'public'


        // Mengambil data gambar dari database berdasarkan ID
        $img = ImgKisahCinta::where('kisah_id',$id)->first();

        if (!$img) {
            ImgKisahCinta::create([
                'data_id' => $this->dataId,
                'kisah_id' => $id,
                'image' => $imagePath
            ]);
            $this->mount();  // Menyegarkan komponen Livewire
            session()->flash('message', 'Gambar Kisah Cinta Kamu Berhasil Dibuat.');
        } else {
            if ($img->image) {
                Storage::delete('public/' . $img->image);  // Hapus gambar lama
            }
            $img->update([
                'image' => $imagePath
            ]);
            $this->mount();  // Menyegarkan komponen Livewire
            session()->flash('message', 'Gambar Kisah Cinta Kamu Berhasil Diupdate.');
        }
    }
    public function save()
    {
        $kisah = KisahCinta::where('data_id', $this->dataId)->first();
        // dd($kisah);
        KisahCinta::create([
            'data_id' => $this->dataId,
            'title' => $this->judul,
            'deskripsi' => $this->cerita
        ]);
        $this->mount();
        session()->flash('message', 'Kisah Cinta Kamu Berhasil Dibuat.');
        $this->close();
    }
    public function render()
    {
        return view('livewire.dashboard.kelola.kisah');
    }
}
