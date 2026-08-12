<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\JenisUdangan;
use Illuminate\Http\JsonResponse;

class JenisUndanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $jenis = JenisUdangan::select(['id', 'jenis'])
            ->orderBy('jenis', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data jenis undangan berhasil diambil.',
            'data' => $jenis,
        ]);
    }
}
