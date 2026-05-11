<div class="space-y-6 max-w-5xl">
    <!-- Section: General Settings -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                <i data-lucide="settings" class="w-6 h-6"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Pengaturan Umum</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Undangan (Internal)</label>
                    <input type="text" wire:model.defer="title" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Slug URL (u/slug-anda)</label>
                    <div class="relative">
                        <input type="text" wire:model.debounce.500ms="slug" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <p class="mt-2 text-[10px] font-medium {{ $button ? 'text-emerald-500' : 'text-rose-500' }}">{{ $pesan }}</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button wire:click="update('{{ $dataId }}')" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <!-- Section: WhatsApp Settings -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i data-lucide="message-circle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Pesan WhatsApp & Thumbnail</h3>
        </div>
        <div class="p-6 space-y-8">
            <!-- Thumbnail -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Thumbnail WA (OG Image)</label>
                    <p class="text-xs text-slate-400 mb-4">Gambar ini akan muncul saat link dibagikan di WhatsApp/Medsos.</p>
                </div>
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-6">
                        <div class="w-32 h-32 rounded-2xl bg-slate-100 dark:bg-slate-900 border-2 border-dashed border-slate-200 dark:border-slate-800 flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if ($gambar)
                                <img src="{{ $gambar->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($thumbnail)
                                <img src="{{ asset('storage/'.$thumbnail->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="image" class="w-8 h-8 text-slate-300"></i>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2">
                            <input type="file" wire:model="gambar" id="thumbnail-upload" class="hidden">
                            <label for="thumbnail-upload" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-lg cursor-pointer transition-all flex items-center gap-2">
                                <i data-lucide="upload" class="w-3.5 h-3.5"></i> Pilih Gambar
                            </label>
                            @if ($thumbnail)
                                <button wire:click="delThumbnail" class="px-4 py-2 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 text-xs font-bold rounded-lg hover:bg-rose-100 dark:hover:bg-rose-900/50 transition-all flex items-center gap-2">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                    @error('gambar') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                    <button wire:click="thumbnailWa" class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-lg hover:bg-emerald-700 transition-all">Simpan Thumbnail</button>
                </div>
            </div>

            <hr class="border-slate-100 dark:border-slate-700">

            <!-- Message Template -->
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Template Pesan Undangan</label>
                <textarea wire:model.defer="pesanWa" rows="6" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition-all font-mono"></textarea>
                <p class="mt-2 text-[10px] text-slate-400">Gunakan tag: <span class="font-bold text-emerald-500">@{{tamu}}</span>, <span class="font-bold text-emerald-500">@{{nama_mempelai1}}</span>, <span class="font-bold text-emerald-500">@{{nama_mempelai2}}</span>, <span class="font-bold text-emerald-500">@{{link}}</span></p>
                <div class="flex justify-end mt-4">
                    <button wire:click="teksWhatsApp" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-emerald-200 dark:shadow-none flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Template
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Typography -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <i data-lucide="type" class="w-6 h-6"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Tipografi (Font)</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Title Font -->
                <div class="space-y-4">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Font Judul / Nama</label>
                    <select wire:model="fontTitle" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                        @foreach($fonts as $f)
                            <option value="{{ $f->id }}">{{ $f->nama }}</option>
                        @endforeach
                    </select>
                    @if($selectedFont)
                        <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-700 text-center">
                            <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $selectedFont->nama) }}&display=swap" rel="stylesheet">
                            <span style="font-family: '{{ $selectedFont->nama }}'; font-size: {{ $sizeTitle }}px;" class="text-slate-800 dark:text-white">Contoh Judul</span>
                        </div>
                        <input type="range" wire:model="sizeTitle" min="12" max="100" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-amber-500">
                        <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <span>Kecil</span>
                            <span>Besar ({{ $sizeTitle }}px)</span>
                        </div>
                    @endif
                </div>

                <!-- Body Font -->
                <div class="space-y-4">
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Font Konten / Isi</label>
                    <select wire:model="fontPara" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                        @foreach($fonts as $f)
                            <option value="{{ $f->id }}">{{ $f->nama }}</option>
                        @endforeach
                    </select>
                    @if($selectedPara)
                        <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-700 text-center">
                            <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $selectedPara->nama) }}&display=swap" rel="stylesheet">
                            <span style="font-family: '{{ $selectedPara->nama }}'; font-size: {{ $sizePara }}px;" class="text-slate-800 dark:text-white">Ini adalah contoh teks isi atau paragraf undangan.</span>
                        </div>
                        <input type="range" wire:model="sizePara" min="8" max="32" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-amber-500">
                        <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <span>Kecil</span>
                            <span>Besar ({{ $sizePara }}px)</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button wire:click="updateFont('{{ $dataId }}')" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-amber-200 dark:shadow-none flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Terapkan Font
                </button>
            </div>
        </div>
    </div>

    <!-- Section: Words & Quotes -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400">
                <i data-lucide="quote" class="w-6 h-6"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Kata Mutiara (Quotes)</h3>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Judul / Sumber</label>
                <input type="text" wire:model.defer="tit" placeholder="QS. Ar-Rum: 21" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Isi Quote</label>
                <textarea wire:model.defer="qoute" rows="4" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all"></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Subtitle / Tambahan</label>
                <input type="text" wire:model.defer="subtitle" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all">
            </div>
            <div class="flex justify-end pt-2">
                <button wire:click="aksiQoute" class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-rose-200 dark:shadow-none flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Quote
                </button>
            </div>
        </div>
    </div>
</div>
