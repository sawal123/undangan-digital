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
}
