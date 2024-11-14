<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\KelolaUndangan\Streaming as KelolaUndanganStreaming;
use Livewire\Component;

class Streaming extends Component
{
    public $dataId;
    public $link = null;
    public $isActive = false;
    public $fiturStreaming;

    public function updateFiturStreaming($isActive)
    {
        $streaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
        // dd($streaming);
        if ($streaming) {
            $streaming->update([

                'isActive' => $isActive
            ]);
        } else {
            KelolaUndanganStreaming::create([
                'data_id' => $this->dataId,
                'isActive' => $isActive
            ]);
        }
        // $this->fiturStreaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
    }
    public function mount()
    {
        $this->fiturStreaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->value('isActive') ?? false;
        $streaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
        if($streaming){
            $this->link = $streaming->link;
        }
    }


    public function save()
    {
        try {
            $streaming = KelolaUndanganStreaming::where('data_id', $this->dataId)->first();
            if ($streaming) {
                $streaming->update([
                    'link' => $this->link,
                ]);
                session()->flash('message', 'Streaming Berhasil Diubah.');
            } else {
                KelolaUndanganStreaming::create([
                    'data_id' => $this->dataId,
                    'link' => $this->link,
                ]);
                session()->flash('message', 'Streaming Berhasil Ditambahkan.');
            }
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.dashboard.kelola.streaming');
    }
}
