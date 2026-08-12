<?php

namespace Tests\Feature;

use App\Models\Admin\JenisUdangan;
use App\Models\Admin\UndanganCetak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UndanganCetakTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_dengan_jenis_id_berhasil()
    {
        $jenis = JenisUdangan::create(['jenis' => 'Softcover']);

        $undangan = UndanganCetak::create([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis->id,
            'stok' => 100,
            'harga' => 1500,
        ]);

        $this->assertEquals($jenis->id, $undangan->jenis_id);
        $this->assertDatabaseHas('undangan_cetaks', [
            'id' => $undangan->id,
            'jenis_id' => $jenis->id,
        ]);
    }

    public function test_update_jenis_berhasil()
    {
        $jenis1 = JenisUdangan::create(['jenis' => 'Softcover']);
        $jenis2 = JenisUdangan::create(['jenis' => 'Hardcover']);

        $undangan = UndanganCetak::create([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis1->id,
            'stok' => 100,
            'harga' => 1500,
        ]);

        $undangan->update(['jenis_id' => $jenis2->id]);

        $this->assertEquals($jenis2->id, $undangan->refresh()->jenis_id);
    }

    public function test_search_nama_jenis_berhasil()
    {
        $jenis = JenisUdangan::create(['jenis' => 'Rustic Theme']);
        UndanganCetak::create([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis->id,
            'stok' => 100,
            'harga' => 1500,
        ]);

        $searchTerm = 'Rustic';
        $results = UndanganCetak::whereHas('jenisUndangan', function ($q) use ($searchTerm) {
            $q->where('jenis', 'like', "%{$searchTerm}%");
        })->get();

        $this->assertCount(1, $results);
    }

    public function test_listing_tidak_bergantung_pada_kolom_jenis()
    {
        $jenis = JenisUdangan::create(['jenis' => 'Softcover']);
        UndanganCetak::create([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis->id,
            'stok' => 100,
            'harga' => 1500,
        ]);

        $results = UndanganCetak::with('jenisUndangan')->get();
        $this->assertTrue($results->first()->relationLoaded('jenisUndangan'));
        $this->assertEquals('Softcover', $results->first()->jenisUndangan->jenis);
    }

    public function test_api_filter_jenis_id_berhasil()
    {
        $jenis1 = JenisUdangan::create(['jenis' => 'Softcover']);
        $jenis2 = JenisUdangan::create(['jenis' => 'Hardcover']);

        UndanganCetak::create([
            'nama' => 'Undangan 1',
            'jenis_id' => $jenis1->id,
            'stok' => 100,
            'harga' => 1500,
        ]);

        UndanganCetak::create([
            'nama' => 'Undangan 2',
            'jenis_id' => $jenis2->id,
            'stok' => 100,
            'harga' => 2000,
        ]);

        $request = new \Illuminate\Http\Request();
        $request->merge(['jenis_id' => $jenis1->id]);

        $controller = new \App\Http\Controllers\Api\UndanganCetakController();
        $response = $controller->index($request);

        $this->assertEquals(200, $response->status());
        $data = $response->getData(true);
        $this->assertCount(1, $data['data']['data']);
        $this->assertEquals('Undangan 1', $data['data']['data'][0]['nama']);
    }
}
