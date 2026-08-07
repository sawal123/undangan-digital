<div class="flex justify-center py-10 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-8 text-center">
            {{-- Icon Sukses --}}
            <div class="mb-6">
                <div class="w-20 h-20 mx-auto bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-10 h-10 text-emerald-600 dark:text-emerald-400"></i>
                </div>
            </div>

            {{-- Judul --}}
            <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-2">
                Pembayaran Tunai Diterima
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                Tim kami akan segera memverifikasi pembayaran Anda. Status undangan akan aktif dalam waktu 1x24 jam.
            </p>

            {{-- Info Box --}}
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4 mb-6 text-left">
                <div class="flex items-start gap-3">
                    <i data-lucide="clock" class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-amber-800 dark:text-amber-300">Perlu Bantuan?</p>
                        <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">Jika status belum aktif setelah 1x24 jam, segera hubungi admin kami.</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="space-y-3">
                <a href="{{ route('dashboard.index') }}"
                    class="block w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Kembali ke Dashboard
                </a>
                <a href="https://wa.me/6282274677715" target="_blank"
                    class="block w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    Hubungi Admin via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
