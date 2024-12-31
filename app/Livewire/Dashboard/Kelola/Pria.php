<?php

namespace App\Livewire\Dashboard\Kelola;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\KelolaUndangan\Pria as KelolaUndanganPria;
// use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithFileUploads as LivewireWithFileUploads;

class Pria extends Component
{

    use LivewireWithFileUploads;
    public $dataId;
    public $nama;
    public $panggilan;
    public $deskripsi;
    public $gambar;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'panggilan' => 'required|string|max:255',
        'deskripsi' => 'required|string|max:255',
        // 'gambar' => 'image|max:2048',
    ];

    public function mount($dataId)
    {
        $this->dataId = $dataId;
        $pria = KelolaUndanganPria::where('data_id', $this->dataId)->first();

        if ($pria) {
            $this->nama = $pria->nama_lengkap;
            $this->panggilan = $pria->nama_panggilan;
            $this->deskripsi = $pria->deskripsi;
            $this->gambar = asset('storage/' . $pria->image);
        }
    }

    public function save()
    {
        $this->validate();

        $data = KelolaUndanganPria::where('data_id', $this->dataId)->first();
        if ($data && $data->gambar) {
            // Hapus gambar lama jika ada
            if (Storage::disk('public')->exists($data->gambar)) {
                Storage::disk('public')->delete($data->gambar);
            }
        }
        $imagePath = is_object($this->gambar) ? $this->gambar->store('pria', 'public') : null;
        if ($data) {
            $updateData = [
                'nama_lengkap' => $this->nama,
                'nama_panggilan' => $this->panggilan,
                'deskripsi' => $this->deskripsi,
            ];

            // Tambahkan `image` ke array pembaruan hanya jika ada gambar baru
            if ($imagePath) {
                $updateData['image'] = $imagePath;
            }
            $data->update($updateData);

            session()->flash('message', 'Data mempelai pria berhasil disimpan.');

        } else {
            KelolaUndanganPria::create([
                'data_id' => $this->dataId,
                'nama_lengkap' => $this->nama,
                'nama_panggilan' => $this->panggilan,
                'deskripsi' => $this->deskripsi,
                'image' => $imagePath,
            ]);
            session()->flash('message', 'Data mempelai pria berhasil disimpan.');
        }



        
        // $this->reset(); 

    }
    public function render()
    {
        return view('livewire.dashboard.kelola.pria', []);
    }
}
