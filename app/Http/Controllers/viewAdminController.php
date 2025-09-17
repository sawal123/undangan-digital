<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\User;
use Illuminate\Http\Request;

class viewAdminController extends Controller
{
    public function admin(){
        $user = User::count();
        $undangan = Data::count();
        $title = "Admin";
        return view('admin.admin');
    }
    public function index(){
        return view('admin.paysetting');
    }

    public function harga(){
        $title = "Harga Thema";
        return view('admin.harga');
    }
    public function transaksi(){
        $title = "Transaksi";
        return view('admin.transaksi');
    }
    public function user(){
        $title = "User";
        return view('admin.user');
    }
    public function animation(){
        $title = "Undangan Animation";
        return view('admin.animation');
    }
    public function undangancetak(){
        $title = "Undangan Animation";
        return view('admin.undangancetak');
    }
    public function fonts(){
        $title = "Fonts";
        return view('admin.fonts');
    }
}
