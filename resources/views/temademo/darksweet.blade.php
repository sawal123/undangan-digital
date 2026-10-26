<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Darksweet — Justin & Sisca</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/css/style.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Capriola&family=Oleo+Script+Swash+Caps:wght@400;700&display=swap');
        .darksweet-body { font-family: Capriola, system-ui, sans-serif; }
        .darksweet-cover__title, .darksweet-section__title, .darksweet-hero__title, .darksweet-ending__title { font-family: 'Oleo Script Swash Caps', Georgia, serif; }
    </style>
</head>

<body class="darksweet-body darksweet-locked">
    <div class="darksweet-shell">
        <section id="cover" class="darksweet-cover" aria-label="Sampul undangan">
            <div class="darksweet-cover__backdrop" style="background-image: url('{{ asset('tema/darksweet/img/illustration.jpg') }}');"></div>
            <div class="darksweet-cover__card">
                <div class="darksweet-cover__monogram" aria-hidden="true"><i class="fa-solid fa-heart"></i></div>
                <p class="darksweet-cover__eyebrow">Happy Wedding</p>
                <h1 class="darksweet-cover__title">Justin & Sisca</h1>
                <p class="darksweet-cover__date">12 April 2027</p>
                <div class="darksweet-cover__visual">
                    <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}" alt="Foto Justin dan Sisca">
                </div>
                <p class="darksweet-cover__guest">Kepada<strong>Tamu Undangan</strong>Dengan penuh kebahagiaan, kami mengundang Anda untuk hadir di hari istimewa kami.</p>
                <button type="button" id="openCover" class="darksweet-button" style="margin-top: 1.35rem;"><i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>Buka Undangan</button>
            </div>
        </section>

        <main id="content" class="darksweet-content is-locked">
            <section id="hero" class="darksweet-hero">
                <div class="swiper mySwiper darksweet-hero__slider" aria-label="Foto pembuka undangan">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image: url('{{ asset('tema/darksweet/img/illustration.jpg') }}');"></div>
                        <div class="swiper-slide" style="background-image: url('{{ asset('tema/darksweet/img/pasangan.jpg') }}');"></div>
                        <div class="swiper-slide" style="background-image: url('{{ asset('tema/darksweet/img/wedding.jpg') }}');"></div>
                    </div>
                </div>
                <div class="darksweet-hero__content">
                    <p class="darksweet-hero__badge" data-aos="fade-down"><i class="fa-solid fa-sparkles" aria-hidden="true"></i> Happy Wedding</p>
                    <h1 class="darksweet-hero__title" data-aos="fade-up">Justin & Sisca</h1>
                    <div class="darksweet-hero__countdown" data-aos="fade-up" data-aos-delay="100">
                        <p class="darksweet-hero__date">12 April 2027</p>
                        <div id="countdown" class="darksweet-countdown date countdown" data-date="2027-04-12T10:00:00+07:00" aria-label="Hitung mundur acara">
                            <div class="darksweet-countdown__item"><span id="days" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Hari</span></div>
                            <div class="darksweet-countdown__item"><span id="hours" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Jam</span></div>
                            <div class="darksweet-countdown__item"><span id="minutes" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Menit</span></div>
                            <div class="darksweet-countdown__item"><span id="seconds" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Detik</span></div>
                        </div>
                    </div>
                    <div class="darksweet-scroll-hint" data-aos="fade-up" data-aos-delay="250"><i class="fa-solid fa-chevron-down" aria-hidden="true"></i><span>Gulir untuk melihat cerita kami</span></div>
                </div>
            </section>

            <section id="pengantin" class="darksweet-section darksweet-section--soft">
                <div class="darksweet-section__header" data-aos="fade-up"><p class="darksweet-eyebrow">Dengan penuh rasa syukur</p><h2 class="darksweet-section__title">Tentang Kami</h2><p class="darksweet-section__subtitle">Dua hati, satu cerita, dan perjalanan baru yang ingin kami rayakan bersama.</p></div>
                <p class="darksweet-lead" data-aos="fade-up">Atas rahmat dan kasih Tuhan, kami memohon doa restu untuk memulai kehidupan baru sebagai pasangan.</p>
                <div class="darksweet-couple-grid">
                    <article class="darksweet-person-card" data-aos="fade-up"><div class="darksweet-person-card__image"><img src="{{ asset('tema/darksweet/img/young-bride-groom-outdoor-photoshoot.jpg') }}" alt="Justin" loading="lazy"></div><div class="darksweet-person-card__body"><h3 class="darksweet-person-card__name">Tobias Justin</h3><p class="darksweet-person-card__description">Putra dari Bapak Justin dan Ibu Justin.</p></div></article>
                    <article class="darksweet-person-card" data-aos="fade-up"><div class="darksweet-person-card__image"><img src="{{ asset('tema/darksweet/img/smiley-newlyweds-posing-together-outdoors.jpg') }}" alt="Sisca" loading="lazy"></div><div class="darksweet-person-card__body"><h3 class="darksweet-person-card__name">Sisca Kohl</h3><p class="darksweet-person-card__description">Putri dari Bapak Sisca dan Ibu Sisca.</p></div></article>
                </div>
            </section>

            <section id="hitunghari" class="darksweet-section darksweet-section--accent">
                <div class="darksweet-section__header" data-aos="fade-up"><p class="darksweet-eyebrow">Menuju hari bahagia</p><h2 class="darksweet-section__title">Menghitung Hari</h2></div>
                <p class="darksweet-quote" data-aos="fade-up">“Dan di antara tanda-tanda kekuasaan-Nya, Dia menciptakan pasangan hidup untukmu agar kamu merasa tenteram, dan menjadikan kasih sayang.”<br><span style="color: var(--ds-gold);">(QS. Ar-Rum: 21)</span></p>
                <div style="text-align: center;" data-aos="fade-up"><a class="darksweet-button darksweet-button--ghost" href="https://www.google.com/calendar/render?action=TEMPLATE&text=The%20Wedding%20of%20Justin%20%26%20Sisca&dates=20270412T100000Z/20270412T120000Z" target="_blank" rel="noopener"><i class="fa-regular fa-calendar-plus" aria-hidden="true"></i>Simpan ke Kalender</a></div>
            </section>

            <section id="savethedate" class="darksweet-section darksweet-section--soft">
                <div class="darksweet-section__header" data-aos="fade-up"><p class="darksweet-eyebrow">Catat tanggalnya</p><h2 class="darksweet-section__title">Acara Kami</h2><p class="darksweet-section__subtitle">Kami menantikan kehadiran dan doa restu Anda.</p></div>
                <div class="darksweet-event-list">
                    <article class="darksweet-event-card" data-aos="fade-up" style="background-image: url('{{ asset('tema/darksweet/img/download (4).jpg') }}');"><h3 class="darksweet-event-card__title">Akad Nikah</h3><div class="darksweet-event-card__date"><span class="darksweet-event-card__day">12</span><span class="darksweet-event-card__meta">Senin<br>April 2027</span></div><p class="darksweet-event-card__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Rumah Justin<br>Jakarta</p><a class="darksweet-event-card__link" href="#map">Lihat lokasi <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></a></article>
                    <article class="darksweet-event-card" data-aos="fade-up" style="background-image: url('{{ asset('tema/darksweet/img/wedding.jpg') }}');"><h3 class="darksweet-event-card__title">Resepsi Pernikahan</h3><div class="darksweet-event-card__date"><span class="darksweet-event-card__day">12</span><span class="darksweet-event-card__meta">Senin<br>April 2027</span></div><p class="darksweet-event-card__location"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Gedung Bahagia<br>Jakarta</p><a class="darksweet-event-card__link" href="#map">Lihat lokasi <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></a></article>
                </div>
            </section>

            <section id="story" class="darksweet-section darksweet-section--accent">
                <div class="darksweet-section__header" data-aos="fade-up"><p class="darksweet-eyebrow">Potongan perjalanan kami</p><h2 class="darksweet-section__title">Our Story</h2><p class="darksweet-section__subtitle">Momen-momen kecil yang membawa kami sampai di hari ini.</p></div>
                <div class="darksweet-story-list">
                    <article class="darksweet-story-card" data-aos="fade-up"><div class="darksweet-story-card__image"><img src="{{ asset('tema/darksweet/img/wedding-potret.jpg') }}" alt="Pertemuan pertama" loading="lazy"></div><div class="darksweet-story-card__body"><h3 class="darksweet-story-card__title">Pertama kali bertemu</h3><p class="darksweet-story-card__text">Sebuah pertemuan sederhana yang perlahan tumbuh menjadi cerita yang berarti.</p></div></article>
                    <article class="darksweet-story-card" data-aos="fade-up"><div class="darksweet-story-card__image"><img src="{{ asset('tema/darksweet/img/pasangan.jpg') }}" alt="Perjalanan bersama" loading="lazy"></div><div class="darksweet-story-card__body"><h3 class="darksweet-story-card__title">Menemukan rumah</h3><p class="darksweet-story-card__text">Kami belajar bahwa rumah bukan hanya tempat, tetapi seseorang yang selalu ingin kita tuju.</p></div></article>
                </div>
            </section>

            <section id="gallery" class="darksweet-section darksweet-section--soft">
                <div class="darksweet-section__header" data-aos="fade-up"><p class="darksweet-eyebrow">Momen yang kami simpan</p><h2 class="darksweet-section__title">Galeri</h2><p class="darksweet-section__subtitle">Beberapa bingkai kecil dari perjalanan kami.</p></div>
                <div class="darksweet-gallery" data-aos="fade-up">
                    @foreach (['wedding-potret.jpg', 'prewed-square.jpg', 'pasangan.jpg', 'wedding.jpg', 'young-bride-groom-outdoor-photoshoot.jpg', 'smiley-newlyweds-posing-together-outdoors.jpg'] as $image)
                        <button type="button" class="darksweet-gallery__item" onclick="openModalImg(this.querySelector('img'))" aria-label="Buka foto galeri"><img src="{{ asset('tema/darksweet/img/' . $image) }}" alt="Foto momen pernikahan" loading="lazy"></button>
                    @endforeach
                </div>
            </section>

            <section id="hadiah" class="darksweet-section darksweet-section--accent">
                <div class="darksweet-section__header" data-aos="fade-up"><p class="darksweet-eyebrow">Tanda kasih</p><h2 class="darksweet-section__title">Titip Hadiah</h2><p class="darksweet-section__subtitle">Doa dan kehadiran Anda adalah hadiah terindah bagi kami.</p></div>
                <div class="darksweet-gift-list">
                    <article class="darksweet-gift-card" data-aos="fade-up"><div class="darksweet-gift-card__icon"><i class="fa-solid fa-building-columns"></i></div><div><p class="darksweet-gift-card__name">Sisca Kohl</p><p class="darksweet-gift-card__number">12345678</p></div><button type="button" class="darksweet-copy-button" data-copy="12345678">Salin</button></article>
                    <article class="darksweet-gift-card" data-aos="fade-up"><div class="darksweet-gift-card__icon"><i class="fa-solid fa-building-columns"></i></div><div><p class="darksweet-gift-card__name">Tobias Justin</p><p class="darksweet-gift-card__number">0982309823</p></div><button type="button" class="darksweet-copy-button" data-copy="0982309823">Salin</button></article>
                </div>
            </section>

            <section id="absen" class="darksweet-section darksweet-section--soft">
                <div class="darksweet-attendance">
                    <div class="darksweet-section__header" data-aos="fade-up"><p class="darksweet-eyebrow">Doa dan harapan</p><h2 class="darksweet-section__title">Kirim Ucapan</h2><p class="darksweet-section__subtitle">Tinggalkan pesan terbaik untuk kedua mempelai.</p></div>
                    <form class="darksweet-form" data-aos="fade-up" onsubmit="event.preventDefault(); alert('Terima kasih atas ucapan Anda.');"><div class="darksweet-form__field"><label for="demo-nama">Nama lengkap</label><input id="demo-nama" type="text" placeholder="Masukkan nama Anda" required></div><div class="darksweet-form__field"><label for="demo-ucapan">Ucapan dan doa</label><textarea id="demo-ucapan" placeholder="Tulis ucapan terbaik Anda" required></textarea></div><div class="darksweet-form__field"><label for="demo-status">Konfirmasi kehadiran</label><select id="demo-status" required><option value="" disabled selected>Pilih status kehadiran</option><option>Saya akan hadir</option><option>Maaf, saya tidak bisa hadir</option><option>Masih diusahakan hadir</option></select></div><button type="submit" class="darksweet-button">Kirim Ucapan</button></form>
                    <div class="darksweet-message-list" data-aos="fade-up"><article class="darksweet-message-card"><div class="darksweet-message-card__top"><strong class="darksweet-message-card__name">Andi</strong><span class="darksweet-message-card__status">Hadir</span></div><p class="darksweet-message-card__date">12 Maret 2027</p><p class="darksweet-message-card__text">Selamat menempuh hidup baru. Semoga selalu bahagia.</p></article><article class="darksweet-message-card"><div class="darksweet-message-card__top"><strong class="darksweet-message-card__name">Rina</strong><span class="darksweet-message-card__status">Hadir</span></div><p class="darksweet-message-card__date">10 Maret 2027</p><p class="darksweet-message-card__text">Semoga menjadi keluarga yang penuh kasih.</p></article></div>
                </div>
            </section>

            <section id="map" class="darksweet-section darksweet-section--accent"><div class="darksweet-section__header"><p class="darksweet-eyebrow">Sampai jumpa</p><h2 class="darksweet-section__title">Terima Kasih</h2><p class="darksweet-section__subtitle">Sampai bertemu di hari bahagia kami.</p></div></section>
        </main>

        <nav class="darksweet-nav" aria-label="Navigasi undangan"><div class="darksweet-nav__inner"><a class="darksweet-nav__link" href="#hero"><i class="fa-solid fa-house"></i><span>Home</span></a><a class="darksweet-nav__link" href="#pengantin"><i class="fa-solid fa-heart"></i><span>Pasangan</span></a><a class="darksweet-nav__link" href="#savethedate"><i class="fa-solid fa-calendar-days"></i><span>Acara</span></a><a class="darksweet-nav__link" href="#story"><i class="fa-solid fa-clock-rotate-left"></i><span>Cerita</span></a><a class="darksweet-nav__link" href="#gallery"><i class="fa-solid fa-images"></i><span>Galeri</span></a><a class="darksweet-nav__link" href="#absen"><i class="fa-solid fa-comment-dots"></i><span>Ucapan</span></a><button type="button" id="toggleButton" class="darksweet-nav__link" aria-label="Musik"><i class="fa-solid fa-music"></i><span>Musik</span></button></div></nav>
    </div>

    <div id="imageModal" class="darksweet-modal is-hidden" role="dialog" aria-modal="true" aria-label="Pratinjau foto"><div class="darksweet-modal__panel"><button type="button" class="darksweet-modal__close" onclick="closeModalImg()" aria-label="Tutup foto">&times;</button><img id="modalImage" class="darksweet-modal__image" src="" alt="Pratinjau foto"></div></div>

    <script src="{{ asset('tema/darksweet/assets/aos/dist/aos.js') }}"></script>
    <script>window.addEventListener('load', () => window.AOS?.init({ once: true, duration: 750, offset: 70 }));</script>
    <script src="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/setDate.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/swiper.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/autoScroll.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/modalImage.js') }}"></script>
    <script>
        document.addEventListener('click', function (event) {
            const button = event.target.closest('[data-copy]');
            if (!button) return;
            navigator.clipboard?.writeText(button.dataset.copy).then(() => {
                const originalText = button.textContent;
                button.textContent = 'Tersalin';
                window.setTimeout(() => { button.textContent = originalText; }, 1400);
            });
        });
    </script>
</body>

</html>
