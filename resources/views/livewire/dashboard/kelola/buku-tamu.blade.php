<div class="space-y-6">
    <!-- Quick Back Link -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard.undangan.kelola', $invitation->uid) }}" wire:navigate
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Kelola Undangan</span>
        </a>

        <a href="{{ route('dashboard.undangan.tamu', $invitation->uid) }}" wire:navigate
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all shadow-sm">
            <i data-lucide="users" class="w-4 h-4"></i>
            <span>Buka Tamu & RSVP</span>
        </a>
    </div>

    <!-- Hero Card Coming Soon -->
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-950 via-slate-900 to-purple-950 rounded-3xl border border-indigo-500/30 p-8 lg:p-12 shadow-xl">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-2xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/40 text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-ping"></span>
                <span>Fitur Hari-H • Segera Hadir</span>
            </div>

            <h2 class="text-3xl lg:text-4xl font-black text-white tracking-tight">
                Buku Tamu Digital & QR Check-in
            </h2>

            <p class="text-sm lg:text-base text-slate-300 leading-relaxed">
                Revolusi meja penerima tamu di hari-H pernikahan Anda. Tamu cukup menunjukkan QR Code dari undangan digital, penerima tamu melakukan scan instan untuk mencatat kehadiran tanpa antrean buku tamu konvensional.
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-3">
                <a href="{{ route('dashboard.undangan.tamu', ['id' => $invitation->uid, 'tab' => 'rsvp']) }}" wire:navigate
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm shadow-lg shadow-indigo-600/30 transition-all">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Lihat Rekap RSVP Online Tamu</span>
                </a>
                <a href="{{ route('dashboard.undangan.kelola', $invitation->uid) }}" wire:navigate
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-slate-800/80 hover:bg-slate-700 text-slate-300 font-semibold text-sm border border-slate-700 transition-all">
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Feature Preview Grid -->
    <div>
        <h4 class="text-base font-black text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
            Apa saja yang akan hadir di modul Buku Tamu Digital ini?
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Feature 1: QR Scanner -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <i data-lucide="qr-code" class="w-6 h-6"></i>
                </div>
                <h5 class="text-base font-bold text-slate-800 dark:text-white">QR Code Check-in</h5>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Setiap tamu yang diundang memiliki kode QR unik di undangan digitalnya. Petugas meja penerima tamu cukup scan via kamera HP/tablet untuk validasi instan.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-600 dark:text-indigo-400">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        Tahap Pengembangan
                    </span>
                </div>
            </div>

            <!-- Feature 2: Souvenir & Angpao Log -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <i data-lucide="gift" class="w-6 h-6"></i>
                </div>
                <h5 class="text-base font-bold text-slate-800 dark:text-white">Log Souvenir & Kehadiran</h5>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Mencatat jam kedatangan tamu di lokasi secara otomatis, memantau kuota souvenir yang telah diambil, dan mendata tanda terima kado fisik.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        Tahap Pengembangan
                    </span>
                </div>
            </div>

            <!-- Feature 3: Welcome Screen Monitor -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                    <i data-lucide="tv" class="w-6 h-6"></i>
                </div>
                <h5 class="text-base font-bold text-slate-800 dark:text-white">Layar Sambutan (Welcome Screen)</h5>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Tampilan layar monitor interaktif di pintu masuk yang menampilkan sapaan "Selamat Datang, Bapak/Ibu [Nama Tamu]" secara otomatis saat QR discan.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-600 dark:text-purple-400">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        Tahap Pengembangan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Callout Box: RSVP Online Sudah Aktif -->
    <div class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center text-white flex-shrink-0 mt-0.5">
                <i data-lucide="info" class="w-5 h-5"></i>
            </div>
            <div>
                <h5 class="text-sm font-bold text-slate-800 dark:text-white">Ingin memantau RSVP & Ucapan Online yang sudah masuk?</h5>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Konfirmasi kehadiran tamu dan pesan doa restu online kini telah disatukan di halaman <strong>Tamu & RSVP</strong>.
                </p>
            </div>
        </div>
        <a href="{{ route('dashboard.undangan.tamu', $invitation->uid) }}" wire:navigate
            class="px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-800 dark:text-white text-xs font-bold border border-slate-200 dark:border-slate-700 transition-colors flex-shrink-0">
            Buka Tamu & RSVP &rarr;
        </a>
    </div>
</div>
