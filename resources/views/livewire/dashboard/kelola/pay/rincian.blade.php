<div class="space-y-3">
    {{-- Paket --}}
    <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-700">
        <div>
            <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Paket Premium</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">Harga dasar undangan</p>
        </div>
        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Rp {{ number_format($harga, 0, ',', '.') }}</span>
    </div>

    {{-- Promo --}}
    @if ($promo > 0)
    <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-700">
        <div>
            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Kode Promo</p>
            <p class="text-xs text-emerald-500">{{ $code }}</p>
        </div>
        <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">- Rp {{ number_format($promo, 0, ',', '.') }}</span>
    </div>
    @endif

    {{-- Fee --}}
    @if ($fee > 0)
    <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-700">
        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Biaya Layanan</p>
        <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">+ Rp {{ number_format($fee, 0, ',', '.') }}</span>
    </div>
    @endif

    {{-- Total --}}
    <div class="flex justify-between items-center pt-1">
        <span class="text-base font-bold text-slate-800 dark:text-white">Total</span>
        <span class="text-base font-bold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($total == 0 ? $harga : $total, 0, ',', '.') }}</span>
    </div>
</div>
