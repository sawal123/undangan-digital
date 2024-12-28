<?php

namespace App\Http\Controllers\Dashboard\KelolaUndangan;

use App\Models\Data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class ViewKelolaUndanganController extends Controller
{

    protected function getData($id)
    {
        $decryptedId = Crypt::decryptString($id);
        return  Data::findOrFail($decryptedId);
    }

    public function pengantin($id)
    {
        // dd($this->getData($id));
        return view('user.kelola.pengantin', [
            'data' => $this->getData($id),
        ]);
    }
    public function acara($id)
    {

        return view('user.kelola.acara', [
            'data' => $this->getData($id),
        ]);
    }
    public function galery($id)
    {

        return view('user.kelola.galery', [
            'data' => $this->getData($id),
        ]);
    }
    public function sound($id){
        return view('user.kelola.sound',[
            'data' => $this->getData($id),
        ]);
    }
    public function ucapan($id){
        return view('user.kelola.ucapan',[
            'data' => $this->getData($id),
        ]);
    }
    public function tamu($id){
        return view('user.kelola.tamu',[
            'data' => $this->getData($id),
        ]);
    }
    public function streaming($id){
        return view('user.kelola.streaming',[
            'data' => $this->getData($id),
        ]);
    }
    public function kado($id){
        return view('user.kelola.kado',[
            'data' => $this->getData($id),
        ]);
    }
    public function kisah($id){
        return view('user.kelola.kisah',[
            'data' => $this->getData($id),
        ]);
    }
    public function setting($id){
        $data = Data::find($this->getData($id));
        // dd($this->getData($id));
        return view('user.kelola.setting',[
            'data' => $this->getData($id),
        ]);
    }
    public function tema($id){
        $data = Data::find($this->getData($id));
        // dd($this->getData($id));
        return view('user.kelola.tema',[
            'data' => $this->getData($id),
        ]);
    }
    public function bukutamu($id){
        $data = Data::find($this->getData($id));
        // dd($this->getData($id));
        return view('user.kelola.bukutamu',[
            'data' => $this->getData($id),
        ]);
    }
}
