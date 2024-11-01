<?php

namespace App\Http\Controllers\Dashboard\KelolaUndangan;

use App\Models\Data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class AcaraController extends Controller
{
    public function index($id){
        $decryptedId = Crypt::decryptString($id);
        $data = Data::findOrFail($decryptedId);
        return view('user.kelola.acara', [
            'data'=>$data,
        ]);
    }
}
