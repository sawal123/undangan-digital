<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Kisah Cinta</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Ceritakan perjalanan cinta Anda hingga sampai di hari bahagia ini.</p>
        </div>
        <button wire:click="modalAddKisah" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Kisah
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Stories List -->
    <div class="space-y-6">
        @forelse ($kisahCInta as $item)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <!-- Image Section -->
                    <div class="lg:w-1/3 relative group aspect-video lg:aspect-auto">
                        @php $kisahImg = $item->imgKisah->image ?? null; @endphp
                        @if($kisahImg)
                            <img src="{{ asset('storage/'.$kisahImg) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center">
                                <i data-lucide="image" class="w-12 h-12 text-slate-300 dark:text-slate-700"></i>
                            </div>
                        @endif
                        
                        <!-- Upload Overlay -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-4 text-center">
                            <input type="file" wire:model="poto.{{ $item->id }}" id="kisah-img-{{ $item->id }}" class="hidden" accept="image/*">
                            <label for="kisah-img-{{ $item->id }}" class="px-4 py-2 bg-white text-slate-800 text-xs font-bold rounded-lg cursor-pointer hover:bg-slate-100 transition-all flex items-center gap-2 mb-2">
                                <i data-lucide="upload-cloud" class="w-4 h-4 text-indigo-600"></i>
                                Pilih Gambar
                            </label>
                            @if(isset($poto[$item->id]))
                                <button wire:click="saveImage({{ $item->id }})" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-all">Simpan Gambar</button>
                            @endif
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="lg:w-2/3 p-6 lg:p-8 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <h4 class="text-xl font-black text-slate-800 dark:text-white">{{ $item->title }}</h4>
                            <div class="flex gap-2">
                                <button wire:click="modalEditKisah({{ $item->id }})" class="p-2 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </button>
                                <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-2 text-slate-400 hover:text-rose-600 transition-colors">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed flex-1 whitespace-pre-line">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <i data-lucide="heart" class="w-12 h-12 mb-4 opacity-20"></i>
                <p class="font-medium">Belum ada kisah cinta yang ditambahkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Add/Edit Kisah -->
    <x-ui.modal name="kisah-modal" :title="$idKisah ? 'Edit Kisah' : 'Tambah Kisah'" icon="heart">
        <form wire:submit="save" class="space-y-4">
            <x-ui.input label="Judul Kisah" wire:model="judul" placeholder="Contoh: Pertemuan Pertama" required />
            
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Ceritakan Disini</label>
                <textarea wire:model="cerita" rows="4" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all resize-y" placeholder="Pada suatu hari..." required></textarea>
                @error('cerita') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'kisah-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">Simpan</x-ui.button>
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
