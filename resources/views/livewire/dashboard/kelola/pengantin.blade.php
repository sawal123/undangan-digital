<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                </span>
                <h3 class="text-xl font-black text-slate-800 dark:text-white">Data Pengantin</h3>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Silahkan isi dan perbarui informasi profil mempelai Pria dan Wanita.
            </p>
        </div>

        <!-- Current Order Badge Preview -->
        <div class="px-4 py-2 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs">
            <span class="text-slate-400 font-medium">Format Nama Pasangan:</span>
            <span class="font-extrabold text-indigo-600 dark:text-indigo-400 ml-1">
                {{ $data->couple_name }}
            </span>
        </div>
    </div>

    <!-- Alert Message -->
    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3 shadow-sm" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Urutan Tampilan Mempelai Selector Card -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h4 class="text-sm font-black text-slate-800 dark:text-white flex items-center gap-2">
                    <i data-lucide="arrow-left-right" class="w-4 h-4 text-indigo-500"></i>
                    Urutan Tampilan Mempelai di Undangan
                </h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Pilih siapa yang ingin ditampilkan di posisi pertama pada cover, header, dan profil undangan:
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Pilihan 1: Pria di Depan -->
            <div wire:click="setUrutan('pria_wanita')"
                class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 {{ $urutanMempelai === 'pria_wanita' ? 'border-indigo-600 bg-indigo-50/40 dark:bg-indigo-950/20 shadow-sm' : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-slate-50/50 dark:bg-slate-800/40' }}">
                <div class="w-5 h-5 rounded-full border flex items-center justify-center flex-shrink-0 mt-0.5 {{ $urutanMempelai === 'pria_wanita' ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-slate-300 dark:border-slate-600' }}">
                    @if($urutanMempelai === 'pria_wanita')
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    @endif
                </div>
                <div class="space-y-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black text-slate-800 dark:text-white">Pria di Depan (Standar)</span>
                        @if($urutanMempelai === 'pria_wanita')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-600 text-white">Aktif</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Format: <strong class="text-slate-700 dark:text-slate-200">{{ $data->pria?->nama_panggilan ?: 'Pria' }} & {{ $data->wanita?->nama_panggilan ?: 'Wanita' }}</strong>
                    </p>
                    <p class="text-[11px] text-slate-400">Profil mempelai pria tampil pertama, disusul mempelai wanita.</p>
                </div>
            </div>

            <!-- Pilihan 2: Wanita di Depan -->
            <div wire:click="setUrutan('wanita_pria')"
                class="relative p-4 rounded-2xl border-2 cursor-pointer transition-all flex items-start gap-3.5 {{ $urutanMempelai === 'wanita_pria' ? 'border-rose-500 bg-rose-50/40 dark:bg-rose-950/20 shadow-sm' : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-slate-50/50 dark:bg-slate-800/40' }}">
                <div class="w-5 h-5 rounded-full border flex items-center justify-center flex-shrink-0 mt-0.5 {{ $urutanMempelai === 'wanita_pria' ? 'border-rose-500 bg-rose-500 text-white' : 'border-slate-300 dark:border-slate-600' }}">
                    @if($urutanMempelai === 'wanita_pria')
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    @endif
                </div>
                <div class="space-y-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black text-slate-800 dark:text-white">Wanita di Depan (Lady First)</span>
                        @if($urutanMempelai === 'wanita_pria')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500 text-white">Aktif</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Format: <strong class="text-slate-700 dark:text-slate-200">{{ $data->wanita?->nama_panggilan ?: 'Wanita' }} & {{ $data->pria?->nama_panggilan ?: 'Pria' }}</strong>
                    </p>
                    <p class="text-[11px] text-slate-400">Profil mempelai wanita tampil pertama, disusul mempelai pria.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pria & Wanita Form Components (Reordered visually based on urutanMempelai) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($urutanMempelai === 'wanita_pria')
            <!-- Wanita First -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 relative">
                <div class="mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        Posisi 1 (Tampil Pertama)
                    </span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mempelai Wanita</span>
                </div>
                <livewire:dashboard-demo.kelola.wanita :data-id="$dataId" :key="'wanita-card-'.$dataId" />
            </div>

            <!-- Pria Second -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 relative">
                <div class="mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                        Posisi 2 (Tampil Kedua)
                    </span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mempelai Pria</span>
                </div>
                <livewire:dashboard-demo.kelola.pria :data-id="$dataId" :key="'pria-card-'.$dataId" />
            </div>
        @else
            <!-- Pria First -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 relative">
                <div class="mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        Posisi 1 (Tampil Pertama)
                    </span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mempelai Pria</span>
                </div>
                <livewire:dashboard-demo.kelola.pria :data-id="$dataId" :key="'pria-card-'.$dataId" />
            </div>

            <!-- Wanita Second -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 relative">
                <div class="mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                        Posisi 2 (Tampil Kedua)
                    </span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mempelai Wanita</span>
                </div>
                <livewire:dashboard-demo.kelola.wanita :data-id="$dataId" :key="'wanita-card-'.$dataId" />
            </div>
        @endif
    </div>
</div>
