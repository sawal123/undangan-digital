<?php

namespace App\Livewire\Page;

use App\Models\Admin\UndanganCetak;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class Cetak extends Component
{
    public $isOpenModal = false;

    public $mainImage;

    public $gambar = [];

    public $undang;

    public $isExpanded = false; // Properti untuk mengontrol tampilan teks

    public $deskripsi;

    public $yes = [];

    // public $undangan = [];
    public $perPage = 8; // Jumlah awal data

    public $loadAmount = 8; // Jumlah data yang ditambahkan setiap kali tombol "Load More" diklik

    public $search = ''; // Menyimpan nilai pencarian

    public $productToken;

    public function toggleDescription($id)
    {
        $s = UndanganCetak::find($id);
        $this->deskripsi = $s->deskripsi;
        $this->isExpanded = true;
    }

    public function toggleDownDescription($id)
    {
        $s = UndanganCetak::find($id);
        $this->deskripsi = $s->deskripsi;
        $this->isExpanded = false;
    }

    public function closeModal()
    {
        $this->isOpenModal = false;
        $this->isExpanded = false;
        $this->productToken = null;
        $this->dispatch('cetak-modal-closed');
    }

    public function openModal($id)
    {
        $this->showModalForProduct($id);
        $this->productToken = $this->makeProductToken($this->undang->id);
        $this->dispatch('cetak-modal-opened', token: $this->productToken);
    }

    protected function showModalForProduct($id)
    {
        $this->undang = UndanganCetak::findOrFail($id);
        $this->yes = json_decode($this->undang->gambar) ?: [];
        $this->deskripsi = $this->undang->deskripsi;
        $this->mainImage = $this->yes[0] ?? 'default-thumbnail.jpg';
        $this->isExpanded = false;
        $this->isOpenModal = true;
    }

    public function updateMainImage($image)
    {
        $this->mainImage = $image;
    }

    public $undangan;

    public function updateData()
    {
        $this->undangan = UndanganCetak::where('nama', 'like', '%'.$this->search.'%')
            ->orWhere('jenis', 'like', '%'.$this->search.'%')
            ->orWhere('harga', 'like', '%'.$this->search.'%')
            ->limit($this->perPage)
            ->get();
        if ($this->search != '') {
            // dd($this->undangan);
        }
    }

    public function loadMore()
    {
        $this->perPage += $this->loadAmount;
        $this->updateData();
    }

    public function mount()
    {
        $this->updateData();
        $token = request()->query('produk');

        if ($token) {
            try {
                $id = $this->readProductToken($token);
                $this->productToken = $token;
                $this->showModalForProduct($id);
            } catch (DecryptException|ModelNotFoundException $exception) {
                $this->productToken = null;
            }
        }
    }

    public function render()
    {
        $this->undangan = UndanganCetak::where('nama', 'like', '%'.$this->search.'%')
            ->orWhere('jenis', 'like', '%'.$this->search.'%')
            ->orWhere('harga', 'like', '%'.$this->search.'%')
            ->limit($this->perPage)
            ->get();
        $this->dispatch('slider');

        return view('landingpage.cetak')->layout('layouts.landing');
    }

    protected function makeProductToken($id): string
    {
        $max = 36 ** 6;
        $tokenNumber = (((int) $id * 92821) + 177013) % $max;

        return strtolower(base_convert((string) $tokenNumber, 10, 36));
    }

    protected function readProductToken($token): int
    {
        $token = strtolower((string) $token);

        if (preg_match('/^[a-z0-9]{1,6}$/', $token)) {
            $max = 36 ** 6;
            $tokenNumber = (int) base_convert($token, 36, 10);
            $number = ($tokenNumber - 177013) % $max;
            $number = $number < 0 ? $number + $max : $number;

            return ($number * $this->modInverse(92821, $max)) % $max;
        }

        return (int) Crypt::decryptString($token);
    }

    protected function modInverse($number, $modulo): int
    {
        $a = $number;
        $m = $modulo;
        $x = 1;
        $y = 0;

        while ($m) {
            $quotient = intdiv($a, $m);
            [$a, $m] = [$m, $a % $m];
            [$x, $y] = [$y, $x - ($quotient * $y)];
        }

        return ($x % $modulo + $modulo) % $modulo;
    }
}
