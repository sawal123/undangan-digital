<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Data;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UndanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.undangan');
    }

    public function kelola($id)
    {

        $icon = ['Pengantin.svg', 'Tema.svg', 'Acara.svg', 'Galery.svg', 'Musik.svg', 'Ucapan.svg', 'Kado.svg', 'Tamu.svg', 'Streaming.svg', 'Kisah-Cinta.svg', 'Setting.svg', 'Buku-Tamu.svg'];
        $nama = ['Pengantin', 'Tema', 'Acara', 'Galeri', 'Musik', 'Ucapan', 'Kado', 'Tamu', 'Streaming', 'Kisah Cinta', 'Setting', 'Buku Tamu'];
        $url =  ['pengantin', 'tema', 'acara', 'galeri', 'musik', 'ucapan', 'kado', 'tamu', 'streaming', 'kisah-cinta', 'setting', 'buku-tamu'];

        $objects = array_map(function ($nama, $icon, $url) {
            return (object) ['nama' => $nama, 'icon' => $icon, 'url'=> $url];
        }, $nama, $icon, $url);
        $decryptedId = Crypt::decryptString($id);
        $data = Data::findOrFail($decryptedId);
        return view('user.undanganKelola', [
            'data' => $data,
            'objects' => $objects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
