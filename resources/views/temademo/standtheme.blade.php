<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Standtheme — Teddy & Ajeng</title>
    <link rel="stylesheet" href="{{ asset('tema/standtheme/assets/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/standtheme/css/style.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Capriola&family=Dancing+Script:wght@400..700&display=swap');
        .stand-body { font-family: Capriola, system-ui, sans-serif; }
        .stand-title, .stand-script, .stand-modal__title, .stand-cover__title, .stand-opening__names, .stand-event-card__title, .stand-footer__title, .stand-music-modal__panel h2 { font-family: 'Dancing Script', cursive; }
    </style>
</head>

<body class="stand-body is-locked">
    <div class="stand-shell">
        <section id="modal" class="stand-modal" aria-label="Sampul undangan">
            <div class="stand-modal__panel"><div class="stand-modal__content"><p class="stand-modal__label">Jamuan Syukuran</p><h1 class="stand-modal__title">Teddy &amp; Ajeng</h1><div class="stand-modal__image"><img src="{{ asset('tema/standtheme/assets/img/cover.jpg') }}" alt="Foto Teddy dan Ajeng"></div><p class="stand-modal__guest">Kepada<strong>Tamu Undangan</strong>Dengan hormat, kami mengundang Anda untuk hadir dan memberikan doa restu.</p><button type="button" id="closeModal" class="stand-button stand-button--light"><i class="fa-solid fa-envelope-open-text"></i>Buka Undangan</button></div></div>
        </section>

        <main id="standContent" class="stand-main">
            <section id="standCover" class="stand-cover" style="background-image: url('{{ asset('tema/standtheme/assets/img/cover.jpg') }}');"><div class="stand-cover__content" data-aos="fade-up"><p class="stand-cover__eyebrow">Jamuan Syukuran</p><h1 class="stand-cover__title">Teddy &amp; Ajeng</h1><p class="stand-cover__date">Minggu, 7 September 2025</p><div class="stand-cover__hint"><i class="fa-solid fa-chevron-down"></i><span>Gulir untuk melihat undangan</span></div></div></section>

            <section class="stand-section stand-opening" data-aos="fade-up"><img class="stand-opening__ornament" src="{{ asset('tema/standtheme/assets/img/bismillah.png') }}" alt="Bismillah"><p class="stand-eyebrow">Dengan penuh rasa syukur</p><h2 class="stand-opening__names">Teddy Prakarsa</h2><p class="stand-opening__ampersand">&amp;</p><h2 class="stand-opening__names">Ajeng Febian</h2><div class="stand-opening__portrait"><img src="{{ asset('tema/standtheme/assets/img/3.jpg') }}" alt="Foto Teddy dan Ajeng" loading="lazy"></div><p class="stand-opening__description">Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami mengundang Anda untuk hadir di hari bahagia kami.</p><p class="stand-date"><strong>Save the Date</strong><br>Minggu, 7 September 2025</p><a class="stand-button" href="https://www.google.com/calendar/render?action=TEMPLATE&text=Jamuan%20Syukuran%20Teddy%20%26%20Ajeng&dates=20250907T100000Z/20250907T120000Z" target="_blank" rel="noopener"><i class="fa-regular fa-calendar-plus"></i>Tambah ke Kalender</a><div class="stand-quote">“Semoga menjadi keluarga yang penuh kasih, ketenangan, dan keberkahan.”<br><span>— Dengan doa terbaik dari keluarga</span></div></section>

            <section id="standAcara" class="stand-section stand-section--soft"><div class="stand-section__header" data-aos="fade-up"><p class="stand-eyebrow">Catat tanggalnya</p><h2 class="stand-section__title">Acara Kami</h2><p class="stand-section__subtitle">Kami menantikan kehadiran dan doa restu Anda.</p></div><div class="stand-event-list"><article class="stand-event-card" data-aos="fade-up"><h3 class="stand-event-card__title">Akad Nikah</h3><div class="stand-event-card__date"><span>Minggu</span><span><strong class="stand-event-card__day">07</strong><span class="stand-event-card__meta">September 2025</span></span><span>10.00 WIB</span></div><p class="stand-event-card__location"><i class="fa-solid fa-location-dot"></i><br>Gedung Bahagia<br>Jakarta</p><div class="stand-event-card__actions"><a class="stand-button" href="#standMap"><i class="fa-solid fa-location-dot"></i>Lihat Lokasi</a></div></article><article class="stand-event-card" data-aos="fade-up"><h3 class="stand-event-card__title">Jamuan Syukuran</h3><div class="stand-event-card__date"><span>Minggu</span><span><strong class="stand-event-card__day">07</strong><span class="stand-event-card__meta">September 2025</span></span><span>12.00 WIB</span></div><p class="stand-event-card__location"><i class="fa-solid fa-location-dot"></i><br>Rumah Keluarga<br>Jakarta</p><div class="stand-event-card__actions"><a class="stand-button" href="#standMap"><i class="fa-solid fa-location-dot"></i>Lihat Lokasi</a></div></article></div></section>

            <section class="stand-section stand-section--brown" data-aos="fade-up"><div class="stand-section__header"><p class="stand-eyebrow" style="color:#f1d7b0;">Menuju hari bahagia</p><h2 class="stand-section__title">Hitung Mundur</h2></div><div class="stand-countdown" data-stand-countdown data-date="2025-09-07T10:00:00+07:00"><div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="days">00</span><span class="stand-countdown__label">Hari</span></div><div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="hours">00</span><span class="stand-countdown__label">Jam</span></div><div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="minutes">00</span><span class="stand-countdown__label">Menit</span></div><div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="seconds">00</span><span class="stand-countdown__label">Detik</span></div></div><p class="stand-countdown__note">Sampai bertemu di hari yang penuh kebahagiaan.</p></section>

            <section id="standGallery" class="stand-section"><div class="stand-section__header" data-aos="fade-up"><p class="stand-eyebrow">Momen yang kami simpan</p><h2 class="stand-section__title">Album Gallery</h2><p class="stand-section__subtitle">Beberapa momen kecil dari perjalanan kami.</p></div><div class="stand-gallery" data-aos="fade-up">@foreach (['3.jpg', '4.jpg', 'cover.jpg'] as $image)<button type="button" class="stand-gallery__item" onclick="openStandLightbox(this.querySelector('img'))" aria-label="Buka foto galeri"><img src="{{ asset('tema/standtheme/assets/img/' . $image) }}" alt="Foto momen pernikahan" loading="lazy"></button>@endforeach</div></section>

            <section class="stand-section stand-section--soft"><div class="stand-section__header" data-aos="fade-up"><p class="stand-eyebrow">Tanda kasih</p><h2 class="stand-section__title">Titip Hadiah</h2><p class="stand-section__subtitle">Doa dan kehadiran Anda adalah hadiah terindah bagi kami.</p></div><div class="stand-gift-list"><article class="stand-gift-card" data-aos="fade-up"><p class="stand-gift-card__bank">Bank Contoh</p><p class="stand-gift-card__name">Teddy Prakarsa</p><p class="stand-gift-card__number">1234 5678 90</p><button type="button" class="stand-button stand-gift-card__button" data-copy="1234567890"><i class="fa-regular fa-copy"></i>Salin Nomor</button></article></div></section>

            <section id="standMap" class="stand-section stand-section--soft"><div class="stand-section__header" data-aos="fade-up"><p class="stand-eyebrow">Temukan lokasi acara</p><h2 class="stand-section__title">Peta Lokasi</h2><p class="stand-section__subtitle">Gunakan peta berikut untuk menemukan tempat acara kami.</p></div><div class="stand-map" data-aos="fade-up"><iframe src="https://www.google.com/maps" title="Peta lokasi acara" loading="lazy"></iframe></div></section>

            <section id="standUcapan" class="stand-section"><div class="stand-message-wrap"><div class="stand-section__header" data-aos="fade-up"><p class="stand-eyebrow">Doa dan harapan</p><h2 class="stand-section__title">Kirim Ucapan</h2><p class="stand-section__subtitle">Tinggalkan pesan terbaik untuk kedua mempelai.</p></div><form class="stand-form" data-aos="fade-up" onsubmit="event.preventDefault(); alert('Terima kasih atas ucapan Anda.');"><div class="stand-form__field"><label for="demoNama">Nama lengkap</label><input id="demoNama" type="text" placeholder="Masukkan nama Anda" required></div><div class="stand-form__field"><label for="demoUcapan">Ucapan dan doa</label><textarea id="demoUcapan" placeholder="Tulis ucapan terbaik Anda" required></textarea></div><div class="stand-form__field"><label for="demoStatus">Konfirmasi kehadiran</label><select id="demoStatus" required><option value="" disabled selected>Pilih status kehadiran</option><option>Saya akan hadir</option><option>Maaf, saya tidak bisa hadir</option><option>Masih diusahakan hadir</option></select></div><button type="submit" class="stand-button">Kirim Ucapan</button></form><div class="stand-message-list" data-aos="fade-up"><article class="stand-message-card"><div class="stand-message-card__top"><strong class="stand-message-card__name">Rani</strong><span class="stand-message-card__status">Hadir</span></div><p class="stand-message-card__date">2 September 2025</p><p class="stand-message-card__text">Selamat menempuh hidup baru. Semoga selalu bahagia.</p></article></div></div></section>

            <footer class="stand-footer"><h2 class="stand-footer__title">Terima Kasih</h2><p class="stand-footer__text">Dengan penuh kasih, Teddy &amp; Ajeng</p></footer>
        </main>

        <nav class="stand-nav" aria-label="Navigasi undangan"><div class="stand-nav__inner"><a class="stand-nav__link" href="#standCover"><i class="fa-solid fa-house"></i><span>Home</span></a><a class="stand-nav__link" href="#standAcara"><i class="fa-solid fa-calendar-days"></i><span>Acara</span></a><a class="stand-nav__link" href="#standGallery"><i class="fa-solid fa-images"></i><span>Galeri</span></a><a class="stand-nav__link" href="#standMap"><i class="fa-solid fa-location-dot"></i><span>Lokasi</span></a><a class="stand-nav__link" href="#standUcapan"><i class="fa-solid fa-comment-dots"></i><span>Ucapan</span></a></div></nav>
    </div>

    <div id="standLightbox" class="stand-lightbox is-hidden" role="dialog" aria-modal="true" aria-label="Pratinjau foto"><div class="stand-lightbox__panel"><button type="button" class="stand-lightbox__close" onclick="closeStandLightbox()" aria-label="Tutup foto">&times;</button><img id="standLightboxImage" src="" alt="Pratinjau foto"></div></div>

    <script src="{{ asset('tema/standtheme/assets/aos/dist/aos.js') }}"></script>
    <script>window.addEventListener('load', () => window.AOS?.init({ once: true, duration: 750, offset: 70 }));</script>
    <script src="{{ asset('tema/standtheme/js/modal.js') }}"></script>
</body>

</html>
