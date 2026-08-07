<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Data;
use App\Models\KelolaUndangan\Pria as KelolaUndanganPria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Pria extends Component
{
    use WithFileUploads;

    #[Locked]
    public int $dataId;

    public string $nama = '';

    public string $panggilan = '';

    public string $deskripsi = '';

    public ?string $existingImage = null;

    public $newImage;

    public function mount(int $dataId): void
    {
        $this->dataId = Data::query()->ownedBy(auth()->id())->findOrFail($dataId)->id;
        $pria = KelolaUndanganPria::where('data_id', $this->dataId)->first();

        if ($pria) {
            $this->nama = $pria->nama_lengkap ?? '';
            $this->panggilan = $pria->nama_panggilan ?? '';
            $this->deskripsi = $pria->deskripsi ?? '';
            $this->existingImage = $pria->image ? asset('storage/' . $pria->image) : null;
        }
    }

    public function save(): void
    {
        $this->authorizeInvitation();

        $this->validate([
            'nama' => 'required|string|max:255',
            'panggilan' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'newImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'panggilan.required' => 'Nama panggilan wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'newImage.image' => 'File harus berupa gambar.',
        ]);

        $pria = KelolaUndanganPria::where('data_id', $this->dataId)->first();

        $uploadedPath = null;
        $oldFileToDelete = null;

        if ($this->newImage) {
            $uploadedPath = $this->newImage->store('pria', 'public');
            if ($pria && $pria->image) {
                $oldFileToDelete = $pria->image;
            }
        }

        try {
            DB::transaction(function () use ($pria, $uploadedPath) {
                $payload = [
                    'nama_lengkap' => trim($this->nama),
                    'nama_panggilan' => trim($this->panggilan),
                    'deskripsi' => trim($this->deskripsi),
                ];

                if ($uploadedPath) {
                    $payload['image'] = $uploadedPath;
                }

                if ($pria) {
                    $pria->update($payload);
                } else {
                    $payload['data_id'] = $this->dataId;
                    KelolaUndanganPria::create($payload);
                }
            });

            // Delete old file ONLY after DB update succeeds
            if ($oldFileToDelete) {
                Storage::disk('public')->delete($oldFileToDelete);
            }

            if ($uploadedPath) {
                $this->existingImage = asset('storage/' . $uploadedPath);
            }

            $this->newImage = null;
            $this->resetValidation();
            session()->flash('message', 'Data mempelai pria berhasil disimpan.');
        } catch (\Throwable $e) {
            if ($uploadedPath) {
                Storage::disk('public')->delete($uploadedPath);
            }
            session()->flash('error', 'Gagal menyimpan data mempelai pria: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $this->authorizeInvitation();

        return view('livewire.dashboard.kelola.pria')->layout('components.layouts.user-new', [
            'headerTitle' => 'Data Mempelai Pria',
        ]);
    }

    private function authorizeInvitation(): Data
    {
        return Data::query()->ownedBy(auth()->id())->findOrFail($this->dataId);
    }
}
