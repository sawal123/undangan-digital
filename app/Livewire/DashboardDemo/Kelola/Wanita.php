<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Data;
use App\Models\KelolaUndangan\Wanita as ModelsWanita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Wanita extends Component
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
        $wanita = ModelsWanita::where('data_id', $this->dataId)->first();

        if ($wanita) {
            $this->nama = $wanita->nama_lengkap ?? '';
            $this->panggilan = $wanita->nama_panggilan ?? '';
            $this->deskripsi = $wanita->deskripsi ?? '';
            $this->existingImage = $wanita->image ? asset('storage/' . $wanita->image) : null;
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

        $wanita = ModelsWanita::where('data_id', $this->dataId)->first();

        $uploadedPath = null;
        $oldFileToDelete = null;

        if ($this->newImage) {
            $uploadedPath = $this->newImage->store('wanita', 'public');
            if ($wanita && $wanita->image) {
                $oldFileToDelete = $wanita->image;
            }
        }

        try {
            DB::transaction(function () use ($wanita, $uploadedPath) {
                $payload = [
                    'nama_lengkap' => trim($this->nama),
                    'nama_panggilan' => trim($this->panggilan),
                    'deskripsi' => trim($this->deskripsi),
                ];

                if ($uploadedPath) {
                    $payload['image'] = $uploadedPath;
                }

                if ($wanita) {
                    $wanita->update($payload);
                } else {
                    $payload['data_id'] = $this->dataId;
                    ModelsWanita::create($payload);
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
            session()->flash('message', 'Data mempelai wanita berhasil disimpan.');
        } catch (\Throwable $e) {
            if ($uploadedPath) {
                Storage::disk('public')->delete($uploadedPath);
            }
            session()->flash('error', 'Gagal menyimpan data mempelai wanita: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $this->authorizeInvitation();

        return view('livewire.dashboard.kelola.wanita')->layout('components.layouts.user-new', [
            'headerTitle' => 'Data Mempelai Wanita',
        ]);
    }

    private function authorizeInvitation(): Data
    {
        return Data::query()->ownedBy(auth()->id())->findOrFail($this->dataId);
    }
}
