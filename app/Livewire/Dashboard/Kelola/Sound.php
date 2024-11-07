<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\Music;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KelolaUndangan\Sound as KelolaSound;

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

    public $isChecked;


    public function search()
    {
        $this->resetPage();
    }
    public function selectMusic($id)
    {
        $this->selectM = Music::where('id', $id)->first();
        $this->select = true;
    }
    public function mount()
    {
        $this->sound = KelolaSound::where('data_id', $this->dataId)->first();
        if ($this->sound) {
            $this->detik = $this->sound->start;
        }

        $this->isChecked =  $this->sound ?  $this->sound->isActive : false;
    }

    public function convertUrl()
    {
        if (strpos($this->youtube, 'youtube.com/watch?v=') !== false) {
            $videoId = explode('v=', $this->youtube)[1];
        } elseif (strpos($this->youtube, 'youtu.be/') !== false) {
            $videoId = explode('youtu.be/', $this->youtube)[1];
        }

        if ($videoId && strpos($videoId, '&') !== false) {
            $videoId = explode('&', $videoId)[0];
        }

        $this->url = 'https://www.youtube.com/embed/' . $videoId;
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
        $sound = '';
        if ($this->youtube) {
            $sound = $this->url;
        } else {
            if ($this->selectM?->link === null) {
                $sound = $this->sound->sound;
            } else {
                $sound = $this->selectM?->link;
            }
        }
        // dd($this->selectM?->link, $this->sound->sound);
        if (!$this->sound) {
            KelolaSound::create([
                'data_id' => $this->dataId,
                'sound' => $sound,
                'start' => $this->detik,
            ]);
        } else {
            $this->sound->update([
                'sound' => $sound,
                'start' => $this->detik,
            ]);
        }

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
        ]);
    }
}
