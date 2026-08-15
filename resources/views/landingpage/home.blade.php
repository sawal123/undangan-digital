<div class="min-h-screen scroll-smooth bg-[#fffaf7] font-sans text-slate-800">
    <header class="sticky top-0 z-30 border-b border-amber-100 bg-white/90 shadow-sm backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 md:px-8">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
                <i class="fas fa-ring text-2xl text-amber-600"></i>
                <span class="font-display text-2xl font-semibold tracking-normal text-slate-800">
                    Wayae<span class="text-amber-600">Nikah</span>
                </span>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-medium text-slate-600 md:flex">
                <a href="#layanan" class="transition hover:text-amber-600">Layanan</a>
                <a href="#fitur" class="transition hover:text-amber-600">Fitur</a>
                <a href="#promo" class="transition hover:text-amber-600">Penawaran</a>
            </nav>

            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <a href="{{ Auth::user()->hasRole('Owner') ? route('admin.admin') : route('dashboard.index') }}"
                        class="rounded-full border border-amber-200 bg-amber-50 px-5 py-2 text-sm font-semibold text-amber-700 shadow-sm transition hover:bg-amber-100">
                        <i class="fas fa-table-columns mr-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" wire:navigate
                        class="rounded-full border border-amber-200 bg-amber-50 px-5 py-2 text-sm font-semibold text-amber-700 shadow-sm transition hover:bg-amber-100">
                        <i class="fas fa-headset mr-1"></i> Konsultasi
                    </a>
                @endauth
            </div>

            <button type="button" class="text-2xl text-slate-600 md:hidden" id="landingMenuButton"
                aria-label="Buka menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div id="landingMobileMenu"
            class="hidden border-t border-amber-100 bg-white px-5 py-3 text-slate-700 md:hidden">
            <div class="flex flex-col gap-2">
                <a href="#layanan" class="py-2 transition hover:text-amber-600"><i
                        class="fas fa-envelope-open-text w-6"></i> Layanan</a>
                <a href="#fitur" class="py-2 transition hover:text-amber-600"><i class="fas fa-star w-6"></i> Fitur</a>
                <a href="#promo" class="py-2 transition hover:text-amber-600"><i class="fas fa-tag w-6"></i>
                    Penawaran</a>
                <a href="{{ route('login') }}" wire:navigate
                    class="mt-1 rounded-full bg-amber-50 py-2 text-center font-semibold text-amber-700">
                    <i class="fas fa-headset mr-1"></i> Konsultasi Gratis
                </a>
            </div>
        </div>
    </header>

    <main>
        <section class="relative overflow-hidden bg-gradient-to-br from-[#fff5f0] to-[#ffe9e0]">
            <div class="pointer-events-none absolute -left-20 -top-20 h-72 w-72 rounded-full bg-amber-200/30 blur-3xl">
            </div>
            <div class="pointer-events-none absolute bottom-10 right-0 h-80 w-80 rounded-full bg-rose-200/30 blur-3xl">
            </div>

            <div class="relative z-10 mx-auto max-w-7xl px-5 py-16 md:px-8 md:py-24">
                <div class="flex flex-col items-center gap-12 lg:flex-row">
                    <div class="flex-1 text-left   sm:text-center ">
                        <div
                            class="mb-5 inline-flex items-center rounded-full border border-white/50 bg-white/70 px-4 py-1.5 text-sm font-medium text-amber-700 shadow-sm backdrop-blur-sm">
                            <i class="fas fa-mosque mr-2"></i> Wedding Digital Solution
                        </div>
                        <h1 class="font-display text-4xl font-bold leading-tight text-slate-800 md:text-6xl">
                            Wayae Nikah <br>
                            <span class="text-amber-600">Menawarkan Jasa</span> Undangan
                        </h1>
                        <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-600 md:mx-0 md:text-xl">
                            <span class="font-semibold">Pesan 1 bisa dikirim ke semua orang</span> - lebih hemat,
                            lebih praktis, lebih simpel dengan segala kelebihan lainnya.
                        </p>
                        <div class="mt-8 flex flex-wrap justify-center gap-4 md:justify-start">
                            <a href="{{ route('login') }}" wire:navigate
                                class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-yellow-600 px-7 py-3 font-semibold text-white shadow-lg shadow-amber-500/20 transition hover:scale-[1.02] hover:from-yellow-600 hover:to-amber-700">
                                <i class="fas fa-calendar-alt"></i> Buat Undangan
                            </a>
                            <a href="{{ route('login') }}" wire:navigate
                                class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-7 py-3 font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                <i class="fas fa-comment-dots text-amber-500"></i> Konsultasi
                            </a>
                        </div>
                        <div
                            class="mt-10 flex flex-wrap justify-center gap-6 text-sm font-medium text-slate-600 md:justify-start">
                            <div class="flex items-center gap-2"><i class="fas fa-check-circle text-amber-500"></i>
                                Hemat Budget</div>
                            <div class="flex items-center gap-2"><i class="fas fa-check-circle text-amber-500"></i>
                                Praktis & Cepat</div>
                            <div class="flex items-center gap-2"><i class="fas fa-check-circle text-amber-500"></i>
                                Simple Modern</div>
                        </div>
                    </div>

                    <div class="flex flex-1 justify-center">
                        <div class="relative w-72 md:w-96">
                            <div class="absolute inset-0 rounded-full bg-amber-300/20 blur-2xl"></div>
                            <img src="https://placehold.co/600x500/FFF2EB/D4AF37?text=Undangan+Digital&font=playfair"
                                alt="Preview undangan digital"
                                class="relative w-full rounded-2xl border-4 border-white/80 object-cover shadow-2xl">
                            <div
                                class="absolute -bottom-5 -right-5 flex items-center gap-2 rounded-xl bg-white p-3 shadow-xl">
                                <i class="fas fa-heart text-xl text-rose-500"></i>
                                <span class="font-semibold text-slate-800">+1000 Pasangan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-5 md:px-8">
                <div class="mx-auto mb-14 max-w-3xl text-center">
                    <h2 class="font-display text-3xl font-bold text-slate-800 md:text-4xl">Jasa Lengkap untuk Hari
                        Bahagia</h2>
                    <div class="mx-auto mt-4 h-1 w-24 rounded-full bg-amber-400"></div>
                    <p class="mt-4 text-slate-500">Pilih sesuai gaya dan kebutuhan Anda: online, cetak, atau animasi
                        eksklusif.</p>
                </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <article
                        class="flex h-full flex-col rounded-2xl border border-amber-100 bg-white p-6 text-center shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-100">
                            <i class="fas fa-globe text-3xl text-amber-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800">Undangan Web</h3>
                        <p class="mt-2 text-sm text-slate-500">Digital interaktif, akses selamanya. Bagikan link ke
                            seluruh tamu tanpa batas.</p>
                        <ul class="mt-4 space-y-1 text-left text-sm text-slate-600">
                            <li><i class="fas fa-check mr-2 w-4 text-amber-500"></i> Responsif HP & desktop</li>
                            <li><i class="fas fa-check mr-2 w-4 text-amber-500"></i> Live RSVP & lokasi</li>
                        </ul>
                        <a href="{{ route('web') }}" wire:navigate
                            class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-amber-500/20 transition hover:bg-amber-600">
                            Lihat Undangan Web <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </article>

                    <article
                        class="flex h-full flex-col rounded-2xl border border-rose-100 bg-white p-6 text-center shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-rose-100">
                            <i class="fas fa-print text-3xl text-rose-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800">Cetak Undangan Fisik</h3>
                        <p class="mt-2 text-sm text-slate-500">Premium paper, desain eksklusif, pilihan sampul dan
                            finishing elegan.</p>
                        <ul class="mt-4 space-y-1 text-left text-sm text-slate-600">
                            <li><i class="fas fa-check mr-2 w-4 text-rose-500"></i> Bahan mewah atau custom</li>
                            <li><i class="fas fa-check mr-2 w-4 text-rose-500"></i> Cetak kilat dan pengiriman</li>
                        </ul>
                        <a href="{{ route('cetak') }}" wire:navigate
                            class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-rose-500/20 transition hover:bg-rose-600">
                            Lihat Undangan Cetak <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </article>

                    <article
                        class="flex h-full flex-col rounded-2xl border border-indigo-100 bg-white p-6 text-center shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                        <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-indigo-100">
                            <i class="fas fa-film text-3xl text-indigo-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800">Undangan Animasi</h3>
                        <p class="mt-2 text-sm text-slate-500">Motion graphic personal, storytelling cinta yang terasa
                            hidup dan berkesan.</p>
                        <ul class="mt-4 space-y-1 text-left text-sm text-slate-600">
                            <li><i class="fas fa-check mr-2 w-4 text-indigo-500"></i> Durasi 30-60 detik</li>
                            <li><i class="fas fa-check mr-2 w-4 text-indigo-500"></i> Share ke WA dan media sosial</li>
                        </ul>
                        <a href="{{ route('animasi') }}" wire:navigate
                            class="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-indigo-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-500/20 transition hover:bg-indigo-600">
                            Lihat Undangan Animasi <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <section id="fitur" class="bg-[#fefaf8] py-20">
            <div class="mx-auto max-w-7xl px-5 md:px-8">
                <div class="mb-14 text-center">
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-white/80 px-4 py-1.5 text-sm font-semibold text-amber-700 shadow-sm">
                        <i class="fas fa-gem text-amber-500"></i> Keunggulan Premium
                    </div>
                    <h2 class="mt-4 font-display text-3xl font-bold text-slate-800 md:text-5xl">Fitur Apa Saja Yang
                        Kamu Dapat?</h2>
                    <p class="mx-auto mt-3 max-w-2xl text-lg text-slate-500">Dengan fitur lengkap, kamu bisa atur
                        sendiri.</p>
                </div>

                <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([['icon' => 'fa-infinity', 'title' => 'Aktif Selamanya', 'text' => 'Undangan web dan animasi tidak kedaluwarsa, akses seumur hidup.', 'color' => 'text-amber-600'], ['icon' => 'fa-music', 'title' => 'Bebas Music', 'text' => 'Pilih lagu favorit, atur playlist sendiri tanpa ribet.', 'color' => 'text-amber-600'], ['icon' => 'fa-hands-praying', 'title' => 'Ucapan & Doa', 'text' => 'Tamu bisa kirim doa dan ucapan langsung di undangan.', 'color' => 'text-amber-600'], ['icon' => 'fa-gift', 'title' => 'Kado', 'text' => 'Fitur kado online, transfer via bank dan e-wallet terintegrasi.', 'color' => 'text-amber-600'], ['icon' => 'fa-whatsapp', 'title' => 'Kirim WA', 'text' => 'Kirim undangan langsung ke WhatsApp tamu, praktis dan cepat.', 'color' => 'text-green-600', 'brand' => true], ['icon' => 'fa-images', 'title' => 'Galeri Foto & Video', 'text' => 'Unggah momen prewedding, video undangan, dan cerita cinta.', 'color' => 'text-amber-600']] as $feature)
                        <article
                            class="flex items-start gap-4 rounded-xl bg-white p-6 shadow-md transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#fdf0e9]">
                                <i
                                    class="{{ $feature['brand'] ?? false ? 'fab' : 'fas' }} {{ $feature['icon'] }} text-2xl {{ $feature['color'] }}"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">{{ $feature['title'] }}</h3>
                                <p class="text-sm text-slate-500">{{ $feature['text'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="promo" class="relative overflow-hidden py-20">
            <div class="absolute inset-0 bg-gradient-to-r from-amber-50 via-rose-50 to-amber-50 opacity-70"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-5 md:px-8">
                <div class="mx-auto max-w-4xl overflow-hidden rounded-3xl border border-amber-100 bg-white shadow-2xl">
                    <div class="grid md:grid-cols-2">
                        <div class="p-8 md:p-10">
                            <div
                                class="mb-4 inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-1.5 text-sm font-semibold text-amber-800">
                                <i class="fas fa-bolt"></i> Special Offer
                            </div>
                            <h2 class="font-display text-3xl font-bold leading-tight text-slate-800 md:text-4xl">Jangan
                                Ragu Untuk Hari Istimewa</h2>
                            <div class="my-4 rounded-xl border-l-8 border-amber-400 bg-amber-50 p-4">
                                <p
                                    class="flex flex-wrap items-center gap-2 text-xl font-bold text-slate-800 md:text-2xl">
                                    <i class="fas fa-credit-card text-amber-600"></i> Bayar Sekali
                                    <span class="text-amber-600">Bisa Digunakan Berkali-kali</span>
                                </p>
                                <p class="mt-1 text-slate-600">Tidak ada biaya bulanan, cukup investasi sekali untuk
                                    undangan dan revisi.</p>
                            </div>
                            <ul class="mb-6 space-y-2 text-slate-700">
                                <li><i class="fas fa-check-circle mr-2 text-amber-500"></i> Update konten kapan saja
                                </li>
                                <li><i class="fas fa-check-circle mr-2 text-amber-500"></i> Bisa cetak ulang kapan pun
                                </li>
                                <li><i class="fas fa-check-circle mr-2 text-amber-500"></i> Support seumur hidup</li>
                            </ul>
                            <div class="mt-2 flex flex-wrap items-center gap-4">
                                <a href="{{ route('login') }}" wire:navigate
                                    class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-3 font-bold text-white shadow-md transition hover:scale-[1.02] hover:from-yellow-600 hover:to-amber-700">
                                    <i class="fas fa-envelope-open-text"></i> Buat Undangan Kamu
                                </a>
                                <a href="{{ route('login') }}" wire:navigate
                                    class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-5 py-3 font-semibold text-slate-700 transition hover:bg-slate-50">
                                    <i class="fas fa-comments"></i> Konsultasi
                                </a>
                            </div>
                        </div>
                        <div class="relative hidden items-center justify-center bg-amber-800/5 p-8 md:flex">
                            <i class="fas fa-heart absolute left-8 top-8 text-9xl text-amber-200 opacity-30"></i>
                            <div class="relative w-64 rounded-2xl bg-white p-5 text-center shadow-xl">
                                <i class="fas fa-check-circle mb-2 text-5xl text-amber-500"></i>
                                <p class="font-bold">Garansi seumur hidup</p>
                                <p class="text-sm text-slate-500">1x pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @php($contact = \App\Models\SystemSetting::current())

    <section class="border-t border-amber-100 bg-white py-16">
        <div class="mx-auto max-w-7xl px-5 md:px-8">
            <div class="mb-10 text-center">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-4 py-1.5 text-sm font-semibold text-amber-700 shadow-sm">
                    <i class="fas fa-headset text-amber-500"></i> Hubungi Kami
                </div>
                <h2 class="mt-4 font-display text-3xl font-bold text-slate-800 md:text-4xl">Informasi Kontak</h2>
                <div class="mx-auto mt-4 h-1 w-24 rounded-full bg-amber-400"></div>
                <p class="mt-4 text-slate-500">Punya pertanyaan seputar undangan? Silakan hubungi kami.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @if ($contact->whatsapp_link)
                    <a href="{{ $contact->whatsapp_link }}" target="_blank" rel="noopener noreferrer"
                        class="flex h-full flex-col items-center rounded-2xl border border-amber-100 bg-white p-6 text-center shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100">
                            <i class="fab fa-whatsapp text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">WhatsApp</h3>
                        <p class="mt-1 break-all text-sm text-slate-500">{{ $contact->whatsapp }}</p>
                    </a>
                @endif

                @if ($contact->email)
                    <a href="mailto:{{ $contact->email }}"
                        class="flex h-full flex-col items-center rounded-2xl border border-amber-100 bg-white p-6 text-center shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-100">
                            <i class="fas fa-envelope text-2xl text-rose-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Email</h3>
                        <p class="mt-1 break-all text-sm text-slate-500">{{ $contact->email }}</p>
                    </a>
                @endif

                @if ($contact->address)
                    <div
                        class="flex h-full flex-col items-center rounded-2xl border border-amber-100 bg-white p-6 text-center shadow-lg transition hover:-translate-y-1.5 hover:shadow-xl">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100">
                            <i class="fas fa-map-marker-alt text-2xl text-amber-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Alamat</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $contact->address }}</p>
                    </div>
                @endif
            </div>

            @if ($contact->instagram_link || $contact->facebook_link || $contact->tiktok_link)
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <span class="text-sm font-semibold text-slate-500">Ikuti kami:</span>
                    @if ($contact->instagram_link)
                        <a href="{{ $contact->instagram_link }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-tr from-amber-400 via-rose-500 to-purple-600 text-white shadow-lg transition hover:scale-110">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    @endif
                    @if ($contact->facebook_link)
                        <a href="{{ $contact->facebook_link }}" target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-600 text-white shadow-lg transition hover:scale-110">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                    @endif
                    @if ($contact->tiktok_link)
                        <a href="{{ $contact->tiktok_link }}" target="_blank" rel="noopener noreferrer"
                            aria-label="TikTok"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-900 text-white shadow-lg transition hover:scale-110">
                            <i class="fab fa-tiktok text-xl"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <footer class="mt-6 bg-slate-900 py-10 text-slate-300">
        <div class="mx-auto max-w-7xl px-5 md:px-8">
            <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                <div class="flex items-center gap-2">
                    <i class="fas fa-ring text-xl text-amber-400"></i>
                    <span class="font-display text-2xl font-semibold text-white">Wayae<span
                            class="text-amber-400">Nikah</span></span>
                </div>
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <a href="#layanan" class="hover:text-amber-300">Layanan</a>
                    <a href="#fitur" class="hover:text-amber-300">Fitur</a>
                    <a href="#promo" class="hover:text-amber-300">Penawaran</a>
                </div>
                <div class="text-sm text-slate-400">&copy; {{ date('Y') }} Wayae Nikah</div>
            </div>
            <div class="mt-6 text-center text-xs text-slate-500">Bayar sekali, tenang selamanya. Dari hati untuk hari
                spesialmu.</div>
        </div>
    </footer>
</div>

@script
    <script>
        const landingMenuButton = document.getElementById('landingMenuButton');
        const landingMobileMenu = document.getElementById('landingMobileMenu');

        if (landingMenuButton && landingMobileMenu) {
            landingMenuButton.addEventListener('click', () => {
                landingMobileMenu.classList.toggle('hidden');
            });

            landingMobileMenu.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => landingMobileMenu.classList.add('hidden'));
            });
        }
    </script>
@endscript
