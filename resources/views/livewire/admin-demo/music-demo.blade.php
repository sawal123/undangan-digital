<div x-data="{ deleteId: null, deleteMethod: 'delete' }"
    @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Musik</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar musik yang tersedia untuk undangan digital.
            </p>
        </div>
        <x-ui.button variant="primary" icon="plus"
            x-on:click="$wire.resetInput(); $dispatch('open-modal', { name: 'music-modal' })">
            Tambah Musik
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <x-ui.card padding="p-4" class="mb-6">
        <div class="relative max-w-md">
            <x-ui.input wire:model.live="search" placeholder="Cari judul, artis, atau kategori..." icon="search" />
        </div>
    </x-ui.card>

    <x-ui.table :headers="['No.', 'Judul', 'Artis', 'Kategori', 'Link', 'Aksi']" title="Daftar Musik" :count="$music->total()">
        @foreach ($music as $index => $item)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-slate-500 dark:text-slate-400 font-medium text-xs">
                    {{ ($music->currentPage() - 1) * $music->perPage() + $index + 1 }}
                </td>
                <td class="px-5 py-3.5">
                    <span class="font-medium text-slate-800 dark:text-slate-200">{{ $item->judul }}</span>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400">
                    {{ $item->artis }}
                </td>
                <td class="px-5 py-3.5">
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 border-indigo-200 dark:border-indigo-700">
                        <i data-lucide="{{ $item->category->icon ?? 'music' }}" class="w-3.5 h-3.5"></i>
                        {{ $item->category->category ?? '-' }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-xs font-mono text-slate-500 max-w-xs truncate">
                    <a href="{{ $item->link }}" target="_blank"
                        class="text-indigo-600 dark:text-indigo-400 hover:underline truncate block max-w-[200px]">
                        {{ $item->link }}
                    </a>
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button wire:click="edit({{ $item->id }})"
                            class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button
                            x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })"
                            class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot name="pagination">
            {{ $music->links('vendor.livewire.tailwind') }}
        </x-slot>
    </x-ui.table>

    <!-- Add / Edit Music Modal -->
    <x-ui.modal name="music-modal" :title="$isEdit ? 'Edit Musik' : 'Tambah Musik'" icon="music">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input label="Judul Musik" wire:model="judul" placeholder="Masukkan judul musik" />
            <x-ui.input label="Artis" wire:model="artis" placeholder="Masukkan nama artis" />
            <x-ui.input label="Link (YouTube Embed)" wire:model="link"
                placeholder="https://www.youtube.com/embed/..." />

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                <select wire:model="category_id"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-rose-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button"
                    x-on:click="$dispatch('close-modal', { name: 'music-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">{{ $isEdit ? 'Update' : 'Simpan' }}</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus musik ini? Tindakan ini
            tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary"
                x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none"
                x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya,
                Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>
