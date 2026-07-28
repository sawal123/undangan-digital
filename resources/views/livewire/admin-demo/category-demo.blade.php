<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Pengaturan Kategori</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola kategori tema undangan digital.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" wire:click="create" loadingTarget="create" loadingText="Memuat...">
            Tambah Kategori
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $item)
            <x-ui.card padding="p-4" class="flex justify-between items-center group">
                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white">{{ $item->category }}</h3>
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">ID: {{ $item->id }}</p>
                </div>
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button wire:click="edit({{ $item->id }})" wire:loading.attr="disabled" wire:target="edit({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors disabled:opacity-50">
                        <span wire:loading.remove wire:target="edit({{ $item->id }})">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </span>
                        <span wire:loading wire:target="edit({{ $item->id }})">
                            <x-loading-spinner class="w-4 h-4" />
                        </span>
                    </button>
                    <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <x-ui.modal name="category-modal" :title="$isEdit ? 'Edit Kategori' : 'Tambah Kategori'" icon="tag">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input label="Nama Kategori" wire:model="category_name" placeholder="Contoh: Wedding, Birthday, etc." />
            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'category-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" :loadingTarget="$isEdit ? 'update' : 'store'" :loadingText="$isEdit ? 'Memperbarui...' : 'Menyimpan...' ">{{ $isEdit ? 'Update' : 'Simpan' }}</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" loadingTarget="delete" loadingText="Menghapus..." x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>
