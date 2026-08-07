<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <h3 class="text-xl font-black text-slate-800 dark:text-white">Pilih Tema Undangan</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pilih desain terbaik yang sesuai dengan konsep
            acara Anda.</p>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3"
            role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 text-sm text-rose-800 rounded-xl bg-rose-50 dark:bg-rose-900/30 dark:text-rose-400 border border-rose-200 dark:border-rose-800 flex items-center gap-3"
            role="alert">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
            {{ session('error') }}
        </div>
    @endif

    @unless ($canShareInvitation)
        <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300 text-sm flex items-start gap-3">
            <i data-lucide="zap" class="w-5 h-5 mt-0.5"></i>
            <div>
                <p class="font-bold">Link undangan belum bisa dibagikan ke publik.</p>
                <p class="mt-1 text-blue-700 dark:text-blue-400">Upgrade ke premium untuk membagikan link undangan ke tamu anda. Namun, anda tetap dapat melihat preview dengan data anda sendiri.</p>
            </div>
        </div>
    @endunless

    <!-- Themes Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach ($tema as $item)
            @php
                $isSelected = $data->theme_id == $item->id;
                $pathParts = explode('.', $item->path);
                $themeKey = $pathParts[1] ?? \Illuminate\Support\Str::slug($item->nama, '');
                $fallbackImages = [
                    'flowerone' => 'tema/flowerone/img/foto-prewed.webp',
                    'standtheme' => 'tema/standtheme/assets/img/cover.jpg',
                    'darksweet' => 'tema/darksweet/img/wedding-potret.jpg',
                    'darkpre' => 'tema/darkpre/src/img/bg-kanan.jpg',
                    'whitepre' => 'tema/whitepre/src/img/bg-kanan.jpg',
                ];
                $fallbackImage = isset($fallbackImages[$themeKey])
                    ? asset($fallbackImages[$themeKey])
                    : 'https://placehold.co/600x800/6366f1/ffffff?text=' . urlencode($item->nama);

                // if ($item->thumbnail) {
                $previewImage = \Illuminate\Support\Facades\Storage::url($item->thumbnail);
                // } else {
                // $previewImage = $fallbackImage;
                // }
            @endphp
            <div wire:key="theme-{{ $item->id }}"
                class="group relative bg-white dark:bg-slate-900 rounded-3xl border {{ $isSelected ? 'border-indigo-600 ring-2 ring-indigo-500/20' : 'border-slate-200 dark:border-slate-800 shadow-sm' }} overflow-hidden hover:shadow-xl transition-all duration-300">
                <!-- Selection Badge -->
                @if ($isSelected)
                    <div class="absolute top-4 right-4 z-10 bg-indigo-600 text-white p-1.5 rounded-full shadow-lg">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </div>
                @endif
                <div class="aspect-[3/4] overflow-hidden relative bg-slate-100 dark:bg-slate-800">
                    @if ($previewImage)
                        <img src="{{ $previewImage }}" alt="{{ $item->nama }}"
                            onerror="this.onerror=null; this.src='{{ $fallbackImage }}';"
                            class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center">
                            <i data-lucide="image" class="w-12 h-12 text-slate-300 mb-4"></i>
                            <span class="text-xs font-medium text-slate-400">Preview Tidak Tersedia</span>
                        </div>
                    @endif
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <div class="flex gap-2">
                            <a href="{{ $this->previewUrl($item->path) }}"
                                target="_blank"
                                class="flex-1 py-2 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-xl hover:bg-white/40 transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="eye" class="w-4 h-4"></i> Demo
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-800 dark:text-white">{{ $item->nama }}</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">
                                {{ $item->category->category ?? 'Umum' }}</p>
                        </div>
                        @if ($canPreview)
                            <a href="{{ $this->previewUrl($item->path) }}" target="_blank" class="p-2 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors" title="Lihat Preview">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                    <div class="flex mt-2 flex-col sm:flex-row items-end sm:items-center gap-2">
                        @if ($isSelected)
                            <button type="button" wire:click="review" wire:loading.attr="disabled" wire:target="review"
                                class="px-4 py-2 {{ $canShareInvitation ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed' }} text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                                <i wire:loading.remove wire:target="review" data-lucide="{{ $canShareInvitation ? 'eye' : 'lock' }}" class="w-4 h-4"></i>
                                <i wire:loading wire:target="review" data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                                <span wire:loading.remove wire:target="review">Review</span>
                                <span wire:loading wire:target="review">Mengecek...</span>
                            </button>
                        @endif
                        <button wire:click="choose({{ $item->id }})" wire:loading.attr="disabled" wire:target="choose({{ $item->id }})"
                            class="px-4 py-2 {{ $isSelected ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-indigo-600 hover:text-white' }} text-xs font-bold rounded-xl transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="choose({{ $item->id }})">{{ $isSelected ? 'Terpilih' : 'Pilih' }}</span>
                            <span wire:loading.flex wire:target="choose({{ $item->id }})" class="hidden items-center gap-1.5"><i data-lucide="loader-2" class="w-3.5 h-3.5 animate-spin"></i> Memilih...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('morph.updated', ({ el }) => {
            if (typeof lucide === 'undefined') {
                return;
            }

            lucide.createIcons({ nodes: [el] });
        });

        Livewire.on('open-new-tab', (event) => {
            const url = event.url || event[0]?.url;
            if (url) {
                window.open(url, '_blank');
            }
        });
    });
</script>
