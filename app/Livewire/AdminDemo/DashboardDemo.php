<?php

namespace App\Livewire\AdminDemo;

use App\Models\User;
use App\Models\Data;
use App\Models\Transaction;
use App\Models\Admin\Animation;
use App\Models\Admin\UndanganCetak;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardDemo extends Component
{
    use WithPagination;

    public $search = '';
    
    public function render()
    {
        // Fetch Counts
        $totalUsers = User::count();
        $totalDigital = Data::count();
        $totalFisik = UndanganCetak::count();
        $totalAnimasi = Animation::count();

        // Fetch Sales Data (Last 30 Days)
        $salesData = Transaction::where('payment_status', 'settlement')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(gross_amount) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $salesData->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'))->toArray();
        $chartValues = $salesData->pluck('total_sales')->toArray();

        // Existing User Table Logic (Mocked for now as per previous version, but filtered)
        $allData = [
            ['id' => 1, 'name' => 'Andi Pratama', 'email' => 'andi@example.com', 'role' => 'Admin', 'status' => 'Aktif', 'date' => '2024-01-15'],
            ['id' => 2, 'name' => 'Budi Santoso', 'email' => 'budi@example.com', 'role' => 'Editor', 'status' => 'Aktif', 'date' => '2024-02-20'],
            ['id' => 3, 'name' => 'Cindy Wijaya', 'email' => 'cindy@example.com', 'role' => 'Viewer', 'status' => 'Nonaktif', 'date' => '2024-03-10'],
            ['id' => 4, 'name' => 'Dedi Kurniawan', 'email' => 'dedi@example.com', 'role' => 'Editor', 'status' => 'Aktif', 'date' => '2024-04-05'],
            ['id' => 5, 'name' => 'Eka Putri', 'email' => 'eka@example.com', 'role' => 'Admin', 'status' => 'Pending', 'date' => '2024-05-18'],
            ['id' => 6, 'name' => 'Fajar Gumilang', 'email' => 'fajar@example.com', 'role' => 'Viewer', 'status' => 'Aktif', 'date' => '2024-06-22'],
            ['id' => 7, 'name' => 'Gita Anggraini', 'email' => 'gita@example.com', 'role' => 'Editor', 'status' => 'Nonaktif', 'date' => '2024-07-14'],
        ];

        $filteredData = array_filter($allData, function($item) {
            return empty($this->search) || 
                   str_contains(strtolower($item['name']), strtolower($this->search)) ||
                   str_contains(strtolower($item['email']), strtolower($this->search));
        });

        return view('livewire.admin-demo.dashboard-demo', [
            'users' => array_slice($filteredData, 0, 5),
            'totalCount' => count($filteredData),
            'stats' => [
                'users' => $totalUsers,
                'digital' => $totalDigital,
                'fisik' => $totalFisik,
                'animasi' => $totalAnimasi,
            ],
            'chart' => [
                'labels' => $chartLabels,
                'values' => $chartValues,
            ]
        ])->layout('components.layouts.admin-new');
    }
}
