<?php

namespace Tests\Feature;

use App\Livewire\AdminDemo\CetakDemo;
use App\Models\Admin\JenisUdangan;
use App\Models\Admin\UndanganCetak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CetakDemoLifecycleTest extends TestCase
{
    use RefreshDatabase;

    private function makeJenis(string $nama): JenisUdangan
    {
        return JenisUdangan::create(['jenis' => $nama]);
    }

    private function makeProduk(string $nama, int $jenisId, string $deskripsi = 'Deskripsi awal'): UndanganCetak
    {
        return UndanganCetak::create([
            'nama' => $nama,
            'jenis_id' => $jenisId,
            'stok' => 100,
            'terjual' => 0,
            'harga' => 1500,
            'harga_modal' => 1000,
            'ukuran_opp' => '13 x 20 cm',
            'promo' => 0,
            'favorite' => 0,
            'deskripsi' => $deskripsi,
            'gambar' => '[]',
        ]);
    }

    public function test_open_create_modal_mereset_form_dan_masuk_mode_create(): void
    {
        $jenis = $this->makeJenis('Softcover');
        $produk = $this->makeProduk('Produk Lama', $jenis->id);

        Livewire::test(CetakDemo::class)
            ->call('edit', $produk->id)
            ->assertSet('isEdit', true)
            ->assertSet('nama', 'Produk Lama')
            ->call('openCreateModal')
            ->assertDispatched('open-modal', name: 'cetak-modal')
            ->assertDispatched('set-editor-content', content: '')
            ->assertSet('isEdit', false)
            ->assertSet('undangan_id', null)
            ->assertSet('nama', '')
            ->assertSet('jenis_id', null)
            ->assertSet('stok', '')
            ->assertSet('harga', '')
            ->assertSet('deskripsi', '');
    }

    public function test_edit_mengisi_property_yang_benar_dan_masuk_mode_edit(): void
    {
        $jenis = $this->makeJenis('Hardcover');
        $produk = $this->makeProduk('Produk Edit', $jenis->id, '<p>Deskripsi edit</p>');

        Livewire::test(CetakDemo::class)
            ->call('edit', $produk->id)
            ->assertDispatched('open-modal', name: 'cetak-modal')
            ->assertDispatched('set-editor-content', content: '<p>Deskripsi edit</p>')
            ->assertSet('isEdit', true)
            ->assertSet('undangan_id', $produk->id)
            ->assertSet('nama', 'Produk Edit')
            ->assertSet('jenis_id', $jenis->id)
            ->assertSet('stok', '100')
            ->assertSet('harga', '1500')
            ->assertSet('deskripsi', '<p>Deskripsi edit</p>');
    }

    public function test_store_sukses_tidak_membuka_modal_ulang(): void
    {
        $jenis = $this->makeJenis('Softcover');

        Livewire::test(CetakDemo::class)
            ->call('openCreateModal')
            ->set('nama', 'Produk Baru')
            ->set('jenis_id', $jenis->id)
            ->set('stok', '10')
            ->set('harga', '5000')
            ->set('deskripsi', '<p>Deskripsi baru</p>')
            ->call('store')
            ->assertDispatched('close-modal', name: 'cetak-modal')
            ->assertNotDispatched('open-modal');

        $this->assertDatabaseHas('undangan_cetaks', [
            'nama' => 'Produk Baru',
            'jenis_id' => $jenis->id,
            'deskripsi' => '<p>Deskripsi baru</p>',
        ]);
    }

    public function test_update_sukses_tidak_membuka_modal_ulang(): void
    {
        $jenis = $this->makeJenis('Softcover');
        $produk = $this->makeProduk('Produk Lama', $jenis->id);

        Livewire::test(CetakDemo::class)
            ->call('edit', $produk->id)
            ->set('nama', 'Produk Diperbarui')
            ->set('deskripsi', '<p>Deskripsi diperbarui</p>')
            ->call('update')
            ->assertDispatched('close-modal', name: 'cetak-modal')
            ->assertNotDispatched('open-modal');

        $this->assertDatabaseHas('undangan_cetaks', [
            'id' => $produk->id,
            'nama' => 'Produk Diperbarui',
            'deskripsi' => '<p>Deskripsi diperbarui</p>',
        ]);
    }

    public function test_property_deskripsi_tersimpan_dengan_benar_saat_store(): void
    {
        $jenis = $this->makeJenis('Softcover');

        Livewire::test(CetakDemo::class)
            ->call('openCreateModal')
            ->set('nama', 'Produk Deskripsi')
            ->set('jenis_id', $jenis->id)
            ->set('stok', '5')
            ->set('harga', '2500')
            ->set('deskripsi', 'Deskripsi polos tanpa HTML')
            ->call('store');

        $this->assertDatabaseHas('undangan_cetaks', [
            'nama' => 'Produk Deskripsi',
            'deskripsi' => 'Deskripsi polos tanpa HTML',
        ]);
    }

    public function test_create_edit_edit_produk_lain_tidak_membawa_state_lama(): void
    {
        $jenis = $this->makeJenis('Softcover');
        $produkA = $this->makeProduk('Produk A', $jenis->id, '<p>Deskripsi A</p>');
        $produkB = $this->makeProduk('Produk B', $jenis->id, '<p>Deskripsi B</p>');

        Livewire::test(CetakDemo::class)
            ->call('openCreateModal')
            ->assertSet('isEdit', false)
            ->assertSet('undangan_id', null)
            ->assertSet('nama', '')
            ->call('edit', $produkA->id)
            ->assertDispatched('open-modal', name: 'cetak-modal')
            ->assertDispatched('set-editor-content', content: '<p>Deskripsi A</p>')
            ->assertSet('isEdit', true)
            ->assertSet('undangan_id', $produkA->id)
            ->assertSet('nama', 'Produk A')
            ->assertSet('deskripsi', '<p>Deskripsi A</p>')
            ->call('edit', $produkB->id)
            ->assertDispatched('set-editor-content', content: '<p>Deskripsi B</p>')
            ->assertSet('undangan_id', $produkB->id)
            ->assertSet('nama', 'Produk B')
            ->assertSet('deskripsi', '<p>Deskripsi B</p>')
            ->assertSet('stok', '100');
    }
}
