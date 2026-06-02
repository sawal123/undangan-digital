<div class="min-h-screen bg-[#fffaf7] font-sans text-slate-800">
        <header class="sticky top-0 z-30 border-b border-amber-100 bg-white/90 shadow-sm backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 md:px-8">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
                    <i class="fas fa-ring text-2xl text-amber-600"></i>
                    <span class="font-display text-2xl font-semibold text-slate-800">Wayae<span class="text-amber-600">Nikah</span></span>
                </a>

                <nav class="hidden items-center gap-7 text-sm font-medium text-slate-600 md:flex">
                    <a href="{{ route('web') }}" wire:navigate class="transition hover:text-amber-600">Web</a>
                    <a href="{{ route('cetak') }}" wire:navigate class="text-amber-600">Cetak</a>
                    <a href="{{ route('animasi') }}" wire:navigate class="transition hover:text-amber-600">Animasi</a>
                </nav>

                <a href="{{ route('login') }}" wire:navigate
                    class="hidden rounded-full border border-amber-200 bg-amber-50 px-5 py-2 text-sm font-semibold text-amber-700 shadow-sm transition hover:bg-amber-100 md:inline-flex">
                    <i class="fas fa-headset mr-1"></i> Konsultasi
                </a>

                <button type="button" class="text-2xl text-slate-600 md:hidden" id="cetakMenuButton" aria-label="Buka menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div id="cetakMobileMenu" class="hidden border-t border-amber-100 bg-white px-5 py-3 text-slate-700 md:hidden">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('web') }}" wire:navigate class="py-2 transition hover:text-amber-600"><i class="fas fa-globe w-6"></i> Web</a>
                    <a href="{{ route('cetak') }}" wire:navigate class="py-2 text-amber-600"><i class="fas fa-print w-6"></i> Cetak</a>
                    <a href="{{ route('animasi') }}" wire:navigate class="py-2 transition hover:text-amber-600"><i class="fas fa-film w-6"></i> Animasi</a>
                    <a href="{{ route('login') }}" wire:navigate class="mt-1 rounded-full bg-amber-50 py-2 text-center font-semibold text-amber-700">
                        <i class="fas fa-headset mr-1"></i> Konsultasi Gratis
                    </a>
                </div>
            </div>
        </header>

        <main>
            <section class="bg-white py-16 md:py-20">
                <div class="mx-auto max-w-7xl px-5 md:px-8">
                    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div>
                            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-4 py-1.5 text-sm font-semibold text-rose-700">
                                <i class="fas fa-print"></i> Katalog Undangan Cetak
                            </div>
                            <h1 class="font-display text-3xl font-bold leading-tight text-slate-800 md:text-5xl">
                                Undangan <span class="text-rose-500">Cetak Fisik</span>
                            </h1>
                            <p class="mt-3 max-w-2xl text-slate-500">Cari desain cetak berdasarkan nama, harga, atau jenis undangan.</p>
                        </div>
                        <a href="{{ route('home') }}" wire:navigate
                            class="inline-flex w-fit items-center gap-2 rounded-full border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="fas fa-arrow-left text-rose-500"></i> Kembali
                        </a>
                    </div>

                    <div class="mb-10 rounded-2xl border border-rose-100 bg-[#fffaf7] p-4 shadow-sm">
                        <label class="mb-2 block text-sm font-semibold text-slate-700" for="search-cetak">
                            <i class="fas fa-magnifying-glass mr-1 text-rose-500"></i> Cari Undangan
                        </label>
                        <input id="search-cetak" type="search"
                            class="w-full rounded-xl border-slate-200 bg-white px-5 py-3 text-slate-700 shadow-sm focus:border-rose-300 focus:ring-rose-300"
                            placeholder="Cari berdasarkan nama, harga, atau jenis..."
                            wire:model.live="search">
                    </div>

                    @if ($undangan->isEmpty())
                        <div class="mx-auto max-w-xl rounded-2xl border border-rose-100 bg-[#fffaf7] p-8 text-center shadow-sm">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-100">
                                <i class="fas fa-box-open text-2xl text-rose-500"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Undangan cetak tidak ditemukan</h3>
                            <p class="mt-2 text-sm text-slate-500">Coba gunakan kata kunci lain.</p>
                        </div>
                    @else
                        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            @foreach ($undangan as $item)
                                @php
                                    $gambar = json_decode($item->gambar);
                                    $thumbnail = !empty($gambar) && isset($gambar[0]) ? $gambar[0] : 'default-thumbnail.jpg';
                                @endphp

                                <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                                    <button type="button" class="block bg-[#fff5f0] text-left" wire:click='openModal({{ $item->id }})'>
                                        <div class="aspect-[4/5] overflow-hidden">
                                            <img src="{{ asset('storage/' . $thumbnail) }}" alt="Thumbnail {{ $item->nama }}"
                                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                        </div>
                                    </button>

                                    <div class="flex flex-1 flex-col p-5">
                                        <div class="mb-3 inline-flex w-fit items-center gap-2 rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">
                                            <i class="fas fa-tag"></i> {{ $item->jenis }}
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800">{{ $item->nama }}</h3>
                                        <div class="mt-3 flex flex-wrap items-end gap-2">
                                            <span class="text-lg font-bold text-slate-900">
                                                Rp{{ number_format($item->promo > 0 ? $item->promo : $item->harga, 0, ',', '.') }}
                                            </span>
                                            @if ($item->promo > 0)
                                                <del class="text-sm text-rose-500">Rp{{ number_format($item->harga, 0, ',', '.') }}</del>
                                            @endif
                                        </div>

                                        <button type="button" wire:click='openModal({{ $item->id }})'
                                            class="mt-5 inline-flex items-center justify-center gap-2 rounded-full bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-rose-500/20 transition hover:bg-rose-600">
                                            Lihat Detail <i class="fas fa-arrow-right text-xs"></i>
                                        </button>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif

                    @if (count($undangan) >= $perPage)
                        <div class="mt-10 text-center">
                            <button type="button" wire:click="loadMore" wire:loading.attr="disabled"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-rose-500 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-rose-500/20 transition hover:bg-rose-600 disabled:opacity-60">
                                <span wire:loading.remove>Load More</span>
                                <span wire:loading>Loading...</span>
                            </button>
                        </div>
                    @endif
                </div>

                @if ($isOpenModal)
                    @include('landingpage.cetak.modalDetail')
                @endif
            </section>
        </main>

        <footer class="bg-slate-900 py-10 text-slate-300">
            <div class="mx-auto max-w-7xl px-5 md:px-8">
                <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-ring text-xl text-amber-400"></i>
                        <span class="font-display text-2xl font-semibold text-white">Wayae<span class="text-amber-400">Nikah</span></span>
                    </div>
                    <div class="text-sm text-slate-400">&copy; {{ date('Y') }} Wayae Nikah</div>
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
