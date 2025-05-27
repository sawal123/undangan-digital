<?php

namespace App\Http\Controllers\Dashboard\KelolaUndangan\Pay;

use App\Models\Data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PayController extends Controller
{
    protected function getData($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id); // Dekripsi ID
            return Data::findOrFail($decryptedId); // Cari data berdasarkan ID
        } catch (DecryptException $e) {
            return null; // Kembalikan null jika dekripsi gagal
        }
    }

    public function index($id)
    {
        if($this->getData($id)){
            return view('user.kelola.pay.pay', [
                'data' => $this->getData($id),
            ]);
        }else{
            return abort('403');
        }
       
    }

     public function tunai($id)
    {
        if($this->getData($id)){
            return view('user.kelola.pay.finishTunai', [
                'data' => $this->getData($id),
            ]);
        }else{
            return abort('403');
        }
       
    }
}
