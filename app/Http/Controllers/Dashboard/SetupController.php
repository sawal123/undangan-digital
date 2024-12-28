<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $nonce = bin2hex(random_bytes(16));
        return view('user.setup', ['nonce' => $nonce]);
    }

    public function checkName(Request $request)
    {
        $data = Data::where('slug', $request->name)->exists();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Nama sudah digunakan, Cari Nama Lain!',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Bagus, Nama tersedia!',
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
