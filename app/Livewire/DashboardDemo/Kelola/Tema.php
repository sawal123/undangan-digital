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

    public function mount($id){
        $this->dataId = Crypt::decryptString($id);
        $this->loadData();
    }
    
    public function loadData(){
        $this->data = Data::find($this->dataId);
        $this->tema = Theme::with('category')->get();
    }

    public function choose($id){
        $this->data->theme_id = $id;
        $this->data->save();
        session()->flash('message', 'Yeay... Tema Berhasil Dipilih.');
        $this->loadData();
    }
    public function render()
    {
        return view('livewire.dashboard.kelola.tema')->layout('components.layouts.user-new', [
            'headerTitle' => 'Pilih Tema'
        ]);
    }
}
