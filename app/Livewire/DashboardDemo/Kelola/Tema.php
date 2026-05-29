<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Data;
use App\Models\Theme;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class Tema extends Component
{
    public $dataId;
    public $tema;
    public $data;
    public bool $canShareInvitation = false;

    public function mount($id){
        $this->dataId = Data::where('uid', $id)->firstOrFail()->id;
        $this->loadData();
    }
    
    public function loadData(){
        $this->data = Data::with('eventType')->find($this->dataId);
        $this->canShareInvitation = $this->data?->canBeShared() ?? false;
        $this->tema = Theme::with(['category', 'eventType'])
            ->when($this->data->event_type_id, function ($query) {
                $query->where(function ($query) {
                    $query->where('event_type_id', $this->data->event_type_id)
                        ->orWhereNull('event_type_id');
                });
            })
            ->get();
    }

    public function choose($id){
        $this->data->theme_id = $id;
        $this->data->save();
        session()->flash('message', 'Yeay... Tema Berhasil Dipilih.');
        $this->loadData();
    }

    public function review()
    {
        $this->loadData();

        if (!$this->data?->canBeShared()) {
            session()->flash('error', 'Undangan belum aktif, review dengan data user belum bisa dibuka.');
            return;
        }

        if (!$this->data->theme_id) {
            session()->flash('error', 'Pilih tema terlebih dahulu sebelum review.');
            return;
        }

        $this->dispatch('open-new-tab', url: route('visit', ['slug' => $this->data->slug]));
    }

    public function render()
    {
        return view('livewire.dashboard.kelola.tema')->layout('components.layouts.user-new', [
            'headerTitle' => 'Pilih Tema'
        ]);
    }
}
