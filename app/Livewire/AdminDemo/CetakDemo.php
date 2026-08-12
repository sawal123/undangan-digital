<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\JenisUdangan;
use App\Models\Admin\UndanganCetak;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CetakDemo extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';

    public int $perPage = 10;

    public string $nama = '';

    public ?int $jenis_id = null;

    public string $stok = '';

    public string $terjual = '0';

    public string $harga = '';

    public string $harga_modal = '0';

    public string $ukuran_opp = '';

    public string $promo = '0';

    public string $deskripsi = '';

    public ?int $undangan_id = null;

    public array $thumbnails = [];

    public bool $isEdit = false;

    public string $jenisUndangan = '';

    public ?int $idJenis = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $undanganData = UndanganCetak::query()
            ->with('jenisUndangan')
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('nama', 'like', $searchTerm)
                        ->orWhereHas('jenisUndangan', function ($q) use ($searchTerm) {
                            $q->where('jenis', 'like', $searchTerm);
                        })
                        ->orWhere('harga_modal', 'like', $searchTerm)
                        ->orWhere('ukuran_opp', 'like', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate($this->perPage);

        return view('livewire.admin-demo.cetak-demo', [
            'undangan' => $undanganData,
            'categories' => JenisUdangan::orderBy('jenis')->get(),
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->nama = '';
        $this->jenis_id = null;
        $this->stok = '';
        $this->terjual = '0';
        $this->harga = '';
        $this->harga_modal = '0';
        $this->ukuran_opp = '';
        $this->promo = '0';
        $this->deskripsi = '';
        $this->thumbnails = [];
        $this->undangan_id = null;
        $this->isEdit = false;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'cetak-modal');
    }

    public function store(): void
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jenis_id' => 'required|exists:jenis_udangans,id',
            'stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'harga_modal' => 'nullable|numeric|min:0',
            'ukuran_opp' => 'nullable|string|max:50',
            'promo' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'thumbnails.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $thumbnailPaths = [];
        if ($this->thumbnails) {
            foreach ($this->thumbnails as $thumbnail) {
                if (is_object($thumbnail)) {
                    $thumbnailPaths[] = $thumbnail->store('thumbnails', 'public');
                }
            }
        }

        try {
            DB::transaction(function () use ($thumbnailPaths) {
                UndanganCetak::create([
                    'nama' => trim($this->nama),
                    'jenis_id' => $this->jenis_id,
                    'stok' => (int) $this->stok,
                    'terjual' => (int) ($this->terjual ?: 0),
                    'harga' => (int) $this->harga,
                    'harga_modal' => (int) ($this->harga_modal ?: 0),
                    'ukuran_opp' => trim($this->ukuran_opp),
                    'promo' => (int) ($this->promo ?: 0),
                    'favorite' => 0,
                    'deskripsi' => trim($this->deskripsi),
                    'gambar' => $thumbnailPaths,
                ]);
            });

            session()->flash('message', 'Undangan cetak berhasil dibuat.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'cetak-modal');
        } catch (\Throwable $e) {
            foreach ($thumbnailPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            session()->flash('error', 'Gagal membuat undangan cetak: ' . $e->getMessage());
        }
    }

    public function edit(int $id): void
    {
        $u = UndanganCetak::findOrFail($id);
        $this->undangan_id = $u->id;
        $this->nama = $u->nama;
        $this->jenis_id = $u->jenis_id;
        $this->stok = (string) $u->stok;
        $this->terjual = (string) $u->terjual;
        $this->harga = (string) $u->harga;
        $this->harga_modal = (string) $u->harga_modal;
        $this->ukuran_opp = $u->ukuran_opp ?? '';
        $this->promo = (string) $u->promo;
        $this->deskripsi = $u->deskripsi ?? '';
        $this->thumbnails = [];
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'cetak-modal');
    }

    public function update(): void
    {
        if (!$this->undangan_id) {
            return;
        }

        $this->validate([
            'nama' => 'required|string|max:255',
            'jenis_id' => 'required|exists:jenis_udangans,id',
            'stok' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'harga_modal' => 'nullable|numeric|min:0',
            'ukuran_opp' => 'nullable|string|max:50',
            'promo' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'thumbnails.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $u = UndanganCetak::findOrFail($this->undangan_id);

        $data = [
            'nama' => trim($this->nama),
            'jenis_id' => $this->jenis_id,
            'stok' => (int) $this->stok,
            'terjual' => (int) ($this->terjual ?: 0),
            'harga' => (int) $this->harga,
            'harga_modal' => (int) ($this->harga_modal ?: 0),
            'ukuran_opp' => trim($this->ukuran_opp),
            'promo' => (int) ($this->promo ?: 0),
            'deskripsi' => trim($this->deskripsi),
        ];

        $newUploadedPaths = [];
        if ($this->thumbnails) {
            $existingImages = is_array($u->gambar) ? $u->gambar : [];
            foreach ($this->thumbnails as $thumbnail) {
                if (is_object($thumbnail)) {
                    $newUploadedPaths[] = $thumbnail->store('thumbnails', 'public');
                }
            }
            $data['gambar'] = array_merge($existingImages, $newUploadedPaths);
        }

        try {
            DB::transaction(function () use ($u, $data) {
                $u->update($data);
            });

            session()->flash('message', 'Undangan cetak berhasil diperbarui.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'cetak-modal');
        } catch (\Throwable $e) {
            foreach ($newUploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            session()->flash('error', 'Gagal memperbarui undangan cetak: ' . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        $u = UndanganCetak::findOrFail($id);
        $images = is_array($u->gambar) ? $u->gambar : [];

        $u->delete();

        foreach ($images as $img) {
            if (is_string($img) && !empty($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        session()->flash('message', 'Undangan cetak berhasil dihapus.');
    }

    public function createCategory(): void
    {
        $this->validate(['jenisUndangan' => 'required|string|max:255']);
        JenisUdangan::create(['jenis' => trim($this->jenisUndangan)]);
        $this->jenisUndangan = '';
        session()->flash('message', 'Kategori berhasil ditambahkan.');
    }
}
