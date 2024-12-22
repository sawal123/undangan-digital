<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\Data;
use App\Models\Theme;
use Livewire\Component;

class Tema extends Component
{
    public $dataId;
    public $tema;
    public $data;

    public function mount(){
        // dd($this->dataId);
        $this->data = Data::where('id', $this->dataId)->first();
        $this->tema = Theme::all();
    }
    public function choose($id){
        $data = Data::find($this->dataId);
        $data->theme_id = $id;
        $data->save();
        session()->flash('message', 'Yeay... Tema Berhasil Dipilih.');
        $this->mount();
    }
    public function render()
    {
        return view('livewire.dashboard.kelola.tema');
    }
}
