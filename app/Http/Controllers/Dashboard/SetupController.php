<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Data;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function add($id)
    {
        //
        $nonce = bin2hex(random_bytes(16));
        $data = User::find(base64_decode($id));
        if (!$data) {
            return redirect()->route('dashboard.setup')->with('error', 'Data tidak ditemukan');
        }
        return view('user.addUndangan', [
            'data' => $data,
            'nonce' => $nonce
        ]);
    }

    public function checkName(Request $request)
    {
        $data = Data::where('slug', $request->name)->exists();
        if ($data) {
            return response()->json([
                'success' => false,
                'message' => 'Slug sudah digunakan, Cari slug lain!',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Bagus, Slug bisa digunakan!',
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
