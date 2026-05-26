<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
    <title>Undangan Pernikahan Digital | Raisa & Bima</title>
    <!-- Google Fonts & Font Awesome -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f7efe5;
            /* soft beige background outer */
            font-family: 'Poppins', sans-serif;
            color: #3a2c24;
            line-height: 1.5;
            scroll-behavior: smooth;
        }

        /* mobile-first container (card-like on desktop) */
        .wedding-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fffef8;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow-x: hidden;
        }

        /* global section styling */
        section {
            padding: 3rem 1.5rem;
            border-bottom: 1px solid rgba(210, 180, 140, 0.2);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
            color: #b68b5c;
            letter-spacing: 1px;
            position: relative;
        }

        .section-title::after {
            content: "✦";
            display: block;
            font-size: 1.2rem;
            color: #d9b68b;
            margin-top: 0.5rem;
        }

        /* buttons & cards */
        .btn-primary {
            background: #c7a46b;
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.8rem 1.8rem;
            border-radius: 40px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 8px 20px rgba(183, 132, 66, 0.2);
            width: fit-content;
            display: inline-block;
            text-align: center;
        }

        .btn-primary:hover {
            background: #a87d48;
            transform: scale(1.02);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid #c7a46b;
            color: #c7a46b;
            padding: 0.6rem 1.4rem;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
        }

        /* Cover screen full */
        .cover-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(20, 12, 8, 0.55), rgba(20, 12, 8, 0.6)), url('https://images.pexels.com/photos/2253870/pexels-photo-2253870.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2') center/cover no-repeat;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            backdrop-filter: blur(1px);
            transition: opacity 0.6s ease, visibility 0.6s;
            color: white;
        }

        .cover-content {
            max-width: 85%;
            animation: fadeUp 1s ease-out;
        }

        .cover-content h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            letter-spacing: 3px;
            font-size: 1rem;
        }

        .couple-name-cover {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin: 1rem 0;
            font-weight: 600;
            line-height: 1.2;
        }

        .guest-card {
            background: rgba(255, 255, 245, 0.2);
            backdrop-filter: blur(8px);
            padding: 1rem;
            border-radius: 48px;
            margin: 1.5rem 0;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid rgba(255, 215, 175, 0.6);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hidden-cover {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* floating music */
        .music-btn {
            position: fixed;
            bottom: 85px;
            right: 18px;
            background: rgba(255, 250, 240, 0.9);
            backdrop-filter: blur(6px);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            z-index: 1200;
            color: #a47148;
            font-size: 1.6rem;
            border: 1px solid #e2cdb1;
        }

        /* bottom navigation */
        .bottom-nav {
            position: fixed;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 248, 235, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 50px;
            padding: 0.6rem 1.4rem;
            display: flex;
            gap: 1.8rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            z-index: 1100;
            border: 1px solid #f1e3d4;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.7rem;
            color: #8b694a;
            cursor: pointer;
            transition: 0.2s;
            font-weight: 500;
        }

        .nav-item i {
            font-size: 1.4rem;
            margin-bottom: 3px;
        }

        .nav-item.active,
        .nav-item:active {
            color: #c29a6b;
        }

        /* countdown cards */
        .countdown-wrap {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 2rem 0;
        }

        .cd-card {
            background: #fef7ef;
            flex: 1;
            text-align: center;
            padding: 0.8rem 0;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1e2d2;
        }

        .cd-number {
            font-size: 1.7rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: #b57c48;
        }

        /* couple profile */
        .couple-card {
            background: #fffcf7;
            border-radius: 32px;
            padding: 1.2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .couple-photo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 3px solid #eedbcb;
            box-shadow: 0 10px 15px -5px rgba(0, 0, 0, 0.1);
        }

        .instagram-link {
            color: #b27d56;
            font-size: 0.85rem;
            margin-top: 8px;
            display: inline-block;
        }

        .ampersand {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            text-align: center;
            margin: -0.5rem 0 1rem;
            color: #dbb47a;
        }

        /* event card */
        .event-card {
            background: #fff9f2;
            border-radius: 28px;
            padding: 1.3rem;
            margin-bottom: 1.2rem;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.02);
            border-left: 6px solid #e1c6a8;
        }

        .event-icon {
            margin-right: 0.5rem;
            color: #c7a46b;
        }

        .loc-btn {
            background: none;
            border: 1px solid #dcc29e;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.8rem;
            margin-top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        /* Timeline */
        .timeline-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.8rem;
            background: #fefaf5;
            padding: 1rem;
            border-radius: 20px;
        }

        .timeline-year {
            font-weight: 700;
            color: #c7a46b;
            min-width: 70px;
        }

        /* masonry gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .gallery-grid img {
            width: 100%;
            height: auto;
            border-radius: 18px;
            cursor: pointer;
            transition: 0.2s;
            object-fit: cover;
            aspect-ratio: 1/1;
        }

        .gallery-grid :first-child {
            grid-column: span 2;
            aspect-ratio: 16/10;
        }

        /* lightbox */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            visibility: hidden;
            opacity: 0;
            transition: 0.2s;
        }

        .lightbox.active {
            visibility: visible;
            opacity: 1;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 20px;
        }

        /* gift card & rsvp */
        .gift-card {
            background: #fff6ed;
            padding: 1.2rem;
            border-radius: 24px;
            margin-bottom: 1rem;
        }

        .copy-btn {
            background: #e7d8ca;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.75rem;
            margin-top: 8px;
        }

        .wish-card {
            background: #fefaf5;
            padding: 1rem;
            border-radius: 24px;
            margin-bottom: 12px;
        }

        .badge-hadir {
            background: #d9e6c3;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 28px;
            border: 1px solid #ecdbba;
            background: white;
            font-family: 'Poppins', sans-serif;
        }

        footer {
            text-align: center;
            padding: 3rem 1.5rem;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.4)), url('https://images.pexels.com/photos/3171837/pexels-photo-3171837.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
            color: white;
        }

        @media (min-width: 768px) {
            .wedding-container {
                max-width: 480px;
                border-radius: 32px;
                margin: 20px auto;
                overflow: hidden;
            }

            body {
                background: #e7dbcf;
            }

            .bottom-nav {
                padding: 0.5rem 1.8rem;
                gap: 2rem;
            }
        }

        .quote-text {
            font-style: italic;
            text-align: center;
            background: #fef1e4;
            padding: 1rem;
            border-radius: 60px;
            margin: 1rem 0;
        }

        .floral-divider {
            text-align: center;
            font-size: 1.2rem;
            letter-spacing: 6px;
            color: #debb95;
            margin: 1rem 0;
        }
    </style>
</head>

<body>
    <div class="cover-screen" id="coverScreen">
        <div class="cover-content">
            <h3>The Wedding Of</h3>
            <div class="couple-name-cover">Raisa Andini <br> & <br> Bima Pratama</div>
            <p>Sabtu, 12 April 2025</p>
            <div class="guest-card">
                <i class="fas fa-envelope-open-text"></i> Kepada Yth.<br> <strong>Bapak/Ibu/Saudara/i</strong><br>
                <span style="font-size: 1.2rem;">Keluarga & Tamu Undangan</span>
            </div>
            <button class="btn-primary" id="openInvitationBtn" style="background: #f1e0ce; color:#7a532e;">✨ Buka
                Undangan ✨</button>
            <div style="margin-top: 20px;"><i class="fas fa-chevron-down"></i></div>
        </div>
    </div>

    <div class="wedding-container" id="mainContent" style="display: none;">
        <!-- Hero Section -->
        <section id="hero">
            <div style="text-align:center; padding-top: 1rem;">
                <h1 style="font-family:'Playfair Display'; font-size:2rem; color:#a27145;">Raisa & Bima</h1>
                <p>12 April 2025</p>
                <div class="floral-divider">✧ ✿ ✧</div>
                <div class="quote-text">“Dan di antara tanda-tanda kekuasaan-Nya, Dia menciptakan pasangan hidup untukmu
                    agar kamu merasa tenteram, dan menjadikan kasih sayang.” (QS. Ar-Rum: 21)</div>
                <div class="countdown-wrap" id="countdownTimer">
                    <div class="cd-card">
                        <div class="cd-number" id="days">00</div>
                        <div>Hari</div>
                    </div>
                    <div class="cd-card">
                        <div class="cd-number" id="hours">00</div>
                        <div>Jam</div>
                    </div>
                    <div class="cd-card">
                        <div class="cd-number" id="minutes">00</div>
                        <div>Menit</div>
                    </div>
                    <div class="cd-card">
                        <div class="cd-number" id="seconds">00</div>
                        <div>Detik</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mempelai Section -->
        <section id="couple">
            <div class="section-title">Mempelai</div>
            <p style="text-align:center; margin-bottom:2rem;">Dengan memohon rahmat Allah, kami mengundang Bapak/Ibu
                dalam bahagia pernikahan kami.</p>
            <div class="couple-card">
                <img class="couple-photo"
                    src="https://images.pexels.com/photos/1704488/pexels-photo-1704488.jpeg?auto=compress&cs=tinysrgb&w=600"
                    alt="Bride">
                <h2 style="font-family:Playfair Display;">Raisa Andini</h2>
                <p>Putri dari Bapak H. Surya & Ibu Nirmala</p>
                <a href="#" class="instagram-link"><i class="fab fa-instagram"></i> @raisa.andini</a>
            </div>
            <div class="ampersand">&</div>
            <div class="couple-card">
                <img class="couple-photo"
                    src="https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=600"
                    alt="Groom">
                <h2 style="font-family:Playfair Display;">Bima Pratama</h2>
                <p>Putra dari Bapak H. Wahyudi & Ibu Lestari</p>
                <a href="#" class="instagram-link"><i class="fab fa-instagram"></i> @bimapratama</a>
            </div>
        </section>

        <!-- Event Details -->
        <section id="events">
            <div class="section-title">Save The Date</div>
            <div id="eventsContainer"></div>
        </section>

        <!-- Love Story Timeline -->
        <section id="lovestory">
            <div class="section-title">Kisah Kami</div>
            <div id="timelineContainer"></div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery">
            <div class="section-title">Galeri</div>
            <div class="gallery-grid" id="galleryGrid"></div>
        </section>

        <!-- Live Streaming (exists) -->
        <section id="liveStream">
            <div class="section-title">Live Streaming</div>
            <div style="background:#fcf5ea; border-radius: 32px; padding:1.5rem; text-align:center;">
                <i class="fas fa-video" style="font-size:2rem; color:#b88552;"></i>
                <p style="margin: 10px 0;">Turut hadir secara virtual melalui siaran langsung kami.</p>
                <button class="btn-primary" id="streamBtn">📡 Tonton Streaming</button>
            </div>
        </section>

        <!-- Gift Section -->
        <section id="gift">
            <div class="section-title">Wedding Gift</div>
            <p style="text-align:center;">Doa restu Anda merupakan hadiah terindah. Tanda kasih dapat disalurkan
                melalui:</p>
            <div id="giftContainer"></div>
        </section>

        <!-- RSVP & Wishes -->
        <section id="rsvp">
            <div class="section-title">Ucapan & Konfirmasi Kehadiran</div>
            <form id="wishForm">
                <input type="text" id="guestName" placeholder="Nama Anda" required>
                <select id="attendance">
                    <option value="Hadir">💐 Hadir</option>
                    <option value="Tidak Hadir">🙏 Tidak Dapat Hadir</option>
                    <option value="Ragu">🤍 Masih Ragu</option>
                </select>
                <input type="number" id="totalGuest" placeholder="Jumlah Tamu" value="1">
                <textarea rows="2" id="message" placeholder="Ucapan & Doa untuk pasangan..."></textarea>
                <button type="submit" class="btn-primary" style="width:100%">Kirim Ucapan</button>
            </form>
            <div id="wishesList" style="margin-top: 2rem;"></div>
            <button id="loadMoreWishes" class="btn-outline" style="margin: 1rem auto; display:block;">Lihat Lebih
                Banyak</button>
        </section>

        <!-- Closing Footer -->
        <footer>
            <div style="font-family: 'Playfair Display'; font-size:2rem; margin-bottom: 0.5rem;">Raisa & Bima</div>
            <p>Terima kasih atas doa dan kehadiran Anda.</p>
            <div class="floral-divider" style="color:#ffefdb;">❀ ✿ ❀</div>
            <p style="font-size:0.8rem;">Merupakan suatu kehormatan bagi kami atas kehadiran Anda.</p>
        </footer>
    </div>

    <!-- Music Control & Bottom Nav -->
    <div class="music-btn" id="musicToggle"><i class="fas fa-music"></i></div>
    <div class="bottom-nav">
        <div class="nav-item" data-section="hero"><i class="fas fa-home"></i><span>Home</span></div>
        <div class="nav-item" data-section="couple"><i class="fas fa-heart"></i><span>Mempelai</span></div>
        <div class="nav-item" data-section="events"><i class="fas fa-calendar-alt"></i><span>Acara</span></div>
        <div class="nav-item" data-section="gallery"><i class="fas fa-images"></i><span>Galeri</span></div>
        <div class="nav-item" data-section="rsvp"><i class="fas fa-comment-dots"></i><span>Ucapan</span></div>
    </div>

    <div class="lightbox" id="lightbox"><img id="lightboxImg" src=""><span
            style="position:absolute; top:20px; right:30px; color:white; font-size:30px; cursor:pointer;"
            id="closeLightbox">&times;</span></div>

    <audio id="bgAudio" loop src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3"
        preload="auto"></audio>

    <script>
        (function() {
            // ======================= DYNAMIC DATA ========================
            const weddingDate = new Date(2025, 3, 12, 8, 0, 0); // 12 April 2025
            const eventsData = [{
                    name: "Akad Nikah",
                    date: "Sabtu, 12 April 2025",
                    time: "08:00 - 09:30 WIB",
                    location: "Masjid Agung Darussalam",
                    address: "Jl. Merdeka No.10, Bandung"
                },
                {
                    name: "Resepsi",
                    date: "Sabtu, 12 April 2025",
                    time: "10:30 - 14:00 WIB",
                    location: "Gedung Pusdai Ballroom",
                    address: "Jl. Diponegoro No.25, Bandung"
                },
                {
                    name: "Wedding Party",
                    date: "Minggu, 13 April 2025",
                    time: "18:00 - 21:00 WIB",
                    location: "The Heritage Lounge",
                    address: "Jl. Cihampelas, Bandung"
                }
            ];
            const loveStory = [{
                    year: "2019",
                    title: "Pertemuan Pertama",
                    desc: "Bertemu di acara taman bacaan, berbagi mimpi dan secangkir kopi.",
                    img: ""
                },
                {
                    year: "2021",
                    title: "Komitmen Serius",
                    desc: "Melangkah bersama, berkeliling kota dan memahami cinta.",
                    img: ""
                },
                {
                    year: "2024",
                    title: "Lamaran",
                    desc: "Momen haru di pagi hari, keluarga dan doa mengikat janji.",
                    img: ""
                }
            ];
            const galleryImgs = [
                "https://images.pexels.com/photos/2253870/pexels-photo-2253870.jpeg?auto=compress&cs=tinysrgb&w=600",
                "https://images.pexels.com/photos/1484282/pexels-photo-1484282.jpeg?auto=compress&cs=tinysrgb&w=600",
                "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=600",
                "https://images.pexels.com/photos/2098405/pexels-photo-2098405.jpeg?auto=compress&cs=tinysrgb&w=600",
                "https://images.pexels.com/photos/3819475/pexels-photo-3819475.jpeg?auto=compress&cs=tinysrgb&w=600"
            ];
            const giftData = [{
                    bank: "Bank BCA",
                    number: "1234567890",
                    holder: "Raisa Andini Bima",
                    type: "Bank"
                },
                {
                    bank: "DANA / OVO",
                    number: "081234567890",
                    holder: "Bima Pratama",
                    type: "E-Wallet"
                }
            ];

            // Render events
            const eventsContainer = document.getElementById("eventsContainer");

            function renderEvents() {
                eventsContainer.innerHTML = eventsData.map(ev => `
                <div class="event-card">
                    <h3><i class="fas fa-ring event-icon"></i> ${ev.name}</h3>
                    <p><i class="far fa-calendar-alt"></i> ${ev.date}</p>
                    <p><i class="far fa-clock"></i> ${ev.time}</p>
                    <p><i class="fas fa-map-marker-alt"></i> ${ev.location}</p>
                    <p style="font-size:0.8rem;">${ev.address}</p>
                    <button class="loc-btn" data-address="${ev.address}"><i class="fas fa-directions"></i> Petunjuk Lokasi</button>
                </div>
            `).join('');
                document.querySelectorAll('.loc-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const addr = btn.getAttribute('data-address');
                        window.open(
                            `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(addr)}`,
                            '_blank');
                    });
                });
            }

            function renderTimeline() {
                const timelineDiv = document.getElementById("timelineContainer");
                timelineDiv.innerHTML = loveStory.map(st => `
                <div class="timeline-item">
                    <div class="timeline-year">${st.year}</div>
                    <div><strong>${st.title}</strong><br>${st.desc}</div>
                </div>
            `).join('');
            }

            function renderGallery() {
                const grid = document.getElementById("galleryGrid");
                grid.innerHTML = galleryImgs.map((url, idx) => `<img src="${url}" alt="gallery" data-index="${idx}">`)
                    .join('');
                document.querySelectorAll('#galleryGrid img').forEach(img => {
                    img.addEventListener('click', (e) => {
                        const lightbox = document.getElementById('lightbox');
                        const lightboxImg = document.getElementById('lightboxImg');
                        lightboxImg.src = e.target.src;
                        lightbox.classList.add('active');
                    });
                });
            }

            function renderGift() {
                const giftDiv = document.getElementById("giftContainer");
                giftDiv.innerHTML = giftData.map(g => `
                <div class="gift-card">
                    <i class="fas fa-credit-card"></i> <strong>${g.bank}</strong>
                    <p>${g.number}</p>
                    <p>a.n. ${g.holder}</p>
                    <button class="copy-btn" data-num="${g.number}">Salin Nomor</button>
                </div>
            `).join('');
                document.querySelectorAll('.copy-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const text = btn.getAttribute('data-num');
                        navigator.clipboard.writeText(text);
                        alert(`Nomor ${text} disalin!`);
                    });
                });
            }

            // RSVP & Wishes system
            let wishes = [{
                    name: "Ibu Sari",
                    attendance: "Hadir",
                    message: "Selamat menempuh hidup baru!",
                    date: "2025-03-01"
                },
                {
                    name: "Bapak Andi",
                    attendance: "Hadir",
                    message: "Barakallah, semoga sakinah mawaddah.",
                    date: "2025-03-02"
                }
            ];
            let visibleWishes = 3;

            function renderWishes() {
                const container = document.getElementById("wishesList");
                const showWishes = wishes.slice(0, visibleWishes);
                container.innerHTML = showWishes.map(w => `
                <div class="wish-card">
                    <div style="display:flex; justify-content:space-between;"><strong>${w.name}</strong> <span class="badge-hadir">${w.attendance}</span></div>
                    <p style="margin:8px 0;">“${w.message}”</p>
                    <small><i class="far fa-calendar"></i> ${w.date}</small>
                </div>
            `).join('');
                document.getElementById("loadMoreWishes").style.display = visibleWishes >= wishes.length ? "none" :
                    "block";
            }
            document.getElementById("wishForm").addEventListener("submit", function(e) {
                e.preventDefault();
                const name = document.getElementById("guestName").value.trim();
                const attendance = document.getElementById("attendance").value;
                const totalGuest = document.getElementById("totalGuest").value;
                const message = document.getElementById("message").value.trim() ||
                    "Doa terbaik untuk kalian berdua";
                if (!name) return alert("Masukkan nama anda");
                const newWish = {
                    name,
                    attendance,
                    message: message,
                    date: new Date().toLocaleDateString('id-ID')
                };
                wishes.unshift(newWish);
                visibleWishes = 3;
                renderWishes();
                document.getElementById("wishForm").reset();
                alert("Terima kasih atas ucapan dan doanya ❤️");
            });
            document.getElementById("loadMoreWishes").addEventListener("click", () => {
                visibleWishes += 4;
                renderWishes();
            });

            // Countdown timer
            function updateCountdown() {
                const now = new Date().getTime();
                const target = weddingDate.getTime();
                const diff = target - now;
                if (diff <= 0) {
                    document.getElementById("days").innerText = "00";
                    document.getElementById("hours").innerText = "00";
                    document.getElementById("minutes").innerText = "00";
                    document.getElementById("seconds").innerText = "00";
                    return;
                }
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                document.getElementById("days").innerText = days < 10 ? "0" + days : days;
                document.getElementById("hours").innerText = hours < 10 ? "0" + hours : hours;
                document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
                document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;
            }
            setInterval(updateCountdown, 1000);

            // Background Music
            const audio = document.getElementById("bgAudio");
            const musicBtn = document.getElementById("musicToggle");
            let isPlaying = false;
            musicBtn.addEventListener("click", () => {
                if (isPlaying) {
                    audio.pause();
                    musicBtn.innerHTML = '<i class="fas fa-music"></i>';
                } else {
                    audio.play().catch(e => console.log);
                    musicBtn.innerHTML = '<i class="fas fa-pause"></i>';
                }
                isPlaying = !isPlaying;
            });

            // Cover Open
            const cover = document.getElementById("coverScreen");
            const mainCont = document.getElementById("mainContent");
            document.getElementById("openInvitationBtn").addEventListener("click", () => {
                cover.classList.add("hidden-cover");
                setTimeout(() => {
                    cover.style.display = "none";
                    mainCont.style.display = "block";
                    document.body.style.overflow = "auto";
                }, 600);
                // optional gentle music autoplay? user gesture needed, but we keep manual
            });

            // Bottom Navigation Scroll
            const navItems = document.querySelectorAll(".nav-item");
            navItems.forEach(item => {
                item.addEventListener("click", (e) => {
                    const sectionId = item.getAttribute("data-section");
                    const element = document.getElementById(sectionId);
                    if (element) element.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                });
            });

            // Streaming Button Demo
            document.getElementById("streamBtn").addEventListener("click", () => {
                alert("Demo Streaming: Link YouTube (wedding live) akan terhubung nanti.\nTerima kasih!");
            });

            // Lightbox Close
            document.getElementById("closeLightbox").addEventListener("click", () => {
                document.getElementById("lightbox").classList.remove("active");
            });
            document.getElementById("lightbox").addEventListener("click", (e) => {
                if (e.target === document.getElementById("lightbox")) document.getElementById("lightbox")
                    .classList.remove("active");
            });

            // Render all dynamic sections
            renderEvents();
            renderTimeline();
            renderGallery();
            renderGift();
            renderWishes();
            updateCountdown();
        })();
    </script>
</body>

</html>
