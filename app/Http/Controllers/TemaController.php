<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TemaController extends Controller
{
    protected function getData($id)
    {
        return $tema = Crypt::decryptString($id);
    }
    public function index($slug)
    {
        dd('tes');
        $tema = Data::where('slug', $slug)->first();
        return $tema;
    }
    public function demo($slug)
    {
        $tema = Crypt::decryptString($slug);
        // dd($slug);
        return view($tema);
    }
}
