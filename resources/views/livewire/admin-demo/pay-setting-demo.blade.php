<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gift Pay Setting</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Konfigurasi metode pembayaran dan instruksi transfer.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" x-on:click="$wire.resetInput(); $dispatch('open-modal', { name: 'pay-modal' })">
            Tambah Metode
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($paySettings as $item)
            <x-ui.card padding="p-0" class="overflow-hidden flex flex-col h-full group">
                <div class="p-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" class="h-6 w-auto grayscale group-hover:grayscale-0 transition-all" alt="{{ $item->bank }}">
                        @else
                            <i data-lucide="banknote" class="w-5 h-5 text-slate-400"></i>
                        @endif
                        <span class="font-bold text-slate-800 dark:text-white">{{ $item->bank }}</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" {{ $item->isActive ? 'checked' : '' }} wire:click="toggleActive({{ $item->id }})">
                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
                <div class="p-4 flex-1">
                    <div class="flex justify-between text-xs mb-3">
                        <span class="text-slate-500">Kategori:</span>
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $item->category }}</span>
                    </div>
                    <div class="flex justify-between text-xs mb-4">
                        <span class="text-slate-500">Fee:</span>
                        <span class="font-bold text-emerald-600">Rp {{ number_format($item->fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-xs text-slate-500 italic line-clamp-3 bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg border border-slate-100 dark:border-slate-700">
                        {{ $item->deskripsi }}
                    </div>
                </div>
                <div class="p-3 bg-slate-50 dark:bg-slate-800/50 flex gap-2">
                    <x-ui.button variant="secondary" size="sm" class="flex-1" wire:click="edit({{ $item->id }})">Edit</x-ui.button>
                    <x-ui.button variant="secondary" size="sm" class="text-rose-600 hover:bg-rose-50" x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })">Hapus</x-ui.button>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <!-- Modal Form -->
    <x-ui.modal name="pay-modal" :title="$isEdit ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran'" icon="credit-card">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input label="Nama Bank / E-Wallet" wire:model="bank" placeholder="Contoh: Bank BCA" />
            
            <div class="grid grid-cols-2 gap-4">
                <div class="w-full">
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Kategori</label>
                    <select wire:model="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Pilih Kategori</option>
                        <option value="manual">Manual</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="ewallet">E-Wallet</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="cstore">Convenience Store</option>
                    </select>
                </div>
                <x-ui.input label="Admin Fee (Rp)" wire:model="fee" type="number" placeholder="0" />
            </div>

            <x-ui.input label="Kode Midtrans" wire:model="midtrans_code" placeholder="Contoh: bca_va, gopay, credit_card, alfamart" />

            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Deskripsi / Instruksi</label>
                <textarea wire:model="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Masukkan nomor rekening dan instruksi transfer..."></textarea>
            </div>

            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Logo / Icon</label>
                <input type="file" wire:model="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <div wire:loading wire:target="image" class="text-xs text-indigo-500 mt-1">Uploading...</div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'pay-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">{{ $isEdit ? 'Update' : 'Simpan' }}</x-ui.button>
            </div>
        </form>
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
