<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Fonts</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar font yang tersedia untuk undangan digital.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" x-on:click="$wire.resetInput(); $dispatch('open-modal', { name: 'font-modal' })">
            Add Font
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <x-ui.card padding="p-4" class="mb-6">
        <div class="relative max-w-md">
            <x-ui.input wire:model.live="search" placeholder="Cari nama font..." icon="search" />
        </div>
    </x-ui.card>

    <x-ui.table 
        :headers="['No.', 'Nama Font', 'Link / URL', 'Status', 'Aksi']"
        title="Daftar Fonts"
        :count="$fonts->total()"
    >
        @foreach($fonts as $index => $font)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-slate-500 dark:text-slate-400 font-medium text-xs">
                    {{ ($fonts->currentPage() - 1) * $fonts->perPage() + $index + 1 }}
                </td>
                <td class="px-5 py-3.5">
                    <span class="font-medium text-slate-800 dark:text-slate-200">{{ $font->nama }}</span>
                </td>
                <td class="px-5 py-3.5 text-xs font-mono text-slate-500 max-w-xs truncate">
                    {{ $font->link }}
                </td>
                <td class="px-5 py-3.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $font->is_active ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-700' : 'bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $font->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                        {{ $font->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button wire:click="edit({{ $font->id }})" class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button x-on:click="$dispatch('set-delete', { id: {{ $font->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot name="pagination">
            {{ $fonts->links('vendor.livewire.tailwind') }}
        </x-slot>
    </x-ui.table>

    <x-ui.modal name="font-modal" :title="$isEdit ? 'Edit Font' : 'Add Font'" icon="type">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input label="Nama Font" wire:model="nama" placeholder="Contoh: Roboto" />
            <x-ui.input label="Link / URL Google Fonts" wire:model="link" placeholder="https://fonts.googleapis.com/css2?..." />
            
            <div class="flex items-center gap-3">
                <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">Aktifkan Font</label>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'font-modal' })">Batal</x-ui.button>
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
