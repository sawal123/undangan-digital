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
    public $dataId;

    public $detik = 0;

    public $sound = null;

    public $music;

    public $selectM;

    public $select = false;

    public $link;

    public $query = '';

    public $url;

    public $youtube = '';

    public $previewUrl = null;

    public $previewType = null; // 'library' or 'youtube'

    public $tab = 'library'; // 'library' or 'youtube'

    public $currentMusic = null;

    public $isChecked;

    public function search()
    {
        $this->resetPage();
    }

    public function selectMusic($id)
    {
        $this->selectM = Music::find($id);
        if ($this->selectM) {
            $this->previewUrl = $this->selectM->link;
            // Check if it's a youtube link
            if (str_contains($this->previewUrl, 'youtube.com')) {
                $this->previewType = 'youtube';
            } else {
                $this->previewType = 'audio';
            }
            // Reset youtube if library selected
            $this->youtube = '';
            $this->url = '';
        }
    }

    public function updatedYoutube($value)
    {
        if ($value) {
            $this->previewUrl = app(YouTubeUrlParser::class)->toEmbedUrl($value, (int) $this->detik);
            $this->previewType = $this->previewUrl ? 'youtube' : null;
            // Reset library selection if youtube entered
            $this->selectM = null;
        } else {
            $this->previewUrl = null;
            $this->previewType = null;
        }
    }

    public function mount($id)
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->sound = KelolaSound::where('data_id', $this->dataId)->first();
        if ($this->sound) {
            $this->detik = $this->sound->start;
            // Try to find if current sound is from library
            $this->currentMusic = Music::where('link', $this->sound->sound)->first();

            if (str_contains($this->sound->sound, 'youtube.com') && ! $this->currentMusic) {
                $this->tab = 'youtube';
                $this->youtube = $this->sound->sound;
            }
        }

        $this->isChecked = $this->sound ? $this->sound->isActive : false;
    }

    public function updatedDetik()
    {
        if ($this->previewType === 'youtube') {
            $sourceUrl = $this->selectM ? $this->selectM->link : $this->youtube;
            $this->previewUrl = $this->getConvertedUrl($sourceUrl);
        }
    }

    public function getConvertedUrl($rawUrl)
    {
        if (empty($rawUrl)) {
            return '';
        }

        if (! str_contains($rawUrl, 'youtu')) {
            return $rawUrl;
        }

        return app(YouTubeUrlParser::class)->toEmbedUrl($rawUrl, (int) $this->detik) ?? '';
    }

    public function switch($dataId, $isChecked)
    {
        $this->authorizeInvitationState();
        $this->isChecked = $isChecked; // Update nilai isChecked berdasarkan status checkbox

        $sound = KelolaSound::where('data_id', $this->dataId)->first();

        if (! $sound) {
            KelolaSound::create([
                'data_id' => $this->dataId,
                'sound' => 'null',
                'start' => '0',
                'isActive' => $this->isChecked,
            ]);
        } else {
            $sound->update([
                'isActive' => $this->isChecked,
            ]);
        }$this->sound = KelolaSound::where('data_id', $this->dataId)->first();
    }

    public function save()
    {
        $this->authorizeInvitationState();
        $soundUrl = '';

        if ($this->selectM) {
            // Priority to library selection
            $soundUrl = $this->getConvertedUrl($this->selectM->link);
        } elseif ($this->youtube) {
            // Custom youtube input
            $soundUrl = app(YouTubeUrlParser::class)->toEmbedUrl($this->youtube, (int) $this->detik);
            if (! $soundUrl) {
                $this->addError('youtube', 'URL YouTube tidak valid.');

                return;
            }
        }

        if (empty($soundUrl)) {
            session()->flash('message', 'Pilih musik terlebih dahulu.');

            return;
        }

        if (! $this->sound) {
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

        $this->previewUrl = null;
        $this->previewType = null;
        $this->selectM = null;
        $this->youtube = '';

        // Refresh sound and currentMusic metadata
        $this->sound = KelolaSound::where('data_id', $this->dataId)->first();
        $this->currentMusic = Music::where('link', $this->sound->sound)->first();

        session()->flash('message', 'Musik Berhasil Disimpan.');
    }

    public function delete($id)
    {
        $this->authorizeInvitationState();
        KelolaSound::where('data_id', $this->dataId)->findOrFail($id)->delete();
        session()->flash('message', 'Musik Berhasil Dihapus.');
        $this->sound = KelolaSound::where('data_id', $this->dataId)->first();
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $musik = empty($this->query)
            ? Music::paginate(5)
            : Music::where('judul', 'LIKE', '%'.$this->query.'%')
                ->orWhere('artis', 'LIKE', '%'.$this->query.'%')
                ->orWhere('category', 'LIKE', '%'.$this->query.'%')
                ->paginate(5);

        return view('livewire.dashboard.kelola.sound', [
            'musik' => $musik,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Musik',
        ]);
    }
}
