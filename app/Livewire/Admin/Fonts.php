<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fonts as ModelsFonts;

class Fonts extends Component
{
    use WithPagination;

    public $search = '';
    public $font_id, $nama, $link, $is_active;
    public $isModalOpen = false;
    public $delModalOpen = false;
    public $judul = 'Tambah';
    public function openModal()
    {
        $this->isModalOpen = true;
    }
    public function delFont($id)
    {
        $font = ModelsFonts::find($id);
        $font->delete();
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('message', 'Font berhasil diDelete!');
    }
    public function editFont($id)
    {
        $this->font_id = $id;
        $this->isModalOpen = true;
        $font = ModelsFonts::find($id);
        // dd($user);
        $this->nama = $font->nama;
        $this->link = $font->link;
        $this->is_active = $font->is_active;
        $this->judul = 'Edit';
    }

    public function updateFont()
    {
        $font = ModelsFonts::find($this->font_id);
        // dd($user);
        $font->update([
            'nama' => $this->nama,
            'link' => $this->link,
            'is_active' => $this->is_active,
        ]);
        $font->save();
        $this->closeModal(); // Tutup modal setelah penyimpanan
        session()->flash('message', 'Font berhasil diUpdate!');
    }

    // reset pagination kalau pencarian berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->delModalOpen = false;
        $this->resetInputFields();
    }
    public function resetInputFields()
    {
        $this->nama = '';
        $this->link = '';
        $this->is_active = true;
        $this->font_id = null;
        $this->judul = 'Tambah';
    }
    public function confirmDel($id)
    {
        $this->font_id = $id;
        $this->delModalOpen = true;
    }
    public function saveFont(){
        $validatedData = $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);
        ModelsFonts::create($validatedData);
        $this->closeModal();
        session()->flash('message', 'Font berhasil ditambahkan.');
    }

    public function render()
    {
        $fonts = ModelsFonts::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', "%{$this->search}%")
                        ->orWhere('link', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.fonts', [
            'fonts' => $fonts,
        ]);
    }
}
