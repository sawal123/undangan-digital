<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h3 class="text-xl font-black text-slate-800 dark:text-white">Doa & Ucapan Tamu</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Kelola pesan manis dan doa restu dari para tamu undangan Anda.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3 pr-4 border-r border-slate-200 dark:border-slate-800">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aktifkan Fitur:</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:click="updateFiturUcapan('{{ $dataId }}', {{ $fitUcapan && $fitUcapan->isActive ? 'false' : 'true' }}, 'isActive')" class="sr-only peer" @checked($fitUcapan && $fitUcapan->isActive)>
                        <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tampilkan di Undangan:</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:click="updateFiturUcapan('{{ $dataId }}', {{ $fitUcapan && $fitUcapan->viewIsActive ? 'false' : 'true' }}, 'viewIsActive')" class="sr-only peer" @checked($fitUcapan && $fitUcapan->viewIsActive)>
                        <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Search Bar -->
    <div class="relative max-w-md">
        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
        <input type="text" wire:model.debounce.500ms="query" placeholder="Cari ucapan atau nama tamu..." 
            class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
    </div>

    <!-- Ucapan List -->
    <div class="grid grid-cols-1 gap-4">
        @forelse($ucapan as $item)
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- User Info -->
                    <div class="flex-shrink-0 flex md:flex-col items-center md:items-start gap-4 md:w-48">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black">
                            {{ substr($item->tamu->nama ?? 'A', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ $item->tamu->nama ?? 'Anonim' }}</h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $item->status }}</p>
                            <p class="text-[10px] text-slate-500 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="flex-1 space-y-4">
                        <div class="relative p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800 italic text-slate-700 dark:text-slate-300 text-sm leading-relaxed">
                            <i data-lucide="quote" class="absolute -top-3 -left-2 w-8 h-8 text-indigo-500/10 rotate-180"></i>
                            "{{ $item->ucapan }}"
                        </div>

                        <!-- Balasan Section -->
                        <div class="space-y-3 pl-4 border-l-2 border-indigo-100 dark:border-indigo-800">
                            @if($item->balas)
                                <div class="bg-indigo-50/50 dark:bg-indigo-900/10 p-3 rounded-xl text-xs text-indigo-700 dark:text-indigo-300">
                                    <span class="font-bold block mb-1">Balasan Anda:</span>
                                    {{ $item->balas }}
                                </div>
                            @endif
                            
                            <div class="flex gap-2">
                                <input type="text" wire:model.defer="balas.{{ $item->id }}" placeholder="Tanggapi ucapan ini..." 
                                    class="flex-1 px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                                <button wire:click="tanggapi({{ $item->id }})" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition-all">
                                    Balas
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Action -->
                    <div class="flex-shrink-0 self-start">
                        <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="message-square-off" class="w-8 h-8 text-slate-300 dark:text-slate-600"></i>
                </div>
                <p class="font-medium text-center px-6">Belum ada ucapan atau doa yang masuk.</p>
            </div>
        @endforelse
    </div>

    @if($ucapan->hasPages())
        <div class="mt-6">
            {{ $ucapan->links('vendor.pagination.tailwind') }}
        </div>
    @endif

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>
