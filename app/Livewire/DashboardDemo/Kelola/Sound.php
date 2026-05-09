<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Music;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KelolaUndangan\Sound as KelolaSound;
use Illuminate\Support\Facades\Crypt;

class Sound extends Component
{
    use WithPagination;
    public $dataId;
    public $detik = 0;
    public $sound = null;
    public $music;
    public $selectM;
    public $select = false;
    public $link;
    public $query = '';
    public $url;
    public $youtube = "";
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
            $this->previewUrl = $this->getConvertedUrl($value);
            $this->previewType = 'youtube';
            // Reset library selection if youtube entered
            $this->selectM = null;
        } else {
            $this->previewUrl = null;
            $this->previewType = null;
        }
    }
    public function mount($id)
    {
        $this->dataId = Crypt::decryptString($id);
        $this->sound = KelolaSound::where('data_id', $this->dataId)->first();
        if ($this->sound) {
            $this->detik = $this->sound->start;
            // Try to find if current sound is from library
            $this->currentMusic = Music::where('link', $this->sound->sound)->first();
            
            if (str_contains($this->sound->sound, 'youtube.com') && !$this->currentMusic) {
                $this->tab = 'youtube';
                $this->youtube = $this->sound->sound;
            }
        }

        $this->isChecked =  $this->sound ?  $this->sound->isActive : false;
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
        $videoId = '';
        $finalUrl = $rawUrl;

        if (empty($rawUrl)) return '';

        // Handle already embed links
        if (str_contains($rawUrl, 'youtube.com/embed/')) {
            $parts = explode('embed/', $rawUrl);
            $videoId = explode('?', $parts[1] ?? '')[0];
        } 
        // Handle standard watch?v= links
        elseif (str_contains($rawUrl, 'v=')) {
            $queryString = parse_url($rawUrl, PHP_URL_QUERY);
            parse_str($queryString, $vars);
            $videoId = $vars['v'] ?? '';
        } 
        // Handle youtu.be/ links
        elseif (str_contains($rawUrl, 'youtu.be/')) {
            $videoId = basename(parse_url($rawUrl, PHP_URL_PATH));
        }
        // Handle shorts links
        elseif (str_contains($rawUrl, 'youtube.com/shorts/')) {
            $videoId = basename(parse_url($rawUrl, PHP_URL_PATH));
        }

        if ($videoId) {
            $finalUrl = 'https://www.youtube.com/embed/' . $videoId . ($this->detik > 0 ? '?start=' . $this->detik : '');
        }

        return $finalUrl;
    }

    public function switch($dataId, $isChecked)
    {
        $this->isChecked = $isChecked; // Update nilai isChecked berdasarkan status checkbox

        $sound = KelolaSound::where('data_id', $dataId)->first();

        if (!$sound) {
            KelolaSound::create([
                'data_id' => $dataId,
                'sound' => 'null',
                'start' => '0',
                'isActive' => $this->isChecked,
            ]);
        } else {
            $sound->update([
                'isActive' => $this->isChecked,
            ]);
        }$this->sound = KelolaSound::where('data_id', $dataId)->first();
    }
    public function save()
    {
        $soundUrl = '';
        
        if ($this->selectM) {
            // Priority to library selection
            $soundUrl = $this->getConvertedUrl($this->selectM->link);
        } elseif ($this->youtube) {
            // Custom youtube input
            $soundUrl = $this->getConvertedUrl($this->youtube);
        }

        if (empty($soundUrl)) {
            session()->flash('message', 'Pilih musik terlebih dahulu.');
            return;
        }

        if (!$this->sound) {
            $this->sound = KelolaSound::create([
                'data_id' => $this->dataId,
                'sound' => $soundUrl,
                'start' => $this->detik,
                'isActive' => true
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
        KelolaSound::find($id)->delete();
        session()->flash('message', 'Musik Berhasil Dihapus.');
        $this->sound = KelolaSound::where('data_id', $this->dataId)->first();
    }
    public function render()
    {
        $musik = empty($this->query)
            ? Music::paginate(5)
            : Music::where('judul', 'LIKE', '%' . $this->query . '%')
            ->orWhere('artis', 'LIKE', '%' . $this->query . '%')
            ->orWhere('category', 'LIKE', '%' . $this->query . '%')
            ->paginate(5);
        return view('livewire.dashboard.kelola.sound', [
            'musik' => $musik
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Musik'
        ]);
    }
}
