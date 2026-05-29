<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Tamu Undangan</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kelola dan kirimkan undangan kepada tamu spesial Anda.</p>
        </div>
        <button x-on:click="$wire.call('resetField'); $dispatch('open-modal', { name: 'tamu-modal' })" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all gap-2 shadow-sm shadow-indigo-200 dark:shadow-none">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah Tamu
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 dark:bg-rose-900/30 dark:text-rose-400 border border-rose-200 dark:border-rose-800 flex items-center gap-3" role="alert">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
            {{ session('error') }}
        </div>
    @endif

    @unless ($canShareInvitation)
        <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 text-sm flex items-start gap-3">
            <i data-lucide="lock" class="w-5 h-5 mt-0.5"></i>
            <div>
                <p class="font-bold">Link undangan belum bisa dibagikan.</p>
                <p class="mt-1 text-amber-700 dark:text-amber-400">Aktifkan undangan terlebih dahulu sebelum mengirim WhatsApp atau menyalin link tamu.</p>
            </div>
        </div>
    @endunless

    <!-- Search & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 relative" wire:ignore.self>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" wire:model.live.debounce.500ms="query" placeholder="Cari berdasarkan nama, kode, atau nomor WhatsApp..." 
                class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
        </div>
        <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-2xl p-3 flex items-center justify-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Total Tamu</p>
                <p class="text-xl font-black text-slate-800 dark:text-white">{{ $tamu->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Tamu List (Table/Cards) -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Tamu</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($tamu as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold text-xs">
                                        {{ substr($item->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $item->nama }}</p>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-bold tracking-tighter">Kode: {{ $item->kode }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded-md">
                                    <i data-lucide="phone" class="w-3 h-3 text-emerald-500"></i>
                                    {{ $item->nomor ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="shareWA({{ $item->id }})" @disabled(!$canShareInvitation) class="p-2 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors disabled:text-slate-300 disabled:cursor-not-allowed disabled:hover:bg-transparent" title="{{ $canShareInvitation ? 'Kirim via WhatsApp' : 'Undangan belum aktif' }}">
                                        <i data-lucide="send" class="w-5 h-5"></i>
                                    </button>
                                    <button wire:click="shareTamu({{ $item->id }})" @disabled(!$canShareInvitation) class="p-2 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors disabled:text-slate-300 disabled:cursor-not-allowed disabled:hover:bg-transparent" title="{{ $canShareInvitation ? 'Salin Link' : 'Undangan belum aktif' }}">
                                        <i data-lucide="copy" class="w-5 h-5"></i>
                                    </button>
                                    <button wire:click="EditTamu({{ $item->id }})" wire:loading.attr="disabled" wire:target="EditTamu({{ $item->id }})" class="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors disabled:opacity-60 disabled:cursor-not-allowed" title="Edit">
                                        <i wire:loading.remove wire:target="EditTamu({{ $item->id }})" data-lucide="edit-3" class="w-5 h-5"></i>
                                        <i wire:loading wire:target="EditTamu({{ $item->id }})" data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
                                    </button>
                                    <button x-on:click="$dispatch('set-delete', { id: '{{ $item->kode }}', method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-lg transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-20 text-center text-slate-500">
                                <i data-lucide="user-x" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
                                <p class="font-medium">Belum ada tamu undangan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tamu->hasPages())
            <div class="p-4 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800">
                {{ $tamu->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Add/Edit Tamu -->
    <x-ui.modal name="tamu-modal" :title="$idTamu ? 'Edit Tamu' : 'Tambah Tamu'" icon="user">
        <form wire:submit="save" class="space-y-4">
            <x-ui.input label="Nama Tamu" wire:model="nama" placeholder="Contoh: Calvin dan Partner" required />
            <x-ui.input label="WhatsApp (Opsional)" type="number" wire:model="whatsapp" placeholder="Contoh: 08123456789" />

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'tamu-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" loading-target="save" loading-text="Menyimpan...">Simpan</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Share Link Modal -->
    <x-ui.modal name="share-modal" title="Bagikan Link Undangan" icon="share-2">
        <div class="space-y-4">
            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800/50">
                <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-1">Kepada:</p>
                <p class="text-lg font-black text-slate-800 dark:text-white">{{ $invite[0] ?? '-' }}</p>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link Undangan Khusus</label>
                <div class="flex gap-2">
                    <input type="text" value="{{ $slug }}" readonly 
                        class="flex-1 px-4 py-2.5 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-mono outline-none">
                    <button onclick="navigator.clipboard.writeText('{{ $slug }}'); alert('Link disalin!')" 
                        class="px-4 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'share-modal' })">Tutup</x-ui.button>
            </div>
        </div>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('open-new-tab', (event) => {
            window.open(event.url, '_blank');
        });
    });
</script>
