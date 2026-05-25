<div>
    <!-- Page Title -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Dashboard</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Selamat datang kembali! Berikut ringkasan aktivitas terbaru.</p>
    </div>

    <!-- Revenue Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <!-- Total Revenue -->
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-500 via-indigo-600 to-purple-700 rounded-2xl p-5 text-white shadow-lg shadow-indigo-500/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-6 -translate-x-6"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i data-lucide="wallet" class="w-4.5 h-4.5"></i>
                    </div>
                    <span class="text-white/80 text-xs font-medium uppercase tracking-wider">Total Pendapatan</span>
                </div>
                <p class="text-2xl font-bold tracking-tight">Rp {{ number_format($revenue['total'], 0, ',', '.') }}</p>
                <div class="flex items-center gap-1.5 mt-2">
                    @if($revenue['growth'] >= 0)
                        <span class="inline-flex items-center gap-1 text-emerald-200 text-xs font-medium bg-emerald-400/20 px-2 py-0.5 rounded-full">
                            <i data-lucide="trending-up" class="w-3 h-3"></i>
                            +{{ $revenue['growth'] }}%
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-rose-200 text-xs font-medium bg-rose-400/20 px-2 py-0.5 rounded-full">
                            <i data-lucide="trending-down" class="w-3 h-3"></i>
                            {{ $revenue['growth'] }}%
                        </span>
                    @endif
                    <span class="text-white/60 text-xs">vs bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-700 rounded-2xl p-5 text-white shadow-lg shadow-emerald-500/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-6 -translate-x-6"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i data-lucide="calendar" class="w-4.5 h-4.5"></i>
                    </div>
                    <span class="text-white/80 text-xs font-medium uppercase tracking-wider">Bulan Ini</span>
                </div>
                <p class="text-2xl font-bold tracking-tight">Rp {{ number_format($revenue['monthly'], 0, ',', '.') }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-white/60 text-xs">{{ $revenue['pending'] }} transaksi pending</span>
                </div>
            </div>
        </div>

        <!-- New Users This Month -->
        <div class="relative overflow-hidden bg-gradient-to-br from-amber-500 via-orange-500 to-rose-600 rounded-2xl p-5 text-white shadow-lg shadow-amber-500/20">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-6 -translate-x-6"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i data-lucide="user-plus" class="w-4.5 h-4.5"></i>
                    </div>
                    <span class="text-white/80 text-xs font-medium uppercase tracking-wider">User Baru</span>
                </div>
                <p class="text-2xl font-bold tracking-tight">{{ number_format($revenue['newUsers']) }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-white/60 text-xs">Bergabung bulan ini</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <x-ui.card icon="users" title="{{ number_format($stats['users']) }}" iconColor="indigo">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Pengguna</p>
            </div>
        </x-ui.card>

        <x-ui.card icon="package" title="{{ number_format($stats['fisik']) }}" iconColor="emerald">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Undangan Fisik</p>
            </div>
        </x-ui.card>

        <x-ui.card icon="globe" title="{{ number_format($stats['digital']) }}" iconColor="amber">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Undangan Digital</p>
            </div>
        </x-ui.card>

        <x-ui.card icon="video" title="{{ number_format($stats['animasi']) }}" iconColor="rose">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Undangan Animasi</p>
            </div>
        </x-ui.card>
    </div>

    <!-- Sales Graph -->
    <div class="grid grid-cols-1 gap-6 mb-6">
        <x-ui.card padding="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Grafik Penjualan</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Trend pendapatan 30 hari terakhir</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1.5 text-xs font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 px-2.5 py-1 rounded-lg">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Real-time
                    </span>
                </div>
            </div>
            @if(count($chart['values']) > 0)
                <div id="salesChart" class="w-full h-80"></div>
            @else
                <div class="w-full h-80 flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-4">
                        <i data-lucide="bar-chart-3" class="w-7 h-7 text-slate-400"></i>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada data penjualan</p>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Data akan muncul saat transaksi pertama selesai</p>
                </div>
            @endif
        </x-ui.card>
    </div>

    <!-- Bottom Grid: Recent Transactions + Recent Users -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <x-ui.card padding="p-0">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 dark:border-slate-700">
                <div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-white">Transaksi Terbaru</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $transactionStats['settled'] }} dari {{ $transactionStats['total'] }} selesai</p>
                </div>
                <a href="{{ route('admin.transaksi') }}" wire:navigate
                   class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors flex items-center gap-1">
                    Lihat Semua
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($recentTransactions as $trx)
                    <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                            @if($trx->payment_status === 'settlement')
                                bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400
                            @elseif($trx->payment_status === 'pending')
                                bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400
                            @else
                                bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400
                            @endif
                        ">
                            @if($trx->payment_status === 'settlement')
                                <i data-lucide="check-circle" class="w-4.5 h-4.5"></i>
                            @elseif($trx->payment_status === 'pending')
                                <i data-lucide="clock" class="w-4.5 h-4.5"></i>
                            @else
                                <i data-lucide="x-circle" class="w-4.5 h-4.5"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">
                                {{ $trx->user->name ?? 'Unknown' }}
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $trx->invoice ?? 'INV-' . $trx->id }} · {{ $trx->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                Rp {{ number_format($trx->gross_amount, 0, ',', '.') }}
                            </p>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium
                                @if($trx->payment_status === 'settlement')
                                    bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400
                                @elseif($trx->payment_status === 'pending')
                                    bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400
                                @else
                                    bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400
                                @endif
                            ">
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if($trx->payment_status === 'settlement') bg-emerald-500
                                    @elseif($trx->payment_status === 'pending') bg-amber-500
                                    @else bg-rose-500
                                    @endif
                                "></span>
                                {{ ucfirst($trx->payment_status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-3">
                            <i data-lucide="receipt" class="w-6 h-6 text-slate-400"></i>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Belum ada transaksi</p>
                    </div>
                @endforelse
            </div>
        </x-ui.card>

        <!-- Recent Users -->
        <x-ui.card padding="p-0">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 dark:border-slate-700">
                <div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-white">Pengguna Terbaru</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $stats['users'] }} pengguna terdaftar</p>
                </div>
                <a href="{{ route('admin.user') }}" wire:navigate
                   class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors flex items-center gap-1">
                    Lihat Semua
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($recentUsers as $user)
                    <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 ring-2 ring-indigo-200 dark:ring-indigo-800/50">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->created_at->diffForHumans() }}</p>
                            @php
                                $roles = $user->getRoleNames();
                                $role = $roles->first() ?? 'User';
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-medium mt-0.5
                                @if(strtolower($role) === 'owner' || strtolower($role) === 'admin' || strtolower($role) === 'superadmin')
                                    bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400
                                @else
                                    bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400
                                @endif
                            ">
                                {{ ucfirst($role) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-3">
                            <i data-lucide="users" class="w-6 h-6 text-slate-400"></i>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Belum ada pengguna</p>
                    </div>
                @endforelse
            </div>
        </x-ui.card>
    </div>

    <!-- ApexCharts Script -->
    @if(count($chart['values']) > 0)
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function initSalesChart() {
            const chartEl = document.querySelector("#salesChart");
            if (!chartEl || chartEl.dataset.rendered === 'true') return;
            chartEl.dataset.rendered = 'true';

            // Detect dark mode
            const isDark = document.documentElement.classList.contains('dark');

            const options = {
                series: [{
                    name: 'Penjualan',
                    data: @json($chart['values'])
                }],
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    fontFamily: 'Inter, sans-serif',
                    background: 'transparent',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#6366f1']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [20, 100, 100, 100],
                        colorStops: [{
                            offset: 0,
                            color: '#6366f1',
                            opacity: 0.4
                        }, {
                            offset: 100,
                            color: '#6366f1',
                            opacity: 0.05
                        }]
                    }
                },
                xaxis: {
                    categories: @json($chart['labels']),
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            colors: isDark ? '#64748b' : '#94a3b8',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            if (val >= 1000000) return "Rp " + (val / 1000000).toFixed(1) + "jt";
                            if (val >= 1000) return "Rp " + (val / 1000).toFixed(0) + "rb";
                            return "Rp " + val.toLocaleString('id-ID');
                        },
                        style: {
                            colors: isDark ? '#64748b' : '#94a3b8',
                            fontSize: '12px'
                        }
                    }
                },
                grid: {
                    borderColor: isDark ? '#1e293b' : '#f1f5f9',
                    strokeDashArray: 4,
                    padding: { left: 10, right: 10, top: 0, bottom: 0 }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    x: { show: true },
                    y: {
                        formatter: function (val) {
                            return "Rp " + val.toLocaleString('id-ID');
                        }
                    },
                    marker: { show: true }
                },
                markers: {
                    size: 0,
                    hover: { size: 6 },
                    colors: ['#6366f1'],
                    strokeColors: isDark ? '#1e293b' : '#fff',
                    strokeWidth: 3
                },
                colors: ['#6366f1']
            };

            const chart = new ApexCharts(chartEl, options);
            chart.render();
        }

        document.addEventListener('livewire:navigated', () => {
            // Reset rendered state on navigation
            const el = document.querySelector("#salesChart");
            if (el) el.dataset.rendered = 'false';
            setTimeout(initSalesChart, 100);
        });
        document.addEventListener('DOMContentLoaded', () => setTimeout(initSalesChart, 100));
    </script>
    @endif
</div>
