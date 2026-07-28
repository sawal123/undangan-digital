<?php

namespace App\Livewire\Page;

use App\Models\Theme;
use Livewire\Component;

class UndanganWeb extends Component
{
    public $search = '';
    public $perPage = 8;
    public $loadAmount = 8;

    public function loadMore()
    {
        $this->perPage += $this->loadAmount;
    }

    public function render()
    {
        $query = Theme::query()
            ->with('category')
            ->when(!empty(trim($this->search)), function ($q) {
                $searchTerm = '%' . trim($this->search) . '%';
                $q->where(function ($sub) use ($searchTerm) {
                    $sub->where('nama', 'like', $searchTerm)
                        ->orWhereHas('category', function ($catQuery) use ($searchTerm) {
                            $catQuery->where('category', 'like', $searchTerm);
                        });
                });
            })
            ->latest('id');

        $totalResults = $query->count();
        $undanganWeb = (clone $query)->limit($this->perPage)->get();
        $hasMore = $totalResults > count($undanganWeb);

        return view('livewire.page.undangan-web', [
            'undanganWeb' => $undanganWeb,
            'totalResults' => $totalResults,
            'hasMore' => $hasMore,
        ])->layout('layouts.landing');
    }
}
