<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Animation as AdminAnimation;

class Animation extends Component
{
    use WithFileUploads;
    public $isModalOpen = false;
    public $delModalOpen = false;
    public $modalDelete = false;
    public $editModalOpen = false;
    public $animation;

    public $nama;
    public $link;
    public $thumbnail;
    public $judul;
    public function openModal()
    {
        $this->judul = "Tambah";
        $this->isModalOpen = true;
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->delModalOpen = false;
    }

    public function conversi()
    {
        if (strpos($this->link, 'youtube.com/shorts/') !== false) {
            $parts = explode('shorts/', $this->link);
            $videoId = end($parts);
            $this->link = "https://www.youtube.com/embed/" . $videoId;
        } elseif (strpos($this->link, 'watch?v=') !== false) {
            $parts = explode('v=', $this->link);
            $videoId = end($parts);
            $this->link = "https://www.youtube.com/embed/" . $videoId;
        }
    }

    public function saveAnimation()
    {
        $this->conversi();
        // dd($this->nama);
        $imagePath = is_object($this->thumbnail) ? $this->thumbnail->store('animation', 'public') : null;
        $animasi = AdminAnimation::create([
            'nama' => $this->nama,
            'link' => $this->link,
            'thumbnail' => $imagePath
        ]);
        session()->flash('message', 'Undangan Animasi Telah Tersimpan.');
        $this->mount();
        $this->closeModal();
    }
    public $animasi;
    public function confirmDel($id)
    {
        $this->delModalOpen = true;
        $this->animasi = AdminAnimation::find($id);
    }
    public function delAnimasi($id)
    {
        $this->animasi = AdminAnimation::find($id);
        $this->animasi->delete();
        session()->flash('message', 'Undangan Animasi Telah Dihapus.');
        $this->mount();
        $this->closeModal();
    }
    public $UpAnimasi;
    public function editAnimasi($id)
    {

        $this->judul = "Edit";
        $this->UpAnimasi = AdminAnimation::find($id);

        $this->nama = $this->UpAnimasi->nama;
        $this->link = $this->UpAnimasi->link;
        // $this->thumbnail = $this->UpAnimasi->thumbnail;
        $this->isModalOpen = true;
    }
    public function updateAnimasi()
    {
        $this->conversi();
        $a  = AdminAnimation::find($this->UpAnimasi->id);
        // dd($this->thumbnail);
        if ($this->thumbnail) {
            Storage::delete('public/' . $a->thumbnail);  // Hapus gambar lama
            $imagePath = is_object($this->thumbnail) ? $this->thumbnail->store('animation', 'public') : null;
            $a->update([
                'nama' => $this->nama,
                'link' => $this->link,
                'thumbnail' =>   $imagePath
            ]);
        } else {
            $a->update([
                'nama' => $this->nama,
                'link' => $this->link,
            ]);
        }

        session()->flash('message', 'Undangan Animasi Telah Diupdate.');
        $this->mount();
        $this->closeModal();
    }

    public function mount()
    {
        $this->animation = AdminAnimation::all();
    }
    public function render()
    {
        return view('livewire.admin.animation');
    }
}
