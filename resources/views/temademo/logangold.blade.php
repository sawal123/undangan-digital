<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
    <title>Undangan Pernikahan | Elena & James | Gold Glassmorphism</title>
    <!-- TailwindCSS + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        body {
            background: linear-gradient(135deg, #1e1a14 0%, #2a241d 100%);
            overflow-x: hidden;
        }
        /* glassmorphism card */
        .glass-card {
            background: rgba(255, 255, 245, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .gold-text {
            color: #d4af37;
        }
        .gold-border {
            border-color: #d4af37;
        }
        .btn-gold {
            background: linear-gradient(135deg, #d4af37 0%, #b8922a 100%);
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
        }
        /* scroll reveal */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        /* timeline image */
        .timeline-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 20px;
            border: 2px solid #d4af37;
        }
        /* ATM card style */
        .atm-card {
            background: linear-gradient(135deg, #1e1b16 0%, #0f0d0a 100%);
            border: 1px solid #d4af37;
            border-radius: 24px;
            padding: 1.2rem;
            box-shadow: 0 12px 25px rgba(0,0,0,0.3);
            transition: transform 0.2s;
        }
        .atm-card:hover {
            transform: translateY(-3px);
        }
        .chip-icon {
            background: #e6c27a;
            width: 45px;
            height: 35px;
            border-radius: 8px;
            position: relative;
        }
        .chip-icon::before {
            content: "💳";
            font-size: 28px;
            position: absolute;
            top: -2px;
            left: 10px;
            color: #2c2c2c;
        }
        /* floating flowers animation */
        .floating-flower {
            position: fixed;
            pointer-events: none;
            z-index: 10;
            font-size: 1.5rem;
            opacity: 0.4;
            animation: floatFlower 12s infinite ease-in-out;
        }
        @keyframes floatFlower {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-20vh) rotate(360deg); opacity: 0; }
        }
        /* parallax jumbotron */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        @media (max-width: 768px) {
            .parallax-bg {
                background-attachment: scroll;
            }
        }
        /* input elegant */
        input, select, textarea {
            background: rgba(255, 255, 245, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.5);
            border-radius: 50px;
            padding: 12px 18px;
            color: #f5e6c4;
            outline: none;
            transition: 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #d4af37;
            box-shadow: 0 0 8px rgba(212, 175, 55, 0.4);
        }
        .guest-badge {
            background: rgba(212, 175, 55, 0.2);
            border-radius: 40px;
            padding: 4px 12px;
            font-size: 0.7rem;
        }
        /* bottom nav minimalis */
        .bottom-nav {
            background: rgba(30, 26, 20, 0.85);
            backdrop-filter: blur(16px);
            border-top: 1px solid rgba(212, 175, 55, 0.3);
        }
        .nav-item {
            transition: all 0.2s;
        }
        .nav-item.active {
            color: #d4af37;
        }
        /* lightbox */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
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
            border-radius: 24px;
        }
    </style>
</head>
<body class="text-[#f5e6c4]">

<!-- Floating Flowers (berserakan) -->
<div id="flowerContainer"></div>

<!-- COVER SCREEN -->
<div id="coverScreen" class="fixed inset-0 z-[2000] flex items-center justify-center bg-cover bg-center transition-all duration-700" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('https://images.pexels.com/photos/2253870/pexels-photo-2253870.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');">
    <div class="glass-card rounded-[48px] p-6 w-11/12 max-w-sm text-center backdrop-blur-md animate-fade-up">
        <i class="fas fa-crown gold-text text-3xl mb-2"></i>
        <p class="text-sm uppercase tracking-wider gold-text">The Wedding Of</p>
        <h1 class="font-serif text-3xl font-bold gold-text my-2">Elena & James</h1>
        <p class="text-sm">15 Juni 2024</p>
        <div class="bg-white/10 rounded-full py-2 px-4 my-4 text-sm backdrop-blur-sm">
            <i class="fas fa-envelope-open-text mr-2"></i> Kepada Yth. Bapak/Ibu/Saudara/i<br>
            <span class="font-semibold">Keluarga & Tamu Undangan</span>
        </div>
        <button id="openInvitationBtn" class="btn-gold text-black font-bold py-3 px-8 rounded-full shadow-lg w-full">✨ BUKA UNDANGAN ✨</button>
    </div>
</div>

<!-- MAIN CONTENT -->
<div id="mainContent" class="max-w-md mx-auto relative hidden pb-24">
    
    <!-- Hero Section Jumbotron dengan Parallax -->
    <div class="relative h-96 w-full rounded-b-3xl overflow-hidden shadow-xl scroll-reveal parallax-bg" id="hero" style="background-image: url('https://images.pexels.com/photos/3171837/pexels-photo-3171837.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'); background-attachment: fixed; background-position: center 30%; background-size: cover;">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex flex-col justify-end p-6">
            <h1 class="font-serif text-4xl font-bold gold-text">Elena & James</h1>
            <p class="text-white/90">15 Juni 2024</p>
            <div class="flex gap-2 mt-2">
                <span class="text-xs bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">💍 Pernikahan</span>
            </div>
        </div>
    </div>

    <!-- Quote & Countdown -->
    <div class="px-5 py-8 scroll-reveal">
        <div class="glass-card rounded-2xl p-5 text-center">
            <i class="fas fa-quote-left gold-text text-2xl mb-2"></i>
            <p class="italic text-sm">“Dan di antara tanda-tanda kekuasaan-Nya, Dia menciptakan pasangan hidup untukmu agar kamu merasa tenteram.” (QS. Ar-Rum: 21)</p>
            <div class="grid grid-cols-4 gap-2 mt-5">
                <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text" id="days">00</span><p class="text-[10px]">Hari</p></div>
                <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text" id="hours">00</span><p class="text-[10px]">Jam</p></div>
                <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text" id="minutes">00</span><p class="text-[10px]">Menit</p></div>
                <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text" id="seconds">00</span><p class="text-[10px]">Detik</p></div>
            </div>
        </div>
    </div>

    <!-- Mempelai -->
    <div class="px-5 py-4 scroll-reveal" id="couple">
        <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Mempelai</h2>
        <div class="glass-card rounded-3xl p-5 text-center mb-6">
            <img src="https://images.pexels.com/photos/1704488/pexels-photo-1704488.jpeg?auto=compress&cs=tinysrgb&w=600" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gold mb-3">
            <h3 class="font-serif text-xl font-semibold">Elena Michelle</h3>
            <p class="text-sm opacity-80">Putri dari Bapak Steven & Ibu Linda</p>
            <a href="#" class="text-gold text-sm inline-block mt-2"><i class="fab fa-instagram"></i> @elenamichelle</a>
        </div>
        <div class="text-center gold-text text-2xl my-2">✦ & ✦</div>
        <div class="glass-card rounded-3xl p-5 text-center mt-2">
            <img src="https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=600" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gold mb-3">
            <h3 class="font-serif text-xl font-semibold">James Alexander</h3>
            <p class="text-sm opacity-80">Putra dari Bapak Robert & Ibu Catherine</p>
            <a href="#" class="text-gold text-sm inline-block mt-2"><i class="fab fa-instagram"></i> @jamesalex</a>
        </div>
    </div>

    <!-- Event Details -->
    <div class="px-5 py-4 scroll-reveal" id="events">
        <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Save The Date</h2>
        <div id="eventsContainer" class="space-y-4"></div>
    </div>

    <!-- Love Story dengan gambar setiap cerita -->
    <div class="px-5 py-4 scroll-reveal" id="lovestory">
        <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Kisah Kami</h2>
        <div id="timelineContainer" class="space-y-4"></div>
    </div>

    <!-- Gallery -->
    <div class="px-5 py-4 scroll-reveal" id="gallery">
        <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Galeri</h2>
        <div class="grid grid-cols-2 gap-3" id="galleryGrid"></div>
    </div>

    <!-- Live Streaming -->
    <div class="px-5 py-4 scroll-reveal">
        <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Live Streaming</h2>
        <div class="glass-card rounded-2xl p-6 text-center">
            <i class="fas fa-video text-4xl gold-text mb-2"></i>
            <p class="text-sm mb-4">Turut hadir secara virtual melalui siaran langsung kami.</p>
            <button id="streamBtn" class="btn-gold text-black font-semibold py-2 px-6 rounded-full">📡 Tonton Streaming</button>
        </div>
    </div>

    <!-- Wedding Gift dengan ATM Style Card -->
    <div class="px-5 py-4 scroll-reveal" id="gift">
        <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Wedding Gift</h2>
        <p class="text-center text-sm mb-4">Doa restu Anda merupakan hadiah terindah. Tanda kasih dapat disalurkan melalui:</p>
        <div id="giftContainer" class="space-y-4"></div>
        <div class="glass-card rounded-2xl p-4 mt-4 text-center text-xs">
            <i class="fas fa-gift gold-text mr-1"></i> Atau kirimkan hadiah fisik ke: Jl. Melati No. 88, Jakarta
        </div>
    </div>

    <!-- RSVP & Wishes -->
    <div class="px-5 py-4 scroll-reveal" id="rsvp">
        <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Ucapan & Konfirmasi</h2>
        <form id="wishForm" class="space-y-3">
            <input type="text" id="guestName" placeholder="Nama Anda" class="w-full" required>
            <select id="attendance" class="w-full">
                <option value="Hadir">💐 Hadir</option>
                <option value="Tidak Hadir">🙏 Tidak Dapat Hadir</option>
                <option value="Ragu">🤍 Masih Ragu</option>
            </select>
            <input type="number" id="totalGuest" placeholder="Jumlah Tamu" value="1" class="w-full">
            <textarea rows="2" id="message" placeholder="Ucapan & Doa untuk pasangan..." class="w-full rounded-2xl"></textarea>
            <button type="submit" class="btn-gold text-black font-bold py-3 rounded-full w-full">✨ Kirim Ucapan ✨</button>
        </form>
        <div id="wishesList" class="mt-6 space-y-3"></div>
        <button id="loadMoreWishes" class="text-gold border border-gold/50 py-2 px-4 rounded-full text-sm mt-3 w-full">Lihat Lebih Banyak</button>
    </div>

    <!-- Footer Penutup -->
    <footer class="mt-8 mb-6 text-center px-5 py-8 rounded-t-3xl glass-card">
        <div class="font-serif text-2xl font-bold gold-text">Elena & James</div>
        <p class="text-sm mt-2">Terima kasih atas doa dan kehadiran Anda.</p>
        <div class="text-gold text-2xl my-2">❀ ✿ ❀</div>
        <p class="text-[10px] opacity-70">Merupakan suatu kehormatan bagi kami atas kehadiran Anda.</p>
    </footer>
</div>

<!-- Floating Music Button & Bottom Nav -->
<div id="musicToggle" class="fixed bottom-24 right-4 z-50 bg-black/40 backdrop-blur-md p-3 rounded-full border border-gold/50 cursor-pointer">
    <i class="fas fa-music gold-text text-xl"></i>
</div>
<div class="bottom-nav fixed bottom-0 left-0 right-0 z-50 py-2 flex justify-around items-center max-w-md mx-auto rounded-t-2xl">
    <div class="nav-item flex flex-col items-center text-xs" data-section="hero"><i class="fas fa-home text-lg"></i><span>Home</span></div>
    <div class="nav-item flex flex-col items-center text-xs" data-section="couple"><i class="fas fa-heart text-lg"></i><span>Pasangan</span></div>
    <div class="nav-item flex flex-col items-center text-xs" data-section="events"><i class="fas fa-calendar text-lg"></i><span>Acara</span></div>
    <div class="nav-item flex flex-col items-center text-xs" data-section="gallery"><i class="fas fa-images text-lg"></i><span>Galeri</span></div>
    <div class="nav-item flex flex-col items-center text-xs" data-section="rsvp"><i class="fas fa-comment-dots text-lg"></i><span>Ucapan</span></div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox"><img id="lightboxImg" src=""><span class="absolute top-5 right-5 text-white text-3xl cursor-pointer" id="closeLightbox">&times;</span></div>

<audio id="bgAudio" loop src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3" preload="auto"></audio>

<script>
    (function() {
        // Wedding Date: 15 Juni 2024
        const weddingDate = new Date(2024, 5, 15, 9, 0, 0);
        
        // Event Data
        const eventsData = [
            { name: "Akad Nikah", date: "Sabtu, 15 Juni 2024", time: "08:00 - 09:30 WIB", location: "Masjid Al-Ikhlas", address: "Jl. Sudirman No. 12, Jakarta" },
            { name: "Resepsi", date: "Sabtu, 15 Juni 2024", time: "10:30 - 15:00 WIB", location: "The Grand Ballroom", address: "Jl. Gatot Subroto Kav. 56, Jakarta" }
        ];
        
        // Love Story dengan gambar cover
        const loveStory = [
            { year: "2019", title: "Pertemuan Pertama", desc: "Bertemu di acara galeri seni, berbincang hingga larut malam.", img: "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=300" },
            { year: "2021", title: "Komitmen Serius", desc: "Perjalanan ke Yogyakarta menguatkan ikatan hati.", img: "https://images.pexels.com/photos/1484282/pexels-photo-1484282.jpeg?auto=compress&cs=tinysrgb&w=300" },
            { year: "2023", title: "Lamaran", desc: "Di bawah bunga sakura, sebuah kejutan romantis.", img: "https://images.pexels.com/photos/2098405/pexels-photo-2098405.jpeg?auto=compress&cs=tinysrgb&w=300" }
        ];
        
        const galleryImgs = [
            "https://images.pexels.com/photos/2253870/pexels-photo-2253870.jpeg?auto=compress&cs=tinysrgb&w=600",
            "https://images.pexels.com/photos/1484282/pexels-photo-1484282.jpeg?auto=compress&cs=tinysrgb&w=600",
            "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=600",
            "https://images.pexels.com/photos/2098405/pexels-photo-2098405.jpeg?auto=compress&cs=tinysrgb&w=600"
        ];
        
        const giftData = [
            { bank: "BCA", number: "1234 5678 9012 3456", holder: "Elena Michelle James" },
            { bank: "Mandiri", number: "9876 5432 1098 7654", holder: "James Alexander" }
        ];
        
        function renderEvents() {
            const container = document.getElementById("eventsContainer");
            container.innerHTML = eventsData.map(ev => `
                <div class="glass-card rounded-2xl p-4 border-l-4 border-gold">
                    <h3 class="font-bold"><i class="fas fa-ring gold-text mr-2"></i>${ev.name}</h3>
                    <p class="text-xs mt-1"><i class="far fa-calendar-alt mr-1"></i>${ev.date}</p>
                    <p class="text-xs"><i class="far fa-clock mr-1"></i>${ev.time}</p>
                    <p class="text-xs"><i class="fas fa-map-marker-alt mr-1"></i>${ev.location}</p>
                    <p class="text-xs opacity-70">${ev.address}</p>
                    <button class="loc-btn mt-2 text-gold border border-gold/50 px-3 py-1 rounded-full text-xs" data-address="${ev.address}"><i class="fas fa-directions"></i> Petunjuk Lokasi</button>
                </div>
            `).join('');
            document.querySelectorAll('.loc-btn').forEach(btn => {
                btn.addEventListener('click', () => window.open(`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(btn.dataset.address)}`, '_blank'));
            });
        }
        
        function renderTimeline() {
            const container = document.getElementById("timelineContainer");
            container.innerHTML = loveStory.map(st => `
                <div class="glass-card rounded-2xl p-3 flex gap-3 items-center">
                    <img src="${st.img}" class="timeline-img">
                    <div>
                        <div class="text-gold text-xs font-bold">${st.year}</div>
                        <div class="font-semibold text-sm">${st.title}</div>
                        <p class="text-xs opacity-80">${st.desc}</p>
                    </div>
                </div>
            `).join('');
        }
        
        function renderGallery() {
            const grid = document.getElementById("galleryGrid");
            grid.innerHTML = galleryImgs.map((url, idx) => `<img src="${url}" class="rounded-2xl aspect-square object-cover cursor-pointer transition hover:scale-[1.02]" data-img="${url}">`).join('');
            document.querySelectorAll('#galleryGrid img').forEach(img => {
                img.addEventListener('click', () => {
                    document.getElementById('lightboxImg').src = img.dataset.img || img.src;
                    document.getElementById('lightbox').classList.add('active');
                });
            });
        }
        
        function renderGift() {
            const container = document.getElementById("giftContainer");
            container.innerHTML = giftData.map(g => `
                <div class="atm-card">
                    <div class="flex justify-between items-center">
                        <div class="chip-icon"></div>
                        <span class="text-[10px] gold-text">💳 WEDDING CARD</span>
                    </div>
                    <div class="font-mono text-center my-3 tracking-wider text-sm">${g.number}</div>
                    <div class="flex justify-between text-[10px]">
                        <span>HOLDER</span>
                        <span>${g.holder}</span>
                    </div>
                    <div class="flex justify-between text-[10px] mt-1">
                        <span>BANK</span>
                        <span>${g.bank}</span>
                    </div>
                    <button class="copy-btn-atm w-full mt-3 bg-gold/20 text-gold py-1 rounded-full text-xs" data-num="${g.number.replace(/\s/g, '')}">📋 Salin Nomor Rekening</button>
                </div>
            `).join('');
            document.querySelectorAll('.copy-btn-atm').forEach(btn => {
                btn.addEventListener('click', () => {
                    const text = btn.dataset.num;
                    navigator.clipboard.writeText(text);
                    alert(`Nomor ${text} disalin!`);
                });
            });
        }
        
        // Wishes
        let wishes = [
            { name: "Ibu Ratna", attendance: "Hadir", message: "Selamat menempuh hidup baru, Elena & James!", date: "2024-05-20" },
            { name: "Bapak Hendra", attendance: "Hadir", message: "Semoga menjadi keluarga sakinah mawaddah.", date: "2024-05-21" }
        ];
        let visibleWishes = 3;
        function renderWishes() {
            const container = document.getElementById("wishesList");
            const show = wishes.slice(0, visibleWishes);
            container.innerHTML = show.map(w => `
                <div class="glass-card rounded-2xl p-3">
                    <div class="flex justify-between"><span class="font-semibold">${w.name}</span><span class="guest-badge">${w.attendance}</span></div>
                    <p class="text-sm mt-1 italic">“${w.message}”</p>
                    <div class="text-[10px] mt-2 opacity-60"><i class="far fa-calendar"></i> ${w.date}</div>
                </div>
            `).join('');
            document.getElementById("loadMoreWishes").style.display = visibleWishes >= wishes.length ? "none" : "block";
        }
        
        document.getElementById("wishForm").addEventListener("submit", (e) => {
            e.preventDefault();
            const name = document.getElementById("guestName").value.trim();
            const attendance = document.getElementById("attendance").value;
            const message = document.getElementById("message").value.trim() || "Doa terbaik untuk kalian berdua";
            if(!name) return alert("Masukkan nama anda");
            wishes.unshift({ name, attendance, message, date: new Date().toLocaleDateString('id-ID') });
            visibleWishes = 3;
            renderWishes();
            document.getElementById("wishForm").reset();
            alert("Terima kasih atas ucapan dan doanya ❤️");
        });
        document.getElementById("loadMoreWishes").addEventListener("click", () => {
            visibleWishes += 4;
            renderWishes();
        });
        
        // Countdown
        function updateCountdown() {
            const now = new Date().getTime();
            const diff = weddingDate - now;
            if(diff <= 0) {
                document.getElementById("days").innerText = "00"; document.getElementById("hours").innerText = "00";
                document.getElementById("minutes").innerText = "00"; document.getElementById("seconds").innerText = "00";
                return;
            }
            document.getElementById("days").innerText = Math.floor(diff/(1000*60*60*24)).toString().padStart(2,'0');
            document.getElementById("hours").innerText = Math.floor((diff%(1000*60*60*24))/(1000*60*60)).toString().padStart(2,'0');
            document.getElementById("minutes").innerText = Math.floor((diff%(1000*60*60))/(1000*60)).toString().padStart(2,'0');
            document.getElementById("seconds").innerText = Math.floor((diff%(1000*60))/1000).toString().padStart(2,'0');
        }
        setInterval(updateCountdown, 1000);
        
        // Music
        const audio = document.getElementById("bgAudio");
        const musicBtn = document.getElementById("musicToggle");
        let isPlaying = false;
        musicBtn.addEventListener("click", () => {
            if(isPlaying) { audio.pause(); musicBtn.innerHTML = '<i class="fas fa-music gold-text text-xl"></i>'; }
            else { audio.play().catch(e=>console.log); musicBtn.innerHTML = '<i class="fas fa-pause gold-text text-xl"></i>'; }
            isPlaying = !isPlaying;
        });
        
        // Cover open
        const cover = document.getElementById("coverScreen");
        const main = document.getElementById("mainContent");
        document.getElementById("openInvitationBtn").addEventListener("click", () => {
            cover.style.opacity = "0";
            setTimeout(() => { cover.style.display = "none"; main.classList.remove("hidden"); document.body.style.overflow = "auto"; }, 700);
        });
        
        // Bottom navigation
        document.querySelectorAll(".nav-item").forEach(item => {
            item.addEventListener("click", () => {
                const section = item.dataset.section;
                const el = document.getElementById(section);
                if(el) el.scrollIntoView({ behavior: "smooth", block: "start" });
            });
        });
        
        document.getElementById("streamBtn").addEventListener("click", () => alert("Streaming akan tersedia pada hari H via YouTube live."));
        
        // Lightbox close
        document.getElementById("closeLightbox").addEventListener("click", () => document.getElementById("lightbox").classList.remove("active"));
        document.getElementById("lightbox").addEventListener("click", (e) => { if(e.target === document.getElementById("lightbox")) document.getElementById("lightbox").classList.remove("active"); });
        
        // Scroll reveal observer
        const reveals = document.querySelectorAll('.scroll-reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('revealed'); });
        }, { threshold: 0.15 });
        reveals.forEach(r => observer.observe(r));
        
        // Generate floating flowers
        function createFloatingFlowers() {
            const container = document.getElementById("flowerContainer");
            const flowers = ['🌸', '🌼', '🌻', '🌺', '🌸', '🌿', '🌸', '🌼'];
            for(let i = 0; i < 20; i++) {
                const flower = document.createElement('div');
                flower.className = 'floating-flower';
                flower.innerHTML = flowers[Math.floor(Math.random() * flowers.length)];
                const size = Math.random() * 20 + 16;
                flower.style.fontSize = size + 'px';
                flower.style.left = Math.random() * 100 + '%';
                flower.style.animationDuration = Math.random() * 10 + 8 + 's';
                flower.style.animationDelay = Math.random() * 15 + 's';
                flower.style.opacity = Math.random() * 0.4 + 0.2;
                container.appendChild(flower);
            }
        }
        createFloatingFlowers();
        
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