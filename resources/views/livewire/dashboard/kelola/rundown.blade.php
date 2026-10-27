<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }"
    @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">

    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </span>
                <h3 class="text-xl font-black text-slate-800 dark:text-white">Susunan Acara (Rundown)</h3>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Atur jadwal kegiatan, linimasa hari-H, dan kontrol status tampil susunan acara.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('dashboard.undangan.acara', ['id' => $invitationUid]) }}" wire:navigate
                class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs sm:text-sm font-semibold rounded-xl transition-all gap-1.5 shadow-sm">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i> Kelola Acara
            </a>

            <button wire:click="openCreateModal"
                class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition-all gap-2 shadow-sm shadow-indigo-200 dark:shadow-none">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Kegiatan
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3 shadow-sm" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 flex-shrink-0"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 dark:bg-rose-900/30 dark:text-rose-300 border border-rose-200 dark:border-rose-800 flex items-center gap-3 shadow-sm" role="alert">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500 flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Event Filter Tabs (if multiple acara exist) -->
    @if ($acaras->count() > 0)
        <div class="bg-white dark:bg-slate-900 p-2 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
                <button type="button" wire:click="$set('filterAcara', 'all')"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ $filterAcara === 'all' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                    Semua Kegiatan
                </button>

                @foreach ($acaras as $ac)
                    <button type="button" wire:click="$set('filterAcara', '{{ $ac->id }}')"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ $filterAcara == $ac->id ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        {{ $ac->nama_acara }}
                    </button>
                @endforeach

                <button type="button" wire:click="$set('filterAcara', 'general')"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all flex items-center gap-1.5 {{ $filterAcara === 'general' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/20' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                    Umum (Tanpa Acara Spesifik)
                </button>
            </div>
        </div>
    @endif

    <!-- Rundown Timeline List -->
    <div class="space-y-3">
        @forelse ($rundowns as $index => $item)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 sm:p-5 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 {{ !$item->is_active ? 'opacity-60 bg-slate-50/50 dark:bg-slate-950/40' : '' }}">
                <div class="flex items-start gap-4 flex-1">
                    <!-- Position Order Badge -->
                    <div class="flex flex-col items-center justify-center">
                        <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-extrabold text-xs flex items-center justify-center shadow-sm">
                            #{{ $index + 1 }}
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="space-y-1.5 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Time Badge -->
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                {{ $item->waktu_mulai }} - {{ $item->waktu_selesai ?: 'Selesai' }}
                            </span>

                            @if ($item->acara)
                                <span class="inline-flex items-center text-[11px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    {{ $item->acara->nama_acara }}
                                </span>
                            @endif

                            <!-- Is Active Pill -->
                            <button type="button" wire:click="toggleActive({{ $item->id }})"
                                class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-0.5 rounded-full transition-colors {{ $item->is_active ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100' : 'bg-slate-200 dark:bg-slate-800 text-slate-500 hover:bg-slate-300' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </div>

                        <h4 class="text-base font-bold text-slate-800 dark:text-white">
                            {{ $item->nama_kegiatan }}
                        </h4>

                        @if ($item->lokasi)
                            <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                                <span>{{ $item->lokasi }}</span>
                            </p>
                        @endif

                        @if ($item->keterangan)
                            <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 line-clamp-2">
                                {{ $item->keterangan }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Controls & Actions -->
                <div class="flex items-center justify-end gap-2 border-t md:border-t-0 pt-3 md:pt-0 border-slate-100 dark:border-slate-800">
                    <!-- Sort Reorder Buttons -->
                    <div class="flex items-center gap-0.5 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl">
                        <button type="button" @if($index === 0) disabled @else wire:click="moveUp({{ $item->sort }})" wire:loading.attr="disabled" @endif
                            title="Pindahkan ke atas"
                            class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 disabled:opacity-30 disabled:pointer-events-none transition-colors">
                            <i data-lucide="chevron-up" class="w-4 h-4"></i>
                        </button>
                        <button type="button" @if($rundowns->count() === $index + 1) disabled @else wire:click="moveDown({{ $item->sort }})" wire:loading.attr="disabled" @endif
                            title="Pindahkan ke bawah"
                            class="p-1.5 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 disabled:opacity-30 disabled:pointer-events-none transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <!-- Edit Button -->
                    <button type="button" wire:click="edit({{ $item->id }})"
                        class="p-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-xl transition-colors font-medium text-xs flex items-center gap-1">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Edit</span>
                    </button>

                    <!-- Delete Button -->
                    <button type="button" x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })"
                        class="p-2 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition-colors font-medium text-xs flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Hapus</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="py-16 flex flex-col items-center justify-center text-slate-400 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 border-dashed">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-3">
                    <i data-lucide="clock" class="w-8 h-8 opacity-60"></i>
                </div>
                <h4 class="text-base font-bold text-slate-700 dark:text-slate-300">Belum Ada Susunan Acara</h4>
                <p class="text-xs text-slate-400 mt-1 max-w-sm text-center">
                    Tambahkan jadwal kegiatan hari-H seperti Akad Nikah, Temu Manten, Sambutan, Ramah Tamah, atau Sesi Foto.
                </p>
                <button type="button" wire:click="openCreateModal"
                    class="mt-4 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                    + Tambah Kegiatan Pertama
                </button>
            </div>
        @endforelse
    </div>

    <!-- Modal Form: Add / Edit Rundown -->
    <x-ui.modal name="rundown-modal" :title="$selectedRundownId ? 'Edit Susunan Acara' : 'Tambah Susunan Acara'" icon="clock" maxWidth="lg">
        <form wire:submit="save" class="space-y-4">
            @if ($acaras->count() > 0)
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
                        Kaitkan ke Acara (Opsional)
                    </label>
                    <select wire:model="acara_id" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <option value="">-- Umum / Tanpa Acara Khusus --</option>
                        @foreach ($acaras as $ac)
                            <option value="{{ $ac->id }}">{{ $ac->nama_acara }} ({{ $ac->vanue }})</option>
                        @endforeach
                    </select>
                    @error('acara_id') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
            @endif

            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
                    Nama Kegiatan / Agenda <span class="text-rose-500">*</span>
                </label>
                <input type="text" wire:model="nama_kegiatan" placeholder="Contoh: Akad Nikah & Ijab Qabul"
                    class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                @error('nama_kegiatan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
                        Waktu Mulai <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" wire:model="waktu_mulai" placeholder="Contoh: 08:00 WIB"
                        class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                    @error('waktu_mulai') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
                        Waktu Selesai
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model="waktu_selesai" placeholder="09:30 WIB"
                            class="flex-1 px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all disabled:opacity-50"
                            {{ $sampai_selesai ? 'disabled' : '' }}>
                        <label class="flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400 cursor-pointer whitespace-nowrap">
                            <input type="checkbox" wire:model.live="sampai_selesai" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                            s/d Selesai
                        </label>
                    </div>
                    @error('waktu_selesai') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
                    Lokasi / Ruangan (Opsional)
                </label>
                <input type="text" wire:model="lokasi" placeholder="Contoh: Ruang Utama Masjid / Panggung Pelaminan"
                    class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                @error('lokasi') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
                    Keterangan / PIC / Pengisi Acara (Opsional)
                </label>
                <textarea wire:model="keterangan" rows="2" placeholder="Catatan tambahan, penanggung jawab, atau dresscode..."
                    class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all"></textarea>
                @error('keterangan') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Toggle is_active -->
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">Status Tampil di Undangan</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Jika aktif, kegiatan ini akan ditampilkan dalam susunan acara undangan.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="is_active" class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" x-on:click="$dispatch('close-modal', { name: 'rundown-modal' })"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors">
                    Batal
                </button>
                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/30 transition-all flex items-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="save">{{ $selectedRundownId ? 'Simpan Perubahan' : 'Tambah Rundown' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus jadwal rundown ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" loadingTarget="delete" loadingText="Menghapus..." x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>
