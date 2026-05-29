<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Kisah Cinta</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Ceritakan perjalanan cinta Anda hingga sampai di hari bahagia ini.</p>
        </div>
        <button wire:click="modalAddKisah" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all gap-2 shadow-sm">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Kisah
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Stories List -->
    <div class="space-y-4">
        @forelse ($kisahCInta as $item)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4 sm:p-5 transition-all duration-200 hover:shadow-md">
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-start">
                    <!-- Image Section (Compact Thumbnail) -->
                    <div class="w-full sm:w-44 sm:h-44 h-48 relative group flex-shrink-0 rounded-xl overflow-hidden bg-slate-50 dark:bg-slate-950 border border-slate-100 dark:border-slate-800">
                        @php 
                            $kisahImg = $item->image->image ?? null; 
                            $tempPoto = $poto[$item->id] ?? null;
                        @endphp
                        
                        @if($tempPoto)
                            <img src="{{ $tempPoto->temporaryUrl() }}" class="w-full h-full object-cover object-top" alt="Preview">
                            <div class="absolute top-2 left-2 px-2 py-0.5 bg-amber-500 text-white text-[9px] font-bold rounded shadow">Preview</div>
                        @elseif($kisahImg)
                            <img src="{{ asset('storage/'.$kisahImg) }}" class="w-full h-full object-cover object-top" alt="Foto Kisah">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center">
                                <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-800 flex items-center justify-center mb-2 text-slate-400">
                                    <i data-lucide="image" class="w-6 h-6"></i>
                                </div>
                                <p class="text-[11px] text-slate-400">Belum ada foto</p>
                            </div>
                        @endif
                        
                        <!-- Upload Overlay -->
                        <div class="absolute inset-0 bg-slate-900/70 opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-xs flex flex-col items-center justify-center p-3 text-center">
                            <input type="file" wire:model="poto.{{ $item->id }}" id="kisah-img-{{ $item->id }}" class="hidden" accept="image/*">
                            
                            @if(isset($poto[$item->id]))
                                <div class="flex flex-col gap-1.5 w-full max-w-[120px]">
                                    <button wire:click="saveImage({{ $item->id }})" wire:loading.attr="disabled" wire:target="saveImage({{ $item->id }})" class="w-full px-3 py-1.5 bg-indigo-600 text-white text-[11px] font-bold rounded-lg hover:bg-indigo-700 transition-all shadow-sm flex items-center justify-center gap-1 disabled:opacity-60 disabled:cursor-not-allowed">
                                        <span wire:loading.remove wire:target="saveImage({{ $item->id }})" class="inline-flex items-center gap-1"><i data-lucide="save" class="w-3 h-3"></i> Simpan</span>
                                        <span wire:loading.flex wire:target="saveImage({{ $item->id }})" class="hidden items-center gap-1"><i data-lucide="loader-2" class="w-3 h-3 animate-spin"></i> Menyimpan...</span>
                                    </button>
                                    <button wire:click="$set('poto.{{ $item->id }}', null)" class="w-full px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-[11px] font-bold rounded-lg transition-all backdrop-blur-md">
                                        Batal
                                    </button>
                                </div>
                            @else
                                <label for="kisah-img-{{ $item->id }}" class="px-3 py-1.5 bg-white text-slate-800 text-[11px] font-bold rounded-lg cursor-pointer hover:scale-105 active:scale-95 transition-all flex items-center gap-1.5 shadow-md">
                                    <i data-lucide="camera" class="w-3.5 h-3.5 text-indigo-600"></i>
                                    Ganti Foto
                                </label>
                            @endif

                            <div wire:loading wire:target="poto.{{ $item->id }}" class="mt-2">
                                <div class="flex items-center gap-1.5 text-white text-[10px] font-medium">
                                    <div class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                    <span>Uploading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="flex-1 min-w-0 w-full flex flex-col sm:py-1">
                        <div class="flex justify-between items-start gap-3 mb-2">
                            <h4 class="text-base font-bold text-slate-800 dark:text-white leading-snug">{{ $item->title }}</h4>
                            <div class="flex items-center gap-1 flex-shrink-0 -mt-1">
                                <button wire:click="modalEditKisah({{ $item->id }})" wire:loading.attr="disabled" wire:target="modalEditKisah({{ $item->id }})" class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all disabled:opacity-60 disabled:cursor-not-allowed" title="Edit Kisah">
                                    <i wire:loading.remove wire:target="modalEditKisah({{ $item->id }})" data-lucide="edit-3" class="w-4 h-4"></i>
                                    <i wire:loading wire:target="modalEditKisah({{ $item->id }})" data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                </button>
                                <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all" title="Hapus Kisah">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed whitespace-pre-line">{{ $item->deskripsi }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-16 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <i data-lucide="heart" class="w-10 h-10 mb-3 opacity-20"></i>
                <p class="text-sm font-medium">Belum ada kisah cinta yang ditambahkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Add/Edit Kisah -->
    <x-ui.modal name="kisah-modal" :title="$idKisah ? 'Edit Kisah' : 'Tambah Kisah'" icon="heart">
        <form wire:submit="save" class="space-y-4">
            <x-ui.input label="Judul Kisah" wire:model="judul" placeholder="Contoh: Pertemuan Pertama" required />
            
            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Foto Kisah (Opsional)</label>
                <div class="relative flex items-center justify-center w-full">
                    <label for="modal-kisah-img" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 dark:border-slate-700 border-dashed rounded-2xl cursor-pointer bg-slate-50 dark:bg-slate-900/50 hover:bg-slate-100 dark:hover:bg-slate-900 transition-all overflow-hidden group">
                        @if($formImage)
                            <img src="{{ $formImage->temporaryUrl() }}" class="w-full h-full object-cover object-top" alt="Preview Modal">
                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold">Ganti Foto</div>
                        @else
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                <i data-lucide="upload-cloud" class="w-8 h-8 mb-2 text-slate-400 dark:text-slate-500 group-hover:scale-110 transition-transform"></i>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Klik untuk upload foto</p>
                                <p class="text-[10px] text-slate-400 dark:text-slate-600 mt-0.5">PNG, JPG, WEBP maks 2MB</p>
                            </div>
                        @endif
                    </label>
                    <input id="modal-kisah-img" wire:model="formImage" type="file" class="hidden" accept="image/*" />
                </div>
                <div wire:loading wire:target="formImage" class="mt-1">
                    <span class="text-[10px] text-indigo-600 dark:text-indigo-400 font-medium animate-pulse">Menyiapkan pratinjau...</span>
                </div>
            </div>

            <div>
                <x-ui.textarea label="Ceritakan Disini" wire:model="cerita" rows="5" placeholder="Ceritakan perjalanan cinta Anda..." required />
                @error('cerita') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'kisah-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" loading-target="save" loading-text="Menyimpan...">Simpan</x-ui.button>
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
