<?php

namespace App\Livewire\AdminDemo;

use App\Models\Data;
use Livewire\Component;
use Livewire\WithPagination;

class UndanganDemo extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'all'; // 'all', 'ongoing', 'finished'

    public string $activeFilter = 'all'; // 'all', 'active', 'inactive'

    public ?int $selectedDataId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedActiveFilter(): void
    {
        $this->resetPage();
    }

    public function toggleActive(int $id): void
    {
        $data = Data::findOrFail($id);
        $data->isActive = !$data->isActive;
        $data->save();

        session()->flash('message', 'Status aktivasi undangan "' . $data->title . '" berhasil diperbarui.');
    }

    public function showDetail(int $id): void
    {
        $this->selectedDataId = $id;
        $this->dispatch('open-modal', name: 'detail-undangan-modal');
    }

    public function render()
    {
        $today = now()->format('Y-m-d');

        $query = Data::query()
            ->with(['user', 'theme', 'acara', 'pria', 'wanita']);

        if (!empty(trim($this->search))) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('slug', 'like', $term)
                    ->orWhereHas('user', function ($uq) use ($term) {
                        $uq->where('name', 'like', $term)
                            ->orWhere('email', 'like', $term);
                    })
                    ->orWhereHas('theme', function ($tq) use ($term) {
                        $tq->where('nama', 'like', $term);
                    })
                    ->orWhereHas('pria', function ($pq) use ($term) {
                        $pq->where('nama_lengkap', 'like', $term)
                            ->orWhere('nama_panggilan', 'like', $term);
                    })
                    ->orWhereHas('wanita', function ($wq) use ($term) {
                        $wq->where('nama_lengkap', 'like', $term)
                            ->orWhere('nama_panggilan', 'like', $term);
                    });
            });
        }

        if ($this->activeFilter === 'active') {
            $query->where('isActive', true);
        } elseif ($this->activeFilter === 'inactive') {
            $query->where('isActive', false);
        }

        if ($this->statusFilter === 'ongoing') {
            $query->where(function ($sub) use ($today) {
                $sub->whereHas('acara', function ($aq) use ($today) {
                    $aq->where('date', '>=', $today);
                })->orDoesntHave('acara');
            });
        } elseif ($this->statusFilter === 'finished') {
            $query->whereHas('acara', function ($aq) use ($today) {
                $aq->where('date', '<', $today);
            })->whereDoesntHave('acara', function ($aq) use ($today) {
                $aq->where('date', '>=', $today);
            });
        }

        $undanganList = $query->latest('id')->paginate(10);

        $selectedData = $this->selectedDataId
            ? Data::with(['user', 'theme', 'acara', 'pria', 'wanita'])->find($this->selectedDataId)
            : null;

        $totalCount = Data::count();
        $ongoingCount = Data::where(function ($sub) use ($today) {
            $sub->whereHas('acara', function ($aq) use ($today) {
                $aq->where('date', '>=', $today);
            })->orDoesntHave('acara');
        })->count();
        $finishedCount = Data::whereHas('acara', function ($aq) use ($today) {
            $aq->where('date', '<', $today);
        })->whereDoesntHave('acara', function ($aq) use ($today) {
            $aq->where('date', '>=', $today);
        })->count();
        $activeCount = Data::where('isActive', true)->count();

        return view('livewire.admin-demo.undangan-demo', [
            'undanganList' => $undanganList,
            'selectedData' => $selectedData,
            'today' => $today,
            'totalCount' => $totalCount,
            'ongoingCount' => $ongoingCount,
            'finishedCount' => $finishedCount,
            'activeCount' => $activeCount,
        ])->layout('components.layouts.admin-new');
    }
}
