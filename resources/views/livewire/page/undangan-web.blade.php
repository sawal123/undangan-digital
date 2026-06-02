<div class="min-h-screen bg-[#fffaf7] font-sans text-slate-800">
        <header class="sticky top-0 z-30 border-b border-amber-100 bg-white/90 shadow-sm backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 md:px-8">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
                    <i class="fas fa-ring text-2xl text-amber-600"></i>
                    <span class="font-display text-2xl font-semibold text-slate-800">Wayae<span class="text-amber-600">Nikah</span></span>
                </a>

                <nav class="hidden items-center gap-7 text-sm font-medium text-slate-600 md:flex">
                    <a href="{{ route('web') }}" wire:navigate class="text-amber-600">Web</a>
                    <a href="{{ route('cetak') }}" wire:navigate class="transition hover:text-amber-600">Cetak</a>
                    <a href="{{ route('animasi') }}" wire:navigate class="transition hover:text-amber-600">Animasi</a>
                </nav>

                <a href="{{ route('login') }}" wire:navigate
                    class="hidden rounded-full border border-amber-200 bg-amber-50 px-5 py-2 text-sm font-semibold text-amber-700 shadow-sm transition hover:bg-amber-100 md:inline-flex">
                    <i class="fas fa-headset mr-1"></i> Konsultasi
                </a>

                <button type="button" class="text-2xl text-slate-600 md:hidden" id="webMenuButton" aria-label="Buka menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div id="webMobileMenu" class="hidden border-t border-amber-100 bg-white px-5 py-3 text-slate-700 md:hidden">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('web') }}" wire:navigate class="py-2 text-amber-600"><i class="fas fa-globe w-6"></i> Web</a>
                    <a href="{{ route('cetak') }}" wire:navigate class="py-2 transition hover:text-amber-600"><i class="fas fa-print w-6"></i> Cetak</a>
                    <a href="{{ route('animasi') }}" wire:navigate class="py-2 transition hover:text-amber-600"><i class="fas fa-film w-6"></i> Animasi</a>
                    <a href="{{ route('login') }}" wire:navigate class="mt-1 rounded-full bg-amber-50 py-2 text-center font-semibold text-amber-700">
                        <i class="fas fa-headset mr-1"></i> Konsultasi Gratis
                    </a>
                </div>
            </div>
        </header>

        <main>
            <section id="tema-web" class="bg-white py-16 md:py-20">
                <div class="mx-auto max-w-7xl px-5 md:px-8">
                    <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div>
                            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-4 py-1.5 text-sm font-semibold text-amber-700">
                                <i class="fas fa-globe"></i> Katalog Undangan Web
                            </div>
                            <h1 class="font-display text-3xl font-bold leading-tight text-slate-800 md:text-5xl">
                                Tema <span class="text-amber-600">Undangan Web</span>
                            </h1>
                            <p class="mt-3 max-w-2xl text-slate-500">
                                Pilih desain digital yang responsif, mudah dibagikan, dan siap dilihat dari HP maupun desktop.
                            </p>
                        </div>
                        <a href="{{ route('home') }}" wire:navigate
                            class="inline-flex w-fit items-center gap-2 rounded-full border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <i class="fas fa-arrow-left text-amber-500"></i> Kembali
                        </a>
                    </div>

                    @if ($undanganWeb->isEmpty())
                        <div class="mx-auto max-w-xl rounded-2xl border border-amber-100 bg-[#fffaf7] p-8 text-center shadow-sm">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-100">
                                <i class="fas fa-images text-2xl text-amber-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Tema belum tersedia</h3>
                            <p class="mt-2 text-sm text-slate-500">Katalog undangan web akan tampil di sini setelah tema ditambahkan.</p>
                        </div>
                    @else
                        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            @foreach ($undanganWeb as $item)
                                <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-amber-100 bg-white shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                                    <a href="{{ url('demo/' . $item->demo) }}" class="block bg-[#fff5f0]" target="_blank" rel="noopener">
                                        <div class="aspect-[4/5] overflow-hidden">
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                                alt="Preview tema {{ $item->nama }}"
                                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                        </div>
                                    </a>

                                    <div class="flex flex-1 flex-col p-5">
                                        <div class="mb-3 inline-flex w-fit items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                            <i class="fas fa-mobile-screen-button"></i> Responsive
                                        </div>
                                        <h3 class="text-xl font-bold text-slate-800">{{ $item->nama }}</h3>
                                        <p class="mt-2 text-sm text-slate-500">Tema web siap pakai untuk dibagikan ke seluruh tamu.</p>

                                        <a href="{{ url('demo/' . $item->demo) }}" target="_blank" rel="noopener"
                                            class="mt-5 inline-flex items-center justify-center gap-2 rounded-full bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-amber-500/20 transition hover:bg-amber-600">
                                            Preview Tema <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
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
    const webMenuButton = document.getElementById('webMenuButton');
    const webMobileMenu = document.getElementById('webMobileMenu');

    if (webMenuButton && webMobileMenu) {
        webMenuButton.addEventListener('click', () => webMobileMenu.classList.toggle('hidden'));
        webMobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => webMobileMenu.classList.add('hidden'));
        });
    }
</script>
@endscript
