<?php

namespace App\Livewire\AdminDemo;

use App\Models\User;
use App\Models\Data;
use App\Models\Transaction;
use App\Models\Admin\Animation;
use App\Models\Admin\UndanganCetak;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardDemo extends Component
{
    public function render()
    {
        // === Stats ===
        $totalUsers = User::count();
        $totalDigital = Data::count();
        $totalFisik = UndanganCetak::count();
        $totalAnimasi = Animation::count();

        // === Revenue Metrics ===
        $totalRevenue = Transaction::where('payment_status', 'settlement')->sum('gross_amount');
        $monthlyRevenue = Transaction::where('payment_status', 'settlement')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('gross_amount');

        $lastMonthRevenue = Transaction::where('payment_status', 'settlement')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('gross_amount');

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($monthlyRevenue > 0 ? 100 : 0);

        // New users this month
        $newUsersThisMonth = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Pending transactions
        $pendingTransactions = Transaction::where('payment_status', 'pending')->count();

        // === Sales Chart Data (Last 30 Days) ===
        $salesData = Transaction::where('payment_status', 'settlement')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(gross_amount) as total_sales'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $salesData->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'))->toArray();
        $chartValues = $salesData->pluck('total_sales')->toArray();
        $chartOrders = $salesData->pluck('total_orders')->toArray();

        // === Recent Transactions (last 5) ===
        $recentTransactions = Transaction::with(['user', 'data'])
            ->latest()
            ->take(5)
            ->get();

        // === Recent Users (last 5) ===
        $recentUsers = User::latest()->take(5)->get();

        // === Monthly Transactions count ===
        $totalTransactions = Transaction::count();
        $settledTransactions = Transaction::where('payment_status', 'settlement')->count();

        return view('livewire.admin-demo.dashboard-demo', [
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
        ])->layout('components.layouts.admin-new');
    }
}
