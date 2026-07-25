<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\ImgKisahCinta;
use App\Models\KelolaUndangan\KisahCinta;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kisah extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    public $title = '';

    public $idKisah;

    public $judul = '';

    public $cerita = '';

    public $dataId;

    public $kisahCInta;

    public $image;

    public $poto = [];

    public $formImage;

    public $modal;

    public function mount($id)
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->loadKisah();
    }

    public function loadKisah()
    {
        $this->kisahCInta = KisahCinta::with('image')->where('data_id', $this->dataId)->get();
    }

    public function resetField()
    {
        $this->idKisah = null;
        $this->judul = '';
        $this->cerita = '';
        $this->formImage = null;
    }

    public function modalAddKisah()
    {
        $this->resetField();
        $this->dispatch('open-modal', name: 'kisah-modal');
    }

    public function modalEditKisah($id)
    {
        $this->idKisah = $id;
        $kisah = KisahCinta::where('data_id', $this->dataId)->findOrFail($id);
        $this->judul = $kisah->title;
        $this->cerita = $kisah->deskripsi;
        $this->formImage = null;
        $this->title = 'Edit Kisah';
        $this->dispatch('open-modal', name: 'kisah-modal');
    }

    public function close()
    {
        $this->dispatch('close-modal', name: 'kisah-modal');
        $this->resetField();
    }

    public function delete($id)
    {
        $k = KisahCinta::where('data_id', $this->dataId)->findOrFail($id);
        if ($k) {
            // Hapus gambar jika ada
            $img = ImgKisahCinta::where('data_id', $this->dataId)->where('kisah_id', $id)->first();
            if ($img && $img->image) {
                Storage::delete('public/'.$img->image);
            }
            $k->delete();
            session()->flash('message', 'Kisah Cinta Telah Dihapus.');
            $this->loadKisah();
        }
    }

    public function updatedPhotos($value, $itemId)
    {
        $this->poto[$itemId] = $value;
    }

    public function triggerFileInput($itemId)
    {
        $this->dispatch('triggerFileInput', ['itemId' => $itemId]);
    }

    public function saveImage($id)
    {
        if (! isset($this->poto[$id]) || ! $this->poto[$id]) {
            session()->flash('message', 'Upload Gambar Terlebih Dahulu!');

            return;
        }
        $this->validate([
            'poto.'.$id => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        KisahCinta::where('data_id', $this->dataId)->findOrFail($id);
        $imagePath = $this->poto[$id]->store('kisah', 'public');

        $img = ImgKisahCinta::where('data_id', $this->dataId)->where('kisah_id', $id)->first();

        if (! $img) {
            ImgKisahCinta::create([
                'data_id' => $this->dataId,
                'kisah_id' => $id,
                'image' => $imagePath,
            ]);
            $this->loadKisah();
            $this->poto[$id] = null;
            session()->flash('message', 'Gambar Kisah Cinta Kamu Berhasil Dibuat.');
        } else {
            if ($img->image) {
                Storage::delete('public/'.$img->image);
            }
            $img->update([
                'image' => $imagePath,
            ]);
            $this->loadKisah();
            $this->poto[$id] = null;
            session()->flash('message', 'Gambar Kisah Cinta Kamu Berhasil Diupdate.');
        }
    }

    public function save()
    {
        $storyId = null;
        $this->validate([
            'judul' => 'required|string|max:255',
            'cerita' => 'required|string|max:1000',
            'formImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($this->idKisah) {
            $kisah = KisahCinta::where('data_id', $this->dataId)->find($this->idKisah);
            if ($kisah) {
                $kisah->update([
                    'title' => $this->judul,
                    'deskripsi' => $this->cerita,
                ]);
                $storyId = $kisah->id;
                session()->flash('message', 'Kisah Cinta Kamu Berhasil Diperbarui.');
            }
        } else {
            $kisah = KisahCinta::create([
                'data_id' => $this->dataId,
                'title' => $this->judul,
                'deskripsi' => $this->cerita,
            ]);
            $storyId = $kisah->id;
            session()->flash('message', 'Kisah Cinta Kamu Berhasil Dibuat.');
        }

        // Tangani upload gambar dari modal form
        if ($storyId && $this->formImage) {
            $imagePath = $this->formImage->store('kisah', 'public');
            $img = ImgKisahCinta::where('data_id', $this->dataId)->where('kisah_id', $storyId)->first();
            if ($img) {
                if ($img->image) {
                    Storage::delete('public/'.$img->image);
                }
                $img->update(['image' => $imagePath]);
            } else {
                ImgKisahCinta::create([
                    'data_id' => $this->dataId,
                    'kisah_id' => $storyId,
                    'image' => $imagePath,
                ]);
            }
        }

        $this->loadKisah();
        $this->close();
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.kisah')->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Kisah Cinta',
        ]);
    }
}
