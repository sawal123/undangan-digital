<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\UndanganCetak as AdminUndanganCetak;

class Cetak extends Component
{
    public $undangan;
    public $isModalOpen = false;
    public $judul = "Tambah";

    use WithFileUploads; // Untuk file upload
    public $favorite = 0;
    public $nama;
    public $jenis;
    public $stok;
    public $terjual;
    public $harga;
    public $promo;
    public $thumbnails = []; // Untuk thumbnail
    public $undanganId; // Jika Anda ingin mengubah data yang sudah ada

    public $deskripsi = '';
    public $parameter;

    public $temporaryThumbnails = [];
    public $undanganData = []; // Menyimpan hasil pencarian
    public $search = ''; // Menyimpan nilai pencarian

   

    // protected $listeners = ['updateDeskripsi'];
    public function resetInputFields()
    {
        $this->undanganId = null;
        $this->nama = '';
        $this->jenis = '';
        $this->stok = '';
        $this->terjual = '';
        $this->harga = '';
        $this->promo = '';
        $this->deskripsi = '';
        $this->thumbnails = [];
    }
    public $img;
    public $combinedThumbnails;
    public function editUndangan($id)
    {
        // Ambil data dari database
        $undangan = AdminUndanganCetak::find($id);
        if ($undangan) {
            $this->undanganId = $undangan->id;
            $this->nama = $undangan->nama;
            $this->jenis = $undangan->jenis;
            $this->stok = $undangan->stok;
            $this->terjual = $undangan->terjual;
            $this->harga = $undangan->harga;
            $this->promo = $undangan->promo;
            $this->deskripsi = $undangan->deskripsi;
            $this->thumbnails = json_decode($undangan->gambar); // Gambar yang ada saat edit
            $this->judul = 'Edit';
            $this->openModal();
        }
        // dd($this->thumbnails);
    }
    public function upUndangan()
    {
        $undangan = AdminUndanganCetak::find($this->undanganId);
        if ($undangan) {
            $undangan->nama = $this->nama;
            $undangan->jenis = $this->jenis;
            $undangan->stok = $this->stok;
            $undangan->terjual = $this->terjual;
            $undangan->harga = $this->harga;
            $undangan->promo = $this->promo;
            $undangan->deskripsi = $this->deskripsi;

            // Mengecek jika ada gambar baru
            if ($this->thumbnails) {
                // Mendapatkan gambar yang sudah ada di database
                $gambarLama = json_decode($undangan->gambar, true);

                // Jika gambar lama tidak ada, inisialisasi sebagai array kosong
                if (!is_array($gambarLama)) {
                    $gambarLama = [];
                }

                // Menambahkan gambar baru ke dalam array gambar yang lama
                $gambarBaru = [];
                foreach ($this->thumbnails as $thumbnail) {
                    if (is_object($thumbnail)) {
                        // Jika thumbnail adalah objek file, simpan ke storage
                        $path = $thumbnail->store('undangan/thumbnails', 'public');
                        $gambarBaru[] = $path;
                    } else {
                        // Jika thumbnail adalah URL atau string, masukkan saja
                        $gambarBaru[] = $thumbnail;
                    }
                }

                // Gabungkan gambar lama dan baru, dan hilangkan duplikat jika ada
                $gambarFinal = array_unique(array_merge($gambarLama, $gambarBaru));

                // Simpan gambar dalam format JSON
                $undangan->gambar = json_encode($gambarFinal);
            }

            $undangan->save();
            $this->mount();
            session()->flash('message', 'Undangan berhasil diperbarui!');
            $this->closeModal();
        }
    }

    #[On('updateDeskripsi')]
    public function updateDeskripsi($content)
    {
        $this->deskripsi = $content;
    }
    protected $rules = [
        'nama' => 'required|string|max:255',
        'jenis' => 'required|string',
        'stok' => 'required|numeric|min:0',
        'terjual' => 'required|numeric|min:0',
        'harga' => 'required|numeric|min:0',
        'promo' => 'nullable|numeric|min:0',
        'thumbnails' => 'nullable|array', // Menambahkan validasi untuk array
        'thumbnails.*' => 'image|mimes:jpg,webp,WEBP,png,jpeg,gif,svg|max:2024', // Validasi masing-masing file gambar
    ];




    public function saveUndangan()
    {
        $validate = $this->validate();

        // Menyimpan gambar dan mendapatkan path-nya
        $thumbnailPaths = [];
        if ($this->thumbnails) {
            foreach ($this->thumbnails as $thumbnail) {
                $thumbnailPaths[] = $thumbnail->store('thumbnails', 'public');
            }
        }


        // Simpan data baru ke database
        AdminUndanganCetak::create([
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'stok' => $this->stok,
            'terjual' => $this->terjual,
            'harga' => $this->harga,
            'promo' => $this->promo,
            'favorite' => $this->favorite,
            'gambar' => json_encode($thumbnailPaths), // Menyimpan array gambar sebagai JSON
            'deskripsi' => $this->deskripsi,
        ]);
        session()->flash('message', 'Undangan berhasil disimpan!');
        $this->closeModal();
        $this->mount();
    }


    public $modalDelete = false;
    public $idTrans;

    public function confirmDel($id)
    {
        $this->idTrans = $id; // Menyimpan ID transaksi yang akan dihapus
        $this->modalDelete = true; // Menampilkan modal
    }



    public function delUndangan($id)
    {
        $undangan = AdminUndanganCetak::find($id);
        if ($undangan) {
            $gambarPaths = json_decode($undangan->gambar);
            foreach ($gambarPaths as $gambar) {
                Storage::disk('public')->delete($gambar);
            }
            $undangan->delete();
            session()->flash('message', 'Undangan berhasil dihapus!');
        } else {
            session()->flash('error', 'undangan tidak ditemukan!');
        }
        $this->mount();
        $this->closeModal();
    }

    public function hapusGambar($index)
    {
        $undangan = AdminUndanganCetak::find($this->undanganId);
        if ($undangan && isset($undangan->gambar)) {

            $thumbnails = json_decode($undangan->gambar, true);

            if (is_array($thumbnails)) {
                if (isset($thumbnails[$index])) {
                    $gambar = $thumbnails[$index];
                    // dd($gambar);
                    if (Storage::exists('public/' . $gambar)) {
                        Storage::delete('public/' . $gambar);
                    }
                    unset($thumbnails[$index]);
                    $thumbnails = array_values($thumbnails);
                    $undangan->gambar = json_encode($thumbnails);
                    $undangan->save();
                    $this->thumbnails = $thumbnails;
                    // $this->mount();
                } else {
                    session()->flash('error', 'Gambar tidak ditemukan.');
                }
            } else {
                session()->flash('error', 'Data undangan tidak ditemukan.');
            }
        }
    }


    public function openModal()
    {
        $this->dispatch('syncTinyMCE');
        $this->dispatch('initializeTinyMCE');
        $this->dispatch('modalOpened');
        $this->isModalOpen = true;

        $this->dispatch('tiny');
    }
    public function closeModal()
    {
        $this->modalDelete = false; // Menutup modal
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->reset(['deskripsi']);
        // $this->dispatch('syncTinyMCE');
    }
    public function mount()
    {
        $this->thumbnails;
        $this->thumbnails =   $this->combinedThumbnails;
        // $this->deskripsi = $deskripsi ?? 'default'; 
        $this->undanganData  = AdminUndanganCetak::all();
    }
    public function render()
    {
        // Jika pencarian kosong, tampilkan semua data
        if ($this->search === '') {
            $this->undanganData = AdminUndanganCetak::all();
        } else {
            // Pencarian berdasarkan beberapa kolom
            $this->undanganData = AdminUndanganCetak::where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('jenis', 'like', '%' . $this->search . '%')
                ->orWhere('stok', 'like', '%' . $this->search . '%')
                ->orWhere('terjual', 'like', '%' . $this->search . '%')
                ->orWhere('harga', 'like', '%' . $this->search . '%')
                ->get();
        }

        return view('livewire.admin.undangancetak');
    }
}
