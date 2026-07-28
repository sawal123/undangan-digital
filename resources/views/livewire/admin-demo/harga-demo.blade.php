<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Harga & Promo</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola harga dasar, flash sale, dan kode promo.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Section Harga -->
        <div>
            <x-ui.table :headers="['Keterangan', 'Harga Normal', 'Flash Sale', 'Aksi']" title="Pengaturan Harga">
                @foreach($harga as $h)
                    <tr>
                        <td class="px-5 py-3.5 text-sm font-medium text-slate-800 dark:text-white">Admin / Dasar</td>
                        <td class="px-5 py-3.5 text-sm">Rp {{ number_format($h->harga, 0, ',', '.') }}</td>
                        <td class="px-5 py-3.5 text-sm text-rose-600 font-bold">Rp {{ number_format($h->flashsale, 0, ',', '.') }}</td>
                        <td class="px-5 py-3.5 text-center">
                            <x-ui.button variant="secondary" size="sm" wire:click="editHarga({{ $h->id }})" loadingTarget="editHarga({{ $h->id }})" loadingText="Memuat...">Edit</x-ui.button>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>
        </div>

        <!-- Section Promo -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Kode Promo</h3>
                <x-ui.button variant="primary" size="sm" icon="plus" wire:click="createPromo" loadingTarget="createPromo" loadingText="Memuat...">Tambah Promo</x-ui.button>
            </div>
            <x-ui.table :headers="['Kode', 'Tipe', 'Potongan', 'Aksi']">
                @foreach($promo as $p)
                    <tr>
                        <td class="px-5 py-3.5 font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $p->kode }}</td>
                        <td class="px-5 py-3.5 text-xs">
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 uppercase">{{ $p->type }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-sm">
                            {{ $p->type === 'persen' ? $p->promo . '%' : 'Rp ' . number_format($p->promo, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <div class="flex gap-1 justify-center">
                                <button wire:click="editPromo({{ $p->id }})" wire:loading.attr="disabled" wire:target="editPromo({{ $p->id }})" class="p-1 hover:text-indigo-600 transition-colors disabled:opacity-50">
                                    <span wire:loading.remove wire:target="editPromo({{ $p->id }})"><i data-lucide="pencil" class="w-4 h-4"></i></span>
                                    <span wire:loading wire:target="editPromo({{ $p->id }})"><x-loading-spinner class="w-4 h-4" /></span>
                                </button>
                                <button x-on:click="$dispatch('set-delete', { id: {{ $p->id }}, method: 'deletePromo' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1 hover:text-rose-600 transition-colors"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>
        </div>
    </div>

    <!-- Modal Harga -->
    <x-ui.modal name="harga-modal" title="Edit Pengaturan Harga" icon="banknote">
        <form wire:submit="updateHarga" class="space-y-4">
            <x-ui.input label="Harga Dasar" wire:model="hargaDasar" type="number" />
            <x-ui.input label="Harga Flash Sale" wire:model="flashSale" type="number" />
            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'harga-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" loadingTarget="updateHarga" loadingText="Memperbarui...">Update Harga</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Modal Promo -->
    <x-ui.modal name="promo-modal" :title="$isEditPromo ? 'Edit Promo' : 'Tambah Promo'" icon="ticket">
        <form wire:submit="{{ $isEditPromo ? 'updatePromo' : 'storePromo' }}" class="space-y-4">
            <x-ui.input label="Kode Promo" wire:model="promoName" placeholder="Contoh: PROMOAWAL" />
            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Tipe Potongan</label>
                <select wire:model="promoType" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">Pilih Tipe</option>
                    <option value="persen">Persentase (%)</option>
                    <option value="nominal">Nominal (Rp)</option>
                </select>
            </div>
            <x-ui.input label="Nilai Potongan" wire:model="promoDiscount" type="number" />
            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'promo-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" :loadingTarget="$isEditPromo ? 'updatePromo' : 'storePromo'" :loadingText="$isEditPromo ? 'Memperbarui...' : 'Menyimpan...'">{{ $isEditPromo ? 'Update' : 'Simpan' }}</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" loadingTarget="deletePromo" loadingText="Menghapus..." x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>
