<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\Animation;
use App\Models\Admin\UndanganCetak;
use App\Models\Data;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardDemo extends Component
{
    public function render()
    {
        $metrics = $this->getDashboardMetrics();

        return view('livewire.admin-demo.dashboard-demo', $metrics)
            ->layout('components.layouts.admin-new');
    }

    private function getDashboardMetrics(): array
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Stats Counts
        $totalUsers = User::count();
        $totalDigital = Data::count();
        $totalFisik = UndanganCetak::count();
        $totalAnimasi = Animation::count();

        // Revenue Metrics (supports SUCCESS & SETTLEMENT)
        $totalRevenue = (int) Transaction::successful()->sum('gross_amount');

        $monthlyRevenue = (int) Transaction::successful()
            ->where('created_at', '>=', $startOfMonth)
            ->sum('gross_amount');

        $lastMonthRevenue = (int) Transaction::successful()
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('gross_amount');

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($monthlyRevenue > 0 ? 100 : 0);

        // New Users
        $newUsersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();

        // Pending Transactions
        $pendingTransactions = Transaction::pendingStatus()->count();

        // Sales Chart Data (Last 30 Days)
        $salesData = Transaction::successful()
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(gross_amount) as total_sales'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $salesData->pluck('date')->map(fn ($date) => date('d M', strtotime($date)))->toArray();
        $chartValues = $salesData->pluck('total_sales')->map(fn ($val) => (int) $val)->toArray();
        $chartOrders = $salesData->pluck('total_orders')->map(fn ($val) => (int) $val)->toArray();

        // Recent Items
        $recentTransactions = Transaction::with(['user', 'data'])
            ->latest('id')
            ->take(5)
            ->get();

        $recentUsers = User::latest('id')->take(5)->get();

        $totalTransactions = Transaction::count();
        $settledTransactions = Transaction::successful()->count();

        return [
            'stats' => [
                'users' => $totalUsers,
                'digital' => $totalDigital,
                'fisik' => $totalFisik,
                'animasi' => $totalAnimasi,
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'monthly' => $monthlyRevenue,
                'growth' => $revenueGrowth,
                'newUsers' => $newUsersThisMonth,
                'pending' => $pendingTransactions,
            ],
            'chart' => [
                'labels' => $chartLabels,
                'values' => $chartValues,
                'orders' => $chartOrders,
            ],
            'recentTransactions' => $recentTransactions,
            'recentUsers' => $recentUsers,
            'transactionStats' => [
                'total' => $totalTransactions,
                'settled' => $settledTransactions,
            ],
        ];
    }
}
