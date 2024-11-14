<?php

namespace App\Livewire\Dashboard\Kelola;

use Livewire\Component;
use Livewire\WithFileUploads;
// use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\KelolaUndangan\Galery as KelolaUndanganGalery;


class Galery extends Component
{
    use WithFileUploads;
    public $dataId;
    public $poto;
    public $video = null;
    public $type;
    public $id = '';
    public $data;

    public $url;
  

    public $deleteId;


    public function close()
    {
        $this->dispatch('close-modal');
        $this->poto = '';
        $this->video = '';
    }
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('openDeleteModal');
        // $this->dispatch('open-delete-modal'); 
    }

    public function delete()
    {
        $galery = KelolaUndanganGalery::find($this->deleteId)->delete();
        // Ambil semua data dengan data_id yang sesuai, urutkan berdasarkan `sort`, dan reset ulang nilai `sort`
        if ($galery->poto) {
            Storage::delete('public/' . $galery->poto); // Pastikan path benar
        }

        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort')->get();
        foreach ($this->data as $index => $data) {
            $data->update(['sort' => $index + 1]);
        }
        session()->flash('message', 'Data Galery Berhasil Dihapus.');
        $this->dispatch('close-hapus');
    }

    public function convertUrl()
    {
        if (strpos($this->video, 'youtube.com/watch?v=') !== false) {
            $videoId = explode('v=', $this->video)[1];
        } elseif (strpos($this->video, 'youtu.be/') !== false) {
            $videoId = explode('youtu.be/', $this->video)[1];
        }

        if ($videoId && strpos($videoId, '&') !== false) {
            $videoId = explode('&', $videoId)[0];
        }

        $this->url = 'https://www.youtube.com/embed/' . $videoId;
    }

    public function mount()
    {
        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();
    }

    public function save()
    {

        $data = KelolaUndanganGalery::where('data_id', $this->dataId)->get();
        $imagePath = is_object($this->poto) ? $this->poto->store('galery', 'public') : null;

        if ($data->count() < 10) {
            if ($this->poto !== null) {
                $this->validate([
                    'poto' => 'required|image|max:1024',
                ]);
                KelolaUndanganGalery::create([
                    'data_id' => $this->dataId,
                    'sort' => $data->count() + 1,
                    'poto' => $imagePath,
                ]);
            } else {
                $this->validate([
                    'video' => 'required|string|max:225',
                ]);
                $this->convertUrl();
                KelolaUndanganGalery::create([
                    'data_id' => $this->dataId,
                    'sort' => $data->count() + 1,
                    'video' => $this->url
                ]);
            }
            $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();

            $this->close();
            session()->flash('message', 'Galery Telah Tersimpan.');
        } else {
            $this->close();
            session()->flash('message', 'Galery Anda Telah Mencapai Batas Maksimal.');
        }
    }

    public function previous($sort)
    {
        $dataSort = KelolaUndanganGalery::where('data_id', $this->dataId)->where('sort', $sort)->first();
        $downSort = KelolaUndanganGalery::where('data_id', $this->dataId)->where('sort', $sort - 1)->first();
        while ($downSort === null && $sort > 0) {
            $sort--; // Kurangi nilai sort
            $downSort = KelolaUndanganGalery::where('data_id', $this->dataId)->where('sort', $sort)->first();
        }
        if ($downSort !== null) {
            $dataSort->update([
                'sort' => $dataSort->sort - 1,
            ]);
            $downSort->update([
                'sort' => $downSort->sort + 1,
            ]);
        }
        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();
    }

    public function next($sort)
    {
        $dataSort = KelolaUndanganGalery::where('data_id', $this->dataId)->where('sort', $sort)->first();
        $upSort = KelolaUndanganGalery::where('data_id', $this->dataId)->where('sort', $sort + 1)->first();

        while ($upSort === null && $sort > 0 && $sort < $dataSort->count()) {
            $sort--; // Kurangi nilai sort
            $upSort = KelolaUndanganGalery::where('data_id', $this->dataId)->where('sort', $sort)->first();
        }
        $dataSort->update([
            'sort' => $dataSort->sort + 1,
        ]);
        if ($upSort !== null) {
            $upSort->update([
                'sort' => $upSort->sort - 1,
            ]);
        }
        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();
    }
    public function render()
    {
        return view('livewire.dashboard.kelola.galery'

        );
    }
}
