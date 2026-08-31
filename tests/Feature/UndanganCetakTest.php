<?php

namespace Tests\Feature;

use App\Models\Admin\JenisUdangan;
use App\Models\Admin\UndanganCetak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    private function apiHeaders(): array
    {
        config(['services.api.key' => 'test-key']);

        return ['X-API-Key' => 'test-key'];
    }

    private function makeUndangan(array $merge = []): UndanganCetak
    {
        $jenis = JenisUdangan::create(['jenis' => 'Softcover']);

        return UndanganCetak::create(array_merge([
            'nama' => 'Undangan A',
            'jenis_id' => $jenis->id,
            'stok' => 100,
            'terjual' => 0,
            'harga' => 1500,
            'promo' => 0,
            'favorite' => 0,
            'deskripsi' => 'Test',
            'gambar' => [],
        ], $merge));
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

        $request = new \Illuminate\Http\Request;
        $request->merge(['jenis_id' => $jenis1->id]);

        $controller = new \App\Http\Controllers\Api\UndanganCetakController;
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

        config(['services.api.key' => 'test-key']);
        $apiKey = 'test-key';

        $responseWithoutKey = $this->getJson('/api/v1/jenis-undangan');
        $responseWithoutKey->assertStatus(401);

        $response = $this->withHeaders([
            'X-API-Key' => $apiKey,
        ])->getJson('/api/v1/jenis-undangan');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'jenis',
                ],
            ],
        ]);

        $data = $response->json('data');
        $this->assertEquals('Alpha', $data[0]['jenis']);
        $this->assertEquals('Zebra', $data[1]['jenis']);
    }

    // ---------------------------------------------------------------------
    // Reproduksi kontrak client era_digital:
    //   POST /api/v1/undangan-cetak/{id}  (multipart)
    //   _method=PUT
    //   gambar[]=file
    //   hapus_gambar_lama=true (opsional)
    // ---------------------------------------------------------------------

    public function test_api_update_upload_jpg_baru_multipart_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'nama' => 'Undangan Update',
            'harga' => 2000,
            'gambar' => [UploadedFile::fake()->image('new.jpg', 100, 100)],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $undangan->refresh();
        $this->assertCount(1, $undangan->gambar);
        $this->assertIsString($undangan->gambar[0]);
        $this->assertStringStartsWith('undangan-cetak/', $undangan->gambar[0]);
        Storage::disk('public')->assertExists($undangan->gambar[0]);
        $this->assertEquals('Undangan Update', $undangan->nama);
        $this->assertEquals(2000, $undangan->harga);
    }

    public function test_api_update_upload_png_multipart_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'gambar' => [UploadedFile::fake()->image('cover.png', 200, 200)],
        ]);

        $response->assertStatus(200);
        $undangan->refresh();
        $this->assertCount(1, $undangan->gambar);
        Storage::disk('public')->assertExists($undangan->gambar[0]);
    }

    public function test_api_update_teks_dan_gambar_bersamaan_multipart_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'nama' => 'Nama Baru',
            'harga' => 5000,
            'deskripsi' => 'Deskripsi baru',
            'gambar' => [UploadedFile::fake()->image('a.jpg')],
        ]);

        $response->assertStatus(200);
        $undangan->refresh();
        $this->assertEquals('Nama Baru', $undangan->nama);
        $this->assertEquals(5000, $undangan->harga);
        $this->assertEquals('Deskripsi baru', $undangan->deskripsi);
        $this->assertCount(1, $undangan->gambar);
    }

    public function test_api_update_multiple_gambar_multipart_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'gambar' => [
                UploadedFile::fake()->image('a.jpg'),
                UploadedFile::fake()->image('b.png'),
            ],
        ]);

        $response->assertStatus(200);
        $undangan->refresh();
        $this->assertCount(2, $undangan->gambar);
        Storage::disk('public')->assertExists($undangan->gambar[0]);
        Storage::disk('public')->assertExists($undangan->gambar[1]);
    }

    public function test_api_update_tanpa_gambar_tetap_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'nama' => 'Tanpa Gambar',
        ]);

        $response->assertStatus(200);
        $undangan->refresh();
        $this->assertEquals('Tanpa Gambar', $undangan->nama);
        $this->assertCount(0, $undangan->gambar);
    }

    public function test_api_update_gambar_oversize_mengembalikan_422_bukan_500()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $bigFile = UploadedFile::fake()->image('big.jpg')->size(3000); // KB -> > 2MB

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'gambar' => [$bigFile],
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseHas('undangan_cetaks', [
            'id' => $undangan->id,
            'nama' => 'Undangan A',
        ]);
    }

    public function test_api_update_gambar_invalid_mengembalikan_422()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'gambar' => [UploadedFile::fake()->create('document.pdf', 10)],
        ]);

        $response->assertStatus(422);
    }

    public function test_api_replace_gambar_dengan_hapus_gambar_lama_string_true_berhasil()
    {
        Storage::fake('public');
        Storage::disk('public')->put('undangan-cetak/old-a.jpg', 'old-a');
        Storage::disk('public')->put('undangan-cetak/old-b.jpg', 'old-b');

        $undangan = $this->makeUndangan([
            'gambar' => ['undangan-cetak/old-a.jpg', 'undangan-cetak/old-b.jpg'],
        ]);

        // Persis kontrak client era_digital: hapus_gambar_lama dikirim string "true".
        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'hapus_gambar_lama' => 'true',
            'gambar' => [UploadedFile::fake()->image('new.jpg')],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $undangan->refresh();
        $this->assertCount(1, $undangan->gambar);
        $this->assertStringStartsWith('undangan-cetak/', $undangan->gambar[0]);
        Storage::disk('public')->assertExists($undangan->gambar[0]);
        Storage::disk('public')->assertMissing('undangan-cetak/old-a.jpg');
        Storage::disk('public')->assertMissing('undangan-cetak/old-b.jpg');
    }

    public function test_api_append_gambar_tanpa_hapus_gambar_lama_menyimpan_gambar_lama_dan_baru()
    {
        Storage::fake('public');
        Storage::disk('public')->put('undangan-cetak/old-a.jpg', 'old-a');

        $undangan = $this->makeUndangan([
            'gambar' => ['undangan-cetak/old-a.jpg'],
        ]);

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'gambar' => [UploadedFile::fake()->image('new.jpg')],
        ]);

        $response->assertStatus(200);

        $undangan->refresh();
        $this->assertCount(2, $undangan->gambar);
        $this->assertEquals('undangan-cetak/old-a.jpg', $undangan->gambar[0]);
        $this->assertStringStartsWith('undangan-cetak/', $undangan->gambar[1]);
        Storage::disk('public')->assertExists('undangan-cetak/old-a.jpg');
        Storage::disk('public')->assertExists($undangan->gambar[1]);
    }

    public function test_api_replace_gambar_upload_gagal_record_lama_tetap_utuh()
    {
        Storage::fake('public');
        Storage::disk('public')->put('undangan-cetak/old-a.jpg', 'old-a');
        Storage::disk('public')->put('undangan-cetak/old-b.jpg', 'old-b');

        $oldAPath = Storage::disk('public')->path('undangan-cetak/old-a.jpg');
        $oldBPath = Storage::disk('public')->path('undangan-cetak/old-b.jpg');
        $this->assertFileExists($oldAPath);
        $this->assertFileExists($oldBPath);

        $undangan = $this->makeUndangan([
            'gambar' => ['undangan-cetak/old-a.jpg', 'undangan-cetak/old-b.jpg'],
        ]);

        // Paksa store() gagal: exception filesystem.
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('putFileAs')->andThrow(new \RuntimeException('disk full'));

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'hapus_gambar_lama' => 'true',
            'gambar' => [UploadedFile::fake()->image('new.jpg')],
        ]);

        // Response JSON aman, bukan stack trace.
        $response->assertJson(['success' => false]);
        $this->assertStringNotContainsString('RuntimeException', $response->getContent());
        $this->assertStringNotContainsString('disk full', $response->getContent());

        // Record lama tetap utuh, gambar lama tetap ada.
        $undangan->refresh();
        $this->assertCount(2, $undangan->gambar);
        $this->assertEquals('Undangan A', $undangan->nama);
        $this->assertFileExists($oldAPath);
        $this->assertFileExists($oldBPath);
    }

    public function test_api_replace_file_lama_dihapus_hanya_setelah_database_sukses()
    {
        Storage::fake('public');
        Storage::disk('public')->put('undangan-cetak/old-a.jpg', 'old-a');

        $undangan = $this->makeUndangan([
            'gambar' => ['undangan-cetak/old-a.jpg'],
        ]);

        // Paksa DB transaction gagal.
        \Illuminate\Support\Facades\DB::shouldReceive('transaction')
            ->andThrow(new \RuntimeException('db dead'));

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'hapus_gambar_lama' => 'true',
            'nama' => 'Nama Baru',
            'gambar' => [UploadedFile::fake()->image('new.jpg')],
        ]);

        // Record lama tidak berubah, gambar lama tidak dihapus.
        $undangan->refresh();
        $this->assertEquals('Undangan A', $undangan->nama);
        $this->assertEquals(['undangan-cetak/old-a.jpg'], $undangan->gambar);
        Storage::disk('public')->assertExists('undangan-cetak/old-a.jpg');
    }

    public function test_api_create_dengan_gambar_berhasil_dan_url_dapat_dihasilkan()
    {
        Storage::fake('public');
        $jenis = JenisUdangan::create(['jenis' => 'Softcover']);

        $response = $this->withHeaders($this->apiHeaders())->post('/api/v1/undangan-cetak', [
            'nama' => 'Undangan Baru',
            'jenis_id' => $jenis->id,
            'stok' => 10,
            'harga' => 1000,
            'deskripsi' => 'Deskripsi',
            'gambar' => [UploadedFile::fake()->image('cover.jpg')],
        ]);

        $response->assertStatus(201);
        $data = $response->json('data');
        $this->assertCount(1, $data['gambar']);
        $this->assertStringStartsWith('undangan-cetak/', $data['gambar'][0]);
        Storage::disk('public')->assertExists($data['gambar'][0]);

        // thumbnail_url / image_urls tetap bisa dihasilkan.
        $this->assertStringContainsString('/storage/undangan-cetak/', $data['thumbnail_url']);
        $this->assertCount(1, $data['image_urls']);
    }

    // ---------------------------------------------------------------------
    // Regression: deskripsi NOT NULL di DB vs nullable di API.
    // ConvertEmptyStringsToNull mengubah '' menjadi null, sehingga update
    // yang sebelumnya gagal (SQLSTATE 1048) harus dinormalisasi menjadi ''.
    // ---------------------------------------------------------------------

    public function test_api_update_multipart_gambar_dan_deskripsi_kosong_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'nama' => 'Undangan Deskripsi Kosong',
            'deskripsi' => '',
            'gambar' => [UploadedFile::fake()->image('baru.jpg', 100, 100)],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $undangan->refresh();
        $this->assertSame('', $undangan->deskripsi);
        $this->assertCount(1, $undangan->gambar);
        $this->assertStringStartsWith('undangan-cetak/', $undangan->gambar[0]);
        Storage::disk('public')->assertExists($undangan->gambar[0]);
    }

    public function test_api_update_multipart_deskripsi_null_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->post("/api/v1/undangan-cetak/{$undangan->id}", [
            '_method' => 'PUT',
            'deskripsi' => null,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertSame('', $undangan->refresh()->deskripsi);
    }

    public function test_api_update_tanpa_gambar_deskripsi_kosong_berhasil()
    {
        Storage::fake('public');
        $undangan = $this->makeUndangan();

        $response = $this->withHeaders($this->apiHeaders())->putJson("/api/v1/undangan-cetak/{$undangan->id}", [
            'nama' => 'Tanpa Gambar Deskripsi Kosong',
            'deskripsi' => '',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $undangan->refresh();
        $this->assertEquals('Tanpa Gambar Deskripsi Kosong', $undangan->nama);
        $this->assertSame('', $undangan->deskripsi);
    }

    public function test_api_create_deskripsi_kosong_dengan_gambar_berhasil()
    {
        Storage::fake('public');
        $jenis = JenisUdangan::create(['jenis' => 'Softcover']);

        $response = $this->withHeaders($this->apiHeaders())->post('/api/v1/undangan-cetak', [
            'nama' => 'Undangan Baru Deskripsi Kosong',
            'jenis_id' => $jenis->id,
            'stok' => 10,
            'harga' => 1000,
            'deskripsi' => '',
            'gambar' => [UploadedFile::fake()->image('cover.jpg')],
        ]);

        $response->assertStatus(201);
        $data = $response->json('data');
        $this->assertSame('', $data['deskripsi']);
        $this->assertCount(1, $data['gambar']);
        $this->assertStringStartsWith('undangan-cetak/', $data['gambar'][0]);
        Storage::disk('public')->assertExists($data['gambar'][0]);

        $this->assertDatabaseHas('undangan_cetaks', [
            'id' => $data['id'],
            'deskripsi' => '',
        ]);
    }
}
