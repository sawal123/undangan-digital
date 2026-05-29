<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Detail {{ $eventTypeName }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Isi informasi utama yang akan digunakan oleh tema non-pernikahan.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5">
        <form wire:submit.prevent="save" class="space-y-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Judul Utama</label>
                    <input type="text" wire:model="headline"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: Pengajian Akbar / Engagement Day">
                    @error('headline') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Penyelenggara / Nama Utama</label>
                    <input type="text" wire:model="host_name"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: Keluarga Bapak Ahmad">
                    @error('host_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Narasumber / Pengisi Acara</label>
                    <input type="text" wire:model="speaker_name"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: Ustadz Ahmad / Keynote Speaker">
                    @error('speaker_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Dress Code</label>
                    <input type="text" wire:model="dress_code"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: Putih / Batik / Bebas rapi">
                    @error('dress_code') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi</label>
                <textarea wire:model="description" rows="4"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                    placeholder="Tuliskan pengantar singkat untuk event ini."></textarea>
                @error('description') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                @if ($image)
                    <div class="flex-shrink-0">
                        @if (is_string($image))
                            <img src="{{ $image }}" class="w-28 h-28 object-cover rounded-xl border border-slate-200 dark:border-slate-800" alt="Preview Gambar">
                        @else
                            <img src="{{ $image->temporaryUrl() }}" class="w-28 h-28 object-cover rounded-xl border border-slate-200 dark:border-slate-800" alt="Preview Gambar">
                        @endif
                    </div>
                @endif
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Gambar Utama</label>
                    <input type="file" wire:model="image"
                        class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 dark:hover:file:bg-indigo-900/50 transition-all">
                    @error('image') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="image" class="mt-2 text-xs text-indigo-600 dark:text-indigo-400">Uploading...</div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                <button type="submit" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors gap-2 w-full sm:w-auto disabled:opacity-60 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i> Simpan Detail</span>
                    <span wire:loading.flex wire:target="save" class="hidden items-center gap-2"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
