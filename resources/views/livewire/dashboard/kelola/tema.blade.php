<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <h3 class="text-xl font-black text-slate-800 dark:text-white">Pilih Tema Undangan</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pilih desain terbaik yang sesuai dengan konsep pernikahan Anda.</p>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Themes Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach ($tema as $item)
            @php $isSelected = ($data->theme_id == $item->id); @endphp
            <div class="group relative bg-white dark:bg-slate-900 rounded-3xl border {{ $isSelected ? 'border-indigo-600 ring-2 ring-indigo-500/20' : 'border-slate-200 dark:border-slate-800 shadow-sm' }} overflow-hidden hover:shadow-xl transition-all duration-300">
                <!-- Selection Badge -->
                @if($isSelected)
                    <div class="absolute top-4 right-4 z-10 bg-indigo-600 text-white p-1.5 rounded-full shadow-lg">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </div>
                @endif

                <div class="aspect-[3/4] overflow-hidden relative bg-slate-100 dark:bg-slate-800">
                    @if($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" 
                             onerror="this.src='https://placehold.co/600x800/6366f1/ffffff?text={{ urlencode($item->nama) }}'"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center">
                            <i data-lucide="image" class="w-12 h-12 text-slate-300 mb-4"></i>
                            <span class="text-xs font-medium text-slate-400">Preview Tidak Tersedia</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                        <div class="flex gap-2">
                            <a href="{{ route('dashboard.demo', ['demo' => Crypt::encryptString($item->path), 'id' => $data->uid]) }}" target="_blank"
                                class="flex-1 py-2 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-xl hover:bg-white/40 transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="eye" class="w-4 h-4"></i> Demo
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <h4 class="font-bold text-slate-800 dark:text-white">{{ $item->nama }}</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $item->category->category ?? 'Umum' }}</p>
                        </div>
                        <button wire:click="choose({{ $item->id }})" 
                            class="px-4 py-2 {{ $isSelected ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-indigo-600 hover:text-white' }} text-xs font-bold rounded-xl transition-all">
                            {{ $isSelected ? 'Terpilih' : 'Pilih' }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
