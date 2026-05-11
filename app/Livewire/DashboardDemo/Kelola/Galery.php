<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Data;
use Livewire\Component;
use Livewire\WithFileUploads;
// use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\KelolaUndangan\Galery as KelolaUndanganGalery;
use Illuminate\Support\Facades\Crypt;


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
  

    public $deleteId ='';


    public function close()
    {
        $this->dispatch('close-modal', name: 'delete-modal');
        $this->poto = '';
        $this->video = '';
    }

    public function delete($id)
    {
        $galery = KelolaUndanganGalery::find($id);
        // dd($galery);
        // Ambil semua data dengan data_id yang sesuai, urutkan berdasarkan `sort`, dan reset ulang nilai `sort`
        if ($galery->poto !== null) {
            Storage::delete('public/' . $galery->poto); // Pastikan path benar
        }
        $galery->delete();

        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort')->get();
        foreach ($this->data as $index => $data) {
            $data->update(['sort' => $index + 1]);
        }
        session()->flash('message', 'Data Galery Berhasil Dihapus.');
    }

    public $preview = null ;
    public function pre($id){
        // dd($id);
        $this->preview = KelolaUndanganGalery::find($id);
        $this->dispatch('open-modal', name: 'preview-modal');
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

    public function mount($id)
    {
        $this->dataId = Data::where('uid', $id)->firstOrFail()->id;
        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();
    }

    public function save()
    {

        $data = KelolaUndanganGalery::where('data_id', $this->dataId)->get();
        $imagePath = is_object($this->poto) ? $this->poto->store('galery', 'public') : null;

        if ($data->count() < 10 || !$data) {
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

            $this->dispatch('close-modal', name: 'photo-modal');
            $this->dispatch('close-modal', name: 'video-modal');
            session()->flash('message', 'Galery Telah Tersimpan.');
            $this->poto = '';
            $this->video = '';
        } else {
            $this->dispatch('close-modal', name: 'photo-modal');
            $this->dispatch('close-modal', name: 'video-modal');
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
        return view('livewire.dashboard.kelola.galery')->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Galeri'
        ]);
    }
}
