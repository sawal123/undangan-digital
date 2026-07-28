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

class Galery extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    #[Locked]
    public int $dataId;

    public $poto;

    public ?string $video = null;

    public ?string $url = null;

    public ?KelolaUndanganGalery $preview = null;

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'delete-modal');
        $this->poto = null;
        $this->video = null;
        $this->resetValidation();
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

    public function save(): void
    {
        $this->authorizeInvitationState();

        $count = KelolaUndanganGalery::where('data_id', $this->dataId)->count();

        if ($count >= 10) {
            $this->dispatch('close-modal', name: 'photo-modal');
            $this->dispatch('close-modal', name: 'video-modal');
            session()->flash('error', 'Galeri Anda telah mencapai batas maksimal (10 item).');
            return;
        }

        if ($this->poto !== null) {
            $this->validate([
                'poto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'poto.required' => 'File foto wajib dipilih.',
                'poto.image' => 'File harus berupa gambar valid.',
            ]);

            $imagePath = $this->poto->store('galery', 'public');

            try {
                DB::transaction(function () use ($count, $imagePath) {
                    KelolaUndanganGalery::create([
                        'data_id' => $this->dataId,
                        'sort' => $count + 1,
                        'poto' => $imagePath,
                    ]);
                });

                session()->flash('message', 'Foto galeri berhasil tersimpan.');
            } catch (\Throwable $e) {
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                session()->flash('error', 'Gagal menyimpan foto galeri: ' . $e->getMessage());
            }
        } else {
            $this->validate([
                'video' => 'required|url|max:255',
            ], [
                'video.required' => 'URL video YouTube wajib diisi.',
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
        }

        $this->dispatch('close-modal', name: 'photo-modal');
        $this->dispatch('close-modal', name: 'video-modal');
        $this->poto = null;
        $this->video = null;
        $this->url = null;
        $this->resetValidation();
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
