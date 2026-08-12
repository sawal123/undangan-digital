<div class="min-h-screen bg-[#faf9f6] font-sans text-slate-800">
    <!-- Sticky Header -->
    <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2.5">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600">
                    <i class="fas fa-ring text-lg"></i>
                </div>
                <span class="font-display text-xl font-bold tracking-tight text-slate-900">
                    Wayae<span class="text-amber-600">Nikah</span>
                </span>
            </a>

            <nav class="hidden items-center gap-8 text-sm font-medium text-slate-600 md:flex">
                <a href="{{ route('web') }}" wire:navigate class="transition hover:text-amber-600">Web</a>
                <a href="{{ route('cetak') }}" wire:navigate class="font-semibold text-rose-600">Cetak</a>
                <a href="{{ route('animasi') }}" wire:navigate class="transition hover:text-amber-600">Animasi</a>
            </nav>

            <a href="{{ route('login') }}" wire:navigate
                class="hidden rounded-full border border-rose-200 bg-rose-50/60 px-4 py-2 text-xs font-semibold text-rose-700 shadow-sm transition hover:bg-rose-100/80 md:inline-flex items-center gap-1.5">
                <i class="fas fa-headset text-rose-500"></i> Konsultasi Gratis
            </a>

            <button type="button" class="p-2 text-slate-600 md:hidden" id="cetakMenuButton" aria-label="Buka menu">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="cetakMobileMenu" class="hidden border-t border-slate-200/80 bg-white px-5 py-4 text-slate-700 md:hidden">
            <div class="flex flex-col gap-3 text-sm">
                <a href="{{ route('web') }}" wire:navigate class="flex items-center gap-3 py-1.5 transition hover:text-amber-600">
                    <i class="fas fa-globe w-5 text-slate-400"></i> Web
                </a>
                <a href="{{ route('cetak') }}" wire:navigate class="flex items-center gap-3 py-1.5 font-semibold text-rose-600">
                    <i class="fas fa-print w-5 text-rose-500"></i> Cetak
                </a>
                <a href="{{ route('animasi') }}" wire:navigate class="flex items-center gap-3 py-1.5 transition hover:text-amber-600">
                    <i class="fas fa-film w-5 text-slate-400"></i> Animasi
                </a>
                <a href="{{ route('login') }}" wire:navigate class="mt-2 flex items-center justify-center gap-2 rounded-xl bg-rose-50 py-2.5 text-center font-semibold text-rose-700">
                    <i class="fas fa-headset text-rose-500"></i> Konsultasi Gratis
                </a>
            </div>
        </div>
    </header>

    <main class="py-10 sm:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Top Bar Back Button -->
            <div class="mb-4 flex items-center justify-between">
                <a href="{{ route('home') }}" wire:navigate
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                    <i class="fas fa-arrow-left text-slate-400"></i> Kembali
                </a>
            </div>

            <!-- Hero Header Section (100% Perfectly Centered) -->
            <div class="mb-10 text-center max-w-3xl mx-auto">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-rose-200/80 bg-rose-50/80 px-3.5 py-1 text-xs font-semibold text-rose-700">
                    <i class="fas fa-print text-rose-500 text-[11px]"></i> Katalog Undangan Cetak
                </div>
                <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
                    Undangan <span class="text-rose-600">Cetak Fisik</span>
                </h1>
                <p class="mt-2.5 text-sm sm:text-base text-slate-500 leading-relaxed max-w-xl mx-auto">
                    Katalog cetak undangan pernikahan fisik dengan beragam bahan pilihan, cetak presisi, dan finishing berkualitas.
                </p>
            </div>

            <!-- Search Bar Section -->
            <div class="mb-10 mx-auto max-w-2xl">
                <div class="relative flex items-center rounded-2xl border border-slate-200 bg-white p-1.5 shadow-sm transition-all focus-within:border-rose-300 focus-within:ring-2 focus-within:ring-rose-100">
                    <div class="pl-3.5 text-slate-400">
                        <i class="fas fa-search text-sm"></i>
                    </div>
                    <input
                        id="search-cetak"
                        type="text"
                        wire:model.live.debounce.350ms="search"
                        placeholder="Cari undangan berdasarkan nama, harga, atau jenis..."
                        class="w-full border-none bg-transparent py-2.5 pl-3 pr-10 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0"
                    >
                    
                    <!-- Search Loading Spinner -->
                    <div wire:loading wire:target="search" class="absolute right-3.5">
                        <x-loading-spinner class="w-4 h-4 text-rose-600" />
                    </div>

                    <!-- Clear Search Button -->
                    @if(!empty($search))
                        <button
                            type="button"
                            wire:click="clearSearch"
                            wire:loading.remove
                            wire:target="search"
                            class="absolute right-3.5 text-slate-400 hover:text-slate-600 p-1"
                            aria-label="Hapus pencarian"
                        >
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Skeleton Loading Grid during Search -->
            <div wire:loading.grid wire:target="search" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 animate-pulse">
                @for ($i = 0; $i < 8; $i++)
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 space-y-4">
                        <div class="aspect-[4/3] rounded-xl bg-slate-100"></div>
                        <div class="h-4 w-1/3 rounded bg-slate-100"></div>
                        <div class="h-5 w-2/3 rounded bg-slate-100"></div>
                        <div class="h-6 w-1/2 rounded bg-slate-100"></div>
                        <div class="h-10 rounded-xl bg-slate-100"></div>
                    </div>
                @endfor
            </div>

            <!-- Product Grid -->
            <div wire:loading.remove wire:target="search">
                @if ($undangan->isEmpty())
                    <!-- Empty State -->
                    <div class="mx-auto max-w-md rounded-3xl border border-slate-200/80 bg-white p-8 text-center shadow-sm my-8">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-stone-100 text-slate-400">
                            <i class="fas fa-box-open text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Undangan Tidak Ditemukan</h3>
                        <p class="mt-1 text-sm text-slate-500">Coba gunakan kata kunci lain seperti nama atau jenis cetak.</p>
                        @if (!empty($search))
                            <button
                                type="button"
                                wire:click="clearSearch"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white shadow transition hover:bg-slate-800"
                            >
                                <i class="fas fa-times text-xs"></i> Hapus Pencarian
                            </button>
                        @endif
                    </div>
                @else
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($undangan as $item)
                            <article wire:key="undangan-cetak-{{ $item->id }}" class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-slate-300">
                                <!-- Thumbnail Container -->
                                <div class="relative aspect-[4/3] w-full overflow-hidden bg-stone-50/80">
                                    <button type="button" wire:click="openModal({{ $item->id }})" class="block h-full w-full focus:outline-none">
                                        <img
                                            src="{{ $item->thumbnail_url }}"
                                            alt="Thumbnail {{ $item->nama }}"
                                            loading="lazy"
                                            decoding="async"
                                            class="h-full w-full object-contain p-2.5 transition duration-300 group-hover:scale-[1.03]"
                                            onerror="this.onerror=null; this.src='{{ asset('images/default-invitation.png') }}';"
                                        >
                                    </button>

                                    <!-- Category Badge -->
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-semibold text-slate-700 shadow-sm border border-slate-200/60 backdrop-blur-md">
                                            <i class="fas fa-tag text-[10px] text-rose-500"></i> {{ $item->jenisUndangan?->jenis ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Body Container -->
                                <div class="flex flex-1 flex-col p-4 sm:p-5">
                                    <h3 class="text-base font-bold text-slate-800 line-clamp-2 min-h-[3rem] group-hover:text-rose-600 transition-colors">
                                        {{ $item->nama }}
                                    </h3>

                                    <div class="mt-2 flex flex-wrap items-baseline gap-2">
                                        <span class="text-lg font-extrabold text-slate-900">
                                            Rp{{ number_format($item->promo > 0 ? $item->promo : $item->harga, 0, ',', '.') }}
                                        </span>
                                        @if ($item->promo > 0)
                                            <del class="text-xs font-medium text-rose-500 line-through">
                                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                                            </del>
                                        @endif
                                    </div>

                                    <!-- Action Button -->
                                    <button
                                        type="button"
                                        wire:click="openModal({{ $item->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="openModal({{ $item->id }})"
                                        class="mt-4 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-rose-200 bg-rose-50/70 px-4 text-sm font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100/80 active:bg-rose-200/80 disabled:pointer-events-none disabled:opacity-60"
                                    >
                                        <span wire:loading.remove wire:target="openModal({{ $item->id }})" class="inline-flex items-center gap-1.5">
                                            Lihat Detail <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                                        </span>
                                        <span wire:loading.inline-flex wire:target="openModal({{ $item->id }})" class="items-center gap-2">
                                            <x-loading-spinner class="w-4 h-4 text-rose-600" />
                                            <span>Memuat...</span>
                                        </span>
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Load More Button -->
            @if ($hasMore)
                <div class="mt-12 text-center">
                    <button
                        type="button"
                        wire:click="loadMore"
                        wire:loading.attr="disabled"
                        wire:target="loadMore"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-7 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:border-slate-400 disabled:opacity-60 disabled:pointer-events-none"
                    >
                        <span wire:loading.remove wire:target="loadMore">Tampilkan Lebih Banyak</span>
                        <span wire:loading.inline-flex wire:target="loadMore" class="items-center gap-2">
                            <x-loading-spinner class="w-4 h-4 text-slate-600" />
                            <span>Memuat...</span>
                        </span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Modal Detail -->
        @if ($isOpenModal && $undang)
            @include('landingpage.cetak.modalDetail')
        @endif
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200/80 bg-slate-900 py-8 text-slate-400 text-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/20 text-amber-400">
                        <i class="fas fa-ring text-sm"></i>
                    </div>
                    <span class="font-display text-lg font-bold text-white">Wayae<span class="text-amber-400">Nikah</span></span>
                </div>
                <div>
                    &copy; {{ date('Y') }} Wayae Nikah. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
</div>

@script
<script>
    const cetakMenuButton = document.getElementById('cetakMenuButton');
    const cetakMobileMenu = document.getElementById('cetakMobileMenu');

    if (cetakMenuButton && cetakMobileMenu) {
        cetakMenuButton.addEventListener('click', () => cetakMobileMenu.classList.toggle('hidden'));
        cetakMobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => cetakMobileMenu.classList.add('hidden'));
        });
    }

    Livewire.on('cetak-modal-opened', (event) => {
        const payload = Array.isArray(event) ? event[0] : event;
        const url = new URL(window.location.href);
        url.searchParams.set('produk', payload.token);
        window.history.pushState({ cetakModal: true }, '', url);
    });

    Livewire.on('cetak-modal-closed', () => {
        const url = new URL(window.location.href);
        if (url.searchParams.has('produk')) {
            url.searchParams.delete('produk');
            window.history.replaceState({}, '', url);
        }
    });

    window.addEventListener('popstate', () => {
        const url = new URL(window.location.href);
        if (!url.searchParams.has('produk')) {
            $wire.closeModal();
        }
    });
</script>
@endscript
