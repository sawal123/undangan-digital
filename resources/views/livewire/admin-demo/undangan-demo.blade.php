<div>
    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Status & Jadwal Undangan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitoring undangan yang masih berjalan (mendatang / hari ini) dan undangan yang sudah selesai pestanya.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 rounded-2xl border border-emerald-200 dark:border-emerald-800/60 flex items-center gap-3 shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 text-emerald-500"></i>
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Statistic Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: Total Undangan -->
        <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-5 flex items-center gap-4 shadow-sm hover:border-indigo-500/40 transition-all duration-200">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 border border-indigo-500/30 flex-shrink-0 shadow-inner">
                <i data-lucide="mail" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Undangan</p>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-0.5 tracking-tight">{{ number_format($totalCount) }}</h3>
            </div>
        </div>

        <!-- Card 2: Masih Berjalan -->
        <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-5 flex items-center gap-4 shadow-sm cursor-pointer hover:border-emerald-500/60 transition-all duration-200 group" wire:click="$set('statusFilter', 'ongoing')">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 flex-shrink-0 shadow-inner group-hover:scale-105 transition-transform">
                <i data-lucide="calendar-clock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Masih Berjalan</p>
                <h3 class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5 tracking-tight">{{ number_format($ongoingCount) }}</h3>
            </div>
        </div>

        <!-- Card 3: Pesta Selesai -->
        <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-5 flex items-center gap-4 shadow-sm cursor-pointer hover:border-purple-500/60 transition-all duration-200 group" wire:click="$set('statusFilter', 'finished')">
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 dark:bg-purple-500/20 flex items-center justify-center text-purple-600 dark:text-purple-400 border border-purple-500/30 flex-shrink-0 shadow-inner group-hover:scale-105 transition-transform">
                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pesta Selesai</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-purple-300 mt-0.5 tracking-tight">{{ number_format($finishedCount) }}</h3>
            </div>
        </div>

        <!-- Card 4: Aktif (Premium) -->
        <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-5 flex items-center gap-4 shadow-sm cursor-pointer hover:border-amber-500/60 transition-all duration-200 group" wire:click="$set('activeFilter', 'active')">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 border border-amber-500/30 flex-shrink-0 shadow-inner group-hover:scale-105 transition-transform">
                <i data-lucide="sparkles" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Aktif (Premium)</p>
                <h3 class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-0.5 tracking-tight">{{ number_format($activeCount) }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-4 mb-6 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Status Tabs -->
            <div class="flex flex-wrap items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700/80">
                <button type="button"
                    wire:click="$set('statusFilter', 'all')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $statusFilter === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    Semua ({{ $totalCount }})
                </button>
                <button type="button"
                    wire:click="$set('statusFilter', 'ongoing')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $statusFilter === 'ongoing' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="w-2 h-2 rounded-full {{ $statusFilter === 'ongoing' ? 'bg-white' : 'bg-emerald-500' }}"></span>
                    <span>Masih Berjalan ({{ $ongoingCount }})</span>
                </button>
                <button type="button"
                    wire:click="$set('statusFilter', 'finished')"
                    class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 {{ $statusFilter === 'finished' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="w-2 h-2 rounded-full {{ $statusFilter === 'finished' ? 'bg-white' : 'bg-purple-400' }}"></span>
                    <span>Sudah Selesai ({{ $finishedCount }})</span>
                </button>
            </div>

            <!-- Search and Active Filter -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative min-w-[260px]">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari judul, mempelai, tema, user..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-400">
                    @if($search)
                        <button type="button" wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    @endif
                </div>

                <select wire:model.live="activeFilter" class="px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="all">Semua Aktivasi</option>
                    <option value="active">Aktif (Premium)</option>
                    <option value="inactive">Belum Aktif (Draft)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <x-ui.table
        :headers="['No.', 'Undangan & Mempelai', 'Tema & URL', 'Jadwal Pesta', 'Status Pesta', 'Aktivasi', 'Aksi']"
        title="Daftar Undangan"
        :count="$undanganList->total()"
        loadingTarget="search,statusFilter,activeFilter,gotoPage,nextPage,previousPage"
    >
        @forelse($undanganList as $index => $item)
            @php
                $maxDate = $item->acara->max('date');
                $isToday = $maxDate && $maxDate === $today;
                $isFinished = $maxDate && $maxDate < $today;
                $isUpcoming = $maxDate && $maxDate > $today;

                $daysDiff = 0;
                if ($maxDate) {
                    try {
                        $parsedDate = \Carbon\Carbon::parse($maxDate);
                        $todayCarbon = \Carbon\Carbon::parse($today);
                        $daysDiff = (int) $todayCarbon->diffInDays($parsedDate, false);
                    } catch (\Throwable $e) {
                        $daysDiff = 0;
                    }
                }

                $coupleName = '';
                if ($item->pria || $item->wanita) {
                    $coupleName = trim(($item->pria->nama_panggilan ?? '') . ' & ' . ($item->wanita->nama_panggilan ?? ''));
                }
            @endphp
            <tr class="table-row-hover transition-colors">
                <!-- No. -->
                <td class="px-5 py-4 text-xs font-mono font-medium text-slate-400">
                    {{ ($undanganList->currentPage() - 1) * $undanganList->perPage() + $index + 1 }}
                </td>

                <!-- Undangan & Mempelai -->
                <td class="px-5 py-4">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-800 dark:text-white">{{ $item->title }}</span>
                        @if($coupleName)
                            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 mt-0.5">{{ $coupleName }}</span>
                        @endif
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">User: {{ $item->user->name ?? '-' }} ({{ $item->user->email ?? '-' }})</span>
                    </div>
                </td>

                <!-- Tema & URL -->
                <td class="px-5 py-4">
                    <div class="space-y-1.5">
                        @if($item->theme)
                            <div class="flex items-center gap-1.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30">
                                    <i data-lucide="palette" class="w-3 h-3"></i>
                                    {{ $item->theme->nama }}
                                </span>
                                @if($item->theme->demo)
                                    <a href="{{ route('admin.temademo', $item->theme->demo) }}" target="_blank" class="text-[10px] font-semibold text-indigo-500 hover:text-indigo-400 hover:underline flex items-center gap-0.5">
                                        <span>Demo</span>
                                        <i data-lucide="external-link" class="w-2.5 h-2.5"></i>
                                    </a>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-slate-400 italic">Belum pilih tema</span>
                        @endif

                        @if($item->slug)
                            <div>
                                <a href="{{ route('visit', $item->slug) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                                    <i data-lucide="link" class="w-3 h-3"></i>
                                    <span>/u/{{ $item->slug }}</span>
                                    <i data-lucide="external-link" class="w-2.5 h-2.5"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </td>

                <!-- Jadwal Acara -->
                <td class="px-5 py-4">
                    @if($maxDate)
                        <div>
                            <p class="text-xs font-bold text-slate-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($maxDate)->translatedFormat('d M Y') }}
                            </p>
                            @if($item->acara->first()?->vanue)
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate max-w-[160px]" title="{{ $item->acara->first()->vanue }}">
                                    <i data-lucide="map-pin" class="w-3 h-3 inline mr-0.5 text-rose-400"></i>
                                    {{ $item->acara->first()->vanue }}
                                </p>
                            @endif
                            <p class="text-[10px] text-slate-400">Total: {{ $item->acara->count() }} agenda acara</p>
                        </div>
                    @else
                        <span class="text-xs text-slate-400 italic">Belum ada acara</span>
                    @endif
                </td>

                <!-- Status Pesta -->
                <td class="px-5 py-4">
                    @if($isToday)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 animate-pulse">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            Hari Ini!
                        </span>
                    @elseif($isUpcoming)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                            Masih Berjalan (H-{{ $daysDiff }})
                        </span>
                    @elseif($isFinished)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-800 text-slate-400 border border-slate-700">
                            <i data-lucide="check" class="w-3 h-3 text-slate-400"></i>
                            Pesta Selesai ({{ abs($daysDiff) }} hari lalu)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-medium bg-amber-500/10 text-amber-400 border border-amber-500/30">
                            Belum Ada Tanggal
                        </span>
                    @endif
                </td>

                <!-- Status Aktivasi -->
                <td class="px-5 py-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" {{ $item->isActive ? 'checked' : '' }} wire:click="toggleActive({{ $item->id }})">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="ml-2 text-xs font-semibold {{ $item->isActive ? 'text-emerald-500 dark:text-emerald-400' : 'text-slate-400' }}">
                            {{ $item->isActive ? 'Aktif' : 'Draft' }}
                        </span>
                    </label>
                </td>

                <!-- Aksi -->
                <td class="px-5 py-4 text-center">
                    <div class="flex items-center justify-center gap-1.5">
                        <button type="button"
                            wire:click="showDetail({{ $item->id }})"
                            class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 hover:text-indigo-600 dark:hover:text-indigo-400 border border-transparent dark:hover:border-indigo-500/40 transition-colors"
                            title="Detail Undangan">
                            <i data-lucide="info" class="w-4 h-4"></i>
                        </button>
                        @if($item->slug)
                            <a href="{{ route('visit', $item->slug) }}"
                                target="_blank"
                                class="p-2 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500/20 border border-emerald-500/30 transition-colors"
                                title="Buka Undangan">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="py-12 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3">
                        <i data-lucide="calendar-x" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tidak ada data undangan ditemukan</p>
                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan filter status pesta atau kata kunci pencarian Anda.</p>
                </td>
            </tr>
        @endforelse

        <x-slot name="pagination">
            {{ $undanganList->links('components.ui.pagination') }}
        </x-slot>
    </x-ui.table>

    <!-- Detail Modal -->
    <x-ui.modal name="detail-undangan-modal" title="Detail Informasi Undangan" icon="mail" maxWidth="2xl">
        @if($selectedData)
            <div class="space-y-4">
                <!-- Header Info (Gradient Card) -->
                <div class="p-4 rounded-2xl bg-gradient-to-r from-slate-50 via-white to-indigo-50/40 dark:from-slate-900 dark:via-indigo-950/40 dark:to-slate-900 border border-slate-200 dark:border-indigo-500/30 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 dark:bg-indigo-400 animate-ping"></span>
                            <h4 class="text-base font-black text-slate-900 dark:text-white tracking-tight">{{ $selectedData->title }}</h4>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1 text-slate-700 dark:text-slate-300 font-medium">
                                <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-500 dark:text-indigo-400"></i>
                                {{ $selectedData->user->name ?? '-' }}
                            </span>
                            <span class="text-slate-300 dark:text-slate-600">•</span>
                            <span class="inline-flex items-center gap-1 text-slate-500 dark:text-slate-400">
                                <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500"></i>
                                {{ $selectedData->user->email ?? '-' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $selectedData->isActive ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 border border-emerald-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $selectedData->isActive ? 'bg-emerald-500 dark:bg-emerald-400' : 'bg-slate-400 dark:bg-slate-500' }}"></span>
                            {{ $selectedData->isActive ? 'Aktif (Premium)' : 'Draft (Nonaktif)' }}
                        </span>
                    </div>
                </div>

                <!-- Mempelai & Tema (Crisp High-Contrast Modern Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Card Mempelai -->
                    <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700/80 bg-slate-50/80 dark:bg-slate-800/90 shadow-sm space-y-2.5">
                        <div class="flex items-center justify-between pb-2.5 border-b border-slate-200 dark:border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-rose-500/10 dark:bg-rose-500/20 text-rose-500 dark:text-rose-400 flex items-center justify-center">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                </div>
                                <span class="text-xs font-black tracking-wider uppercase text-slate-700 dark:text-slate-200">Data Mempelai</span>
                            </div>
                        </div>

                        <!-- Groom -->
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-700/50">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 flex items-center gap-1">
                                <i data-lucide="user" class="w-3 h-3"></i> Mempelai Pria
                            </span>
                            <p class="text-sm font-bold text-slate-900 dark:text-white mt-0.5">
                                {{ $selectedData->pria->nama_lengkap ?? '-' }}
                                @if(!empty($selectedData->pria?->nama_panggilan))
                                    <span class="text-indigo-600 dark:text-indigo-400 font-semibold">({{ $selectedData->pria->nama_panggilan }})</span>
                                @endif
                            </p>
                        </div>

                        <!-- Bride -->
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-700/50">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-rose-500 dark:text-rose-400 flex items-center gap-1">
                                <i data-lucide="user-check" class="w-3 h-3"></i> Mempelai Wanita
                            </span>
                            <p class="text-sm font-bold text-slate-900 dark:text-white mt-0.5">
                                {{ $selectedData->wanita->nama_lengkap ?? '-' }}
                                @if(!empty($selectedData->wanita?->nama_panggilan))
                                    <span class="text-rose-500 dark:text-rose-400 font-semibold">({{ $selectedData->wanita->nama_panggilan }})</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Card Tema & Tautan -->
                    <div class="p-4 rounded-2xl border border-slate-200 dark:border-slate-700/80 bg-slate-50/80 dark:bg-slate-800/90 shadow-sm space-y-2.5">
                        <div class="flex items-center justify-between pb-2.5 border-b border-slate-200 dark:border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                                    <i data-lucide="palette" class="w-4 h-4"></i>
                                </div>
                                <span class="text-xs font-black tracking-wider uppercase text-slate-700 dark:text-slate-200">Tema & URL Undangan</span>
                            </div>
                        </div>

                        <!-- Selected Theme -->
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-700/50 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tema Terpilih</span>
                                <p class="text-sm font-extrabold text-indigo-600 dark:text-indigo-300 mt-0.5">
                                    {{ $selectedData->theme->nama ?? 'Belum dipilih' }}
                                </p>
                            </div>
                            @if($selectedData->theme?->demo)
                                <a href="{{ route('admin.temademo', $selectedData->theme->demo) }}" target="_blank"
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-bold bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-500/20 dark:hover:bg-indigo-500/30 border border-indigo-500/30 transition-colors">
                                    <span>Demo</span>
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            @endif
                        </div>

                        <!-- Public URL -->
                        <div class="p-3 rounded-xl bg-white dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-700/50 flex items-center justify-between">
                            <div class="min-w-0 pr-2">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                    <i data-lucide="globe" class="w-3 h-3 text-emerald-500 dark:text-emerald-400"></i> Public URL
                                </span>
                                @if($selectedData->slug)
                                    <p class="text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400 mt-0.5 truncate">
                                        /u/{{ $selectedData->slug }}
                                    </p>
                                @else
                                    <p class="text-xs text-slate-400 mt-0.5 italic">Belum ada slug</p>
                                @endif
                            </div>
                            @if($selectedData->slug)
                                <a href="{{ route('visit', $selectedData->slug) }}" target="_blank"
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-bold bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 hover:bg-emerald-500/20 dark:hover:bg-emerald-500/30 border border-emerald-500/30 transition-colors flex-shrink-0">
                                    <span>Buka</span>
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Agenda Acara Cards -->
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-black tracking-wider uppercase text-slate-700 dark:text-slate-200">Jadwal Agenda Acara</span>
                        </div>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                            {{ $selectedData->acara->count() }} Acara
                        </span>
                    </div>

                    @if($selectedData->acara && $selectedData->acara->count() > 0)
                        <div class="space-y-2">
                            @foreach($selectedData->acara as $acara)
                                @php
                                    $acaraDate = $acara->date;
                                    $isAcaraFinished = $acaraDate && $acaraDate < $today;
                                    $isAcaraToday = $acaraDate && $acaraDate === $today;
                                @endphp
                                <div class="p-3.5 rounded-2xl border border-slate-200 dark:border-slate-700/80 bg-white dark:bg-slate-800/90 flex items-start justify-between gap-3 hover:border-indigo-500/50 dark:hover:border-indigo-500/50 transition-colors shadow-sm">
                                    <div class="space-y-1.5 flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h5 class="text-sm font-bold text-slate-900 dark:text-white">{{ $acara->nama_acara }}</h5>
                                            @if($isAcaraToday)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 border border-emerald-500/40">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                                                    Hari Ini!
                                                </span>
                                            @elseif($isAcaraFinished)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                    <i data-lucide="check" class="w-3 h-3"></i>
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/15 text-indigo-600 dark:text-indigo-300 border border-indigo-500/30">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 dark:bg-indigo-400"></span>
                                                    Mendatang
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs font-medium text-slate-600 dark:text-slate-300 flex items-center gap-1.5">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 text-indigo-500 dark:text-indigo-400 flex-shrink-0"></i>
                                            <span>{{ \Carbon\Carbon::parse($acara->date)->translatedFormat('l, d F Y') }}</span>
                                            <span class="text-slate-300 dark:text-slate-600">•</span>
                                            <span>{{ $acara->jam_start }} - {{ $acara->jam_end }} {{ $acara->zona_waktu }}</span>
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5 truncate" title="{{ $acara->vanue }} - {{ $acara->alamat }}">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-500 dark:text-rose-400 flex-shrink-0"></i>
                                            <span class="truncate">{{ $acara->vanue }} &mdash; {{ $acara->alamat }}</span>
                                        </p>
                                    </div>
                                    @if($acara->maps)
                                        <a href="{{ $acara->maps }}" target="_blank" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700/60 hover:bg-indigo-600 hover:text-white text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600/60 transition-all flex items-center gap-1 text-xs flex-shrink-0 shadow-sm" title="Buka Google Maps">
                                            <i data-lucide="map" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center rounded-2xl border border-dashed border-slate-200 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-800/40 text-slate-400 text-xs italic">
                            Belum ada agenda acara yang diisi oleh mempelai.
                        </div>
                    @endif
                </div>

                <!-- Footer Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700/80">
                    <button type="button" x-on:click="$dispatch('close-modal', { name: 'detail-undangan-modal' })" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition-colors">
                        Tutup
                    </button>
                    @if($selectedData->slug)
                        <a href="{{ route('visit', $selectedData->slug) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/30 transition-all">
                            <span>Buka Undangan</span>
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </x-ui.modal>
</div>
