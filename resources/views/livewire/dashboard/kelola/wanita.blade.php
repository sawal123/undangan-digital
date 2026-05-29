<div>
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800" role="alert">
            {{ session('message') }}
        </div>
    @endif
    
    <form wire:submit.prevent="save" wire:ignore.self class="space-y-5">
        <div class="border-b border-slate-200 dark:border-slate-800 pb-3 mb-4">
            <h4 class="text-md font-bold text-slate-800 dark:text-white">Data Mempelai Wanita</h4>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Mempelai <span class="text-rose-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                </div>
                <input id="name_wanita" name="nama" type="text" wire:model="nama" 
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                    placeholder="Nama Lengkap :">
            </div>
            @error('nama') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Panggilan <span class="text-rose-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="user-circle" class="w-4 h-4 text-slate-400"></i>
                </div>
                <input id="panggilan_wanita" name="panggilan" wire:model="panggilan" type="text"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm" 
                    placeholder="Nama Panggilan :">
            </div>
            @error('panggilan') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi <span class="text-rose-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="message-square" class="w-4 h-4 text-slate-400"></i>
                </div>
                <input id="deskripsi_wanita" name="deskripsi" type="text" wire:model="deskripsi"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm" 
                    placeholder="Putri Bpk Polan & Ibu Paulani">
            </div>
            @error('deskripsi') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            @if ($gambar)
                <div class="flex-shrink-0">
                    @if (is_string($gambar))
                        <img src="{{ $gambar }}" class="w-24 h-24 object-cover rounded-xl border border-slate-200 dark:border-slate-800" alt="Preview Image">
                    @else
                        <img src="{{ $gambar->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-xl border border-slate-200 dark:border-slate-800" alt="Preview Image">
                    @endif
                </div>
            @endif
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Gambar <span class="text-rose-500">*</span></label>
                <input id="gambar_wanita" name="gambar" wire:model="gambar" type="file" 
                    class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 dark:file:bg-pink-900/30 dark:file:text-pink-400 dark:hover:file:bg-pink-900/50 transition-all">
                @error('gambar') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                <div wire:loading wire:target="gambar" class="mt-2 text-xs text-indigo-600 dark:text-indigo-400">Uploading...</div>
            </div>
        </div>

        <div class="pt-4 mt-6 border-t border-slate-200 dark:border-slate-800">
            <button type="submit" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center justify-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium rounded-xl transition-colors gap-2 w-full sm:w-auto disabled:opacity-60 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i> Simpan Data Wanita</span>
                <span wire:loading.flex wire:target="save" class="hidden items-center gap-2"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
