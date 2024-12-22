<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class viewAdminController extends Controller
{
    public function index(){
        return view('admin.paysetting');
    }

    public function harga(){
        $title = "Harga Thema";
        return view('admin.harga');
    }
}
