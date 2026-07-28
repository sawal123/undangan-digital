<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Galeri Foto & Video</h3>
            @if ($data->count() < 10)
                <p class="text-sm text-slate-500 dark:text-slate-400">Anda dapat mengunggah hingga <span class="font-bold text-indigo-600 dark:text-indigo-400">10</span> media ({{ $data->count() }}/10).</p>
            @else
                <p class="text-sm text-rose-500 font-medium">Kapasitas galeri Anda sudah penuh (10/10).</p>
            @endif
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <button x-on:click="$dispatch('open-modal', { name: 'photo-modal' })" @if($data->count() >= 10) disabled @endif
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-xl transition-all gap-2">
                <i data-lucide="image" class="w-4 h-4"></i> Tambah Foto
            </button>
            <button x-on:click="$dispatch('open-modal', { name: 'video-modal' })" @if($data->count() >= 10) disabled @endif
                class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 hover:bg-rose-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-xl transition-all gap-2">
                <i data-lucide="video" class="w-4 h-4"></i> Tambah Video
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Media Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($data as $index => $item)
            <div class="group bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden hover:shadow-md transition-all">
                <!-- Media Preview -->
                <div class="relative aspect-video overflow-hidden bg-slate-100 dark:bg-slate-900">
                    @if ($item->poto)
                        <img src="{{ asset('storage/' . $item->poto) }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Gallery Image">
                    @else
                        <iframe src="{{ $item->video }}" class="w-full h-full" frameborder="0"></iframe>
                    @endif
                    
                    <!-- Quick Actions Overlay -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <button wire:click="pre({{ $item->id }})" wire:loading.attr="disabled" wire:target="pre({{ $item->id }})" class="p-2 bg-white/20 backdrop-blur-md text-white rounded-lg hover:bg-white/40 transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="pre({{ $item->id }})"><i data-lucide="maximize-2" class="w-5 h-5"></i></span>
                            <span wire:loading wire:target="pre({{ $item->id }})"><x-loading-spinner class="w-5 h-5" /></span>
                        </button>
                    </div>
                </div>

                <!-- Footer / Controls -->
                <div class="p-4 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-1">
                        <button @if($index === 0) disabled @else wire:click="previous({{ $item->sort }})" wire:loading.attr="disabled" wire:target="previous({{ $item->sort }})" @endif
                            class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 disabled:opacity-30 disabled:pointer-events-none transition-colors">
                            <span wire:loading.remove wire:target="previous({{ $item->sort }})"><i data-lucide="arrow-left-circle" class="w-5 h-5"></i></span>
                            <span wire:loading wire:target="previous({{ $item->sort }})"><x-loading-spinner class="w-4 h-4" /></span>
                        </button>
                        <button @if($data->count() === $index + 1) disabled @else wire:click="next({{ $item->sort }})" wire:loading.attr="disabled" wire:target="next({{ $item->sort }})" @endif
                            class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 disabled:opacity-30 disabled:pointer-events-none transition-colors">
                            <span wire:loading.remove wire:target="next({{ $item->sort }})"><i data-lucide="arrow-right-circle" class="w-5 h-5"></i></span>
                            <span wire:loading wire:target="next({{ $item->sort }})"><x-loading-spinner class="w-4 h-4" /></span>
                        </button>
                    </div>
                    
                    <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" 
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 px-3 py-1.5 rounded-lg transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="image-plus" class="w-8 h-8 text-slate-300 dark:text-slate-600"></i>
                </div>
                <p class="font-medium">Galeri masih kosong. Silahkan tambahkan foto atau video.</p>
            </div>
        @endforelse
    </div>

    <!-- Add Photo Modal -->
    <x-ui.modal name="photo-modal" title="Tambah Foto" icon="image">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Gambar <span class="text-rose-500">*</span></label>
                <input wire:model.defer="poto" type="file" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Foto Maks 1Mb</p>
                @error('poto') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div wire:loading wire:target="poto" class="text-sm text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                <i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Uploading...
            </div>
            
            @if ($poto)
                <div class="mt-4">
                    <p class="text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">Preview:</p>
                    <div class="w-32 h-32 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                        <img src="{{ $poto->temporaryUrl() }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'photo-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" loadingTarget="save" loadingText="Menyimpan...">Simpan</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Add Video Modal -->
    <x-ui.modal name="video-modal" title="Tambah Video" icon="video">
        <form wire:submit="save" class="space-y-4">
            <x-ui.input label="Link YouTube" type="url" wire:model="video" placeholder="https://www.youtube.com/watch?v=..." required />

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'video-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" loadingTarget="save" loadingText="Menyimpan...">Simpan</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Preview Modal -->
    <x-ui.modal name="preview-modal" title="Pratinjau Media" icon="maximize-2">
        <div class="bg-slate-900 rounded-2xl overflow-hidden flex items-center justify-center min-h-[300px]">
            @if (!empty($preview) && $preview->poto)
                <img src="{{ asset('storage/' . $preview->poto) }}" loading="lazy" class="max-w-full max-h-[60vh] object-contain" alt="Preview">
            @elseif (!empty($preview) && $preview->video)
                <iframe src="{{ $preview->video }}" class="w-full aspect-video" frameborder="0" allowfullscreen></iframe>
            @endif
        </div>
        <div class="flex justify-end mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'preview-modal' })">Tutup</x-ui.button>
        </div>
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
