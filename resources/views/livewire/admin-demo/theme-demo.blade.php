<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Theme</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar tema undangan digital (Versi Livewire Demo).</p>
        </div>
        <x-ui.button variant="primary" icon="plus" x-on:click="$wire.resetInput(); $dispatch('open-modal', { name: 'theme-modal' })">
            Add Theme
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <x-ui.card padding="p-4" class="mb-6">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
            </div>
            <x-ui.input wire:model.live="search" placeholder="Cari nama tema, kategori, atau jenis event..." icon="search" />
        </div>
    </x-ui.card>

    <x-ui.table 
        :headers="['No.', 'Nama Undangan', 'Event', 'Category', 'Path', 'Demo', 'Aksi']"
        title="Daftar Theme"
        :count="$themes->total()"
    >
        @foreach($themes as $index => $theme)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-slate-500 dark:text-slate-400 font-medium text-xs">
                    {{ ($themes->currentPage() - 1) * $themes->perPage() + $index + 1 }}
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        @if($theme->thumbnail)
                            <img src="{{ Storage::url($theme->thumbnail) }}" class="w-10 h-10 rounded-lg object-cover shadow-sm border border-slate-200 dark:border-slate-700" alt="{{ $theme->nama }}">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                <i data-lucide="image" class="w-5 h-5 text-slate-400"></i>
                            </div>
                        @endif
                        <span class="font-medium text-slate-800 dark:text-slate-200">{{ $theme->nama }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400">
                    {{ $theme->eventType->name ?? '-' }}
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400">
                    {{ $theme->category->category ?? '-' }}
                </td>
                <td class="px-5 py-3.5 text-xs font-mono text-slate-500">
                    {{ $theme->path }}
                </td>
                <td class="px-5 py-3.5">
                    <a href="{{ route('admin.temademo', $theme->demo) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                        {{ $theme->demo }}
                        <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button wire:click="edit({{ $theme->id }})" class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button x-on:click="$dispatch('set-delete', { id: {{ $theme->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot name="pagination">
            {{ $themes->links('vendor.livewire.tailwind') }}
        </x-slot>
    </x-ui.table>

    <!-- Modal Form -->
    <x-ui.modal name="theme-modal" :title="$isEdit ? 'Edit Theme' : 'Add New Theme'" icon="palette">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input label="Nama Undangan" wire:model="nama" placeholder="Contoh: Modern Elegant" />

            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Jenis Event</label>
                <select wire:model="event_type_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">Pilih Jenis Event</option>
                    @foreach($eventTypes as $eventType)
                        <option value="{{ $eventType->id }}">{{ $eventType->name }}</option>
                    @endforeach
                </select>
                @error('event_type_id') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Category</label>
                <select wire:model="category_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <x-ui.input label="Path" wire:model="path" placeholder="Contoh: themes.modern" />
            <x-ui.input label="Demo ID" wire:model="demo" placeholder="Contoh: 12345" />
            
            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Thumbnail</label>
                <div class="mt-1 flex items-center gap-4">
                    @if ($thumbnail)
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-20 h-20 rounded-xl object-cover border border-slate-200">
                    @endif
                    <input type="file" wire:model="thumbnail" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <div wire:loading wire:target="thumbnail" class="text-xs text-indigo-500 mt-1">Uploading...</div>
                @error('thumbnail') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'theme-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">
                    {{ $isEdit ? 'Update Theme' : 'Save Theme' }}
                </x-ui.button>
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
