<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\Galery as KelolaUndanganGalery;
use App\Services\YouTubeUrlParser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Contracts\View\View;

class Galery extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    #[Locked]
    public int $dataId;

    public $poto = [];

    public ?string $video = null;

    public ?string $url = null;

    public ?KelolaUndanganGalery $preview = null;

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'delete-modal');
        $this->dispatch('close-modal', name: 'photo-modal');
        $this->dispatch('close-modal', name: 'video-modal');
        $this->poto = [];
        $this->video = null;
        $this->resetValidation();
    }

    public function openPhotoModal(): void
    {
        $this->poto = [];
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'photo-modal');
    }

    public function openVideoModal(): void
    {
        $this->video = null;
        $this->url = null;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'video-modal');
    }

    public function removeSelectedPoto(int $index): void
    {
        if (is_array($this->poto)) {
            unset($this->poto[$index]);
            $this->poto = array_values($this->poto);
        } else {
            $this->poto = [];
        }
    }

    public function delete(int $id): void
    {
        $this->authorizeInvitationState();

        DB::transaction(function () use ($id) {
            $galery = KelolaUndanganGalery::where('data_id', $this->dataId)->lockForUpdate()->findOrFail($id);
            $photoPath = $galery->poto;

            $galery->delete();

            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            $remaining = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort')->get();
            foreach ($remaining as $index => $item) {
                $item->update(['sort' => $index + 1]);
            }
        });

        session()->flash('message', 'Data galeri berhasil dihapus.');
    }

    public function pre(int $id): void
    {
        $this->openPreview($id);
    }

    public function openPreview(int $id): void
    {
        $this->authorizeInvitationState();
        $this->preview = KelolaUndanganGalery::where('data_id', $this->dataId)->findOrFail($id);
        $this->dispatch('open-modal', name: 'preview-modal');
    }

    public function convertUrl(): void
    {
        if (empty($this->video)) {
            $this->url = null;
            return;
        }

        $this->url = app(YouTubeUrlParser::class)->toEmbedUrl($this->video);

        if (!$this->url) {
            $this->addError('video', 'URL YouTube tidak valid.');
        }
    }

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
    }

    public function savePhoto(): void
    {
        $this->authorizeInvitationState();

        $count = KelolaUndanganGalery::where('data_id', $this->dataId)->count();

        if ($count >= 10) {
            $this->dispatch('close-modal', name: 'photo-modal');
            session()->flash('error', 'Galeri Anda telah mencapai batas maksimal (10 item).');
            return;
        }

        $files = is_array($this->poto) ? $this->poto : ($this->poto ? [$this->poto] : []);
        $files = array_values(array_filter($files));

        if (empty($files)) {
            $this->addError('poto', 'Silakan pilih minimal 1 foto untuk diunggah.');
            return;
        }

        $remaining = 10 - $count;
        if (count($files) > $remaining) {
            $this->addError('poto', "Maksimal kapasitas galeri adalah 10 item. Tersisa {$remaining} slot, namun Anda memilih " . count($files) . " foto.");
            return;
        }

        try {
            if (is_array($this->poto)) {
                $this->validate([
                    'poto' => 'required|array|min:1',
                    'poto.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
                ], [
                    'poto.required' => 'File foto wajib dipilih.',
                    'poto.array' => 'File foto tidak valid.',
                    'poto.min' => 'Silakan pilih minimal 1 foto.',
                    'poto.*.image' => 'Setiap file harus berupa gambar valid.',
                    'poto.*.mimes' => 'Format gambar yang didukung: JPG, JPEG, PNG, WEBP.',
                    'poto.*.max' => 'Ukuran maksimal setiap foto adalah 2MB.',
                ]);
            } else {
                $this->validate([
                    'poto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ], [
                    'poto.required' => 'File foto wajib dipilih.',
                    'poto.image' => 'File harus berupa gambar valid.',
                    'poto.mimes' => 'Format gambar yang didukung: JPG, JPEG, PNG, WEBP.',
                    'poto.max' => 'Ukuran maksimal foto adalah 2MB.',
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $e->validator->errors()->add('poto', $e->validator->errors()->first());
            $this->addError('poto', $e->validator->errors()->first());
            throw $e;
        }

        $storedPaths = [];
        try {
            DB::transaction(function () use ($files, &$count, &$storedPaths) {
                foreach ($files as $file) {
                    $count++;
                    $imagePath = $file->store('galery', 'public');
                    $storedPaths[] = $imagePath;

                    KelolaUndanganGalery::create([
                        'data_id' => $this->dataId,
                        'sort' => $count,
                        'poto' => $imagePath,
                    ]);
                }
            });

            $totalUploaded = count($storedPaths);
            session()->flash('message', "{$totalUploaded} foto galeri berhasil tersimpan.");
        } catch (\Throwable $e) {
            foreach ($storedPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            session()->flash('error', 'Gagal menyimpan foto galeri: ' . $e->getMessage());
        }

        $this->dispatch('close-modal', name: 'photo-modal');
        $this->poto = [];
        $this->resetValidation();
    }

    public function saveVideo(): void
    {
        $this->authorizeInvitationState();

        $count = KelolaUndanganGalery::where('data_id', $this->dataId)->count();

        if ($count >= 10) {
            $this->dispatch('close-modal', name: 'video-modal');
            session()->flash('error', 'Galeri Anda telah mencapai batas maksimal (10 item).');
            return;
        }

        $this->validate([
            'video' => 'required|url|max:255',
        ], [
            'video.required' => 'URL video YouTube wajib diisi.',
            'video.url' => 'URL video YouTube harus berformat tautan yang valid.',
        ]);

        $this->convertUrl();
        if (!$this->url) {
            return;
        }

        DB::transaction(function () use ($count) {
            KelolaUndanganGalery::create([
                'data_id' => $this->dataId,
                'sort' => $count + 1,
                'video' => $this->url,
            ]);
        });

        session()->flash('message', 'Video galeri berhasil tersimpan.');
        $this->dispatch('close-modal', name: 'video-modal');
        $this->video = null;
        $this->url = null;
        $this->resetValidation();
    }

    public function save(): void
    {
        if (!empty($this->poto)) {
            $this->savePhoto();
        } else {
            $this->saveVideo();
        }
    }

    public function previous(int $sort): void
    {
        $this->authorizeInvitationState();
        $this->moveGalleryItem($sort, 'previous');
    }

    public function next(int $sort): void
    {
        $this->authorizeInvitationState();
        $this->moveGalleryItem($sort, 'next');
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $dataGalery = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();

        return view('livewire.dashboard.kelola.galery', [
            'data' => $dataGalery,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Galeri',
        ]);
    }

    private function moveGalleryItem(int $sort, string $direction): void
    {
        DB::transaction(function () use ($sort, $direction) {
            $current = KelolaUndanganGalery::where('data_id', $this->dataId)
                ->where('sort', $sort)
                ->lockForUpdate()
                ->first();

            if (!$current) {
                return;
            }

            $neighborQuery = KelolaUndanganGalery::where('data_id', $this->dataId)->lockForUpdate();

            $neighbor = $direction === 'previous'
                ? $neighborQuery->where('sort', '<', $current->sort)->orderByDesc('sort')->first()
                : $neighborQuery->where('sort', '>', $current->sort)->orderBy('sort')->first();

            if (!$neighbor) {
                return;
            }

            $currentSort = $current->sort;
            $neighborSort = $neighbor->sort;

            $current->update(['sort' => $neighborSort]);
            $neighbor->update(['sort' => $currentSort]);
        });
    }
}
