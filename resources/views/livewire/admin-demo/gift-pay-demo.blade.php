<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Navigation Tabs -->
    <div class="mb-6 flex flex-wrap items-center gap-2 p-1.5 bg-slate-100 dark:bg-slate-800/80 rounded-2xl w-fit border border-slate-200 dark:border-slate-700">
        <a href="{{ route('admin.pay.setting') }}" wire:navigate class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-slate-700/50">
            <i data-lucide="credit-card" class="w-4 h-4"></i>
            <span>Metode Pembayaran (Transaksi)</span>
        </a>
        <a href="{{ route('admin.gift.pay') }}" wire:navigate class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all bg-indigo-600 text-white shadow-sm">
            <i data-lucide="gift" class="w-4 h-4"></i>
            <span>Gift Pay (Hadiah Undangan)</span>
        </a>
    </div>

    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Gift Pay Hadiah</h2>
                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                    Total: {{ $totalCount }}
                </span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola daftar pilihan bank dan dompet digital untuk amplop digital / kado pada undangan pengantin.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative min-w-[240px]">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari bank / e-wallet..."
                    class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                @if($search)
                    <button type="button" wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                @endif
            </div>

            <x-ui.button variant="primary" icon="plus" wire:click="create">
                Tambah Gift Pay
            </x-ui.button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 rounded-xl border border-rose-200 dark:border-rose-700 flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($giftPays as $item)
            @php
                $hasStorageFile = $item->icon && Storage::disk('public')->exists($item->icon);
                $hasPublicFile = $item->icon && file_exists(public_path($item->icon));
            @endphp
            <x-ui.card padding="p-0" class="overflow-hidden flex flex-col h-full group hover:border-indigo-500/50 transition-all duration-200 shadow-sm">
                <div class="p-5 flex-1 flex flex-col items-center text-center">
                    <!-- Icon / Logo Container -->
                    <div class="w-20 h-20 rounded-2xl bg-slate-50 dark:bg-slate-800/80 p-3 mb-4 flex items-center justify-center border border-slate-100 dark:border-slate-700/80 shadow-inner group-hover:scale-105 transition-transform duration-200">
                        @if($hasStorageFile)
                            <img src="{{ Storage::url($item->icon) }}" class="max-h-full max-w-full object-contain" alt="{{ $item->nama_pay }}">
                        @elseif($hasPublicFile)
                            <img src="{{ asset($item->icon) }}" class="max-h-full max-w-full object-contain" alt="{{ $item->nama_pay }}">
                        @else
                            <i data-lucide="gift" class="w-8 h-8 text-indigo-400"></i>
                        @endif
                    </div>

                    <h3 class="font-bold text-slate-800 dark:text-white text-base mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $item->nama_pay }}
                    </h3>

                    <div class="mt-2">
                        @if($item->kado_count > 0)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                <i data-lucide="check" class="w-3 h-3"></i>
                                {{ $item->kado_count }} Kado Pengantin
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                Belum Digunakan
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-3 bg-slate-50/70 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-700/60 flex items-center gap-2">
                    <x-ui.button variant="secondary" size="sm" class="flex-1" wire:click="edit({{ $item->id }})">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-1.5"></i>
                        Edit
                    </x-ui.button>
                    <x-ui.button variant="secondary" size="sm" class="text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 dark:text-rose-400" x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </x-ui.button>
                </div>
            </x-ui.card>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mb-4">
                    <i data-lucide="gift" class="w-8 h-8"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Tidak ada data Gift Pay</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 max-w-md mx-auto">
                    @if($search)
                        Tidak ada pilihan gift pay yang cocok dengan kata kunci "{{ $search }}".
                    @else
                        Belum ada data gift pay yang terdaftar. Tambahkan bank atau dompet digital pertama Anda.
                    @endif
                </p>
                @if($search)
                    <button type="button" wire:click="$set('search', '')" class="mt-4 px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-50 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 transition-colors">
                        Reset Pencarian
                    </button>
                @else
                    <x-ui.button variant="primary" icon="plus" class="mt-4" wire:click="create">
                        Tambah Gift Pay Baru
                    </x-ui.button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $giftPays->links('components.ui.pagination') }}
    </div>

    <!-- Form Modal -->
    <x-ui.modal name="gift-modal" :title="$isEdit ? 'Edit Gift Pay' : 'Tambah Gift Pay Baru'" icon="gift">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input
                label="Nama Bank / E-Wallet"
                wire:model="nama_pay"
                placeholder="Contoh: Bank BCA, Bank BRI, DANA, GoPay"
                required />

            <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">
                    Icon / Logo Bank / E-Wallet
                </label>

                <!-- Current / Preview Icon Box -->
                @if ($icon)
                    <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                        <div class="w-16 h-16 rounded-xl bg-white dark:bg-slate-700 p-2 border border-slate-200 dark:border-slate-600 flex items-center justify-center overflow-hidden">
                            <img src="{{ $icon->temporaryUrl() }}" class="max-h-full max-w-full object-contain" alt="Preview">
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Icon Baru Dipilih</span>
                            <p class="text-xs text-slate-500">Ukuran: {{ number_format($icon->getSize() / 1024, 1) }} KB</p>
                        </div>
                    </div>
                @elseif ($existingIcon)
                    <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                        <div class="w-16 h-16 rounded-xl bg-white dark:bg-slate-700 p-2 border border-slate-200 dark:border-slate-600 flex items-center justify-center overflow-hidden">
                            @if(Storage::disk('public')->exists($existingIcon))
                                <img src="{{ Storage::url($existingIcon) }}" class="max-h-full max-w-full object-contain" alt="Current Icon">
                            @elseif(file_exists(public_path($existingIcon)))
                                <img src="{{ asset($existingIcon) }}" class="max-h-full max-w-full object-contain" alt="Current Icon">
                            @else
                                <i data-lucide="gift" class="w-6 h-6 text-slate-400"></i>
                            @endif
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Icon Saat Ini</span>
                            <p class="text-xs text-slate-500">Pilih file baru di bawah jika ingin mengganti icon.</p>
                        </div>
                    </div>
                @endif

                <input type="file"
                    wire:model="icon"
                    accept="image/png,image/jpeg,image/webp,image/svg+xml"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-950 file:text-indigo-700 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900 border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 cursor-pointer">
                
                <div wire:loading wire:target="icon" class="text-xs text-indigo-500 mt-1.5 flex items-center gap-2">
                    <i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i>
                    <span>Mengunggah file icon...</span>
                </div>

                @error('icon')
                    <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-slate-400 mt-1">Format didukung: PNG, JPG, SVG, WebP (Maksimal 2MB).</p>
            </div>

            <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'gift-modal' })">
                    Batal
                </x-ui.button>
                <x-ui.button variant="primary" type="submit" wire:loading.attr="disabled" wire:target="icon,store,update">
                    {{ $isEdit ? 'Perbarui Gift Pay' : 'Simpan Gift Pay' }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus Gift Pay" icon="alert-triangle">
        <div class="space-y-3">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Apakah Anda yakin ingin menghapus data gift pay ini?
            </p>
            <div class="p-3 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800 text-xs text-amber-700 dark:text-amber-400">
                <span class="font-bold">Perhatian:</span> Menghapus gift pay dapat berdampak pada data kado di undangan pengantin yang menggunakan metode ini. Tindakan ini tidak dapat dibatalkan.
            </div>
        </div>
        <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-slate-100 dark:border-slate-700">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">
                Batal
            </x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">
                Ya, Hapus
            </x-ui.button>
        </div>
    </x-ui.modal>
</div>
