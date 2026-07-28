<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Setting System & Identitas Website</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola identitas brand, logo, favicon, SEO meta tags, dan pratinjau media sosial terpusat.</p>
        </div>
        <div>
            <button
                type="button"
                wire:click="save"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md transition-all disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Semua Pengaturan
                </span>
                <span wire:loading.inline-flex wire:target="save" class="items-center gap-2">
                    <x-loading-spinner class="w-4 h-4 text-white" />
                    <span>Menyimpan...</span>
                </span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-2xl border border-emerald-200 dark:border-emerald-700 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400"></i>
            <span class="text-sm font-semibold">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 rounded-2xl border border-rose-200 dark:border-rose-700 flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 text-rose-600 dark:text-rose-400"></i>
            <span class="text-sm font-semibold">{{ session('error') }}</span>
        </div>
    @endif

    <form wire:submit="save" class="space-y-8">
        <!-- 1. IDENTITAS WEBSITE -->
        <x-ui.card padding="p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-9 h-9 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center">
                    <i data-lucide="layout" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">1. Identitas Website & Branding</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Atur nama aplikasi, logo light/dark, favicon browser, dan Apple touch icon.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- App Name -->
                <div class="md:col-span-2">
                    <x-ui.input label="Nama Aplikasi / Brand Website" wire:model="app_name" icon="globe" placeholder="Masukkan nama aplikasi (misal: WayaeNikah)..." />
                    @error('app_name') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Logo Utama -->
                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Logo Utama (Light Mode)</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center p-2 overflow-hidden flex-shrink-0 shadow-sm">
                            @if ($logo)
                                <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-contain" alt="Preview Logo">
                            @elseif ($old_logo)
                                <img src="{{ $setting->logo_url }}" class="w-full h-full object-contain" alt="Logo Utama">
                            @else
                                <i data-lucide="image" class="w-8 h-8 text-slate-300 dark:text-slate-600"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" wire:model="logo" id="logo-upload" class="hidden" accept="image/*">
                            <div class="flex flex-wrap gap-2">
                                <label for="logo-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer shadow-sm">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i> Unggah Logo
                                </label>
                                @if($old_logo)
                                    <button type="button" wire:click="deleteImage('logo')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-semibold">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                    </button>
                                @endif
                            </div>
                            <div wire:loading wire:target="logo" class="text-xs text-indigo-600 mt-1 font-semibold">Mengunggah logo...</div>
                            <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, SVG, WEBP (Maks. 2MB)</p>
                        </div>
                    </div>
                    @error('logo') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Logo Dark -->
                <div class="p-4 bg-slate-900 rounded-2xl border border-slate-800">
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Logo Dark Mode (Opsional)</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-slate-950 rounded-xl border border-slate-800 flex items-center justify-center p-2 overflow-hidden flex-shrink-0 shadow-sm">
                            @if ($logo_dark)
                                <img src="{{ $logo_dark->temporaryUrl() }}" class="w-full h-full object-contain" alt="Preview Logo Dark">
                            @elseif ($old_logo_dark)
                                <img src="{{ $setting->logo_dark_url }}" class="w-full h-full object-contain" alt="Logo Dark">
                            @else
                                <i data-lucide="image" class="w-8 h-8 text-slate-600"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" wire:model="logo_dark" id="logo-dark-upload" class="hidden" accept="image/*">
                            <div class="flex flex-wrap gap-2">
                                <label for="logo-dark-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-xs font-semibold text-slate-200 hover:bg-slate-700 cursor-pointer shadow-sm">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i> Unggah Logo Dark
                                </label>
                                @if($old_logo_dark)
                                    <button type="button" wire:click="deleteImage('logo_dark')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-950 text-rose-400 hover:bg-rose-900 text-xs font-semibold">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                    </button>
                                @endif
                            </div>
                            <div wire:loading wire:target="logo_dark" class="text-xs text-indigo-400 mt-1 font-semibold">Mengunggah...</div>
                            <p class="text-[11px] text-slate-400 mt-1">Gunakan background transparan</p>
                        </div>
                    </div>
                    @error('logo_dark') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Favicon Browser -->
                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Favicon (Icon Tab Browser)</label>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center p-2 overflow-hidden flex-shrink-0 shadow-sm">
                            @if ($favicon)
                                <img src="{{ $favicon->temporaryUrl() }}" class="w-full h-full object-contain" alt="Preview Favicon">
                            @else
                                <img src="{{ $setting->favicon_url }}" class="w-full h-full object-contain" alt="Favicon">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" wire:model="favicon" id="favicon-upload" class="hidden" accept="image/*,.ico">
                            <div class="flex flex-wrap gap-2">
                                <label for="favicon-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer shadow-sm">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i> Unggah Favicon
                                </label>
                                @if($old_favicon)
                                    <button type="button" wire:click="deleteImage('favicon')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-semibold">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                    </button>
                                @endif
                            </div>
                            <div wire:loading wire:target="favicon" class="text-xs text-indigo-600 mt-1 font-semibold">Mengunggah favicon...</div>
                            <p class="text-[11px] text-slate-400 mt-1">Rekomendasi ICO / PNG rasio 1:1 (32x32px)</p>
                        </div>
                    </div>
                    @error('favicon') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Apple Touch Icon -->
                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Apple Touch Icon (iOS Shortcut)</label>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center p-2 overflow-hidden flex-shrink-0 shadow-sm">
                            @if ($apple_touch_icon)
                                <img src="{{ $apple_touch_icon->temporaryUrl() }}" class="w-full h-full object-contain" alt="Preview Apple Touch">
                            @elseif ($old_apple_touch_icon)
                                <img src="{{ $setting->apple_touch_icon_url }}" class="w-full h-full object-contain" alt="Apple Touch Icon">
                            @else
                                <i data-lucide="smartphone" class="w-6 h-6 text-slate-300 dark:text-slate-600"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <input type="file" wire:model="apple_touch_icon" id="apple-touch-upload" class="hidden" accept="image/*">
                            <div class="flex flex-wrap gap-2">
                                <label for="apple-touch-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer shadow-sm">
                                    <i data-lucide="upload" class="w-3.5 h-3.5"></i> Unggah Icon iOS
                                </label>
                                @if($old_apple_touch_icon)
                                    <button type="button" wire:click="deleteImage('apple_touch_icon')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-semibold">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                    </button>
                                @endif
                            </div>
                            <div wire:loading wire:target="apple_touch_icon" class="text-xs text-indigo-600 mt-1 font-semibold">Mengunggah icon iOS...</div>
                            <p class="text-[11px] text-slate-400 mt-1">PNG rasio 1:1 (Rekomendasi 180x180px)</p>
                        </div>
                    </div>
                    @error('apple_touch_icon') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
        </x-ui.card>

        <!-- 2. SEO DASAR -->
        <x-ui.card padding="p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-9 h-9 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">2. Konfigurasi SEO Dasar (Search Engine Optimization)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Metadata utama untuk optimasi peringkat di mesin pencari Google.</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- Meta Title -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Judul SEO Global (Meta Title)</label>
                        @php $titleLen = strlen($seo_title ?? ''); @endphp
                        <span class="text-xs font-semibold {{ $titleLen > 60 ? 'text-amber-600 dark:text-amber-400' : 'text-slate-400' }}">
                            {{ $titleLen }} / 60 Karakter (Rekomendasi 50-60)
                        </span>
                    </div>
                    <x-ui.input wire:model.live="seo_title" placeholder="Contoh: WayaeNikah - Undangan Digital Premium & Cetak Fisik..." />
                    @error('seo_title') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Meta Description -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Deskripsi SEO Global (Meta Description)</label>
                        @php $descLen = strlen($seo_description ?? ''); @endphp
                        <span class="text-xs font-semibold {{ $descLen > 160 ? 'text-amber-600 dark:text-amber-400' : 'text-slate-400' }}">
                            {{ $descLen }} / 160 Karakter (Rekomendasi 140-160)
                        </span>
                    </div>
                    <x-ui.textarea wire:model.live="seo_description" rows="3" placeholder="Rangkuman menarik mengenai platform undangan pernikahan digital & cetak fisik..." />
                    @error('seo_description') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Keywords -->
                    <div>
                        <x-ui.textarea label="Kata Kunci SEO (Meta Keywords)" wire:model="seo_keywords" rows="2" placeholder="undangan digital, undangan cetak, wayaenikah, cetak undangan..." />
                        <p class="text-[11px] text-slate-400 mt-1">Pisahkan dengan koma (,)</p>
                        @error('seo_keywords') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Author & Google Site Verification -->
                    <div class="space-y-4">
                        <div>
                            <x-ui.input label="Penulis Meta (SEO Author)" wire:model="seo_author" placeholder="WayaeNikah Team" />
                            @error('seo_author') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-ui.input label="Kode Google Site Verification" wire:model="google_site_verification" placeholder="google-site-verification=xxxx..." />
                            @error('google_site_verification') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- 3. SEARCH ENGINE ROBOTS INDEX / FOLLOW -->
        <x-ui.card padding="p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-9 h-9 bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center">
                    <i data-lucide="bot" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">3. Pengaturan Indeks Mesin Pencari (Search Engine Robots)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Kontrol visibilitas landing page publik di Google dan Bing.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-start gap-4">
                    <input type="checkbox" wire:model="seo_robots_index" id="seo_robots_index" class="mt-1 h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <label for="seo_robots_index" class="font-bold text-slate-900 dark:text-white text-sm cursor-pointer">Izinkan Indeks (INDEX)</label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Memungkinkan mesin pencari menampilkan landing page publik di hasil pencarian.</p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-start gap-4">
                    <input type="checkbox" wire:model="seo_robots_follow" id="seo_robots_follow" class="mt-1 h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <label for="seo_robots_follow" class="font-bold text-slate-900 dark:text-white text-sm cursor-pointer">Izinkan Penelusuran Link (FOLLOW)</label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Memungkinkan web crawler mengikuti link-link internal yang ada pada landing page.</p>
                    </div>
                </div>
            </div>

            @if(!$seo_robots_index)
                <div class="mt-4 p-3.5 bg-amber-50 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 rounded-xl border border-amber-200 dark:border-amber-700 text-xs font-semibold flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 flex-shrink-0"></i>
                    <span>Peringatan: Menonaktifkan INDEX akan menyembunyikan website Anda dari hasil pencarian Google!</span>
                </div>
            @endif
        </x-ui.card>

        <!-- 4. SOCIAL SHARING (OPEN GRAPH & TWITTER) -->
        <x-ui.card padding="p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-9 h-9 bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center">
                    <i data-lucide="share-2" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">4. Social Media Sharing Metadata (Open Graph & Twitter Cards)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Atur tampilan link pratinjau saat dibagikan ke WhatsApp, Facebook, dan X (Twitter).</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Open Graph (Facebook / WA) -->
                <div class="space-y-4 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm flex items-center gap-2">
                        <i data-lucide="facebook" class="w-4 h-4 text-blue-600"></i> Open Graph (Facebook / WhatsApp)
                    </h4>
                    <div>
                        <x-ui.input label="OG Title" wire:model.live="og_title" placeholder="Judul pratinjau media sosial..." />
                    </div>
                    <div>
                        <x-ui.textarea label="OG Description" wire:model.live="og_description" rows="2" placeholder="Deskripsi pratinjau media sosial..." />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">OG Image (Gambar Pratinjau WA/FB)</label>
                        <div class="flex items-center gap-4">
                            <div class="w-24 h-16 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center p-1 overflow-hidden flex-shrink-0 shadow-sm">
                                @if ($og_image)
                                    <img src="{{ $og_image->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg" alt="Preview OG">
                                @elseif ($old_og_image)
                                    <img src="{{ $setting->og_image_url }}" class="w-full h-full object-cover rounded-lg" alt="OG Image">
                                @else
                                    <i data-lucide="image" class="w-6 h-6 text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <input type="file" wire:model="og_image" id="og-image-upload" class="hidden" accept="image/*">
                                <div class="flex flex-wrap gap-2">
                                    <label for="og-image-upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer shadow-sm">
                                        <i data-lucide="upload" class="w-3.5 h-3.5"></i> Unggah OG Image
                                    </label>
                                    @if($old_og_image)
                                        <button type="button" wire:click="deleteImage('og_image')" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-semibold">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                                <div wire:loading wire:target="og_image" class="text-xs text-indigo-600 mt-1 font-semibold">Mengunggah...</div>
                                <p class="text-[11px] text-slate-400 mt-1">Rekomendasi 1200x630px (Maks. 4MB)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Twitter Cards -->
                <div class="space-y-4 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm flex items-center gap-2">
                        <i data-lucide="twitter" class="w-4 h-4 text-sky-500"></i> Twitter Card (X)
                    </h4>
                    <div>
                        <x-ui.input label="Twitter Title" wire:model.live="twitter_title" placeholder="Judul pratinjau Twitter..." />
                    </div>
                    <div>
                        <x-ui.textarea label="Twitter Description" wire:model.live="twitter_description" rows="2" placeholder="Deskripsi pratinjau Twitter..." />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">Tipe Card Twitter</label>
                        <select wire:model="twitter_card" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:ring-indigo-500">
                            <option value="summary_large_image">Summary Large Image (Rekomendasi Gambar Besar)</option>
                            <option value="summary">Summary (Gambar Kecil)</option>
                        </select>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- 5. PREVIEW PRATINJAU REALTIME -->
        <x-ui.card padding="p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-9 h-9 bg-sky-50 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400 rounded-xl flex items-center justify-center">
                    <i data-lucide="eye" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">5. Live Preview (Pratinjau Realtime)</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Simulasi tampilan website di Google Search & Media Sosial.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Google Search Card Preview -->
                <div class="p-5 bg-white dark:bg-slate-950 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Simulasi Google Search</span>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                            <span class="font-medium truncate max-w-[200px]">{{ url('/') }}</span>
                            <span>&rsaquo;</span>
                        </div>
                        <h4 class="text-lg font-semibold text-blue-600 dark:text-blue-400 hover:underline cursor-pointer line-clamp-1">
                            {{ $seo_title ?: ($app_name . ' - Undangan Digital Premium') }}
                        </h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-2">
                            {{ $seo_description ?: 'Buat undangan pernikahan digital & fisik yang indah dan elegan hanya dalam beberapa menit.' }}
                        </p>
                    </div>
                </div>

                <!-- Social Card Preview -->
                <div class="p-5 bg-white dark:bg-slate-950 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="share-2" class="w-4 h-4 text-slate-400"></i>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Simulasi WhatsApp / Social Share</span>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900">
                        <div class="aspect-[12/6] w-full bg-slate-200 dark:bg-slate-800 overflow-hidden flex items-center justify-center">
                            @if($og_image)
                                <img src="{{ $og_image->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Share">
                            @elseif($old_og_image)
                                <img src="{{ $setting->og_image_url }}" class="w-full h-full object-cover" alt="Preview Share">
                            @else
                                <div class="text-slate-400 text-xs font-semibold flex items-center gap-2">
                                    <i data-lucide="image" class="w-5 h-5"></i> Tanpa Gambar Share
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ parse_url(url('/'), PHP_URL_HOST) }}</span>
                            <h5 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-1">
                                {{ $og_title ?: ($seo_title ?: $app_name) }}
                            </h5>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-0.5">
                                {{ $og_description ?: ($seo_description ?: 'Platform pembuatan undangan digital & cetak fisik.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- Save Floating Footer Bar -->
        <div class="sticky bottom-4 z-20 p-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <i data-lucide="info" class="w-4 h-4 text-indigo-500"></i>
                <span>Perubahan akan langsung memperbarui cache settings secara otomatis.</span>
            </div>
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md transition-all disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </span>
                <span wire:loading.inline-flex wire:target="save" class="items-center gap-2">
                    <x-loading-spinner class="w-4 h-4 text-white" />
                    <span>Menyimpan...</span>
                </span>
            </button>
        </div>
    </form>
</div>
