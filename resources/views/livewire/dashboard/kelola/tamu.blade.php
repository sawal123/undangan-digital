<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }"
    @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">

    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </span>
                <h3 class="text-xl font-black text-slate-800 dark:text-white">Tamu & RSVP</h3>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Kelola daftar tamu undangan, pantau konfirmasi kehadiran (RSVP), dan balas pesan doa restu tamu.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="exportCsv" wire:loading.attr="disabled"
                class="inline-flex items-center justify-center px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-semibold rounded-xl transition-all gap-1.5 shadow-sm">
                <i data-lucide="download" class="w-4 h-4 text-slate-500"></i>
                <span wire:loading.remove wire:target="exportCsv">Export CSV</span>
                <span wire:loading wire:target="exportCsv">Mengunduh...</span>
            </button>

            @if($activeTab === 'daftar')
                <button wire:click="openImportModal"
                    class="inline-flex items-center justify-center px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-semibold rounded-xl transition-all gap-1.5 shadow-sm">
                    <i data-lucide="upload" class="w-4 h-4 text-slate-500"></i> Import Tamu
                </button>
                <button x-on:click="$wire.call('resetField'); $dispatch('open-modal', { name: 'tamu-modal' })"
                    class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition-all gap-2 shadow-sm shadow-indigo-200 dark:shadow-none">
                    <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Tamu
                </button>
            @endif
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3 shadow-sm" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 dark:bg-rose-900/30 dark:text-rose-300 border border-rose-200 dark:border-rose-800 flex items-center gap-3 shadow-sm" role="alert">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500 flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @unless ($canShareInvitation)
        <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 text-sm flex items-start gap-3 shadow-sm">
            <i data-lucide="lock" class="w-5 h-5 mt-0.5 flex-shrink-0 text-amber-500"></i>
            <div>
                <p class="font-bold">Link undangan belum bisa dibagikan ke publik.</p>
                <p class="mt-0.5 text-xs text-amber-700 dark:text-amber-400">Aktifkan paket undangan terlebih dahulu untuk membagikan tautan undangan personal melalui WhatsApp atau copy link.</p>
            </div>
        </div>
    @endunless

    <!-- Tab Navigation Bar -->
    <div class="bg-white dark:bg-slate-900 p-2 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex flex-wrap items-center gap-2">
            <!-- Tab 1: Daftar Tamu -->
            <button type="button"
                wire:click="setTab('daftar')"
                class="flex-1 min-w-[160px] py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center justify-center gap-2 {{ $activeTab === 'daftar' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Daftar Tamu</span>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-extrabold {{ $activeTab === 'daftar' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                    {{ $totalTamu }}
                </span>
            </button>

            <!-- Tab 2: Rekap RSVP & Kehadiran -->
            <button type="button"
                wire:click="setTab('rsvp')"
                class="flex-1 min-w-[160px] py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center justify-center gap-2 {{ $activeTab === 'rsvp' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <i data-lucide="calendar-check" class="w-4 h-4"></i>
                <span>Rekap Kehadiran (RSVP)</span>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-extrabold {{ $activeTab === 'rsvp' ? 'bg-white/20 text-white' : 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' }}">
                    {{ $totalHadir }} Hadir
                </span>
            </button>

            <!-- Tab 3: Doa & Ucapan -->
            <button type="button"
                wire:click="setTab('ucapan')"
                class="flex-1 min-w-[160px] py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center justify-center gap-2 {{ $activeTab === 'ucapan' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <i data-lucide="message-square" class="w-4 h-4"></i>
                <span>Doa & Ucapan</span>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-extrabold {{ $activeTab === 'ucapan' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                    {{ $totalRespon }}
                </span>
            </button>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- TAB 1: DAFTAR TAMU & SEBAR UNDANGAN                      -->
    <!-- ======================================================== -->
    @if($activeTab === 'daftar')
        <div class="space-y-4">
            <!-- Search & Quick Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 relative">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" wire:model.live.debounce.300ms="query"
                        placeholder="Cari berdasarkan nama, nomor WhatsApp, atau kode tamu..."
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                </div>
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl px-5 py-3 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Tamu</p>
                            <p class="text-base font-black text-slate-800 dark:text-white">{{ $totalTamu }} Orang</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-wider">Sudah RSVP</p>
                        <p class="text-base font-black text-emerald-600 dark:text-emerald-400">{{ $totalRespon }} Tamu</p>
                    </div>
                </div>
            </div>

            <!-- Table Daftar Tamu -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Tamu</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kontak WhatsApp</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status RSVP</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Aksi & Sebar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($tamu as $item)
                                @php
                                    $rsvpStatus = $item->ucapans?->status;
                                @endphp
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black text-xs flex-shrink-0">
                                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $item->nama }}</p>
                                                <p class="text-[11px] font-mono text-slate-400 mt-0.5">Kode: #{{ $item->kode }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->nomor)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-700 dark:text-slate-300">
                                                <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-500"></i>
                                                {{ $item->nomor }}
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Belum ada nomor</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($rsvpStatus === 'Hadir')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Hadir
                                            </span>
                                        @elseif($rsvpStatus === 'Tidak Hadir')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Berhalangan
                                            </span>
                                        @elseif($rsvpStatus === 'Akan Hadir')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                Akan Hadir
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                Belum Respon
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Share WA -->
                                            <button wire:click="shareWA({{ $item->id }})"
                                                type="button"
                                                class="p-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all shadow-sm"
                                                title="Kirim Undangan via WhatsApp">
                                                <i data-lucide="send" class="w-4 h-4"></i>
                                            </button>

                                            <!-- Share / Copy Link Modal -->
                                            <button wire:click="shareTamu({{ $item->id }})"
                                                type="button"
                                                class="p-2 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm"
                                                title="Salin & Lihat Link Tamu">
                                                <i data-lucide="share-2" class="w-4 h-4"></i>
                                            </button>

                                            <!-- Edit Tamu -->
                                            <button wire:click="EditTamu({{ $item->id }})"
                                                type="button"
                                                class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all shadow-sm"
                                                title="Edit Tamu">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>

                                            <!-- Hapus Tamu -->
                                            <button type="button"
                                                x-on:click="$dispatch('set-delete', { id: '{{ $item->kode }}', method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })"
                                                class="p-2 rounded-xl bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white transition-all shadow-sm"
                                                title="Hapus Tamu">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                                            <i data-lucide="users" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada data tamu</p>
                                        <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Tamu" untuk mulai mendata tamu undangan Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tamu->hasPages())
                    <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                        {{ $tamu->links('components.ui.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- TAB 2: REKAP KEHADIRAN (RSVP)                            -->
    <!-- ======================================================== -->
    @if($activeTab === 'rsvp')
        <div class="space-y-6">
            <!-- 4 Attendance Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Diundang -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Diundang</p>
                        <p class="text-2xl font-black text-slate-800 dark:text-white mt-0.5">{{ $totalTamu }}</p>
                    </div>
                </div>

                <!-- Pasti Hadir -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4 cursor-pointer hover:border-emerald-500/50 transition-all"
                    wire:click="setRsvpFilter('Hadir')">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 flex-shrink-0">
                        <i data-lucide="user-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Konfirmasi Hadir</p>
                        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $totalHadir }}</p>
                    </div>
                </div>

                <!-- Berhalangan -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4 cursor-pointer hover:border-rose-500/50 transition-all"
                    wire:click="setRsvpFilter('Tidak Hadir')">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400 flex-shrink-0">
                        <i data-lucide="user-x" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Berhalangan</p>
                        <p class="text-2xl font-black text-rose-600 dark:text-rose-400 mt-0.5">{{ $totalTidakHadir }}</p>
                    </div>
                </div>

                <!-- Belum Respon -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 flex-shrink-0">
                        <i data-lucide="clock" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Belum Respon</p>
                        <p class="text-2xl font-black text-slate-700 dark:text-slate-300 mt-0.5">{{ $totalBelumRespon }}</p>
                    </div>
                </div>
            </div>

            <!-- Toolbar Filter RSVP -->
            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                <!-- Status Pills -->
                <div class="flex items-center gap-1.5 p-1 bg-slate-100 dark:bg-slate-800/80 rounded-xl">
                    <button type="button" wire:click="setRsvpFilter('all')"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $rsvpFilter === 'all' ? 'bg-white dark:bg-slate-900 text-slate-800 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
                        Semua Status ({{ $totalRespon }})
                    </button>
                    <button type="button" wire:click="setRsvpFilter('Hadir')"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $rsvpFilter === 'Hadir' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $rsvpFilter === 'Hadir' ? 'bg-white' : 'bg-emerald-500' }}"></span>
                        Hadir ({{ $totalHadir }})
                    </button>
                    <button type="button" wire:click="setRsvpFilter('Tidak Hadir')"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 {{ $rsvpFilter === 'Tidak Hadir' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $rsvpFilter === 'Tidak Hadir' ? 'bg-white' : 'bg-rose-500' }}"></span>
                        Berhalangan ({{ $totalTidakHadir }})
                    </button>
                </div>

                <!-- Search RSVP -->
                <div class="relative w-full sm:w-72">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input type="text" wire:model.live.debounce.300ms="rsvpSearch"
                        placeholder="Cari nama atau pesan..."
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>
            </div>

            <!-- RSVP Table -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tamu Undangan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status Kehadiran</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pesan Konfirmasi</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($rsvpList as $item)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $item->tamu->nama ?? 'Tamu Anonim' }}</p>
                                        <p class="text-[11px] font-mono text-slate-400 mt-0.5">ID: #{{ $item->tamu->kode ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($item->status == 'Hadir')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Hadir
                                            </span>
                                        @elseif($item->status == 'Tidak Hadir')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Berhalangan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                {{ $item->status ?? 'Konfirmasi' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-xs text-slate-600 dark:text-slate-300 italic max-w-md truncate" title="{{ $item->ucapan }}">
                                            "{{ $item->ucapan }}"
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-xs text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                                            <i data-lucide="calendar-x" class="w-6 h-6"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada respon RSVP</p>
                                        <p class="text-xs text-slate-400 mt-1">Respon konfirmasi kehadiran dari tamu undangan akan muncul di sini secara otomatis.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($rsvpList->hasPages())
                    <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                        {{ $rsvpList->links('components.ui.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- TAB 3: DOA & UCAPAN                                      -->
    <!-- ======================================================== -->
    @if($activeTab === 'ucapan')
        <div class="space-y-6">
            <!-- Settings Card -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h4 class="text-base font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="sliders" class="w-4 h-4 text-indigo-500"></i>
                        Pengaturan Fitur Ucapan
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Kontrol visibilitas form doa restu dan tampilannya pada halaman web undangan.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-6 bg-slate-50 dark:bg-slate-800/60 p-4 rounded-2xl border border-slate-100 dark:border-slate-700/60">
                    <!-- Toggle Aktifkan Fitur -->
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aktifkan Form:</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                wire:click="updateFiturUcapan({{ $dataId }}, {{ $fitUcapan && $fitUcapan->isActive ? 'false' : 'true' }}, 'isActive')"
                                class="sr-only peer" @checked($fitUcapan && $fitUcapan->isActive)>
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <!-- Toggle Tampilkan di Web -->
                    <div class="flex items-center gap-3 pl-6 border-l border-slate-200 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tampilkan di Web:</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                wire:click="updateFiturUcapan({{ $dataId }}, {{ $fitUcapan && $fitUcapan->viewIsActive ? 'false' : 'true' }}, 'viewIsActive')"
                                class="sr-only peer" @checked($fitUcapan && $fitUcapan->viewIsActive)>
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Search Bar Ucapan -->
            <div class="relative max-w-md">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input type="text" wire:model.live.debounce.300ms="ucapanQuery"
                    placeholder="Cari doa, ucapan, atau nama tamu..."
                    class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
            </div>

            <!-- List of Ucapan Cards -->
            <div class="grid grid-cols-1 gap-4">
                @forelse($ucapanList as $item)
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-indigo-500/30 transition-all">
                        <div class="flex flex-col md:flex-row gap-5">
                            <!-- Guest Info -->
                            <div class="flex-shrink-0 flex md:flex-col items-center md:items-start gap-3 md:w-48">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black text-base">
                                    {{ strtoupper(substr($item->tamu->nama ?? 'A', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <h5 class="text-sm font-bold text-slate-800 dark:text-white truncate">
                                        {{ $item->tamu->nama ?? 'Tamu Anonim' }}
                                    </h5>
                                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $item->status === 'Hadir' ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400' : ($item->status === 'Tidak Hadir' ? 'bg-rose-500/15 text-rose-600 dark:text-rose-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-500') }}">
                                        {{ $item->status ?? 'Ucapan' }}
                                    </span>
                                    <p class="text-[10px] text-slate-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Message & Reply Section -->
                            <div class="flex-1 space-y-3">
                                <!-- Message Box -->
                                <div class="relative p-4 bg-slate-50 dark:bg-slate-850 dark:bg-slate-800/60 rounded-2xl border border-slate-100 dark:border-slate-700/60 text-slate-700 dark:text-slate-300 text-sm leading-relaxed">
                                    <i data-lucide="quote" class="w-5 h-5 text-indigo-400/20 absolute top-3 right-3 pointer-events-none"></i>
                                    "{{ $item->ucapan }}"
                                </div>

                                <!-- Host Existing Reply -->
                                @if ($item->balas)
                                    <div class="p-3.5 bg-indigo-50/60 dark:bg-indigo-950/40 rounded-xl border border-indigo-100 dark:border-indigo-900/60 text-xs text-indigo-900 dark:text-indigo-300 space-y-1">
                                        <span class="font-bold flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400">
                                            <i data-lucide="corner-down-right" class="w-3.5 h-3.5"></i> Balasan Anda:
                                        </span>
                                        <p class="pl-5">{{ $item->balas }}</p>
                                    </div>
                                @endif

                                <!-- Form Reply & Actions -->
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 pt-1">
                                    <input type="text" wire:model.defer="balas.{{ $item->id }}"
                                        placeholder="{{ $item->balas ? 'Perbarui balasan doa restu...' : 'Tanggapi doa restu ini...' }}"
                                        class="flex-1 px-4 py-2 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl text-xs outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-slate-800 dark:text-white">

                                    <button wire:click="tanggapi({{ $item->id }})"
                                        type="button"
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1 shadow-sm">
                                        <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                        <span>{{ $item->balas ? 'Simpan' : 'Balas' }}</span>
                                    </button>

                                    <!-- Delete Wish Button -->
                                    <button type="button"
                                        x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'deleteUcapan' }); $dispatch('open-modal', { name: 'delete-modal' })"
                                        class="px-3 py-2 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1"
                                        title="Hapus Ucapan">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-3">
                            <i data-lucide="message-square-off" class="w-6 h-6"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada doa dan ucapan</p>
                        <p class="text-xs text-slate-400 mt-1">Ucapan dan doa restu dari para tamu undangan akan tampil di sini.</p>
                    </div>
                @endforelse
            </div>

            @if($ucapanList->hasPages())
                <div class="pt-2">
                    {{ $ucapanList->links('components.ui.pagination') }}
                </div>
            @endif
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- MODAL: ADD / EDIT TAMU                                   -->
    <!-- ======================================================== -->
    <x-ui.modal name="tamu-modal" :title="$title" icon="user-plus" maxWidth="md">
        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Nama Tamu <span class="text-rose-500">*</span></label>
                <input type="text" wire:model="nama" placeholder="Contoh: Bpk. Bambang & Keluarga"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                @error('nama') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Nomor WhatsApp (Opsional)</label>
                <input type="text" wire:model="whatsapp" placeholder="Contoh: 081234567890"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <span class="text-[11px] text-slate-400 mt-1 block">Digunakan untuk mengirim undangan langsung ke nomor WhatsApp tamu.</span>
                @error('whatsapp') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" x-on:click="$dispatch('close-modal', { name: 'tamu-modal' })"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/30 transition-all flex items-center gap-2">
                    <span wire:loading.remove wire:target="save">Simpan Tamu</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </x-ui.modal>

    <!-- ======================================================== -->
    <!-- MODAL: SHARE UNDANGAN                                    -->
    <!-- ======================================================== -->
    <x-ui.modal name="share-modal" title="Bagikan Undangan" icon="share-2" maxWidth="md">
        @if($undang)
            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tamu Undangan:</p>
                    <p class="text-base font-black text-slate-900 dark:text-white mt-0.5">{{ $undang->nama }}</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tautan Personal Tamu:</label>
                    <div class="flex items-center gap-2" x-data="{ copied: false }">
                        <input type="text" readonly value="{{ $slug }}" id="guest-url-input"
                            class="flex-1 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-mono text-slate-800 dark:text-slate-200 select-all">
                        <button type="button" @click="navigator.clipboard.writeText('{{ $slug }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="px-3.5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-1 shadow-sm">
                            <i x-show="!copied" data-lucide="copy" class="w-3.5 h-3.5"></i>
                            <i x-show="copied" data-lucide="check" class="w-3.5 h-3.5"></i>
                            <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col gap-2 pt-2">
                    <button wire:click="shareWA({{ $undang->id }})"
                        type="button"
                        class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>Kirim via WhatsApp</span>
                    </button>
                    <a href="{{ $slug }}" target="_blank"
                        class="w-full py-2.5 px-4 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-xl text-xs transition-all text-center flex items-center justify-center gap-1.5">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                        <span>Buka Tampilan Undangan Tamu</span>
                    </a>
                </div>
            </div>
        @endif
    </x-ui.modal>

    <!-- ======================================================== -->
    <!-- MODAL: KONFIRMASI HAPUS                                  -->
    <!-- ======================================================== -->
    <x-ui.modal-delete name="delete-modal" title="Konfirmasi Hapus" message="Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.">
        <button type="button" x-on:click="$wire[deleteMethod](deleteId); show = false"
            class="w-full py-3 px-4 rounded-2xl text-sm font-bold bg-rose-600 hover:bg-rose-700 text-white shadow-lg shadow-rose-600/30 transition-all">
            Ya, Hapus Sekarang
        </button>
    </x-ui.modal-delete>

    <!-- ======================================================== -->
    <!-- MODAL: IMPORT TAMU VIA CSV                               -->
    <!-- ======================================================== -->
    <x-ui.modal name="import-tamu-modal" title="Import Tamu dari CSV" icon="upload" maxWidth="lg">
        <form wire:submit="importCsv" class="space-y-4">
            <div class="p-4 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/40 text-xs text-indigo-900 dark:text-indigo-300 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-bold flex items-center gap-1.5"><i data-lucide="file-spreadsheet" class="w-4 h-4 text-indigo-600"></i> Format File CSV</span>
                    <button type="button" wire:click="downloadTemplateCsv" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline flex items-center gap-1">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i> Unduh Template
                    </button>
                </div>
                <p class="text-slate-600 dark:text-slate-400">File harus berisi kolom: <strong>Nama</strong> (Wajib) dan <strong>WhatsApp</strong> (Opsional). Baris pertama akan dianggap sebagai header jika berisi kata "Nama".</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Pilih File CSV (.csv / .txt) <span class="text-rose-500">*</span></label>
                <input type="file" wire:model="csvFile" accept=".csv,text/csv,text/plain"
                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400">
                <div wire:loading wire:target="csvFile" class="mt-1 text-xs text-indigo-600 dark:text-indigo-400">Mengunggah file...</div>
                @error('csvFile') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" x-on:click="$dispatch('close-modal', { name: 'import-tamu-modal' })"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </button>
                <button type="submit" wire:loading.attr="disabled" wire:target="importCsv"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/30 transition-all flex items-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="importCsv"><i data-lucide="upload-cloud" class="w-4 h-4 inline-block mr-1"></i> Mulai Import</span>
                    <span wire:loading wire:target="importCsv">Memproses...</span>
                </button>
            </div>
        </form>
    </x-ui.modal>
</div>
