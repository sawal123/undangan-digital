<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Jadwal Acara</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Silahkan kelola jadwal acara undangan Anda.</p>
        </div>
        <button x-on:click="$wire.call('resetInputFields'); $dispatch('open-modal', { name: 'acara-modal' })" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Acara
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <!-- Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($dataAcara as $item)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow p-5 flex flex-col">
                <h4 class="text-md font-bold text-slate-800 dark:text-white mb-3">{{ $item->nama_acara }}</h4>
                
                <div class="space-y-2 mb-6 flex-1 text-sm text-slate-600 dark:text-slate-400">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-indigo-500"></i>
                        <span>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</span>
                    </div>
                    
                    @php
                        $zonaWaktuStart = $item->jam_end == 'Selesai' ? $item->zona_waktu : '';
                        $zonaWaktuEnd = $item->jam_end != 'Selesai' ? $item->zona_waktu : '';
                    @endphp
                    <div class="flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-indigo-500"></i>
                        <span>{{ $item->jam_start }} {{ $zonaWaktuStart }} - {{ $item->jam_end }} {{ $zonaWaktuEnd }}</span>
                    </div>
                    
                    <div class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-indigo-500 mt-0.5"></i>
                        <span>{{ $item->alamat }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <i data-lucide="building" class="w-4 h-4 text-indigo-500"></i>
                        <span class="truncate">{{ $item->vanue }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-auto pt-4 border-t border-slate-100 dark:border-slate-700/50">
                    <button wire:click="edit({{ $item->id }})" wire:loading.attr="disabled" wire:target="edit({{ $item->id }})" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-medium rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="edit({{ $item->id }})" class="inline-flex items-center gap-2"><i data-lucide="edit-3" class="w-4 h-4"></i> Edit</span>
                        <span wire:loading.flex wire:target="edit({{ $item->id }})" class="hidden items-center gap-2"><x-loading-spinner class="w-4 h-4" /> Memuat...</span>
                    </button>
                    <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 text-sm font-medium rounded-lg hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-colors gap-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 border-dashed">
                <i data-lucide="calendar-x" class="w-12 h-12 mb-3 text-slate-300 dark:text-slate-600"></i>
                <p>Tidak ada jadwal acara. Silahkan tambah acara baru.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Add/Edit Acara -->
    <x-ui.modal name="acara-modal" :title="$selectedAcaraId ? 'Edit Acara' : 'Tambah Acara'" icon="calendar">
        <form wire:submit="save" class="space-y-4">
            <x-ui.input label="Nama Acara" wire:model="acara" placeholder="Contoh: Akad Nikah" required />
            <x-ui.input label="Nama Lokasi/Gedung/Venue" wire:model="vanue" placeholder="Contoh: Kediaman Mempelai" required />
            <x-ui.input label="Alamat" wire:model="alamat" placeholder="Jl. Raya No. 1" required />
            <x-ui.input label="Tanggal Acara" type="date" wire:model="date" required />
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.input label="Jam Mulai" type="time" wire:model="start" required />
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Jam Selesai</label>
                    <div class="flex items-center gap-3">
                        <input type="time" wire:model="end" class="flex-1 px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all disabled:opacity-50" {{ $selesai ? 'disabled' : '' }}>
                        <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400 cursor-pointer">
                            <input type="checkbox" wire:model.live="selesai" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                            s/d Selesai
                        </label>
                    </div>
                    @error('end') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Zona Waktu</label>
                <select wire:model="zona" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                    <option value="">-- Pilih Zona Waktu --</option>
                    <option value="WIB">WIB</option>
                    <option value="WITA">WITA</option>
                    <option value="WIT">WIT</option>
                </select>
                @error('zona') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <x-ui.input label="Link Navigasi Map (Opsional)" type="url" wire:model="maps" placeholder="https://goo.gl/maps/..." />

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'acara-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" loadingTarget="save" loadingText="Menyimpan...">Simpan</x-ui.button>
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
