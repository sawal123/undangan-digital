<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h3 class="text-xl font-black text-slate-800 dark:text-white">Buku Tamu (Kehadiran)</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Daftar kehadiran dan pesan dari tamu yang hadir.
                </p>
            </div>

            <div class="relative w-full md:w-64">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" wire:model.debounce.500ms="search" placeholder="Cari tamu..."
                    class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>
        </div>
    </div>

    <!-- Attendance Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Hadir</p>
                <p class="text-2xl font-black text-slate-800 dark:text-white">
                    {{ \App\Models\KelolaUndangan\Ucapan::where('data_id', $dataId)->where('status', 'Hadir')->count() }}
                </p>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <i data-lucide="user-minus" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Berhalangan</p>
                <p class="text-2xl font-black text-slate-800 dark:text-white">
                    {{ \App\Models\KelolaUndangan\Ucapan::where('data_id', $dataId)->where('status', 'Tidak Hadir')->count() }}
                </p>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                <i data-lucide="message-square" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pesan</p>
                <p class="text-2xl font-black text-slate-800 dark:text-white">{{ $data->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div
        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden relative">
        <div wire:loading.flex wire:target="search,gotoPage,nextPage,previousPage"
            class="hidden absolute inset-0 z-20 items-center justify-center bg-white/70 dark:bg-slate-900/70 backdrop-blur-[1px] transition-all">
            <div
                class="flex items-center gap-2.5 px-4 py-2.5 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-medium text-sm">
                <x-loading-spinner class="w-5 h-5 text-indigo-600 dark:text-indigo-400" text="Memuat data..." />
            </div>
        </div>

        <div class="overflow-x-auto" wire:loading.class="opacity-50 pointer-events-none"
            wire:target="search,gotoPage,nextPage,previousPage">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tamu</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pesan</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($data as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-950/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-slate-800 dark:text-white">
                                    {{ $item->tamu->nama ?? 'Anonim' }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">ID: #{{ $item->tamu->kode ?? '-' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'Hadir')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        {{ $item->status }}
                                    </span>
                                @elseif($item->status == 'Akan Hadir')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                        {{ $item->status }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-slate-600 dark:text-slate-400 italic line-clamp-2">
                                    "{{ $item->ucapan }}"</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-xs text-slate-500">{{ $item->created_at->diffForHumans() }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="user-x" class="w-8 h-8 text-slate-300 dark:text-slate-700"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada data kehadiran.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($data->hasPages())
            <div class="p-6 border-t border-slate-50 dark:border-slate-800">
                {{ $data->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>
