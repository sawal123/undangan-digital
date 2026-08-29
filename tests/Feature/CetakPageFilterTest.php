<?php

namespace Tests\Feature;

use App\Livewire\Page\Cetak;
use App\Models\Admin\JenisUdangan;
use App\Models\Admin\UndanganCetak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CetakPageFilterTest extends TestCase
{
    use RefreshDatabase;

    private function makeJenis(string $nama): JenisUdangan
    {
        return JenisUdangan::create(['jenis' => $nama]);
    }

    private function makeProduk(string $nama, int $jenisId, int $harga = 1500): UndanganCetak
    {
        return UndanganCetak::create([
            'nama' => $nama,
            'jenis_id' => $jenisId,
            'stok' => 100,
            'terjual' => 0,
            'harga' => $harga,
            'promo' => 0,
            'favorite' => 0,
            'deskripsi' => 'Test',
            'gambar' => '[]',
        ]);
    }

    public function test_semua_menampilkan_semua_produk(): void
    {
        $thara = $this->makeJenis('Thara');
        $softcover = $this->makeJenis('Softcover');

        $this->makeProduk('Undangan Thara', $thara->id);
        $this->makeProduk('Undangan Softcover', $softcover->id);

        $component = Livewire::test(Cetak::class);

        $this->assertCount(2, $component->viewData('undangan'));
    }

    public function test_select_jenis_hanya_menampilkan_produk_kategori(): void
    {
        $thara = $this->makeJenis('Thara');
        $softcover = $this->makeJenis('Softcover');

        $tharaProduk = $this->makeProduk('Undangan Thara', $thara->id);
        $this->makeProduk('Undangan Softcover', $softcover->id);

        $component = Livewire::test(Cetak::class)
            ->call('selectJenis', $thara->id);

        $component->assertSet('selectedJenis', $thara->id);

        $ids = $component->viewData('undangan')->pluck('id')->all();
        $this->assertEquals([$tharaProduk->id], $ids);
    }

    public function test_select_jenis_mereset_per_page(): void
    {
        $thara = $this->makeJenis('Thara');

        Livewire::test(Cetak::class)
            ->call('loadMore')
            ->assertSet('perPage', 16)
            ->call('selectJenis', $thara->id)
            ->assertSet('perPage', 8)
            ->assertSet('selectedJenis', $thara->id);
    }

    public function test_semua_menghapus_filter_jenis(): void
    {
        $thara = $this->makeJenis('Thara');
        $softcover = $this->makeJenis('Softcover');

        $this->makeProduk('Undangan Thara', $thara->id);
        $this->makeProduk('Undangan Softcover', $softcover->id);

        $component = Livewire::test(Cetak::class)
            ->call('selectJenis', $thara->id);

        $component->assertSet('selectedJenis', $thara->id);
        $this->assertCount(1, $component->viewData('undangan'));

        $component->call('selectJenis', null);

        $component->assertSet('selectedJenis', null)
            ->assertSet('perPage', 8);
        $this->assertCount(2, $component->viewData('undangan'));
    }

    public function test_search_dan_kategori_berjalan_bersamaan(): void
    {
        $thara = $this->makeJenis('Thara');
        $softcover = $this->makeJenis('Softcover');

        $match = $this->makeProduk('Undangan 110 Thara', $thara->id);
        $this->makeProduk('Undangan ABC Thara', $thara->id);
        $this->makeProduk('Undangan 110 Softcover', $softcover->id);

        $component = Livewire::test(Cetak::class)
            ->set('search', '110')
            ->call('selectJenis', $thara->id);

        $ids = $component->viewData('undangan')->pluck('id')->all();
        $this->assertEquals([$match->id], $ids);
    }

    public function test_jenis_options_hanya_kategori_dengan_produk(): void
    {
        $thara = $this->makeJenis('Thara');
        $this->makeJenis('Kosong');

        $this->makeProduk('Undangan Thara', $thara->id);

        $component = Livewire::test(Cetak::class);

        $jenisNames = $component->viewData('jenisOptions')->pluck('jenis')->all();

        $this->assertContains('Thara', $jenisNames);
        $this->assertNotContains('Kosong', $jenisNames);
        $this->assertCount(1, $component->viewData('jenisOptions'));
    }
}
