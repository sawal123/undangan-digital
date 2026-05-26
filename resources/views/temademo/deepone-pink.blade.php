<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>Undangan Pernikahan Pink | Melissa & Damian</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fff5f8; /* soft pink background */
            overflow-x: hidden;
            color: #5e3a4a;
            position: relative;
            min-height: 100vh;
        }

        /* Latar belakang bunga bergoyang (pink tone) */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" opacity="0.12"><path fill="%23f7bedd" d="M50,40 L55,55 L70,58 L55,62 L50,78 L45,62 L30,58 L45,55 Z" transform="scale(0.8) translate(10,10)"/><path fill="%23f5a9c7" d="M130,90 L135,105 L150,108 L135,112 L130,128 L125,112 L110,108 L125,105 Z" transform="scale(0.9) translate(5,5)"/><path fill="%23f3c5dd" d="M80,150 L85,165 L100,168 L85,172 L80,188 L75,172 L60,168 L75,165 Z" transform="scale(0.7) translate(20,10)"/><path fill="%23ffd9e8" d="M170,30 L175,45 L190,48 L175,52 L170,68 L165,52 L150,48 L165,45 Z" transform="scale(0.6) translate(30,60)"/><circle cx="40" cy="120" r="6" fill="%23f5b1cf" opacity="0.6"/><circle cx="160" cy="180" r="8" fill="%23f7bfda" opacity="0.5"/></svg>');
            background-repeat: repeat;
            background-size: 120px;
            animation: swayBunga 20s infinite alternate ease-in-out;
        }

        @keyframes swayBunga {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0.5; }
            100% { transform: translateY(15px) rotate(3deg); opacity: 0.85; }
        }

        /* phone container */
        .phone-container {
            max-width: 500px;
            margin: 0 auto;
            background: #fffafc;
            box-shadow: 0 0 40px rgba(0,0,0,0.05);
            min-height: 100vh;
            position: relative;
            z-index: 2;
        }

        /* cover screen */
        .cover-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            max-width: 500px;
            right: 0;
            margin: 0 auto;
            height: 100vh;
            background: #2d1e24;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            opacity: 1;
        }

        .cover-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.55);
            z-index: -1;
        }

        .cover-content {
            padding: 32px 24px;
            color: white;
            z-index: 2;
            animation: fadeInUp 1s ease;
        }

        .cover-content h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            letter-spacing: 2px;
            font-size: 1rem;
            margin-bottom: 16px;
        }

        .cover-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            margin: 12px 0;
            line-height: 1.2;
        }

        .cover-date {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 32px;
        }

        .guest-card {
            background: rgba(255,240,245,0.2);
            backdrop-filter: blur(8px);
            border-radius: 48px;
            padding: 16px 24px;
            margin: 24px 0;
            border: 1px solid rgba(255,200,220,0.5);
        }

        .guest-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 6px;
            color: #ffe0f0;
        }

        .btn-gold, .btn-pink {
            background: #e9a2c0;
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 1rem;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 20px;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-family: 'Poppins', sans-serif;
        }
        .btn-pink:active, .btn-gold:active { transform: scale(0.96); background: #db8aac; }

        .main-content {
            display: none;
            opacity: 0;
            transition: opacity 0.5s;
        }
        .main-content.show {
            display: block;
            opacity: 1;
        }

        section {
            padding: 48px 24px;
            border-bottom: 1px solid #fbe4ef;
            position: relative;
            transition: transform 0.6s ease, opacity 0.6s ease;
            transform: translateY(35px);
            opacity: 0;
            background-color: rgba(255, 250, 252, 0.9);
            border-radius: 0;
        }
        section.section-visible {
            transform: translateY(0);
            opacity: 1;
        }

        /* Hero section pink overlay */
        .hero-bg-section {
            background: linear-gradient(rgba(80, 40, 55, 0.65), rgba(60, 30, 40, 0.7)), url('https://images.unsplash.com/photo-1519741497674-611481863552?w=800&auto=format');
            background-size: cover;
            background-position: center 30%;
            border-radius: 0 0 48px 48px;
            margin-top: -20px;
            padding-top: 60px;
            color: #ffffff;
        }
        .hero-bg-section .couple-names-hero,
        .hero-bg-section .hero-date,
        .hero-bg-section .quote-block,
        .hero-bg-section .countdown .cd-card {
            color: #fff9f0;
        }
        .hero-bg-section .countdown .cd-card {
            background: rgba(245, 200, 220, 0.25);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,200,220,0.6);
        }
        .hero-bg-section .quote-block {
            background: rgba(0,0,0,0.2);
            backdrop-filter: blur(4px);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            text-align: center;
            margin-bottom: 32px;
            color: #c27e9b;
            letter-spacing: -0.3px;
            position: relative;
        }
        .section-title:after {
            content: "✦";
            display: block;
            font-size: 1.3rem;
            color: #e9a2c0;
            margin-top: 6px;
        }

        .floral-divider {
            text-align: center;
            font-size: 1.6rem;
            color: #e9a2c0;
            margin: 24px 0;
            animation: gentleFloat 3s ease-in-out infinite;
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        @keyframes gentleFloat {
            0% { transform: translateY(0px); opacity: 0.7; }
            50% { transform: translateY(5px); opacity: 1; }
            100% { transform: translateY(0px); opacity: 0.7; }
        }

        .couple-names-hero {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .hero-date {
            text-align: center;
            font-weight: 500;
        }
        .quote-block {
            background: #fff0f5;
            padding: 24px;
            border-radius: 28px;
            font-style: italic;
            text-align: center;
            margin: 24px 0;
            color: #a05e7c;
        }
        .countdown {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 28px 0;
        }
        .cd-card {
            background: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            border-radius: 24px;
            flex: 1;
            text-align: center;
            padding: 14px 6px;
            border: 1px solid #fad5e5;
        }
        .cd-number {
            font-size: 1.8rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            color: #d48db0;
        }
        .couple-card {
            background: #fff7fa;
            border-radius: 32px;
            padding: 24px;
            margin: 24px 0;
            text-align: center;
            box-shadow: 0 12px 28px rgba(0,0,0,0.04);
            border: 1px solid #fad5e5;
        }
        .couple-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 16px;
            border: 3px solid #f5bed9;
        }
        .ampersand {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            text-align: center;
            color: #e9a2c0;
        }
        .timeline-item {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
            background: #fff8fb;
            padding: 16px;
            border-radius: 32px;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            border: 1px solid #fad5e5;
        }
        .timeline-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 28px;
            border: 2px solid #f7c0db;
        }
        .timeline-year {
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: #c27e9b;
            min-width: 70px;
        }
        .timeline-content strong {
            color: #b46384;
        }
        .event-card, .gift-card {
            background: #fff9fc;
            border-radius: 32px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #fad5e5;
        }
        .btn-outline-pink {
            background: none;
            border: 1.5px solid #e9a2c0;
            padding: 10px 20px;
            border-radius: 40px;
            color: #b15e82;
            font-weight: 500;
            margin-top: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-outline-pink:hover {
            background: #fdeef4;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .gallery-grid img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 24px;
            cursor: pointer;
        }
        .gallery-grid img:first-child {
            grid-column: span 2;
            height: 240px;
        }
        .lightbox {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            visibility: hidden;
            opacity: 0;
        }
        .lightbox.active {
            visibility: visible;
            opacity: 1;
        }
        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 16px;
        }
        .wish-card {
            background: #fff7fa;
            border-radius: 28px;
            padding: 16px;
            margin-bottom: 16px;
            border: 1px solid #fad5e5;
        }
        /* Floating music button */
        .floating-music {
            position: fixed;
            bottom: 80px;
            right: 16px;
            z-index: 1200;
            background: #ffeef4cc;
            backdrop-filter: blur(8px);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            cursor: pointer;
            color: #d982a8;
            border: 1px solid #f9c2dd;
        }

        /* ========== GAYA NAVIGASI BARU (PINK ELEGAN) ========== */
        .bottom-nav {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 32px);
            max-width: 400px;
            background: rgba(255, 240, 245, 0.88);
            backdrop-filter: blur(20px);
            border-radius: 60px;
            display: flex;
            justify-content: space-between;
            padding: 6px 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            z-index: 1100;
            border: 1px solid rgba(245, 190, 210, 0.5);
        }
        .nav-item {
            text-align: center;
            color: #b15e82;
            font-size: 0.7rem;
            transition: 0.2s;
            cursor: pointer;
            flex: 1;
            padding: 8px 4px;
            border-radius: 40px;
            background: transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }
        .nav-item i {
            font-size: 1.3rem;
            transition: 0.2s;
        }
        .nav-item span {
            font-weight: 500;
            font-size: 0.65rem;
            letter-spacing: 0.3px;
        }
        .nav-item.active, .nav-item:active {
            background: #e9a2c0;
            color: white;
            box-shadow: 0 2px 8px rgba(233, 162, 192, 0.3);
        }
        .nav-item.active i, .nav-item.active span {
            color: white;
        }

        input, select, textarea {
            width: 100%;
            padding: 14px;
            border-radius: 32px;
            border: 1px solid #f7c0db;
            margin-bottom: 14px;
            font-family: inherit;
            background: #fffefd;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @media (max-width: 500px) {
            .phone-container { max-width: 100%; }
            .cover-screen { max-width: 100%; }
        }
    </style>
</head>
<body>
<div class="phone-container">
    <!-- COVER SCREEN -->
    <div class="cover-screen" id="coverScreen">
        <img class="cover-bg" src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&auto=format" alt="wedding cover">
        <div class="cover-content">
            <h3>The Wedding Of</h3>
            <h1>Melissa <span style="font-weight:400">&</span> Damian</h1>
            <div class="cover-date">Sabtu, 30 November 2025</div>
            <div class="guest-card">
                <p>Kepada Yth. Bapak/Ibu/Saudara/i</p>
                <div class="guest-name" id="guestNameDisplay">Keluarga & Teman Terkasih</div>
            </div>
            <button class="btn-pink" id="openInvitationBtn">✨ Buka Undangan ✨</button>
            <div style="margin-top: 20px; font-size:12px;"> <i class="fas fa-chevron-down"></i> </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content" id="mainContent">
        <section id="heroSection" class="hero-bg-section" style="padding-top: 56px;">
            <div class="couple-names-hero">Melissa Aurelia <span style="font-weight:400">&</span> Damian Pratama</div>
            <div class="hero-date">30 November 2025</div>
            <div class="floral-divider"><span>🌸</span> <span>✽</span> <span>🌿</span> <span>✾</span> <span>🌼</span></div>
            <div class="quote-block">“Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.” <br/>— QS. Ar-Rum:21</div>
            <div class="countdown" id="countdownContainer">
                <div class="cd-card"><span class="cd-number" id="days">00</span><br/>Hari</div>
                <div class="cd-card"><span class="cd-number" id="hours">00</span><br/>Jam</div>
                <div class="cd-card"><span class="cd-number" id="minutes">00</span><br/>Menit</div>
                <div class="cd-card"><span class="cd-number" id="seconds">00</span><br/>Detik</div>
            </div>
        </section>

        <section id="coupleSection">
            <div class="section-title">Mempelai</div>
            <div class="floral-divider"><span>🌹</span> <span>✿</span> <span>🌸</span></div>
            <div class="couple-card">
                <img class="couple-img" src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=400&auto=format" alt="bride">
                <h3>Melissa Aurelia Putri</h3>
                <p>Putri dari Bapak Irwan & Ibu Sari</p>
                <a href="#" style="color:#d48db0;"><i class="fab fa-instagram"></i> @melissa.aurel</a>
            </div>
            <div class="ampersand">&</div>
            <div class="couple-card">
                <img class="couple-img" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format" alt="groom">
                <h3>Damian Pratama Hartono</h3>
                <p>Putra dari Bapak Joko & Ibu Dewi</p>
                <a href="#" style="color:#d48db0;"><i class="fab fa-instagram"></i> @damian.prtma</a>
            </div>
        </section>

        <section id="eventSection">
            <div class="section-title">Save The Date</div>
            <div class="floral-divider"><span>🏵️</span> <span>✤</span> <span>🍃</span></div>
            <div id="eventsList"></div>
        </section>

        <section id="storySection">
            <div class="section-title">Kisah Kami</div>
            <div class="floral-divider"><span>💮</span> <span>✽</span> <span>🌾</span></div>
            <div id="timelineContainer"></div>
        </section>

        <section id="gallerySection">
            <div class="section-title">Galeri</div>
            <div class="floral-divider"><span>📸</span> <span>🌺</span> <span>✨</span></div>
            <div class="gallery-grid" id="galleryGrid"></div>
        </section>

        <section id="streamingSection" style="display: none;">
            <div class="section-title">Live Streaming</div>
            <div class="event-card" style="text-align:center">
                <i class="fas fa-video" style="font-size:2rem; color:#e9a2c0;"></i>
                <p style="margin:12px 0">Turut hadir secara virtual melalui siaran langsung kami.</p>
                <button class="btn-outline-pink" id="streamBtn"><i class="fab fa-youtube"></i> Tonton Streaming</button>
            </div>
        </section>

        <section id="giftSection">
            <div class="section-title">Wedding Gift</div>
            <div class="floral-divider"><span>🎁</span> <span>🌷</span> <span>💝</span></div>
            <p style="text-align:center; margin-bottom:24px;">Doa restu Anda merupakan hadiah terindah. Tanda kasih dapat disampaikan melalui:</p>
            <div id="giftCardsContainer"></div>
        </section>

        <section id="rsvpSection">
            <div class="section-title">Ucapan & Konfirmasi Kehadiran</div>
            <div class="floral-divider"><span>💌</span> <span>✉️</span> <span>🌹</span></div>
            <form id="rsvpForm">
                <input type="text" id="guestName" placeholder="Nama Anda" required>
                <select id="attendanceStatus">
                    <option value="Hadir">Hadir</option>
                    <option value="Tidak Dapat Hadir">Tidak Dapat Hadir</option>
                    <option value="Masih Ragu">Masih Ragu</option>
                </select>
                <input type="number" id="guestCount" placeholder="Jumlah Tamu" min="1" value="1">
                <textarea id="wishMessage" rows="2" placeholder="Ucapan dan Doa..."></textarea>
                <button type="submit" class="btn-pink" style="width:100%">Kirim Ucapan</button>
            </form>
            <div id="wishesList" style="margin-top: 32px;"></div>
            <button id="loadMoreWishes" class="btn-outline-pink" style="width:100%; text-align:center;">Lihat Lebih Banyak</button>
        </section>

        <section id="closingSection" style="background: linear-gradient(rgba(80,40,55,0.7), rgba(60,30,40,0.8)), url('https://images.unsplash.com/photo-1519741497674-611481863552?w=800&auto=format'); background-size: cover; background-position: center; color:white; text-align:center; border-bottom: none;">
            <div class="floral-divider"><span>🌙</span> <span>✨</span> <span>🌹</span></div>
            <p style="font-size:1rem;">Terima kasih atas doa dan kehadiran Anda.</p>
            <h1 style="font-family:'Playfair Display'; font-size:2rem; margin:24px 0;">Melissa & Damian</h1>
            <p style="font-style:italic;">“Semoga menjadi keluarga yang sakinah, mawaddah, warahmah.”</p>
            <div class="floral-divider"><span>🌸</span> <span>✿</span> <span>🌼</span></div>
        </section>
    </div>

    <div class="floating-music" id="musicToggle">
        <i class="fas fa-music" id="musicIcon"></i>
    </div>
    <div class="bottom-nav" id="bottomNav">
        <div class="nav-item" data-target="heroSection"><i class="fas fa-home"></i><span>Home</span></div>
        <div class="nav-item" data-target="coupleSection"><i class="fas fa-heart"></i><span>Mempelai</span></div>
        <div class="nav-item" data-target="eventSection"><i class="fas fa-calendar-alt"></i><span>Acara</span></div>
        <div class="nav-item" data-target="gallerySection"><i class="fas fa-images"></i><span>Galeri</span></div>
        <div class="nav-item" data-target="rsvpSection"><i class="fas fa-comment-dots"></i><span>Ucapan</span></div>
    </div>
</div>

<div class="lightbox" id="lightbox"><img id="lightboxImg" src=""><span style="position:absolute; top:20px; right:30px; color:white; font-size:32px; cursor:pointer" id="closeLightbox">&times;</span></div>
<audio id="bgMusic" loop preload="auto"><source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg"></audio>

<script>
    const config = {
        weddingDate: "2025-11-30T08:00:00",
        events: [
            { name: "Akad Nikah", date: "30 November 2025", time: "08:00 - 09:30 WIB", location: "Masjid Agung At-Taqwa", address: "Jl. Merdeka No.12, Kota Bandung", mapLink: "https://maps.google.com/?q=Masjid+Agung+At-Taqwa+Bandung" },
            { name: "Resepsi", date: "30 November 2025", time: "10:30 - 14:00 WIB", location: "Gedung Puspa Wangi", address: "Jl. Asia Afrika no. 45, Bandung", mapLink: "https://maps.google.com/?q=Gedung+Puspa+Wangi+Bandung" }
        ],
        loveStory: [
            { year: "2019", title: "Pertemuan Pertama", desc: "Bertemu di kafe kecil dan obrolan panjang tentang mimpi.", img: "https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?w=300&auto=format" },
            { year: "2021", title: "Kebersamaan", desc: "Menjelajahi destinasi favorit dan saling menguatkan.", img: "https://images.unsplash.com/photo-1516589091380-5d8e87b69921?w=300&auto=format" },
            { year: "2024", title: "Lamaran", desc: "Di pagi hari yang dingin, Damian melamar Melissa dengan sederhana.", img: "https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=300&auto=format" }
        ],
        gallery: [
            "https://images.unsplash.com/photo-1519741497674-611481863552?w=600&auto=format",
            "https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=500&auto=format",
            "https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=500&auto=format",
            "https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=500&auto=format",
            "https://images.unsplash.com/photo-1606216794074-735e6c1e5b1d?w=500&auto=format"
        ],
        liveStreaming: { enabled: true, url: "https://www.youtube.com/watch?v=dQw4w9WgXcQ" },
        giftMethods: [
            { bank: "Bank Mandiri", account: "123-00-0987654", holder: "Melissa & Damian" },
            { bank: "BCA", account: "8765432109", holder: "Melissa Aurelia" }
        ],
        initialWishes: [
            { name: "Ayu Wijaya", status: "Hadir", message: "Selamat menempuh hidup baru! Semoga bahagia selalu.", date: "2 jam lalu" },
            { name: "Budi Santoso", status: "Hadir", message: "Barakallah, semoga keluarga sakinah.", date: "5 jam lalu" }
        ]
    };

    let wishesArray = [...config.initialWishes];
    let wishDisplayLimit = 3;
    let musicPlaying = false;
    const audio = document.getElementById('bgMusic');
    const musicIcon = document.getElementById('musicIcon');
    const streamSection = document.getElementById('streamingSection');
    if(config.liveStreaming.enabled) streamSection.style.display = 'block';

    function renderEvents() {
        const container = document.getElementById('eventsList');
        container.innerHTML = config.events.map(ev => `
            <div class="event-card">
                <h3><i class="fas fa-ring event-icon" style="color:#e9a2c0;"></i> ${ev.name}</h3>
                <p><i class="far fa-calendar-alt event-icon" style="color:#e9a2c0;"></i> ${ev.date}</p>
                <p><i class="far fa-clock event-icon" style="color:#e9a2c0;"></i> ${ev.time}</p>
                <p><i class="fas fa-map-marker-alt event-icon" style="color:#e9a2c0;"></i> ${ev.location}<br/><span style="font-size:12px;">${ev.address}</span></p>
                <button class="btn-outline-pink map-btn" data-map="${ev.mapLink}"><i class="fas fa-directions"></i> Petunjuk Lokasi</button>
            </div>
        `).join('');
        document.querySelectorAll('.map-btn').forEach(btn => btn.addEventListener('click', (e) => window.open(btn.dataset.map, '_blank')));
    }

    function renderLoveStory() {
        const container = document.getElementById('timelineContainer');
        container.innerHTML = config.loveStory.map(story => `
            <div class="timeline-item">
                <img class="timeline-img" src="${story.img}" alt="thumb" loading="lazy">
                <div class="timeline-year">${story.year}</div>
                <div class="timeline-content"><strong>${story.title}</strong><br/><span style="font-size:0.85rem;">${story.desc}</span></div>
            </div>
        `).join('');
    }

    function renderGallery() {
        const grid = document.getElementById('galleryGrid');
        grid.innerHTML = config.gallery.map((src) => `<img src="${src}" class="gallery-img" loading="lazy">`).join('');
        document.querySelectorAll('.gallery-img').forEach(img => {
            img.addEventListener('click', () => { document.getElementById('lightboxImg').src = img.src; document.getElementById('lightbox').classList.add('active'); });
        });
    }
    function renderGiftCards() {
        const container = document.getElementById('giftCardsContainer');
        container.innerHTML = config.giftMethods.map(g => `
            <div class="gift-card">
                <i class="fas fa-university" style="color:#e9a2c0;"></i> <strong>${g.bank}</strong><br/>
                ${g.account}<br/> a.n ${g.holder}
                <button class="btn-outline-pink copy-btn" data-account="${g.account}"><i class="far fa-copy"></i> Salin Nomor</button>
            </div>
        `).join('');
        document.querySelectorAll('.copy-btn').forEach(btn => btn.addEventListener('click', () => { navigator.clipboard.writeText(btn.dataset.account); alert("Nomor rekening disalin!"); }));
    }
    function renderWishes() {
        const container = document.getElementById('wishesList');
        const showWishes = wishesArray.slice(0, wishDisplayLimit);
        container.innerHTML = showWishes.map(w => `<div class="wish-card"><strong>${w.name}</strong> <span style="background:#fad5e5; border-radius:20px; padding:2px 12px; font-size:12px;">${w.status}</span><p>${w.message}</p><small>${w.date}</small></div>`).join('');
        document.getElementById('loadMoreWishes').style.display = wishesArray.length <= wishDisplayLimit ? 'none' : 'block';
    }
    document.getElementById('loadMoreWishes').addEventListener('click', () => { wishDisplayLimit += 5; renderWishes(); });
    document.getElementById('rsvpForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const name = document.getElementById('guestName').value.trim();
        const status = document.getElementById('attendanceStatus').value;
        const message = document.getElementById('wishMessage').value.trim() || "Mendoakan yang terbaik";
        if(!name) return alert("Nama tidak boleh kosong");
        wishesArray.unshift({ name, status, message, date: "Baru saja" });
        renderWishes();
        document.getElementById('rsvpForm').reset();
        alert("Terima kasih atas ucapan!");
    });
    function updateCountdown() {
        const target = new Date(config.weddingDate).getTime();
        const diff = target - new Date().getTime();
        if(diff<0) return;
        const days = Math.floor(diff/(1000*60*60*24));
        const hours = Math.floor((diff%(1000*60*60*24))/(1000*60*60));
        const minutes = Math.floor((diff%(1000*60*60))/(1000*60));
        const seconds = Math.floor((diff%(1000*60))/1000);
        document.getElementById('days').innerText = days<10? '0'+days: days;
        document.getElementById('hours').innerText = hours<10? '0'+hours: hours;
        document.getElementById('minutes').innerText = minutes<10? '0'+minutes: minutes;
        document.getElementById('seconds').innerText = seconds<10? '0'+seconds: seconds;
    }
    setInterval(updateCountdown,1000); updateCountdown();
    document.getElementById('streamBtn')?.addEventListener('click',()=> window.open(config.liveStreaming.url, '_blank'));
    document.getElementById('musicToggle').addEventListener('click', () => {
        if(musicPlaying) { audio.pause(); musicIcon.className = 'fas fa-music'; musicPlaying=false; }
        else { audio.play().catch(()=>{}); musicIcon.className = 'fas fa-pause'; musicPlaying=true; }
    });
    const cover = document.getElementById('coverScreen'), main = document.getElementById('mainContent');
    document.getElementById('openInvitationBtn').addEventListener('click', () => {
        cover.style.opacity = '0';
        setTimeout(() => { cover.style.display = 'none'; main.classList.add('show'); window.scrollTo(0,0); }, 600);
        audio.play().then(()=>{ musicPlaying=true; musicIcon.className = 'fas fa-pause'; }).catch(()=>{});
    });
    // navigasi dengan active class
    const navItems = document.querySelectorAll('.nav-item');
    function setActiveNav(targetId) {
        navItems.forEach(nav => { nav.classList.remove('active'); if(nav.dataset.target === targetId) nav.classList.add('active'); });
    }
    navItems.forEach(item => {
        item.addEventListener('click', () => {
            const targetId = item.dataset.target;
            const el = document.getElementById(targetId);
            if(el) { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); setActiveNav(targetId); }
        });
    });
    const lightbox = document.getElementById('lightbox');
    document.getElementById('closeLightbox').addEventListener('click', () => lightbox.classList.remove('active'));
    lightbox.addEventListener('click', (e) => { if(e.target === lightbox) lightbox.classList.remove('active'); });
    const sections = document.querySelectorAll('#mainContent section');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) { entry.target.classList.add('section-visible'); setActiveNav(entry.target.id); }
        });
    }, { threshold: 0.3 });
    sections.forEach(section => observer.observe(section));
    renderEvents(); renderLoveStory(); renderGallery(); renderGiftCards(); renderWishes();
    const urlParam = new URLSearchParams(window.location.search).get('to');
    if(urlParam) document.getElementById('guestNameDisplay').innerText = decodeURIComponent(urlParam);
</script>
</body>
</html>