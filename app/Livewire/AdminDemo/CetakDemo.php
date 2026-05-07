<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\JenisUdangan;
use App\Models\Admin\UndanganCetak;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CetakDemo extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    
    public $nama, $jenis, $stok, $terjual, $harga, $promo, $deskripsi, $undangan_id;
    public $thumbnails = [];
    public $isEdit = false;
    
    public $jenisUndangan; // For adding new category
    public $idJenis;

    public function render()
    {
        $undanganData = UndanganCetak::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin-demo.cetak-demo', [
            'undangan' => $undanganData,
            'categories' => JenisUdangan::all()
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->nama = '';
        $this->jenis = '';
        $this->stok = '';
        $this->terjual = '';
        $this->harga = '';
        $this->promo = '';
        $this->deskripsi = '';
        $this->thumbnails = [];
        $this->undangan_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'thumbnails.*' => 'image|max:2048',
        ]);

        $thumbnailPaths = [];
        if ($this->thumbnails) {
            foreach ($this->thumbnails as $thumbnail) {
                $thumbnailPaths[] = $thumbnail->store('thumbnails', 'public');
            }
        }

        UndanganCetak::create([
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'stok' => $this->stok,
            'terjual' => $this->terjual ?? 0,
            'harga' => $this->harga,
            'promo' => $this->promo,
            'deskripsi' => $this->deskripsi,
            'gambar' => json_encode($thumbnailPaths),
        ]);

        session()->flash('message', 'Undangan Cetak successfully created.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'cetak-modal');
    }

    public function edit($id)
    {
        $u = UndanganCetak::findOrFail($id);
        $this->undangan_id = $id;
        $this->nama = $u->nama;
        $this->jenis = $u->jenis;
        $this->stok = $u->stok;
        $this->terjual = $u->terjual;
        $this->harga = $u->harga;
        $this->promo = $u->promo;
        $this->deskripsi = $u->deskripsi;
        // Keep existing thumbnails as strings if needed, but for preview we need careful handling
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'cetak-modal');
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        $u = UndanganCetak::findOrFail($this->undangan_id);
        
        $data = [
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'stok' => $this->stok,
            'terjual' => $this->terjual,
            'harga' => $this->harga,
            'promo' => $this->promo,
            'deskripsi' => $this->deskripsi,
        ];

        if ($this->thumbnails) {
            $existingImages = json_decode($u->gambar, true) ?? [];
            $newImages = [];
            foreach ($this->thumbnails as $thumbnail) {
                if (is_object($thumbnail)) {
                    $newImages[] = $thumbnail->store('thumbnails', 'public');
                }
            }
            $data['gambar'] = json_encode(array_merge($existingImages, $newImages));
        }

        $u->update($data);

        session()->flash('message', 'Undangan Cetak successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'cetak-modal');
    }

    public function delete($id)
    {
        $u = UndanganCetak::findOrFail($id);
        $images = json_decode($u->gambar, true) ?? [];
        foreach ($images as $img) {
            Storage::disk('public')->delete($img);
        }
        $u->delete();
        session()->flash('message', 'Undangan Cetak successfully deleted.');
    }

    public function createCategory()
    {
        $this->validate(['jenisUndangan' => 'required|string|max:255']);
        JenisUdangan::create(['jenis' => $this->jenisUndangan]);
        $this->jenisUndangan = '';
        session()->flash('message', 'Kategori berhasil ditambahkan.');
    }
}
