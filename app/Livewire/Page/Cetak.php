<?php

namespace App\Livewire\Page;

use App\Models\Admin\UndanganCetak;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Livewire\Component;

class Cetak extends Component
{
    public bool $isOpenModal = false;

    public bool $isExpanded = false;

    public int $perPage = 8;

    public int $loadAmount = 8;

    public string $search = '';

    public ?string $productToken = null;

    public ?string $mainImage = null;

    public ?string $deskripsi = null;

    public array $yes = [];

    public ?UndanganCetak $undang = null;

    public function updatedSearch(): void
    {
        $this->perPage = 8;
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->perPage = 8;
    }

    public function expandDescription(): void
    {
        $this->isExpanded = true;
    }

    public function collapseDescription(): void
    {
        $this->isExpanded = false;
    }

    public function closeModal(): void
    {
        $this->isOpenModal = false;
        $this->isExpanded = false;
        $this->productToken = null;
        $this->undang = null;
        $this->mainImage = null;
        $this->yes = [];
        $this->deskripsi = null;
        $this->dispatch('cetak-modal-closed');
    }

    public function openModal(int $id): void
    {
        $this->isExpanded = false;
        $this->showModalForProduct($id);
        $this->productToken = $this->makeProductToken($this->undang->id);
        $this->dispatch('cetak-modal-opened', token: $this->productToken);
    }

    protected function showModalForProduct(int $id): void
    {
        $this->undang = UndanganCetak::findOrFail($id);
        $this->yes = $this->undang->image_urls;
        $this->deskripsi = $this->undang->deskripsi;
        $this->mainImage = $this->yes[0] ?? asset('images/default-invitation.png');
        $this->isExpanded = false;
        $this->isOpenModal = true;
    }

    public function updateMainImage(string $image): void
    {
        $this->mainImage = $image;
    }

    public function loadMore(): void
    {
        $this->perPage += $this->loadAmount;
    }

    public function mount(): void
    {
        $token = request()->query('produk');

        if ($token) {
            try {
                $id = $this->readProductToken((string) $token);
                if ($id > 0) {
                    $this->productToken = (string) $token;
                    $this->showModalForProduct($id);
                }
            } catch (DecryptException|ModelNotFoundException $exception) {
                $this->productToken = null;
            }
        }
    }

    private function productsQuery(): Builder
    {
        return UndanganCetak::query()
            ->when(!empty(trim($this->search)), function (Builder $query): void {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function (Builder $sub) use ($searchTerm): void {
                    $sub->where('nama', 'like', $searchTerm)
                        ->orWhere('jenis', 'like', $searchTerm)
                        ->orWhere('harga', 'like', $searchTerm);
                });
            })
            ->latest('id');
    }

    public function render(): View
    {
        $query = $this->productsQuery();
        $totalResults = (clone $query)->count();
        $undangan = (clone $query)->limit($this->perPage)->get();
        $hasMore = $this->perPage < $totalResults;

        $this->dispatch('slider');

        return view('landingpage.cetak', [
            'undangan' => $undangan,
            'totalResults' => $totalResults,
            'hasMore' => $hasMore,
        ])->layout('layouts.landing');
    }

    protected function makeProductToken(int $id): string
    {
        $max = 36 ** 6;
        $tokenNumber = (((int) $id * 92821) + 177013) % $max;

        return strtolower(base_convert((string) $tokenNumber, 10, 36));
    }

    protected function readProductToken(string $token): int
    {
        $token = strtolower(trim($token));

        if (preg_match('/^[a-z0-9]{1,6}$/', $token)) {
            $max = 36 ** 6;
            $tokenNumber = (int) base_convert($token, 36, 10);
            $number = ($tokenNumber - 177013) % $max;
            $number = $number < 0 ? $number + $max : $number;

            return ($number * $this->modInverse(92821, $max)) % $max;
        }

        return (int) Crypt::decryptString($token);
    }

    protected function modInverse(int $number, int $modulo): int
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
