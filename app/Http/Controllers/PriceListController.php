<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\PriceRequest;
use App\Models\Diskon;

class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = 'Price List';
        $price = PriceList::all();
        $diskon = Diskon::all();
        session(['halaman' => $title]);
        return view('admin.priceList', [
            'price' => $price,
            'diskons' => $diskon,
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
    public function store(PriceRequest $request)
    {

        // dd($request->all());
        $deskripsiArray = json_decode($request['deskripsi'], true);
        DB::beginTransaction();
        try {
            // $request = $request->request();


            $pricelist = PriceList::create([
                'name_packet' => $request['namaPaket'],
                'price' => $request['price'],
                'deskripsi' => json_encode($deskripsiArray),
                // 'diskon_id' => $diskon->id,
                'keterangan' => $request['keterangan']
            ]);
            $diskon = Diskon::create([
                'price_id' => $pricelist->id,
                'type' => $request['type'],
                'diskon' => $request['diskon']
            ]);

            $price = PriceList::all();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Price Berhasil ditambah!',
                'data' => $pricelist,
                'count' => $price->count()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500); // Status 500 menandakan ada masalah server
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PriceList $priceList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceList $priceList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceList $priceList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    DB::beginTransaction();
    try {
        $priceList= PriceList::find($id);
        if ($priceList->diskon) {
            $priceList->diskon->delete();
        }
        $priceList->delete();
        DB::commit();
        return response()->json([
            'success' => true,
            'message' => "Price Berhasil Di Hapus!",
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
