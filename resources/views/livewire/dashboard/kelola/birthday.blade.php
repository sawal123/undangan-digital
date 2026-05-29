<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Profil Ulang Tahun</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Isi informasi utama yang akan tampil pada undangan ulang tahun.</p>
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
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="name"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: Keisha Adelia">
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Panggilan</label>
                    <input type="text" wire:model="nickname"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: Keisha">
                    @error('nickname') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Usia</label>
                    <input type="number" wire:model="age" min="1" max="150"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: 7">
                    @error('age') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Orang Tua</label>
                    <input type="text" wire:model="parent_name"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                        placeholder="Contoh: Bapak Andi & Ibu Rina">
                    @error('parent_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi</label>
                <textarea wire:model="description" rows="4"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all text-sm"
                    placeholder="Contoh: Dengan bahagia kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara ulang tahun buah hati kami."></textarea>
                @error('description') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                @if ($photo)
                    <div class="flex-shrink-0">
                        @if (is_string($photo))
                            <img src="{{ $photo }}" class="w-28 h-28 object-cover rounded-xl border border-slate-200 dark:border-slate-800" alt="Preview Foto">
                        @else
                            <img src="{{ $photo->temporaryUrl() }}" class="w-28 h-28 object-cover rounded-xl border border-slate-200 dark:border-slate-800" alt="Preview Foto">
                        @endif
                    </div>
                @endif
                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Foto</label>
                    <input type="file" wire:model="photo"
                        class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 dark:hover:file:bg-indigo-900/50 transition-all">
                    @error('photo') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    <div wire:loading wire:target="photo" class="mt-2 text-xs text-indigo-600 dark:text-indigo-400">Uploading...</div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                <button type="submit" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors gap-2 w-full sm:w-auto disabled:opacity-60 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4"></i> Simpan Profil</span>
                    <span wire:loading.flex wire:target="save" class="hidden items-center gap-2"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
