<div class="space-y-6">
    @php
        $canShareInvitation = $data->canBeShared();
    @endphp

    <!-- Back & Quick Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <a href="{{ route('dashboard.index') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar
        </a>
        
        <div class="flex items-center gap-3">
            @if ($canShareInvitation)
                <a href="{{ url('/u/' . $data->slug) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all gap-2 shadow-sm">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                    Lihat Undangan
                </a>
                <button onclick="copyLink('{{ url('/u/' . $data->slug) }}')" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition-all gap-2 shadow-md shadow-indigo-200 dark:shadow-none">
                    <i data-lucide="copy" class="w-4 h-4"></i>
                    Salin Link
                </button>
            @else
                <span class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-400 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 cursor-not-allowed gap-2">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                    Link Belum Aktif
                </span>
            @endif
        </div>
    </div>

    @unless ($canShareInvitation)
        <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 text-sm flex items-start gap-3">
            <i data-lucide="lock" class="w-5 h-5 mt-0.5"></i>
            <div>
                <p class="font-bold">Undangan belum bisa dibagikan.</p>
                <p class="mt-1 text-amber-700 dark:text-amber-400">Aktifkan undangan terlebih dahulu sebelum menyalin link atau mengirim ke tamu.</p>
            </div>
        </div>
    @endunless

    <!-- Invitation Info Card -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 lg:p-8">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-rose-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200 dark:shadow-none flex-shrink-0">
                    <i data-lucide="mail" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white">{{ $data->title }}</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                        <i data-lucide="link" class="w-4 h-4"></i>
                        {{ url('/u/' . $data->slug) }}
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                <div class="text-center px-4 border-r border-slate-200 dark:border-slate-800">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tamu</p>
                    <p class="text-xl font-black text-slate-800 dark:text-white">{{ $data->tamu_count ?? 0 }}</p>
                </div>
                <div class="text-center px-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status</p>
                    <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded-full {{ $data->isActive ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }} text-[10px] font-black uppercase">
                        {{ $data->isActive ? 'Premium' : 'Free' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modules Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 lg:gap-6">
        @foreach ($modules as $module)
            <a href="{{ url('/dashboard/kelola/' . $data->uid . '/' . $module['url']) }}" wire:navigate
                class="group bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 dark:bg-slate-900 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 flex items-center justify-center text-slate-600 dark:text-slate-400">
                    <i data-lucide="{{ $module['icon'] }}" class="w-7 h-7"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $module['nama'] }}</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 line-clamp-1">{{ $module['desc'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>

<script>
    function copyLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin!');
        });
    }
</script>
