<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\Data;
use App\Models\KelolaUndangan\Galery as KelolaUndanganGalery;
// use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Services\YouTubeUrlParser;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class Galery extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    #[Locked]
    public $dataId;

    public $poto;

    public $video = null;

    public $type;

    public $id = '';

    public $data;

    public $url;

    public $deleteId = '';

    public function close()
    {
        $this->dispatch('close-modal', name: 'delete-modal');
        $this->poto = '';
        $this->video = '';
    }

    public function delete($id)
    {
        $this->authorizeInvitationState();
        $galery = KelolaUndanganGalery::where('data_id', $this->dataId)->findOrFail($id);
        // dd($galery);
        // Ambil semua data dengan data_id yang sesuai, urutkan berdasarkan `sort`, dan reset ulang nilai `sort`
        if ($galery->poto !== null) {
            Storage::delete('public/'.$galery->poto); // Pastikan path benar
        }
        $galery->delete();

        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort')->get();
        foreach ($this->data as $index => $data) {
            $data->update(['sort' => $index + 1]);
        }
        session()->flash('message', 'Data Galery Berhasil Dihapus.');
    }

    public $preview = null;

    public function pre($id)
    {
        $this->authorizeInvitationState();
        // dd($id);
        $this->preview = KelolaUndanganGalery::where('data_id', $this->dataId)->findOrFail($id);
        $this->dispatch('open-modal', name: 'preview-modal');
    }

    public function convertUrl()
    {
        $this->url = app(YouTubeUrlParser::class)->toEmbedUrl($this->video);

        if (! $this->url) {
            $this->addError('video', 'URL YouTube tidak valid.');
        }
    }

    public function mount($id)
    {
        $this->dataId = $this->ownedInvitationByUid($id)->id;
        $this->data = KelolaUndanganGalery::where('data_id', $this->dataId)->orderBy('sort', 'asc')->get();
    }

    public function save()
    {
        $this->authorizeInvitationState();

        $data = KelolaUndanganGalery::where('data_id', $this->dataId)->get();
        if ($data->count() < 10 || ! $data) {
            if ($this->poto !== null) {
                $this->validate([
                    'poto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);
                $imagePath = is_object($this->poto) ? $this->poto->store('galery', 'public') : null;
                KelolaUndanganGalery::create([
                    'data_id' => $this->dataId,
                    'sort' => $data->count() + 1,
                    'poto' => $imagePath,
                ]);
            } else {
                $this->validate([
                    'video' => 'required|url|max:225',
                ]);
                $this->convertUrl();
                if (! $this->url) {
                    return;
                }
                KelolaUndanganGalery::create([
                    'data_id' => $this->dataId,
                    'sort' => $data->count() + 1,
                    'video' => $this->url,
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
        $this->authorizeInvitationState();
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
        $this->authorizeInvitationState();
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
        $this->authorizeInvitationState();

        return view('livewire.dashboard.kelola.galery')->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Galeri',
        ]);
    }
}
