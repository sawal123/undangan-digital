<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Undangan Saya</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kelola semua undangan digital yang telah Anda buat.</p>
        </div>
        <a href="{{ url('dashboard/setup') }}" wire:navigate class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all gap-2 shadow-sm shadow-indigo-200 dark:shadow-none">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            Buat Undangan Baru
        </a>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Invitations List -->
    <div class="grid grid-cols-1 gap-4">
        @forelse ($dataUndangan as $item)
            @php
                $hasPending = collect($item->transaction)->contains('payment_status', 'PENDING');
                $invitationUid = $item->uid;
            @endphp
            <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all group">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <!-- Title & Info -->
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i data-lucide="mail" class="w-6 h-6 text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-md font-bold text-slate-800 dark:text-white truncate">{{ $item->title }}</h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                @if($item->isActive)
                                    <span class="px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                        <i data-lucide="crown" class="w-3 h-3"></i> Premium
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider">Free</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap items-center gap-2">
                        @if ($hasPending)
                            <a href="{{ $invitationUid ? url('/dashboard/finishtunai/' . $invitationUid) : '#' }}"
                                class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-sm font-medium rounded-xl border border-slate-200 dark:border-slate-800 cursor-not-allowed">
                                <i data-lucide="clock" class="w-4 h-4 mr-2"></i> Sedang Diproses
                            </a>
                        @else
                            @if (!$item->isActive && $invitationUid)
                                <a href="{{ route('dashboard.pay', $invitationUid) }}" wire:navigate
                                    class="inline-flex items-center px-4 py-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold rounded-xl border border-emerald-100 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors">
                                    <i data-lucide="zap" class="w-4 h-4 mr-2 text-emerald-500"></i> Aktifkan Premium
                                </a>
                            @endif
                        @endif

                        <a href="{{ url('/u/' . $item->slug) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-slate-50 dark:bg-slate-950 text-slate-600 dark:text-slate-300 text-sm font-medium rounded-xl hover:bg-slate-100 dark:hover:bg-slate-600 transition-colors">
                            <i data-lucide="external-link" class="w-4 h-4 mr-2"></i> Lihat
                        </a>
                        
                        @if ($invitationUid)
                            <a href="{{ route('dashboard.undangan.kelola', $invitationUid) }}" wire:navigate
                                class="inline-flex items-center px-4 py-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-semibold rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors">
                                <i data-lucide="settings-2" class="w-4 h-4 mr-2"></i> Kelola
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-950/50 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="mail-warning" class="w-10 h-10 text-slate-300 dark:text-slate-600"></i>
                </div>
                <h5 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Belum ada undangan</h5>
                <p class="text-sm mb-6">Mulai buat undangan digital pertama Anda sekarang!</p>
                <a href="{{ url('dashboard/setup') }}" wire:navigate class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-2xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                    Buat Undangan Sekarang
                </a>
            </div>
        @endforelse
    </div>
</div>
