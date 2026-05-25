<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Setting System</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Atur identitas website, logo, icon, serta metadata SEO untuk optimasi mesin pencari.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Card Identitas Website -->
            <x-ui.card padding="p-6">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div class="w-8 h-8 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg flex items-center justify-center">
                        <i data-lucide="layout" class="w-4.5 h-4.5"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 dark:text-white text-base">Identitas Website</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-ui.input label="Nama Aplikasi / Website" wire:model="app_name" icon="globe" placeholder="Masukkan nama aplikasi..." />
                        @error('app_name') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Logo Website</label>
                        <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                            <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-contain p-1" alt="Preview Logo">
                                @elseif ($old_logo)
                                    <img src="{{ asset('storage/' . $old_logo) }}" class="w-full h-full object-contain p-1" alt="Current Logo">
                                @else
                                    <i data-lucide="image" class="w-6 h-6 text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <input type="file" wire:model="logo" id="logo-upload" class="hidden" accept="image/*">
                                <label for="logo-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer transition-colors shadow-sm">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                    Pilih File Logo
                                </label>
                                <div wire:loading wire:target="logo" class="text-[10px] text-indigo-600 dark:text-indigo-400 mt-1 block font-medium">Mengunggah...</div>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 truncate">Format: PNG, JPG, GIF (Maks. 2MB)</p>
                            </div>
                        </div>
                        @error('logo') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Favicon Upload -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Favicon (Icon Browser)</label>
                        <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if ($favicon)
                                    <img src="{{ $favicon->temporaryUrl() }}" class="w-full h-full object-contain p-1" alt="Preview Favicon">
                                @elseif ($old_favicon)
                                    <img src="{{ asset('storage/' . $old_favicon) }}" class="w-full h-full object-contain p-1" alt="Current Favicon">
                                @else
                                    <i data-lucide="globe" class="w-5 h-5 text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <input type="file" wire:model="favicon" id="favicon-upload" class="hidden" accept="image/*">
                                <label for="favicon-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer transition-colors shadow-sm">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i>
                                    Pilih Icon
                                </label>
                                <div wire:loading wire:target="favicon" class="text-[10px] text-indigo-600 dark:text-indigo-400 mt-1 block font-medium">Mengunggah...</div>
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 truncate">Format: PNG, ICO (Rekomendasi 1:1, Maks. 1MB)</p>
                            </div>
                        </div>
                        @error('favicon') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-ui.card>

            <!-- Card Metadata SEO -->
            <x-ui.card padding="p-6">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div class="w-8 h-8 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg flex items-center justify-center">
                        <i data-lucide="search" class="w-4.5 h-4.5"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 dark:text-white text-base">Konfigurasi SEO</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-ui.input label="Judul SEO (Meta Title)" wire:model="seo_title" icon="tag" placeholder="Contoh: Undangan Digital Premium & Elegan" />
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">Judul yang akan muncul di hasil pencarian Google.</p>
                        @error('seo_title') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-ui.textarea label="Kata Kunci SEO (Meta Keywords)" wire:model="seo_keywords" rows="2" placeholder="undangan digital, undangan online, website pernikahan, cetak undangan..." />
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">Pisahkan kata kunci dengan tanda koma (,).</p>
                        @error('seo_keywords') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-ui.textarea label="Deskripsi SEO (Meta Description)" wire:model="seo_description" rows="3" placeholder="Buat undangan digital pernikahan online yang indah, elegan, dan kaya fitur hanya dalam beberapa menit..." />
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">Rangkuman singkat tentang website untuk menarik pengunjung di hasil pencarian.</p>
                        @error('seo_description') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
            <x-ui.button variant="primary" type="submit" icon="save">
                Simpan Pengaturan
            </x-ui.button>
        </div>
    </form>
</div>
