<?php

namespace Tests\Feature;

use App\Models\Admin\JenisUdangan;
use App\Models\Admin\UndanganCetak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UndanganCetakTest extends TestCase
{
    use RefreshDatabase;

    private function getDefaultData(array $merge = [])
    {
        return array_merge([
            'stok' => 100,
            'terjual' => 0,
            'harga' => 1500,
            'promo' => 0,
            'favorite' => 0,
            'deskripsi' => 'Test',
            'gambar' => '[]',
        ], $merge);
    }

    public function test_create_dengan_jenis_id_berhasil()
    {
        $jenis = JenisUdangan::create(['jenis' => 'Softcover']);

        $undangan = UndanganCetak::create($this->getDefaultData([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis->id,
        ]));

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

        $undangan = UndanganCetak::create($this->getDefaultData([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis1->id,
        ]));

        $undangan->update(['jenis_id' => $jenis2->id]);

        $this->assertEquals($jenis2->id, $undangan->refresh()->jenis_id);
    }

    public function test_search_nama_jenis_berhasil()
    {
        $jenis = JenisUdangan::create(['jenis' => 'Rustic Theme']);
        UndanganCetak::create($this->getDefaultData([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis->id,
        ]));

        $searchTerm = 'Rustic';
        $results = UndanganCetak::whereHas('jenisUndangan', function ($q) use ($searchTerm) {
            $q->where('jenis', 'like', "%{$searchTerm}%");
        })->get();

        $this->assertCount(1, $results);
    }

    public function test_listing_tidak_bergantung_pada_kolom_jenis()
    {
        $jenis = JenisUdangan::create(['jenis' => 'Softcover']);
        UndanganCetak::create($this->getDefaultData([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis->id,
        ]));

        $results = UndanganCetak::with('jenisUndangan')->get();
        $this->assertTrue($results->first()->relationLoaded('jenisUndangan'));
        $this->assertEquals('Softcover', $results->first()->jenisUndangan->jenis);
    }

    public function test_api_filter_jenis_id_berhasil()
    {
        $jenis1 = JenisUdangan::create(['jenis' => 'Softcover']);
        $jenis2 = JenisUdangan::create(['jenis' => 'Hardcover']);

        UndanganCetak::create($this->getDefaultData([
            'nama' => 'Undangan 1',
            'jenis_id' => $jenis1->id,
        ]));

        UndanganCetak::create($this->getDefaultData([
            'nama' => 'Undangan 2',
            'jenis_id' => $jenis2->id,
            'harga' => 2000,
        ]));

        $request = new \Illuminate\Http\Request();
        $request->merge(['jenis_id' => $jenis1->id]);

        $controller = new \App\Http\Controllers\Api\UndanganCetakController();
        $response = $controller->index($request);

        $this->assertEquals(200, $response->status());
        $data = $response->getData(true);
        $this->assertCount(1, $data['data']['data']);
        $this->assertEquals('Undangan 1', $data['data']['data'][0]['nama']);
    }

    public function test_api_jenis_undangan_berhasil_dengan_api_key_valid()
    {
        JenisUdangan::create(['jenis' => 'Zebra']);
        JenisUdangan::create(['jenis' => 'Alpha']);

        // Test with API Key (middleware api.key checks for Bearer token or api_key query param usually)
        // Since we are just testing the endpoint structure and ordering here, 
        // we can test the controller method directly to bypass middleware in this simple test,
        // OR we can make an actual HTTP request. Assuming api.key uses 'api_key' param or similar,
        // let's just make a JSON request. If we need to pass middleware, we should set the config/api key.
        // But since this is a feature test, let's call the endpoint.
        // Wait, the instruction says "Request tanpa API key tetap ditolak oleh middleware yang sudah ada".
        // Let's first test the response without API key.
        $responseWithoutKey = $this->getJson('/api/v1/jenis-undangan');
        $responseWithoutKey->assertStatus(401);

        // To test with valid key, we need to know how 'api.key' middleware works. 
        // We'll mock the middleware or get the key from config.
        $apiKey = config('services.api.key');
        if (empty($apiKey)) {
            config(['services.api.key' => 'test-key']);
            $apiKey = 'test-key';
        }

        $response = $this->withHeaders([
            'X-API-Key' => $apiKey
        ])->getJson('/api/v1/jenis-undangan');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'jenis'
                ]
            ]
        ]);

        // Check if data is ordered by 'jenis' asc
        $data = $response->json('data');
        $this->assertEquals('Alpha', $data[0]['jenis']);
        $this->assertEquals('Zebra', $data[1]['jenis']);
    }
}
