<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darkpre — Izzah &amp; Rifki</title>
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/swiper/swiper-bundle.min.css') }}">
    <link href="{{ asset('tema/darkpre/src/css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/src/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/src/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/fontawesome-free/css/all.css') }}">
    @include('tema.darkpre.styles')
</head>

<body class="darkpre-page">
    <div id="cover-mobile" class="darkpre-mobile-cover fixed inset-0 z-50 text-white lg:hidden"
        style="background-image: url('{{ asset('tema/darkpre/src/img/bg-kanan.jpg') }}'); background-position: center; background-size: cover;">
        <div class="darkpre-hero-content">
            <p class="darkpre-hero-eyebrow" data-aos="fade-down">The Wedding Of</p>
            <h1 class="darkpre-hero-title" data-aos="fade-up" data-aos-delay="120">
                Izzah <span class="font-poppins text-[25px]">&amp;</span> Rifki
            </h1>
            <p class="darkpre-hero-date" data-aos="fade-up" data-aos-delay="220">02 . 04 . 2025</p>
            <button id="open-cover" type="button" class="darkpre-submit-button mt-8 min-w-48">Buka Undangan</button>
        </div>
    </div>

    <div class="darkpre-shell flex flex-row">
        <aside class="darkpre-left-panel" aria-label="Panel foto undangan">
            <div class="darkpre-left-image"
                style="background-image: url('{{ asset('tema/darkpre/src/img/bg-kiri.jpg') }}');"></div>
            <h2 class="darkpre-left-title">Izzah <span class="font-poppins text-[25px]">&amp;</span> Rifki</h2>

            <div id="youtube-player" class="hidden" aria-hidden="true">
                <iframe id="videoFrame" width="1" height="1"
                    src="https://www.youtube.com/embed/sy0LqD9EA7A?enablejsapi=1" title="Musik undangan"
                    frameborder="0" allow="autoplay"></iframe>
            </div>
            <button id="musicToggle" type="button" aria-label="Putar atau jeda musik"
                class="darkpre-float-control darkpre-float-control--music fixed lg:absolute top-10 right-2 z-50 flex h-10 w-10 items-center justify-center rounded-full text-xl lg:right-5">
                <i class="fa-solid fa-play" aria-hidden="true"></i>
            </button>

            <button onclick="toggleModal()" type="button" aria-label="Buka informasi kado"
                class="darkpre-float-control darkpre-float-control--gift fixed lg:absolute top-28 right-2 z-50 h-14 w-14 rounded-full text-2xl lg:right-5">
                <i class="fa-solid fa-wallet" aria-hidden="true"></i>
            </button>

            <nav class="darkpre-side-nav hidden lg:block" id="desktop-navbar" aria-label="Navigasi undangan">
                <div><div>
                    <a aria-label="Pasangan" class="nav-link couple" href="#couple"><i class="fa-regular fa-heart"></i><span class="ml-2 hidden">Pasangan</span></a>
                    <a aria-label="Acara" class="nav-link date" href="#date"><i class="fa-regular fa-calendar"></i><span class="ml-2 hidden">Acara</span></a>
                    <a aria-label="Lokasi" class="nav-link location" href="#location"><i class="fa-solid fa-map-location-dot"></i><span class="ml-2 hidden">Lokasi</span></a>
                    <a aria-label="Galeri" class="nav-link gallery" href="#gallery"><i class="fa-regular fa-images"></i><span class="ml-2 hidden">Galeri</span></a>
                    <a aria-label="Ucapan" class="nav-link wishes" href="#wishes"><i class="fa-regular fa-note-sticky"></i><span class="ml-2 hidden">Ucapan</span></a>
                </div></div>
            </nav>
        </aside>

        <main class="darkpre-content-panel relative z-10">
            <section id="darkpre-hero" class="darkpre-hero" aria-label="Pembuka undangan">
                <div class="darkpre-hero-media"
                    style="background-image: url('{{ asset('tema/darkpre/src/img/bg-kanan.jpg') }}');"
                    aria-hidden="true"></div>
                <div class="darkpre-hero-content">
                    <p class="darkpre-hero-eyebrow" data-aos="fade-down">The Wedding Of</p>
                    <h1 class="darkpre-hero-title" data-aos="fade-up" data-aos-delay="120">
                        Izzah <span class="font-poppins text-[25px]">&amp;</span> Rifki
                    </h1>
                    <p class="darkpre-hero-date" data-aos="fade-up" data-aos-delay="220">02 . 04 . 2025</p>
                </div>
                <div class="darkpre-scroll-cue" aria-hidden="true">
                    <div class="darkpre-scroll-mouse"></div>
                    <span>Scroll ke bawah</span>
                </div>
                <svg class="darkpre-wave" viewBox="0 0 1440 320" preserveAspectRatio="none" aria-hidden="true">
                    <path fill="#080808" d="M0,64L60,80C120,96,240,128,360,122.7C480,117,600,75,720,80C840,85,960,139,1080,154.7C1200,171,1320,149,1380,138.7L1440,128L1440,320L0,320Z"></path>
                </svg>
            </section>

            <section class="darkpre-section" aria-label="Kutipan pernikahan">
                <div class="darkpre-quote-card" data-aos="fade-up">
                    <p>Dan di antara tanda-tanda kebesaran-Nya, Dia menciptakan pasangan hidup untukmu agar kamu merasa tenteram dan menjadikan kasih sayang di antara kamu.</p>
                    <span class="mt-3 block text-sm not-italic">QS. Ar-Rum: 21</span>
                </div>
            </section>

            <div class="darkpre-divider" aria-hidden="true"><img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" alt=""></div>

            <section id="couple" class="darkpre-section darkpre-couple-section" aria-label="Kedua mempelai">
                <p class="darkpre-section-lead" data-aos="fade-down">Dengan penuh syukur, kami mengundang Anda untuk merayakan kisah cinta kami.</p>
                <div class="darkpre-couple-grid">
                    <article class="darkpre-couple-card" data-aos="fade-right">
                        <img src="{{ asset('tema/darkpre/src/img/izzah.jpg') }}" alt="Foto Minhatul Izzah">
                        <h2 class="darkpre-couple-name">Izzah</h2>
                        <p class="darkpre-couple-bio">Minhatul Izzah<br>Putri dari Bapak Akbar S.Kom &amp; Ibu Siti S.Pd</p>
                    </article>
                    <div class="darkpre-couple-ampersand" aria-hidden="true">&amp;</div>
                    <article class="darkpre-couple-card" data-aos="fade-left">
                        <img src="{{ asset('tema/darkpre/src/img/rifki.jpg') }}" alt="Foto Rifki">
                        <h2 class="darkpre-couple-name">Rifki</h2>
                        <p class="darkpre-couple-bio">Rifki<br>Putra dari Bapak Akbar S.Kom &amp; Ibu Siti S.Pd</p>
                    </article>
                </div>
            </section>

            <div class="darkpre-divider" aria-hidden="true"><img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" alt=""></div>

            <section id="date" class="darkpre-section darkpre-event-section" aria-label="Jadwal acara">
                <h2 class="darkpre-section-heading" data-aos="fade-up">Acara Akan Diselenggarakan</h2>
                <div class="darkpre-countdown" aria-label="Hitung mundur acara">
                    <div class="darkpre-countdown-item"><span id="days" class="darkpre-countdown-value">00</span><span class="darkpre-countdown-label">Hari</span></div>
                    <div class="darkpre-countdown-item"><span id="hours" class="darkpre-countdown-value">00</span><span class="darkpre-countdown-label">Jam</span></div>
                    <div class="darkpre-countdown-item"><span id="minutes" class="darkpre-countdown-value">00</span><span class="darkpre-countdown-label">Menit</span></div>
                    <div class="darkpre-countdown-item"><span id="seconds" class="darkpre-countdown-value">00</span><span class="darkpre-countdown-label">Detik</span></div>
                </div>
                <p id="countdown" class="darkpre-date-line">Rabu, 2 April 2025</p>
                <div class="mt-6 text-center"><a href="#" class="darkpre-calendar-button"><i class="fa-solid fa-calendar-days"></i>Simpan acara ke kalender</a></div>
            </section>

            <section id="location" class="darkpre-section" aria-label="Detail lokasi acara">
                <h2 class="darkpre-section-heading" data-aos="fade-up">Detail Acara</h2>
                <div class="darkpre-event-list">
                    <article class="darkpre-event-card" data-aos="fade-up">
                        <h3>Akad Nikah</h3>
                        <div class="darkpre-event-details"><div>Rabu, 2 April 2025</div><div>Pukul 09.00 WIB - selesai</div><div>Masjid Al Barokah</div></div>
                        <a href="#" class="darkpre-map-button mt-5"><i class="fa-solid fa-map-location-dot"></i>Lihat lokasi</a>
                    </article>
                    <article class="darkpre-event-card" data-aos="fade-up">
                        <h3>Resepsi</h3>
                        <div class="darkpre-event-details"><div>Rabu, 2 April 2025</div><div>Pukul 11.00 WIB - selesai</div><div>Gedung Serbaguna</div></div>
                        <a href="#" class="darkpre-map-button mt-5"><i class="fa-solid fa-map-location-dot"></i>Lihat lokasi</a>
                    </article>
                </div>
            </section>

            <section class="darkpre-section darkpre-guest-section" aria-label="Keterangan undangan">
                <p class="darkpre-section-lead" data-aos="fade-up">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Anda berkenan hadir untuk memberikan doa restu.</p>
                <div class="darkpre-guest-list" data-aos="fade-up"><strong>Turut Mengundang</strong><div>Keluarga Besar Sujono<br>Keluarga Besar Emence<br>Teman SMK 1 Negeri</div></div>
            </section>

            <div class="darkpre-divider" aria-hidden="true"><img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" alt=""></div>

            <section class="darkpre-section darkpre-story-section" aria-label="Cerita pasangan">
                <h2 class="darkpre-section-heading" data-aos="fade-up">Story</h2>
                <div class="swiper swiperStory">
                    <div class="swiper-wrapper">
                        <article class="swiper-slide darkpre-story-slide"><img src="{{ asset('tema/darkpre/src/img/gambar-1.jpg') }}" alt="Cerita pertama" onclick="openModalImg(this)"><div class="darkpre-story-line"></div><p class="darkpre-story-copy">Pertama kita bertemu di tahun baru tahun 2014</p></article>
                        <article class="swiper-slide darkpre-story-slide"><img src="{{ asset('tema/darkpre/src/img/gambar-2.jpg') }}" alt="Cerita kedua" onclick="openModalImg(this)"><div class="darkpre-story-line"></div><p class="darkpre-story-copy">15 November 2020</p></article>
                        <article class="swiper-slide darkpre-story-slide"><img src="{{ asset('tema/darkpre/src/img/gambar-3.jpg') }}" alt="Cerita ketiga" onclick="openModalImg(this)"><div class="darkpre-story-line"></div><p class="darkpre-story-copy">29 November 2023</p></article>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>

            <section id="gallery" class="darkpre-section" aria-label="Galeri foto">
                <h2 class="darkpre-section-heading" data-aos="fade-up">Gallery Kami</h2>
                <p class="darkpre-section-lead">Pernikahan adalah kumpulan momen kecil yang tumbuh menjadi kisah cinta.</p>
                <div class="darkpre-gallery-grid"><div class="swiper mySwiper"><div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="{{ asset('tema/darkpre/src/img/gambar-1.jpg') }}" alt="Momen foto 1" onclick="openModalImg(this)"></div>
                    <div class="swiper-slide"><img src="{{ asset('tema/darkpre/src/img/gambar-2.jpg') }}" alt="Momen foto 2" onclick="openModalImg(this)"></div>
                    <div class="swiper-slide"><img src="{{ asset('tema/darkpre/src/img/gambar-3.jpg') }}" alt="Momen foto 3" onclick="openModalImg(this)"></div>
                </div><div class="swiper-pagination"></div></div></div>
            </section>

            <section id="wishes" class="darkpre-section darkpre-wishes-section" aria-label="Ucapan dan doa">
                <h2 class="darkpre-section-heading" data-aos="fade-up">Ucapan &amp; Doa</h2>
                <div class="darkpre-message-list">
                    <article class="darkpre-message-card"><strong>Andy Tengil</strong><p class="mt-1 text-xs text-orange-100/60">6 Maret 2025</p><p class="mt-2 text-sm italic">"Mantap, selamat ya!"</p></article>
                    <article class="darkpre-message-card"><strong>Selamat Tembak Dalam Coy</strong><p class="mt-1 text-xs text-orange-100/60">6 Maret 2025</p><p class="mt-2 text-sm italic">"Selamat menempuh hidup baru."</p></article>
                </div>
                <div class="darkpre-form-card"><h2 class="darkpre-form-title">Kirim Ucapan</h2><p class="darkpre-form-intro">Tinggalkan doa dan ucapan terbaik untuk kedua mempelai.</p>
                    <form action="#" class="darkpre-wish-form"><input type="text" placeholder="Nama Lengkap" class="darkpre-form-input p-3"><textarea rows="4" placeholder="Ucapan &amp; Doa" class="darkpre-form-input p-3"></textarea><select class="darkpre-form-input p-3"><option>Konfirmasi Kehadiran</option><option>Datang Dong</option><option>Tidak Bisa Datang Nih</option></select><button type="submit" class="darkpre-submit-button p-3">Kirim Sekarang</button></form>
                </div>
            </section>

            <footer class="darkpre-footer">presented by<br><span class="font-semibold">Wayae Nikah</span></footer>

            <nav class="darkpre-mobile-nav block lg:hidden" id="mobile-navbar" aria-label="Navigasi undangan"><div><div>
                <a aria-label="Pasangan" class="nav-link couple" href="#couple"><i class="fa-regular fa-heart"></i><span class="ml-2 hidden">Pasangan</span></a>
                <a aria-label="Acara" class="nav-link date" href="#date"><i class="fa-regular fa-calendar"></i><span class="ml-2 hidden">Acara</span></a>
                <a aria-label="Lokasi" class="nav-link location" href="#location"><i class="fa-solid fa-map-location-dot"></i><span class="ml-2 hidden">Lokasi</span></a>
                <a aria-label="Galeri" class="nav-link gallery" href="#gallery"><i class="fa-regular fa-images"></i><span class="ml-2 hidden">Galeri</span></a>
                <a aria-label="Ucapan" class="nav-link wishes" href="#wishes"><i class="fa-regular fa-note-sticky"></i><span class="ml-2 hidden">Ucapan</span></a>
            </div></div></nav>
        </main>

        <div id="imageModal" class="fixed hidden inset-0 z-50 flex items-center justify-center bg-black/80 p-4">
            <div class="relative"><img id="modalImageContent" class="max-h-screen max-w-full rounded-xl shadow-xl" src="" alt="Gambar kenangan"><button onclick="closeModalImg()" aria-label="Tutup gambar" class="absolute right-2 top-2 rounded-full bg-black/70 px-3 py-1 text-white">&times;</button></div>
        </div>

        <div id="infoModal" class="invisible fixed inset-0 flex items-center justify-center font-poppins">
            <div class="w-full max-w-sm rounded-2xl p-6 text-center"><h2 class="mb-3 text-lg font-bold text-stone-800">Kado</h2><p class="mb-4 text-sm text-stone-600">Terima kasih atas doa dan perhatian Anda.</p><img src="{{ asset('tema/darkpre/src/img/dana.png') }}" alt="Informasi kado" class="mx-auto mb-4 w-32"><button onclick="toggleModal()" type="button" class="rounded-full bg-stone-800 px-5 py-2 text-sm text-white">Tutup</button></div>
        </div>
    </div>

    <script src="{{ asset('tema/darkpre/assets/aos/dist/aos.js') }}"></script>
    <script src="{{ asset('tema/darkpre/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/darkpre/src/js/swiper.js') }}"></script>
    <script src="{{ asset('tema/darkpre/src/js/nav.js') }}"></script>
    <script src="{{ asset('tema/darkpre/src/js/modal.js') }}"></script>
    <script src="{{ asset('tema/darkpre/src/js/audio.js') }}"></script>
    <script>
        AOS.init({ duration: 850, easing: 'ease-out-cubic', once: true, offset: 70 });

        document.addEventListener('DOMContentLoaded', () => {
            const target = new Date('2025-04-02T09:00:00').getTime();
            const elements = ['days', 'hours', 'minutes', 'seconds'].reduce((map, id) => ({ ...map, [id]: document.getElementById(id) }), {});
            const update = () => {
                const distance = Math.max(0, target - Date.now());
                const values = {
                    days: Math.floor(distance / 86400000),
                    hours: Math.floor((distance % 86400000) / 3600000),
                    minutes: Math.floor((distance % 3600000) / 60000),
                    seconds: Math.floor((distance % 60000) / 1000),
                };
                Object.entries(values).forEach(([key, value]) => elements[key].textContent = String(value).padStart(2, '0'));
            };
            update();
            setInterval(update, 1000);
        });
    </script>
</body>

</html>
