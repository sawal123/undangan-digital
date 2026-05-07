<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Undangan Animasi</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola video animasi undangan (YouTube Embed).</p>
        </div>
        <x-ui.button variant="primary" icon="plus" x-on:click="$wire.resetInput(); $dispatch('open-modal', { name: 'animation-modal' })">
            Tambah Animasi
        </x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($animations as $item)
            <x-ui.card padding="p-0" class="overflow-hidden flex flex-col h-full group">
                <div class="relative aspect-video bg-slate-100 dark:bg-slate-800">
                    <iframe src="{{ $item->link }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-lg">{{ $item->nama }}</h3>
                        <p class="text-xs text-slate-500 font-mono mt-1 truncate">{{ $item->link }}</p>
                    </div>
                    <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <x-ui.button variant="secondary" size="sm" class="flex-1" wire:click="edit({{ $item->id }})">
                            Edit
                        </x-ui.button>
                        <x-ui.button variant="secondary" size="sm" class="text-rose-600 hover:bg-rose-50" x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })">
                            Hapus
                        </x-ui.button>
                    </div>
                </div>
            </x-ui.card>
        @endforeach
    </div>

    <x-ui.modal name="animation-modal" :title="$isEdit ? 'Edit Animasi' : 'Tambah Animasi'" icon="video">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input label="Nama Animasi" wire:model="nama" placeholder="Contoh: Undangan Islamic Gold" />
            <x-ui.input label="Link YouTube" wire:model="link" placeholder="https://www.youtube.com/watch?v=..." />
            <x-ui.input label="Thumbnail Link (Opsional)" wire:model="thumbnail" placeholder="Link gambar thumbnail..." />
            
            <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl">
                <p class="text-xs text-amber-700 dark:text-amber-400 flex gap-2">
                    <i data-lucide="info" class="w-4 h-4 flex-shrink-0"></i>
                    <span>Link YouTube akan otomatis dikonversi menjadi format Embed.</span>
                </p>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'animation-modal' })">Batal</x-ui.button>
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
