<div class="space-y-6">
    <!-- Header Section -->
    <div
        class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h3 class="text-xl font-black text-slate-800 dark:text-white">Riwayat Transaksi</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Pantau semua status pembayaran dan riwayat aktivasi
                undangan Anda.</p>
        </div>

        <div
            class="flex items-center gap-3 bg-indigo-50 dark:bg-indigo-900/20 px-4 py-2 rounded-2xl border border-indigo-100 dark:border-indigo-800">
            <i data-lucide="info" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
            <span class="text-xs font-bold text-indigo-700 dark:text-indigo-300">Total: {{ $transactions->total() }}
                Transaksi</span>
        </div>
    </div>

    <!-- Transaction List -->
    <div
        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Invoice /
                            Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Undangan
                        </th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Bayar
                        </th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse($transactions as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-950/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-slate-800 dark:text-white">#{{ $item->invoice }}</p>
                                <p class="text-[10px] text-slate-500">{{ $item->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ $item->data->title ?? 'Undangan Terhapus' }}</p>
                                <p class="text-[10px] text-slate-400 font-mono">{{ $item->payment_type }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-black text-indigo-600 dark:text-indigo-400">Rp
                                    {{ number_format($item->gross_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @if ($item->payment_status == 'SETTLEMENT' || $item->payment_status == 'SUCCESS')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            Berhasil
                                        </span>
                                    @elseif($item->payment_status == 'PENDING')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                            Menunggu
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400">
                                            {{ $item->payment_status }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if ($item->payment_status == 'PENDING' && $item->link_snap)
                                    <a href="{{ $item->link_snap }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-indigo-600 text-white text-[10px] font-bold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                        Bayar Sekarang
                                    </a>
                                @else
                                    <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors"
                                        title="Detail Transaksi">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="shopping-bag"
                                        class="w-8 h-8 text-slate-300 dark:text-slate-700"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada riwayat transaksi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($transactions->hasPages())
            <div class="p-6 border-t border-slate-50 dark:border-slate-800">
                {{ $transactions->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>
