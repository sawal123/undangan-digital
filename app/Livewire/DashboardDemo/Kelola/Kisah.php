<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\ImgKisahCinta;
use App\Models\KelolaUndangan\KisahCinta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Contracts\View\View;

class Kisah extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    public string $title = 'Tambah Kisah';

    public ?int $idKisah = null;

    public string $judul = '';

    public string $cerita = '';

    #[Locked]
    public int $dataId;

    public array $poto = [];

    public $formImage;

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
    }

    public function resetField(): void
    {
        $this->idKisah = null;
        $this->judul = '';
        $this->cerita = '';
        $this->formImage = null;
        $this->title = 'Tambah Kisah';
        $this->resetValidation();
    }

    public function modalAddKisah(): void
    {
        $this->resetField();
        $this->dispatch('open-modal', name: 'kisah-modal');
    }

    public function modalEditKisah(int $id): void
    {
        $this->authorizeInvitationState();
        $this->idKisah = $id;
        $kisah = KisahCinta::where('data_id', $this->dataId)->findOrFail($id);
        $this->judul = $kisah->title;
        $this->cerita = $kisah->deskripsi;
        $this->formImage = null;
        $this->title = 'Edit Kisah';
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'kisah-modal');
    }

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'kisah-modal');
        $this->resetField();
    }

    public function delete(int $id): void
    {
        $this->authorizeInvitationState();

        DB::transaction(function () use ($id) {
            $kisah = KisahCinta::where('data_id', $this->dataId)->findOrFail($id);
            $img = ImgKisahCinta::where('data_id', $this->dataId)->where('kisah_id', $id)->first();

            $imagePath = $img?->image;

            if ($img) {
                $img->delete();
            }
            $kisah->delete();

            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        });

        session()->flash('message', 'Kisah cinta berhasil dihapus.');
    }

    public function saveImage(int $id): void
    {
        $this->authorizeInvitationState();

        if (!isset($this->poto[$id]) || !$this->poto[$id]) {
            session()->flash('error', 'Unggah gambar terlebih dahulu.');
            return;
        }

        $this->validate([
            'poto.' . $id => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'poto.' . $id . '.image' => 'File harus berupa gambar valid.',
        ]);

        KisahCinta::where('data_id', $this->dataId)->findOrFail($id);
        $imagePath = $this->poto[$id]->store('kisah', 'public');

        $img = ImgKisahCinta::where('data_id', $this->dataId)->where('kisah_id', $id)->first();
        $oldFileToDelete = null;

        try {
            DB::transaction(function () use ($img, $id, $imagePath, &$oldFileToDelete) {
                if (!$img) {
                    ImgKisahCinta::create([
                        'data_id' => $this->dataId,
                        'kisah_id' => $id,
                        'image' => $imagePath,
                    ]);
                } else {
                    if ($img->image) {
                        $oldFileToDelete = $img->image;
                    }
                    $img->update(['image' => $imagePath]);
                }
            });

            if ($oldFileToDelete) {
                Storage::disk('public')->delete($oldFileToDelete);
            }

            unset($this->poto[$id]);
            session()->flash('message', 'Gambar kisah cinta berhasil disimpan.');
        } catch (\Throwable $e) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            session()->flash('error', 'Gagal menyimpan gambar: ' . $e->getMessage());
        }
    }

    public function save(): void
    {
        $this->authorizeInvitationState();

        $this->validate([
            'judul' => 'required|string|max:255',
            'cerita' => 'required|string|max:2000',
            'formImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required' => 'Judul kisah wajib diisi.',
            'cerita.required' => 'Cerita kisah wajib diisi.',
        ]);

        $uploadedPath = null;
        if ($this->formImage) {
            $uploadedPath = $this->formImage->store('kisah', 'public');
        }

        try {
            DB::transaction(function () use ($uploadedPath) {
                if ($this->idKisah) {
                    $kisah = KisahCinta::where('data_id', $this->dataId)->findOrFail($this->idKisah);
                    $kisah->update([
                        'title' => trim($this->judul),
                        'deskripsi' => trim($this->cerita),
                    ]);
                    $targetKisahId = $kisah->id;
                } else {
                    $kisah = KisahCinta::create([
                        'data_id' => $this->dataId,
                        'title' => trim($this->judul),
                        'deskripsi' => trim($this->cerita),
                    ]);
                    $targetKisahId = $kisah->id;
                }

                if ($uploadedPath) {
                    $img = ImgKisahCinta::where('data_id', $this->dataId)->where('kisah_id', $targetKisahId)->first();
                    if ($img) {
                        $oldImg = $img->image;
                        $img->update(['image' => $uploadedPath]);
                        if ($oldImg) {
                            Storage::disk('public')->delete($oldImg);
                        }
                    } else {
                        ImgKisahCinta::create([
                            'data_id' => $this->dataId,
                            'kisah_id' => $targetKisahId,
                            'image' => $uploadedPath,
                        ]);
                    }
                }
            });

            session()->flash('message', 'Kisah cinta berhasil disimpan.');
            $this->resetField();
            $this->dispatch('close-modal', name: 'kisah-modal');
        } catch (\Throwable $e) {
            if ($uploadedPath) {
                Storage::disk('public')->delete($uploadedPath);
            }
            session()->flash('error', 'Gagal menyimpan kisah cinta: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $kisahCinta = KisahCinta::with('image')
            ->where('data_id', $this->dataId)
            ->latest('id')
            ->get();

        return view('livewire.dashboard.kelola.kisah', [
            'kisahCInta' => $kisahCinta,
            'kisahCinta' => $kisahCinta,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kisah Cinta',
        ]);
    }
}
