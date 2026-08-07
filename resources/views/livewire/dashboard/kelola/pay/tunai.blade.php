<div class="flex justify-center py-10">
    <div class="w-full max-w-md">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 p-8 text-center">
            {{-- Ilustrasi --}}
            <div class="mb-6">
                <img src="{{ asset('assets/images/illustrator/finish.svg') }}" alt="Pembayaran Tunai"
                    class="w-40 h-40 mx-auto">
            </div>

            {{-- Judul --}}
            <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-2">
                Harap Tunggu
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                Jika Status Belum Aktif Segera Hubungi Admin
            </p>

            {{-- Tombol Aksi --}}
            <div class="space-y-3">
                <a href="{{ route('dashboard') }}"
                    class="block w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                    Dashboard
                </a>
                <a href="https://wa.me/6282274677715" target="_blank"
                    class="block w-full px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                    Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</div>
