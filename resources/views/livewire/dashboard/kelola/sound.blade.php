<div class="space-y-6" x-data="{ playing: null }">
    <!-- Header Section -->
    <div
        class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h3 class="text-xl font-black text-slate-800 dark:text-white">Latar Musik</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Pilih alunan musik yang sempurna untuk melengkapi momen
                spesial Anda.</p>
        </div>
        <div
            class="flex items-center gap-4 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aktifkan Musik:</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:click="switch('{{ $dataId }}', {{ $isChecked ? 'false' : 'true' }})"
                    class="sr-only peer" {{ $isChecked ? 'checked' : '' }}>
                <div
                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600">
                </div>
            </label>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3"
            role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Previews & Status -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Source Selector -->
            <div
                class="bg-white dark:bg-slate-900 p-2 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm flex items-center">
                <button wire:click="$set('tab', 'library')"
                    class="flex-1 py-3 px-4 rounded-[1.75rem] text-sm font-black transition-all flex items-center justify-center gap-2 {{ $tab === 'library' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-500 hover:bg-slate-50' }}">
                    <i data-lucide="library" class="w-4 h-4"></i> Pustaka
                </button>
                <button wire:click="$set('tab', 'youtube')"
                    class="flex-1 py-3 px-4 rounded-[1.75rem] text-sm font-black transition-all flex items-center justify-center gap-2 {{ $tab === 'youtube' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-500 hover:bg-slate-50' }}">
                    <i data-lucide="youtube" class="w-4 h-4"></i> YouTube
                </button>
            </div>

            <!-- Temporary Preview Card -->
            @if ($previewUrl)
                <div
                    class="bg-white dark:bg-slate-900 p-6 rounded-3xl border-2 border-indigo-500 shadow-xl shadow-indigo-100 dark:shadow-none animate-in fade-in slide-in-from-bottom-4 duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span
                                class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-full uppercase tracking-widest">Preview
                                Pilihan</span>
                            @if ($previewType === 'library')
                                <span
                                    class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest">Pustaka</span>
                            @endif
                        </div>
                        <button wire:click="$set('previewUrl', null)"
                            class="text-slate-400 hover:text-rose-500 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>

                    @if ($previewType === 'youtube')
                        <div class="aspect-video rounded-2xl overflow-hidden bg-slate-900 mb-6">
                            <iframe src="{{ $previewUrl }}" class="w-full h-full" frameborder="0"
                                allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                        @if ($selectM)
                            <div
                                class="mb-6 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <h5 class="font-bold text-slate-800 dark:text-white text-sm truncate">
                                    {{ $selectM->judul }}</h5>
                                <p class="text-xs text-slate-500 truncate">{{ $selectM->artis }}</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-2xl mb-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                    <i data-lucide="music" class="w-6 h-6 animate-pulse"></i>
                                </div>
                                <div class="min-w-0">
                                    <h5 class="font-bold text-slate-800 dark:text-white truncate">
                                        {{ $selectM->judul ?? 'Musik Terpilih' }}</h5>
                                    <p class="text-xs text-slate-500 truncate">{{ $selectM->artis ?? 'Pustaka Musik' }}
                                    </p>
                                </div>
                            </div>
                            <audio controls class="w-full h-8" autoplay>
                                <source src="{{ $previewUrl }}" type="audio/mpeg">
                            </audio>
                        </div>
                    @endif

                    <div class="mb-6">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Mulai
                            dari Detik ke-</label>
                        <div class="relative">
                            <i data-lucide="timer"
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="number" wire:model.live.debounce.500ms="detik"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[1.25rem] text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                        </div>
                        <p class="text-[9px] text-slate-400 mt-2 italic">* Angka ini akan otomatis diupdate ke link
                            youtube</p>
                    </div>

                    <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                        class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                        <i wire:loading.remove wire:target="save" data-lucide="check-circle" class="w-5 h-5"></i>
                        <i wire:loading wire:target="save" data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>
                        <span wire:loading.remove wire:target="save">Simpan Pilihan Musik</span>
                        <span wire:loading.flex wire:target="save" class="hidden">Menyimpan...</span>
                    </button>
                </div>
            @endif

            <!-- Active Music Card -->
            @if ($sound && $sound->sound)
                <div class="bg-indigo-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
                    <div
                        class="absolute -right-8 -bottom-8 w-32 h-32 bg-indigo-800 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></div>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Musik Aktif
                                Sekarang</span>
                        </div>

                        @if (str_contains($sound->sound, 'youtube.com'))
                            <div
                                class="aspect-video rounded-2xl overflow-hidden bg-slate-900 mb-6 border border-white/10 shadow-lg">
                                <iframe
                                    src="{{ $sound->sound . ($sound->start > 0 ? (str_contains($sound->sound, '?') ? '&' : '?') . 'start=' . $sound->start : '') }}"
                                    class="w-full h-full" frameborder="0" allow="autoplay; encrypted-media"
                                    allowfullscreen></iframe>
                            </div>
                        @endif

                        <div class="flex items-center gap-5 mb-8">
                            @if ($currentMusic)
                                <div
                                    class="w-14 h-14 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center border border-white/20">
                                    <i data-lucide="music" class="w-8 h-8 text-white"></i>
                                </div>
                                <div class="min-w-0">
                                    <h5 class="text-md font-black truncate">{{ $currentMusic->judul }}</h5>
                                    <p class="text-xs font-bold opacity-60">{{ $currentMusic->artis }}</p>
                                    <p class="text-[10px] font-bold opacity-40 mt-1 uppercase tracking-widest">Mulai:
                                        {{ $sound->start }}s</p>
                                </div>
                            @else
                                <div
                                    class="w-14 h-14 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center border border-white/20">
                                    <i data-lucide="disc" class="w-8 h-8 animate-[spin_4s_linear_infinite]"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-medium opacity-60">Status</p>
                                    <h5 class="text-lg font-black truncate">Custom Musik</h5>
                                    <p class="text-[10px] font-bold opacity-60 mt-1">Mulai: {{ $sound->start ?? 0 }}s
                                    </p>
                                </div>
                            @endif
                        </div>

                        <button wire:click="delete({{ $sound->id }})"
                            class="w-full py-3 bg-white/10 hover:bg-rose-500 hover:text-white text-white/80 text-xs font-bold rounded-2xl transition-all border border-white/10 flex items-center justify-center gap-2">
                            <i data-lucide="trash-2" class="w-4 h-4"></i> Lepas Musik Ini
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Options -->
        <div class="lg:col-span-8 relative min-h-[600px] flex flex-col" wire:key="right-column-{{ $tab }}">
            <!-- Loading Overlay -->
            <div wire:loading wire:target="tab, query, gotoPage, nextPage, previousPage"
                class="mt-10 absolute inset-0 z-[100] bg-white/60 dark:bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] flex flex-col items-center justify-center animate-in fade-in duration-300">
                <div class="flex flex-col items-center justify-center gap-6">
                    <div class="relative">
                        <div
                            class="w-16 h-16 border-4 border-indigo-600/10 border-t-indigo-600 rounded-full animate-spin">
                        </div>
                        <i data-lucide="music"
                            class="w-6 h-6 text-indigo-600 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-pulse"></i>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <span
                            class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em] animate-pulse">Memuat
                            Konten</span>
                        <div class="flex gap-1">
                            <div class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.3s]">
                            </div>
                            <div
                                class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.15s]">
                            </div>
                            <div class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-init="lucide.createIcons()" class="flex-1">
                @if ($tab === 'library')
                    <!-- Music Library -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden animate-in fade-in zoom-in-95 duration-300 h-full">
                        <div
                            class="p-8 border-b border-slate-100 dark:border-slate-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div>
                                <h4
                                    class="text-lg font-black text-slate-800 dark:text-white flex items-center gap-3 uppercase tracking-tight">
                                    <i data-lucide="library" class="w-6 h-6 text-indigo-500"></i>
                                    Pustaka Musik
                                </h4>
                                <p class="text-xs text-slate-500 mt-1">Pilih dari koleksi musik premium kami.</p>
                            </div>
                            <div class="relative w-full md:w-80">
                                <i data-lucide="search"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                <input type="text" wire:model.live.debounce.500ms="query"
                                    placeholder="Cari judul lagu atau penyanyi..."
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[1.25rem] text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>

                        <div class="divide-y divide-slate-50 dark:divide-slate-800" x-init="lucide.createIcons()">
                            @forelse($musik as $item)
                                @php $isSelected = $previewUrl && $selectM && $selectM->id == $item->id; @endphp
                                <div class="p-5 flex items-center justify-between {{ $isSelected ? 'bg-indigo-50/50 dark:bg-indigo-900/20' : 'hover:bg-slate-50/80 dark:hover:bg-slate-800/30' }} transition-all group"
                                    wire:key="music-item-{{ $item->id }}">
                                    <div class="flex items-center gap-5 min-w-0">
                                        <div
                                            class="w-12 h-12 rounded-2xl {{ $isSelected ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-slate-50 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400' }} border border-slate-100 dark:border-slate-800 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-300 shadow-sm">
                                            <i data-lucide="{{ $isSelected ? 'volume-2' : 'music-2' }}"
                                                class="w-6 h-6"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <h5
                                                    class="text-sm font-black {{ $isSelected ? 'text-indigo-600' : 'text-slate-800 dark:text-white' }} group-hover:text-indigo-600 transition-colors">
                                                    {{ $item->judul }}</h5>
                                                @if ($isSelected)
                                                    <span
                                                        class="text-[9px] font-black bg-indigo-600 text-white px-1.5 py-0.5 rounded-md uppercase tracking-widest">Terpilih</span>
                                                @endif
                                            </div>
                                            <p class="text-xs font-bold text-slate-400 mt-0.5">{{ $item->artis }}
                                                <span class="mx-1 text-slate-300">•</span> {{ $item->category }}</p>
                                        </div>
                                    </div>
                                    <button wire:click="selectMusic({{ $item->id }})"
                                        class="px-6 py-2.5 {{ $isSelected ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-indigo-600 hover:text-white border border-slate-200 dark:border-slate-700' }} text-xs font-black rounded-xl transition-all flex items-center gap-2">
                                        <i data-lucide="{{ $isSelected ? 'check' : 'play-circle' }}"
                                            class="w-4 h-4"></i> {{ $isSelected ? 'Terpilih' : 'Preview' }}
                                    </button>
                                </div>
                            @empty
                                <div class="p-20 text-center">
                                    <i data-lucide="music-2" class="w-12 h-12 text-slate-200 mx-auto mb-4"></i>
                                    <p class="text-slate-400 font-bold">Musik tidak ditemukan</p>
                                </div>
                            @endforelse
                        </div>

                        <div
                            class="p-6 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-800 mt-auto">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                    Menampilkan {{ $musik->firstItem() }}-{{ $musik->lastItem() }} dari
                                    {{ $musik->total() }} Musik
                                </div>
                                <div class="flex items-center gap-1">
                                    @if ($musik->onFirstPage())
                                        <span
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-300 cursor-not-allowed">
                                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                        </span>
                                    @else
                                        <button wire:click="previousPage"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-indigo-600 hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-700">
                                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                        </button>
                                    @endif

                                    @foreach ($musik->getUrlRange(max(1, $musik->currentPage() - 1), min($musik->lastPage(), $musik->currentPage() + 1)) as $page => $url)
                                        <button wire:click="gotoPage({{ $page }})"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl text-xs font-black transition-all {{ $page == $musik->currentPage() ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 border border-slate-200 dark:border-slate-700' }}">
                                            {{ $page }}
                                        </button>
                                    @endforeach

                                    @if ($musik->hasMorePages())
                                        <button wire:click="nextPage"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-indigo-600 hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-700">
                                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                        </button>
                                    @else
                                        <span
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-300 cursor-not-allowed">
                                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Custom YouTube Option -->
                    <div
                        class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-sm animate-in fade-in zoom-in-95 duration-300 h-full flex flex-col justify-center">
                        <div class="flex items-center gap-6 mb-10">
                            <div
                                class="w-20 h-20 rounded-3xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400 shadow-sm group">
                                <i data-lucide="youtube"
                                    class="w-10 h-10 group-hover:scale-110 transition-transform duration-500"></i>
                            </div>
                            <div>
                                <h4
                                    class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight">
                                    Input Link YouTube Kustom</h4>
                                <p class="text-sm text-slate-500">Gunakan musik dari video YouTube favorit Anda secara
                                    instan.</p>
                            </div>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Link
                                    Video YouTube</label>
                                <div class="relative">
                                    <i data-lucide="link"
                                        class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-slate-400"></i>
                                    <input type="text" wire:model.live.debounce.1000ms="youtube"
                                        placeholder="https://youtube.com/watch?v=..."
                                        class="w-full pl-14 pr-6 py-5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2rem] text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm font-medium">
                                </div>
                                <div
                                    class="mt-6 p-5 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-dashed border-slate-200 dark:border-slate-700 flex items-start gap-4">
                                    <i data-lucide="info" class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5"></i>
                                    <p class="text-xs text-slate-500 leading-relaxed">
                                        <b>Tips:</b> Anda bisa menyalin link dari browser atau tombol share di aplikasi
                                        YouTube. Sistem kami mendukung format link standar, pendek (youtu.be), maupun
                                        Shorts.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    document.addEventListener('livewire:init', () => {
        Livewire.hook('request', ({
            component,
            commit,
            respond,
            succeed,
            fail
        }) => {
            succeed(({
                snapshot,
                effect
            }) => {
                queueMicrotask(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                })
            })
        })
    });
</script>t>t>

 
 < s c r i p t > 
             d o c u m e n t . a d d E v e n t L i s t e n e r ( ' l i v e w i r e : u p d a t e d ' ,   ( )   = >   { 
                     i f   ( t y p e o f   l u c i d e   ! = =   ' u n d e f i n e d ' )   { 
                             l u c i d e . c r e a t e I c o n s ( ) ; 
                     } 
             } ) ; 
     <  / s c r i p t > 
         
         
