<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\Sound as KelolaSound;
use App\Models\Music;
use App\Services\YouTubeUrlParser;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Sound extends Component
{
    use LoadsOwnedInvitation;
    use WithPagination;

    #[Locked]
    public int $dataId;

    public int $detik = 0;

    public ?KelolaSound $sound = null;

    public ?Music $selectM = null;

    public string $query = '';

    public string $youtube = '';

    public ?string $previewUrl = null;

    public ?string $previewType = null; // 'audio' or 'youtube'

    public string $tab = 'library'; // 'library' or 'youtube'

    public ?Music $currentMusic = null;

    public bool $isChecked = false;

    public function updatedQuery(): void
    {
        $this->resetPage();
    }

    public function selectMusic(int $id): void
    {
        $this->selectM = Music::find($id);
        if ($this->selectM) {
            $this->previewUrl = $this->selectM->link;
            if (str_contains($this->previewUrl, 'youtube.com') || str_contains($this->previewUrl, 'youtu.be')) {
                $this->previewType = 'youtube';
            } else {
                $this->previewType = 'audio';
            }
            $this->youtube = '';
        }
    }

    public function updatedYoutube(?string $value): void
    {
        if ($value) {
            $this->previewUrl = app(YouTubeUrlParser::class)->toEmbedUrl($value, (int) $this->detik);
            $this->previewType = $this->previewUrl ? 'youtube' : null;
            $this->selectM = null;
        } else {
            $this->previewUrl = null;
            $this->previewType = null;
        }
    }

    public function mount(string $id): void
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->sound = KelolaSound::where('data_id', $this->dataId)->first();
        if ($this->sound && $this->sound->sound && $this->sound->sound !== 'null') {
            $this->detik = (int) $this->sound->start;
            $this->currentMusic = Music::where('link', $this->sound->sound)->first();

            if (str_contains($this->sound->sound, 'youtu') && !$this->currentMusic) {
                $this->tab = 'youtube';
                $this->youtube = $this->sound->sound;
            }
        }

        $this->isChecked = $this->sound ? (bool) $this->sound->isActive : false;
    }

    public function updatedDetik(): void
    {
        if ($this->previewType === 'youtube') {
            $sourceUrl = $this->selectM ? $this->selectM->link : $this->youtube;
            $this->previewUrl = $this->getConvertedUrl($sourceUrl);
        }
    }

    public function getConvertedUrl(?string $rawUrl): string
    {
        if (empty($rawUrl)) {
            return '';
        }

        if (!str_contains($rawUrl, 'youtu')) {
            return $rawUrl;
        }

        return app(YouTubeUrlParser::class)->toEmbedUrl($rawUrl, (int) $this->detik) ?? '';
    }

    public function switch(bool $isChecked): void
    {
        $this->authorizeInvitationState();
        $this->isChecked = $isChecked;

        $sound = KelolaSound::where('data_id', $this->dataId)->first();

        if (!$sound) {
            $this->sound = KelolaSound::create([
                'data_id' => $this->dataId,
                'sound' => '',
                'start' => 0,
                'isActive' => $this->isChecked,
            ]);
        } else {
            $sound->update([
                'isActive' => $this->isChecked,
            ]);
            $this->sound = $sound;
        }
        session()->flash('message', 'Status musik berhasil diperbarui.');
    }

    public function save(): void
    {
        $this->authorizeInvitationState();

        $this->validate([
            'detik' => 'required|integer|min:0|max:86400',
        ], [
            'detik.min' => 'Waktu detik mulai minimal 0.',
        ]);

        $soundUrl = '';

        if ($this->selectM) {
            $soundUrl = $this->getConvertedUrl($this->selectM->link);
        } elseif (!empty(trim($this->youtube))) {
            $soundUrl = app(YouTubeUrlParser::class)->toEmbedUrl($this->youtube, (int) $this->detik);
            if (!$soundUrl) {
                $this->addError('youtube', 'URL YouTube tidak valid.');
                return;
            }
        }

        if (empty($soundUrl)) {
            session()->flash('error', 'Pilih musik dari pustaka atau masukkan link YouTube terlebih dahulu.');
            return;
        }

        if (!$this->sound) {
            $this->sound = KelolaSound::create([
                'data_id' => $this->dataId,
                'sound' => $soundUrl,
                'start' => $this->detik,
                'isActive' => true,
            ]);
        } else {
            $this->sound->update([
                'sound' => $soundUrl,
                'start' => $this->detik,
            ]);
        }

        session()->flash('message', 'Musik latar belakang berhasil disimpan.');
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $musicList = Music::query()
            ->when(!empty(trim($this->query)), function ($q) {
                $searchTerm = '%' . trim($this->query) . '%';
                $q->where(function ($sub) use ($searchTerm) {
                    $sub->where('judul', 'like', $searchTerm)
                        ->orWhere('artis', 'like', $searchTerm)
                        ->orWhere('category', 'like', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate(6);

        return view('livewire.dashboard.kelola.sound', [
            'musik' => $musicList,
            'musicList' => $musicList,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Musik',
        ]);
    }
}
