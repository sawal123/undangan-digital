<?php

namespace App\Http\Controllers;

use App\Models\GiftPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GiftPayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'nama_pay' => 'required|string|max:255',
            'icon' => 'required|image|mimes:png,jpg,jpeg,webp|max:1024'
        ]);
        DB::beginTransaction();
        try {

            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('gift', 'public');
                $validatedData['icon'] = $iconPath;
            } else {
                $iconPath = 'images/icon-category-default.png';
            }
            $gift = GiftPay::create($validatedData);
            DB::commit();
            $count = GiftPay::all();
            return response()->json([
                'success' => true,
                'message' => 'Gift Pay Berhasil Disimpan!',
                'data' => $gift,
                'count' => $count->count()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
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
    public function destroy($id)
    {
        DB::beginTransaction();
        $giftPay = GiftPay::find($id);
        // dd($giftPay);
        try {
            if ($giftPay->icon) {
                Storage::disk('public')->delete($giftPay->icon);
            }
            $giftPay->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Gift Pay Berhasil dihapus!',
                'data' => $giftPay,
                'count' => GiftPay::count(),
            ]);
          
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
