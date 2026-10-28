<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawiwahan Ageng 3D — Raden Aditya &amp; Roro Kirana | Javanese 1</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Third-Party 3D, Parallax & ZIP Libraries via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sogan: {
                            950: '#0F0704',
                            900: '#1C0E08',
                            800: '#2E170D',
                            700: '#462415',
                            600: '#63341E',
                            500: '#8A4F30',
                        },
                        emas: {
                            100: '#FFF8DC',
                            200: '#F6E39F',
                            300: '#E8C86B',
                            400: '#D4AF37',
                            500: '#AA820A',
                            600: '#7D5D04',
                        },
                        krem: {
                            50: '#FDFBF7',
                            100: '#F7F1E3',
                            200: '#EFE4CE',
                            300: '#DFD1B3',
                        },
                        daun: {
                            600: '#3B6251',
                            700: '#2A473A',
                            800: '#1B3027',
                            900: '#101F18',
                        }
                    },
                    fontFamily: {
                        serifJawa: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                        aksen: ['"Great Vibes"', 'cursive'],
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* 3D Stage & Perspective Utilities */
        .stage-3d-viewport {
            perspective: 1400px;
            transform-style: preserve-3d;
        }
        .preserve-3d {
            transform-style: preserve-3d;
        }
        .layer-3d {
            will-change: transform;
            transform-style: preserve-3d;
            transition: transform 0.12s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* 3D Gate Opening Animation */
        .gebyok-door-left {
            transform-origin: left center;
            transition: transform 1.8s cubic-bezier(0.68, -0.05, 0.26, 1.05), opacity 1.5s ease;
        }
        .gebyok-door-right {
            transform-origin: right center;
            transition: transform 1.8s cubic-bezier(0.68, -0.05, 0.26, 1.05), opacity 1.5s ease;
        }
        .gate-open .gebyok-door-left {
            transform: perspective(1500px) rotateY(-105deg);
            opacity: 0;
        }
        .gate-open .gebyok-door-right {
            transform: perspective(1500px) rotateY(105deg);
            opacity: 0;
        }

        @keyframes windSwayPrimary {
            0%, 100% { transform: rotate(0deg) skewX(0deg) scale(1); }
            30% { transform: rotate(4.2deg) skewX(1.8deg) scale(1.01); }
            65% { transform: rotate(-2.8deg) skewX(-1.2deg) scale(0.99); }
        }
        @keyframes windSwaySecondary {
            0%, 100% { transform: rotate(0deg) skewX(0deg); }
            40% { transform: rotate(-5deg) skewX(-2.2deg); }
            75% { transform: rotate(3.2deg) skewX(1.4deg); }
        }
        @keyframes roncePendulum {
            0%, 100% { transform: rotate(-2.5deg); }
            50% { transform: rotate(4.5deg) translateX(3px); }
        }
        @keyframes mistDrift {
            0% { transform: translateX(-8%) scaleY(1); opacity: 0.25; }
            50% { transform: translateX(8%) scaleY(1.08); opacity: 0.45; }
            100% { transform: translateX(-8%) scaleY(1); opacity: 0.25; }
        }
        @keyframes kayonBreath {
            0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); filter: drop-shadow(0 0 25px rgba(212,175,55,0.35)); }
            50% { transform: translateY(-10px) scale(1.03) rotate(1deg); filter: drop-shadow(0 0 45px rgba(212,175,55,0.65)); }
        }
        @keyframes lanternPulse {
            0%, 100% { opacity: 0.75; transform: scale(0.96); }
            50% { opacity: 1; transform: scale(1.12); }
        }

        .daun-angin-kiri {
            transform-origin: top left;
            animation: windSwayPrimary 6.8s ease-in-out infinite;
        }
        .daun-angin-kanan {
            transform-origin: top right;
            animation: windSwaySecondary 7.4s ease-in-out infinite;
        }
        .daun-bawah-kiri {
            transform-origin: bottom left;
            animation: windSwayPrimary 5.8s ease-in-out infinite 0.5s;
        }
        .daun-bawah-kanan {
            transform-origin: bottom right;
            animation: windSwaySecondary 6.4s ease-in-out infinite 1s;
        }
        .ronce-ayun-1 {
            transform-origin: top center;
            animation: roncePendulum 5.2s ease-in-out infinite;
        }
        .ronce-ayun-2 {
            transform-origin: top center;
            animation: roncePendulum 6.5s ease-in-out infinite 1.2s;
        }
        .kabut-gunung {
            animation: mistDrift 16s ease-in-out infinite;
        }
        .kayon-glow {
            animation: kayonBreath 6s ease-in-out infinite;
        }
        .lentera-pendar {
            transform-box: fill-box;
            transform-origin: center;
            animation: lanternPulse 3.2s ease-in-out infinite;
        }

        /* Metallic Gold Foil Typography */
        .text-gold-foil {
            background: linear-gradient(135deg, #FFF8DC 0%, #D4AF37 35%, #AA820A 65%, #F6E39F 85%, #D4AF37 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shineFoil 6s linear infinite;
        }
        @keyframes shineFoil {
            to { background-position: 200% center; }
        }

        .card-3d-keraton {
            background: linear-gradient(155deg, rgba(46, 23, 13, 0.85) 0%, rgba(22, 11, 6, 0.92) 100%);
            border: 1px solid rgba(212, 175, 55, 0.42);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75), inset 0 0 25px rgba(212, 175, 55, 0.08);
            backdrop-filter: blur(12px);
            transform-style: preserve-3d;
        }
        .card-3d-inner {
            transform: translateZ(30px);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0F0704; }
        ::-webkit-scrollbar-thumb { background: #7D5D04; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #D4AF37; }
    </style>
</head>
<body class="bg-sogan-950 text-krem-100 font-sans antialiased selection:bg-emas-400 selection:text-sogan-950 overflow-x-hidden overflow-y-hidden" id="body-root">

    <!-- 1. THREE.JS 3D WEBGL CANVAS -->
    <canvas id="three-canvas" class="fixed inset-0 pointer-events-none z-30 w-full h-full"></canvas>

    <!-- 2. FLOATING ASSET STUDIO BUTTON -->
    <button onclick="openAssetModal()" class="fixed top-4 right-4 z-50 flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-sogan-900/95 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400 shadow-[0_0_25px_rgba(212,175,55,0.45)] transition-all duration-300 text-xs sm:text-sm font-semibold group">
        <i class="fa-solid fa-box-open text-emas-400 group-hover:text-sogan-950 transition-colors"></i>
        <span>Studio Asset (SVG/PNG/ZIP)</span>
    </button>

    <!-- 3. LIGHTBOX MODAL (ZOOM FOTO PREVIEW) -->
    <div id="lightbox-modal" class="fixed inset-0 z-[60] bg-sogan-950/95 backdrop-blur-md hidden items-center justify-center p-4">
        <button type="button" onclick="closeLightbox()" class="absolute top-5 right-5 w-11 h-11 rounded-full bg-sogan-900 border border-emas-400 text-emas-300 hover:text-white flex items-center justify-center transition shadow-lg z-20">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
        <button type="button" onclick="changeLightbox(-1)" class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-sogan-900/90 border border-emas-400 text-emas-300 hover:text-white flex items-center justify-center transition shadow-lg z-20">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <div class="max-w-3xl max-h-[85vh] flex flex-col items-center">
            <img id="lightbox-img" src="" alt="Galeri Preview" class="max-h-[75vh] w-auto rounded-2xl shadow-2xl border-2 border-emas-400/60 object-contain">
            <p id="lightbox-caption" class="font-serifJawa text-emas-200 text-base sm:text-lg mt-3 text-center tracking-wide"></p>
        </div>
        <button type="button" onclick="changeLightbox(1)" class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-sogan-900/90 border border-emas-400 text-emas-300 hover:text-white flex items-center justify-center transition shadow-lg z-20">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <!-- 4. 3D GEBYOK GATE OPENING COVER -->
    <div id="gate-cover" class="fixed inset-0 z-40 flex items-center justify-center overflow-hidden stage-3d-viewport">
        <!-- Pintu Gebyok Kiri -->
        <div class="gebyok-door-left absolute inset-y-0 left-0 w-1/2 bg-sogan-950 border-r-2 border-emas-400/60 flex flex-col justify-between p-6 overflow-hidden shadow-[20px_0_50px_rgba(0,0,0,0.9)]">
            <div class="absolute inset-0 opacity-20 dynamic-batik-bg"></div>
            <div class="w-28 h-28 asset-slot-ukiran" data-flip="none"></div>
            <div class="my-auto mr-0 ml-auto pr-4 sm:pr-10 opacity-40 w-40 sm:w-64 pointer-events-none asset-slot-gunungan"></div>
            <div class="w-28 h-28 asset-slot-ukiran transform scale-y-[-1]"></div>
        </div>

        <!-- Pintu Gebyok Kanan -->
        <div class="gebyok-door-right absolute inset-y-0 right-0 w-1/2 bg-sogan-950 border-l-2 border-emas-400/60 flex flex-col justify-between items-end p-6 overflow-hidden shadow-[-20px_0_50px_rgba(0,0,0,0.9)]">
            <div class="absolute inset-0 opacity-20 dynamic-batik-bg"></div>
            <div class="w-28 h-28 asset-slot-ukiran transform scale-x-[-1]"></div>
            <div class="my-auto ml-0 mr-auto pl-4 sm:pl-10 opacity-40 w-40 sm:w-64 pointer-events-none asset-slot-gunungan"></div>
            <div class="w-28 h-28 asset-slot-ukiran transform scale-[-1]"></div>
        </div>

        <!-- Medallion Tengah Gebyok -->
        <div id="gate-center-card" class="relative z-10 max-w-lg w-full mx-4 p-6 sm:p-10 rounded-3xl card-3d-keraton text-center transition-all duration-700" data-tilt data-tilt-max="8" data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.2">
            <div class="card-3d-inner">
                <p class="text-emas-300 uppercase tracking-[0.35em] text-xs font-semibold mb-2">Kula Nuwun • Pawiwahan Ageng</p>
                
                <div class="w-56 sm:w-64 mx-auto my-2 asset-slot-joglo"></div>

                <h1 class="font-aksen text-5xl sm:text-6xl text-gold-foil py-1">Aditya &amp; Kirana</h1>
                <p class="font-serifJawa italic text-krem-200 text-sm sm:text-base tracking-widest">Minggu Pahing, 20 Desember 2026</p>

                <!-- Nama Tamu Undangan -->
                <div class="mt-5 py-3 px-4 rounded-2xl bg-sogan-950/80 border border-emas-400/40 max-w-xs mx-auto">
                    <p class="text-[11px] uppercase tracking-widest text-krem-200/70">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                    <h2 id="guest-name-target" class="font-serifJawa font-bold text-xl text-emas-200 my-0.5">Tamu Kehormatan Keraton</h2>
                    <p class="text-[10px] text-krem-200/50 italic">Di Tempat</p>
                </div>

                <button id="btn-open-gate" onclick="open3DGate()" class="mt-6 inline-flex items-center gap-3 px-8 py-3.5 rounded-full bg-gradient-to-r from-emas-500 via-emas-300 to-emas-500 text-sogan-950 font-bold text-xs sm:text-sm uppercase tracking-widest shadow-[0_0_30px_rgba(212,175,55,0.6)] hover:scale-105 active:scale-95 transition-all">
                    <i class="fa-solid fa-door-open text-base"></i>
                    <span>Buka Gerbang Undangan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 5. MAIN 3D PARALLAX INVITATION CONTENT -->
    <main id="main-invitation" class="relative z-10">

        <!-- SECTION 1: 3D HERO STAGE -->
        <section id="hero-3d-stage" class="relative h-screen w-full overflow-hidden stage-3d-viewport flex items-center justify-center select-none">
            
            <!-- LAYER 0: Sky & Merapi -->
            <div class="layer-3d absolute inset-[-6%] pointer-events-none flex flex-col justify-end" data-depth="0.08" id="parallax-layer-sky">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,#3A1E10_0%,#180B05_55%,#0B0502_100%)]"></div>
                <div class="absolute inset-0 opacity-15 dynamic-batik-bg"></div>
                <div class="absolute top-[14%] left-1/2 -translate-x-1/2 w-72 h-72 sm:w-[460px] sm:h-[460px] rounded-full bg-[radial-gradient(circle,rgba(246,227,159,0.35)_0%,rgba(212,175,55,0.12)_45%,transparent_70%)] blur-xl"></div>
                
                <svg viewBox="0 0 1440 360" class="w-full h-auto relative z-10 opacity-75" preserveAspectRatio="none">
                    <path d="M0,360 L0,250 Q180,190 360,230 L560,95 L750,210 L940,75 L1180,220 Q1320,190 1440,240 L1440,360 Z" fill="#160B06" stroke="#D4AF37" stroke-opacity="0.25" stroke-width="1.5"/>
                    <path d="M0,360 L240,180 L510,270 L790,140 L1090,260 L1440,190 L1440,360 Z" fill="#0F0704" opacity="0.85"/>
                </svg>

                <div class="kabut-gunung absolute bottom-12 inset-x-0 h-32 bg-gradient-to-t from-sogan-950 via-emas-300/10 to-transparent blur-2xl"></div>
            </div>

            <!-- LAYER 1: Gunungan Wayang Kayon Emas -->
            <div class="layer-3d absolute inset-0 flex items-center justify-center pointer-events-none" data-depth="0.18" id="parallax-layer-kayon">
                <div class="w-64 sm:w-80 md:w-96 opacity-45 kayon-glow -mt-20 asset-slot-gunungan"></div>
            </div>

            <!-- LAYER 2: Rumah Adat Joglo Keraton & Judul -->
            <div class="layer-3d relative z-20 max-w-4xl w-full px-4 flex flex-col items-center text-center mt-8 sm:mt-12" data-depth="0.32" id="parallax-layer-joglo">
                
                <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-sogan-900/80 border border-emas-400/40 text-emas-300 text-[11px] sm:text-xs tracking-[0.3em] uppercase mb-2 shadow-lg">
                    <span>✦</span> Pawiwahan Ageng Keraton <span>✦</span>
                </div>

                <div class="w-full max-w-xl mx-auto drop-shadow-[0_25px_35px_rgba(0,0,0,0.85)] asset-slot-joglo"></div>

                <div class="-mt-4 sm:-mt-6 relative z-30">
                    <h1 class="font-aksen text-5xl sm:text-7xl md:text-8xl text-gold-foil drop-shadow-[0_6px_20px_rgba(0,0,0,0.95)] py-1">
                        Raden Aditya &amp; Roro Kirana
                    </h1>
                    <p class="font-serifJawa italic text-lg sm:text-2xl text-krem-100 tracking-[0.2em] mt-1">
                        Minggu Pahing • 20 Desember 2026 • Yogyakarta
                    </p>
                </div>

                <a href="#filosofi-section" class="mt-6 inline-flex flex-col items-center text-emas-300/80 hover:text-emas-200 transition-colors group">
                    <span class="text-[10px] uppercase tracking-[0.25em] mb-1">Gulir ke Bawah</span>
                    <div class="w-6 h-10 rounded-full border border-emas-400/60 flex justify-center p-1">
                        <div class="w-1.5 h-2.5 rounded-full bg-emas-300 animate-bounce"></div>
                    </div>
                </a>
            </div>

            <!-- LAYER 3: Dedaunan & Ronce Melati Tertiup Angin -->
            <div class="layer-3d absolute inset-0 pointer-events-none z-30 flex flex-col justify-between overflow-hidden" data-depth="0.55" id="parallax-layer-foliage">
                <div class="flex justify-between items-start w-full">
                    <div class="w-52 sm:w-80 md:w-96 -ml-6 -mt-4 daun-angin-kiri asset-slot-daun-kiri"></div>
                    <div class="w-52 sm:w-80 md:w-96 -mr-6 -mt-4 daun-angin-kanan asset-slot-daun-kanan"></div>
                </div>

                <div class="flex justify-between items-end w-full">
                    <div class="w-40 sm:w-64 -ml-6 -mb-6 daun-bawah-kiri asset-slot-bunga-sudut"></div>
                    <div class="w-40 sm:w-64 -mr-6 -mb-6 daun-bawah-kanan transform scale-x-[-1] asset-slot-bunga-sudut"></div>
                </div>
            </div>

            <div class="absolute bottom-0 inset-x-0 h-28 bg-gradient-to-t from-sogan-950 to-transparent z-20 pointer-events-none"></div>
        </section>

        <!-- SECTION 2: FILOSOFI JAWA & AYAT SUCI -->
        <section id="filosofi-section" class="relative py-24 px-4 bg-sogan-950 overflow-hidden">
            <div class="absolute inset-0 opacity-15 dynamic-batik-bg pointer-events-none"></div>
            
            <div class="max-w-4xl mx-auto relative z-10">
                <div class="card-3d-keraton rounded-3xl p-8 sm:p-14 text-center relative gsap-fade-up" data-tilt data-tilt-max="5" data-tilt-speed="500">
                    <div class="w-16 h-16 absolute top-3 left-3 asset-slot-ukiran"></div>
                    <div class="w-16 h-16 absolute top-3 right-3 transform scale-x-[-1] asset-slot-ukiran"></div>
                    <div class="w-16 h-16 absolute bottom-3 left-3 transform scale-y-[-1] asset-slot-ukiran"></div>
                    <div class="w-16 h-16 absolute bottom-3 right-3 transform scale-[-1] asset-slot-ukiran"></div>

                    <div class="card-3d-inner">
                        <div class="w-24 h-20 mx-auto mb-4 asset-slot-bunga-tengah"></div>
                        <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold">Sangkan Paraning Dumadi</p>
                        <h2 class="font-serifJawa font-bold text-3xl sm:text-4xl text-gold-foil mt-1 mb-6">Falsafah Pawiwahan</h2>
                        
                        <p class="font-serifJawa italic text-lg sm:text-2xl text-krem-100 leading-relaxed max-w-2xl mx-auto">
                            "Garwa punika sigaraning nyawa. Pernikahan adalah menyatunya dua belahan jiwa dalam satu irama pengabdian kepada Sang Pencipta, saling mengasihi dalam ketenteraman (Sakinah, Mawaddah, Warahmah)."
                        </p>
                        <div class="mt-6 flex items-center justify-center gap-3 text-emas-400 text-xs tracking-widest uppercase font-semibold">
                            <span>— QS. Ar-Rum: 21 &amp; Piwulang Luhur Jawa —</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3: PROFIL MEMPELAI PRIA & WANITA -->
        <section id="mempelai" class="relative py-24 px-4 bg-gradient-to-b from-sogan-950 via-sogan-900 to-sogan-950 overflow-hidden">
            <div class="w-44 sm:w-64 absolute top-12 -left-8 opacity-75 pointer-events-none daun-angin-kiri asset-slot-daun-kiri"></div>
            <div class="w-44 sm:w-64 absolute bottom-12 -right-8 opacity-75 pointer-events-none daun-angin-kanan asset-slot-daun-kanan"></div>

            <div class="max-w-6xl mx-auto relative z-10 text-center">
                <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold gsap-fade-up">Assalamu’alaikum Warahmatullahi Wabarakatuh</p>
                <h2 class="font-serifJawa font-bold text-4xl sm:text-5xl text-gold-foil mt-2 gsap-fade-up">Mempelai Berbahagia</h2>
                <p class="max-w-xl mx-auto text-krem-200/80 text-sm sm:text-base mt-3 gsap-fade-up">
                    Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan upacara pernikahan putra-putri kami:
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-11 gap-8 items-center mt-14">
                    
                    <!-- Mempelai Pria -->
                    <div class="lg:col-span-5 card-3d-keraton rounded-3xl p-8 sm:p-10 relative gsap-fade-left" data-tilt data-tilt-max="8" data-tilt-glare="true" data-tilt-max-glare="0.18">
                        <div class="w-12 h-12 absolute top-3 left-3 asset-slot-ukiran"></div>
                        <div class="w-12 h-12 absolute top-3 right-3 transform scale-x-[-1] asset-slot-ukiran"></div>
                        
                        <div class="card-3d-inner">
                            <div class="w-44 h-44 mx-auto relative mb-6">
                                <div class="absolute inset-[-8px] rounded-full border-2 border-dashed border-emas-400/60 animate-[spin_30s_linear_infinite]"></div>
                                <div class="w-full h-full rounded-full bg-gradient-to-b from-sogan-700 to-sogan-950 border-2 border-emas-400 p-2 overflow-hidden shadow-2xl flex items-center justify-center">
                                    <svg viewBox="0 0 120 120" class="w-full h-full">
                                        <circle cx="60" cy="60" r="56" fill="url(#warmLantern)" opacity="0.25"/>
                                        <path d="M24,116 C24,84 96,84 96,116 Z" fill="#1C0E08" stroke="#D4AF37" stroke-width="1.5"/>
                                        <path d="M46,88 L60,104 L74,88" fill="none" stroke="#D4AF37" stroke-width="1.8"/>
                                        <path d="M42,90 Q60,116 78,90" fill="none" stroke="#FFFDF9" stroke-width="3.5" stroke-dasharray="3,3"/>
                                        <circle cx="60" cy="48" r="18" fill="#E6C699"/>
                                        <path d="M39,44 C39,24 81,24 81,44 L85,48 L35,48 Z" fill="#462415" stroke="#D4AF37" stroke-width="1.5"/>
                                        <circle cx="60" cy="34" r="3.5" fill="#D4AF37"/>
                                    </svg>
                                </div>
                            </div>

                            <h3 class="font-aksen text-4xl sm:text-5xl text-gold-foil">Raden Bagus Aditya, S.Ars.</h3>
                            <p class="text-xs uppercase tracking-[0.2em] text-emas-300 font-semibold mt-4">Putra Pertama Dari:</p>
                            <p class="font-serifJawa text-xl text-krem-100 font-semibold mt-1">
                                Bapak K.R.T. Hendrawan Suryo &amp; Ibu R.Ay. Sekar Arum
                            </p>
                            <p class="text-xs text-krem-200/70 mt-2"><i class="fa-solid fa-location-dot text-emas-400 mr-1.5"></i>Kraton Ngayogyakarta Hadiningrat</p>
                            
                            <div class="mt-4">
                                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sogan-800 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/40 text-xs font-semibold transition">
                                    <i class="fa-brands fa-instagram"></i>
                                    <span>@radenaditya</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Center Gunungan Divider -->
                    <div class="lg:col-span-1 flex justify-center">
                        <div class="w-24 sm:w-28 kayon-glow asset-slot-gunungan"></div>
                    </div>

                    <!-- Mempelai Wanita -->
                    <div class="lg:col-span-5 card-3d-keraton rounded-3xl p-8 sm:p-10 relative gsap-fade-right" data-tilt data-tilt-max="8" data-tilt-glare="true" data-tilt-max-glare="0.18">
                        <div class="w-12 h-12 absolute top-3 left-3 asset-slot-ukiran"></div>
                        <div class="w-12 h-12 absolute top-3 right-3 transform scale-x-[-1] asset-slot-ukiran"></div>
                        
                        <div class="card-3d-inner">
                            <div class="w-44 h-44 mx-auto relative mb-6">
                                <div class="absolute inset-[-8px] rounded-full border-2 border-dashed border-emas-400/60 animate-[spin_30s_linear_infinite_reverse]"></div>
                                <div class="w-full h-full rounded-full bg-gradient-to-b from-sogan-700 to-sogan-950 border-2 border-emas-400 p-2 overflow-hidden shadow-2xl flex items-center justify-center">
                                    <svg viewBox="0 0 120 120" class="w-full h-full">
                                        <circle cx="60" cy="60" r="56" fill="url(#warmLantern)" opacity="0.25"/>
                                        <ellipse cx="60" cy="45" rx="26" ry="18" fill="#120905"/>
                                        <line x1="60" y1="27" x2="60" y2="14" stroke="#D4AF37" stroke-width="1.8"/>
                                        <circle cx="60" cy="13" r="3.5" fill="#D4AF37"/>
                                        <line x1="46" y1="30" x2="39" y2="18" stroke="#D4AF37" stroke-width="1.5"/>
                                        <circle cx="38" cy="17" r="2.8" fill="#D4AF37"/>
                                        <line x1="74" y1="30" x2="81" y2="18" stroke="#D4AF37" stroke-width="1.5"/>
                                        <circle cx="82" cy="17" r="2.8" fill="#D4AF37"/>
                                        <path d="M27,116 C27,86 93,86 93,116 Z" fill="#2E170D" stroke="#D4AF37" stroke-width="1.5"/>
                                        <circle cx="60" cy="95" r="5" fill="#D4AF37"/>
                                        <circle cx="60" cy="50" r="17" fill="#EDD0A8"/>
                                        <path d="M43,45 Q60,29 77,45 Q68,36 60,42 Q52,36 43,45 Z" fill="#120905"/>
                                        <path d="M77,50 Q83,74 79,96" fill="none" stroke="#FFFDF9" stroke-width="4" stroke-dasharray="3,3"/>
                                    </svg>
                                </div>
                            </div>

                            <h3 class="font-aksen text-4xl sm:text-5xl text-gold-foil">Roro Ayu Kirana, S.Psi.</h3>
                            <p class="text-xs uppercase tracking-[0.2em] text-emas-300 font-semibold mt-4">Putri Bungsu Dari:</p>
                            <p class="font-serifJawa text-xl text-krem-100 font-semibold mt-1">
                                Bapak Drs. Bambang Wijaya &amp; Ibu Hj. Ratna Kumala
                            </p>
                            <p class="text-xs text-krem-200/70 mt-2"><i class="fa-solid fa-location-dot text-emas-400 mr-1.5"></i>Kotagede, Yogyakarta</p>
                            
                            <div class="mt-4">
                                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sogan-800 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/40 text-xs font-semibold transition">
                                    <i class="fa-brands fa-instagram"></i>
                                    <span>@ayukirana</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- SECTION 4: COUNTDOWN 3D & RANGKAIAN ACARA -->
        <section id="acara" class="relative py-24 px-4 bg-sogan-950 overflow-hidden">
            <div class="absolute inset-0 opacity-15 dynamic-batik-bg pointer-events-none"></div>

            <div class="max-w-5xl mx-auto relative z-10 text-center">
                <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold gsap-fade-up">Momentum Suci</p>
                <h2 class="font-serifJawa font-bold text-4xl sm:text-5xl text-gold-foil mt-2 gsap-fade-up">Rangkaian Acara Pawiwahan</h2>

                <!-- 3D Countdown Boxes -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto my-10 gsap-fade-up">
                    <div class="card-3d-keraton rounded-2xl p-4 sm:p-5" data-tilt data-tilt-max="12">
                        <span id="cd-days" class="block font-serifJawa font-bold text-3xl sm:text-5xl text-gold-foil">00</span>
                        <span class="text-xs uppercase tracking-widest text-krem-200/75 mt-1 block">Hari</span>
                    </div>
                    <div class="card-3d-keraton rounded-2xl p-4 sm:p-5" data-tilt data-tilt-max="12">
                        <span id="cd-hours" class="block font-serifJawa font-bold text-3xl sm:text-5xl text-gold-foil">00</span>
                        <span class="text-xs uppercase tracking-widest text-krem-200/75 mt-1 block">Jam</span>
                    </div>
                    <div class="card-3d-keraton rounded-2xl p-4 sm:p-5" data-tilt data-tilt-max="12">
                        <span id="cd-minutes" class="block font-serifJawa font-bold text-3xl sm:text-5xl text-gold-foil">00</span>
                        <span class="text-xs uppercase tracking-widest text-krem-200/75 mt-1 block">Menit</span>
                    </div>
                    <div class="card-3d-keraton rounded-2xl p-4 sm:p-5" data-tilt data-tilt-max="12">
                        <span id="cd-seconds" class="block font-serifJawa font-bold text-3xl sm:text-5xl text-gold-foil">00</span>
                        <span class="text-xs uppercase tracking-widest text-krem-200/75 mt-1 block">Detik</span>
                    </div>
                </div>

                <!-- Event Cards (Akad, Panggih & Pahargyan) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
                    <div class="card-3d-keraton rounded-3xl p-8 sm:p-10 relative gsap-fade-left" data-tilt data-tilt-max="6">
                        <div class="w-12 h-12 absolute top-3 left-3 asset-slot-ukiran"></div>
                        <div class="w-12 h-12 absolute top-3 right-3 transform scale-x-[-1] asset-slot-ukiran"></div>
                        <div class="card-3d-inner">
                            <div class="w-40 mx-auto mb-4 asset-slot-joglo"></div>
                            <h3 class="font-serifJawa font-bold text-3xl text-gold-foil">Akad Nikah &amp; Panggih</h3>
                            <p class="text-emas-300 font-medium text-sm mt-2">Minggu Pahing, 20 Desember 2026</p>
                            <p class="text-krem-100 text-sm mt-1"><i class="fa-regular fa-clock text-emas-400 mr-1.5"></i>Pukul 08.00 – 10.30 WIB</p>
                            <div class="h-px w-24 bg-emas-400/40 mx-auto my-4"></div>
                            <p class="font-serifJawa font-bold text-xl text-emas-200">Pendopo Agung Royal Ambarrukmo</p>
                            <p class="text-xs text-krem-200/70 mt-1 leading-relaxed">Jl. Laksda Adisucipto No. 81, Sleman, Daerah Istimewa Yogyakarta</p>
                            
                            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                                <a href="https://maps.google.com/?q=Pendopo+Agung+Royal+Ambarrukmo+Yogyakarta" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emas-400/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 transition text-xs font-semibold uppercase tracking-wider">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    <span>Google Maps</span>
                                </a>
                                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Akad+Nikah+Aditya+%26+Kirana&dates=20261220T010000Z/20261220T033000Z&details=Pawiwahan+Ageng+Aditya+%26+Kirana&location=Pendopo+Agung+Royal+Ambarrukmo+Yogyakarta" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-sogan-800 hover:bg-emas-400/30 text-krem-200 border border-emas-400/40 transition text-xs font-semibold uppercase tracking-wider">
                                    <i class="fa-regular fa-calendar-plus"></i>
                                    <span>Simpan Kalender</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-3d-keraton rounded-3xl p-8 sm:p-10 relative gsap-fade-right" data-tilt data-tilt-max="6">
                        <div class="w-12 h-12 absolute top-3 left-3 asset-slot-ukiran"></div>
                        <div class="w-12 h-12 absolute top-3 right-3 transform scale-x-[-1] asset-slot-ukiran"></div>
                        <div class="card-3d-inner">
                            <div class="w-40 mx-auto mb-4 asset-slot-joglo"></div>
                            <h3 class="font-serifJawa font-bold text-3xl text-gold-foil">Pahargyan Ageng (Resepsi)</h3>
                            <p class="text-emas-300 font-medium text-sm mt-2">Minggu Pahing, 20 Desember 2026</p>
                            <p class="text-krem-100 text-sm mt-1"><i class="fa-regular fa-clock text-emas-400 mr-1.5"></i>Pukul 11.00 – 14.00 WIB</p>
                            <div class="h-px w-24 bg-emas-400/40 mx-auto my-4"></div>
                            <p class="font-serifJawa font-bold text-xl text-emas-200">Kedhaton Ballroom Royal Ambarrukmo</p>
                            <p class="text-xs text-krem-200/70 mt-1 leading-relaxed">Jl. Laksda Adisucipto No. 81, Sleman, Daerah Istimewa Yogyakarta</p>
                            
                            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                                <a href="https://maps.google.com/?q=Pendopo+Agung+Royal+Ambarrukmo+Yogyakarta" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emas-400/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 transition text-xs font-semibold uppercase tracking-wider">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    <span>Google Maps</span>
                                </a>
                                <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Pahargyan+Resepsi+Aditya+%26+Kirana&dates=20261220T040000Z/20261220T070000Z&details=Resepsi+Pernikahan+Aditya+%26+Kirana&location=Pendopo+Agung+Royal+Ambarrukmo+Yogyakarta" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-sogan-800 hover:bg-emas-400/30 text-krem-200 border border-emas-400/40 transition text-xs font-semibold uppercase tracking-wider">
                                    <i class="fa-regular fa-calendar-plus"></i>
                                    <span>Simpan Kalender</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 5: TATA LAMPAH ADICARA (RUNDOWN PROSESI ADAT) -->
        <section id="rundown" class="relative py-24 px-4 bg-gradient-to-b from-sogan-950 via-sogan-900 to-sogan-950 overflow-hidden">
            <div class="max-w-4xl mx-auto relative z-10 text-center">
                <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold">Tata Lampah Adicara</p>
                <h2 class="font-serifJawa font-bold text-4xl sm:text-5xl text-gold-foil mt-2">Susunan Prosesi Adat Jawa</h2>
                <p class="text-krem-200/80 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                    Urutan upacara sakral Kraton Ngayogyakarta Hadiningrat yang akan berlangsung:
                </p>

                <div class="mt-12 relative max-w-lg mx-auto text-left">
                    <div class="absolute left-6 top-3 bottom-3 w-0.5 bg-emas-400/50"></div>

                    <div class="space-y-6">
                        <div class="relative flex items-start gap-5">
                            <div class="w-12 h-12 rounded-full bg-sogan-900 border-2 border-emas-400 flex items-center justify-center text-emas-300 shrink-0 z-10 shadow-lg">
                                <i class="fa-solid fa-scroll text-sm"></i>
                            </div>
                            <div class="card-3d-keraton rounded-2xl p-5 flex-1" data-tilt data-tilt-max="6">
                                <span class="text-xs font-bold text-emas-300 tracking-wider">08.00 – 08.45 WIB</span>
                                <h4 class="font-serifJawa font-bold text-xl text-gold-foil mt-0.5">Pasrah Panampi &amp; Ijab Qobul</h4>
                                <p class="text-xs text-krem-200/80 mt-1 leading-relaxed">Penyerahan calon mempelai pria dan ikrar suci akad nikah di hadapan penghulu dan saksi keluarga.</p>
                            </div>
                        </div>

                        <div class="relative flex items-start gap-5">
                            <div class="w-12 h-12 rounded-full bg-sogan-900 border-2 border-emas-400 flex items-center justify-center text-emas-300 shrink-0 z-10 shadow-lg">
                                <i class="fa-solid fa-hands-holding-circle text-sm"></i>
                            </div>
                            <div class="card-3d-keraton rounded-2xl p-5 flex-1" data-tilt data-tilt-max="6">
                                <span class="text-xs font-bold text-emas-300 tracking-wider">08.45 – 09.45 WIB</span>
                                <h4 class="font-serifJawa font-bold text-xl text-gold-foil mt-0.5">Upacara Panggih &amp; Balangan Gantal</h4>
                                <p class="text-xs text-krem-200/80 mt-1 leading-relaxed">Pertemuan sakral pengantin, lempar sirih (gantal), ngidak endhog (injak telur), dan sinduran.</p>
                            </div>
                        </div>

                        <div class="relative flex items-start gap-5">
                            <div class="w-12 h-12 rounded-full bg-sogan-900 border-2 border-emas-400 flex items-center justify-center text-emas-300 shrink-0 z-10 shadow-lg">
                                <i class="fa-solid fa-bowl-rice text-sm"></i>
                            </div>
                            <div class="card-3d-keraton rounded-2xl p-5 flex-1" data-tilt data-tilt-max="6">
                                <span class="text-xs font-bold text-emas-300 tracking-wider">09.45 – 10.30 WIB</span>
                                <h4 class="font-serifJawa font-bold text-xl text-gold-foil mt-0.5">Kacar Kucur &amp; Sungkeman</h4>
                                <p class="text-xs text-krem-200/80 mt-1 leading-relaxed">Simbol nafkah lahir batin keluarga (kacar-kucur), dhahar klimah, dilanjutkan sungkem memohon restu orang tua.</p>
                            </div>
                        </div>

                        <div class="relative flex items-start gap-5">
                            <div class="w-12 h-12 rounded-full bg-sogan-900 border-2 border-emas-400 flex items-center justify-center text-emas-300 shrink-0 z-10 shadow-lg">
                                <i class="fa-solid fa-champagne-glasses text-sm"></i>
                            </div>
                            <div class="card-3d-keraton rounded-2xl p-5 flex-1" data-tilt data-tilt-max="6">
                                <span class="text-xs font-bold text-emas-300 tracking-wider">11.00 – 14.00 WIB</span>
                                <h4 class="font-serifJawa font-bold text-xl text-gold-foil mt-0.5">Pahargyan Ageng &amp; Ramah Tamah</h4>
                                <p class="text-xs text-krem-200/80 mt-1 leading-relaxed">Resepsi pernikahan agung, doa restu para tamu kehormatan, sesi foto, dan santap hidangan tradisi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 6: KISAH CINTA (CARIYOS KATRESNAN) -->
        <section id="cerita" class="relative py-24 px-4 bg-sogan-950 overflow-hidden">
            <div class="max-w-5xl mx-auto relative z-10 text-center">
                <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold">Cariyos Katresnan</p>
                <h2 class="font-serifJawa font-bold text-4xl sm:text-5xl text-gold-foil mt-2">Kisah Cinta Berbalut Doa</h2>
                <p class="text-krem-200/80 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                    Setiap langkah pertemuan kami merupakan takdir indah yang telah digariskan:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 text-left">
                    <div class="card-3d-keraton rounded-3xl p-6 group hover:-translate-y-1 transition duration-300" data-tilt data-tilt-max="8">
                        <div class="h-44 rounded-2xl overflow-hidden mb-4 border border-emas-400/40">
                            <img src="{{ asset('tema/javanese1/assets/images/story.webp') }}" alt="Awal Pertemuan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="inline-block px-3 py-1 rounded-full bg-sogan-800 text-emas-300 text-xs font-semibold tracking-wider uppercase mb-2 border border-emas-400/40">
                            Bab 01 • Tahun 2021
                        </span>
                        <h3 class="font-serifJawa font-bold text-2xl text-gold-foil mt-1">Tepang Kapisan</h3>
                        <p class="text-xs text-krem-200/80 mt-2 leading-relaxed">
                            Awal perjumpaan kami di pelataran Keraton Yogyakarta saat festival seni budaya. Perbincangan hangat tentang arsitektur kuno menjadi benih cinta yang tumbuh.
                        </p>
                    </div>

                    <div class="card-3d-keraton rounded-3xl p-6 group hover:-translate-y-1 transition duration-300" data-tilt data-tilt-max="8">
                        <div class="h-44 rounded-2xl overflow-hidden mb-4 border border-emas-400/40">
                            <img src="{{ asset('tema/javanese1/assets/images/proposal.webp') }}" alt="Menjalin Janji" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="inline-block px-3 py-1 rounded-full bg-sogan-800 text-emas-300 text-xs font-semibold tracking-wider uppercase mb-2 border border-emas-400/40">
                            Bab 02 • Tahun 2023
                        </span>
                        <h3 class="font-serifJawa font-bold text-2xl text-gold-foil mt-1">Nglajengaken Prasetya</h3>
                        <p class="text-xs text-krem-200/80 mt-2 leading-relaxed">
                            Menemukan keselarasan batin dan visi masa depan. Saling menemani melewati lika-liku hidup dengan penuh kesabaran dan doa bersama.
                        </p>
                    </div>

                    <div class="card-3d-keraton rounded-3xl p-6 group hover:-translate-y-1 transition duration-300" data-tilt data-tilt-max="8">
                        <div class="h-44 rounded-2xl overflow-hidden mb-4 border border-emas-400/40">
                            <img src="{{ asset('tema/javanese1/assets/images/couple-hero.webp') }}" alt="Menuju Pelaminan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <span class="inline-block px-3 py-1 rounded-full bg-sogan-800 text-emas-300 text-xs font-semibold tracking-wider uppercase mb-2 border border-emas-400/40">
                            Bab 03 • Tahun 2026
                        </span>
                        <h3 class="font-serifJawa font-bold text-2xl text-gold-foil mt-1">Menuju Pelaminan</h3>
                        <p class="text-xs text-krem-200/80 mt-2 leading-relaxed">
                            Prosesi lamaran resmi dihadiri kedua keluarga besar. Kini kami bersiap mengucap janji suci pernikahan untuk melangkah bersama mengarungi samudra kehidupan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 7: GALERI FOTO & VIDEO 3D -->
        <section id="galeri" class="relative py-24 px-4 bg-gradient-to-b from-sogan-950 via-sogan-900 to-sogan-950 overflow-hidden">
            <div class="max-w-5xl mx-auto relative z-10 text-center">
                <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold">Pawartos Momen</p>
                <h2 class="font-serifJawa font-bold text-4xl sm:text-5xl text-gold-foil mt-2">Galeri Foto &amp; Video</h2>
                <p class="text-krem-200/80 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                    Koleksi potret kasih dan momen bahagia kedua mempelai:
                </p>

                <!-- Grid Galeri 3D -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mt-12">
                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl border border-emas-400/50 cursor-pointer card-3d-keraton p-1.5" onclick="openLightbox('{{ asset('tema/javanese1/assets/images/couple-hero.webp') }}', 'Potret Anggun Busana Keraton Jawa')" data-tilt data-tilt-max="10">
                        <img src="{{ asset('tema/javanese1/assets/images/couple-hero.webp') }}" alt="Foto 1" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-sogan-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-emas-400 text-sogan-950 flex items-center justify-center shadow-lg"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                        </div>
                    </div>

                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl border border-emas-400/50 cursor-pointer card-3d-keraton p-1.5" onclick="openLightbox('{{ asset('tema/javanese1/assets/images/groom.webp') }}', 'Mempelai Pria — Raden Bagus Aditya')" data-tilt data-tilt-max="10">
                        <img src="{{ asset('tema/javanese1/assets/images/groom.webp') }}" alt="Foto 2" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-sogan-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-emas-400 text-sogan-950 flex items-center justify-center shadow-lg"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                        </div>
                    </div>

                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl border border-emas-400/50 cursor-pointer card-3d-keraton p-1.5" onclick="openLightbox('{{ asset('tema/javanese1/assets/images/bride.webp') }}', 'Mempelai Wanita — Roro Ayu Kirana')" data-tilt data-tilt-max="10">
                        <img src="{{ asset('tema/javanese1/assets/images/bride.webp') }}" alt="Foto 3" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-sogan-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-emas-400 text-sogan-950 flex items-center justify-center shadow-lg"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                        </div>
                    </div>

                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl border border-emas-400/50 cursor-pointer card-3d-keraton p-1.5" onclick="openLightbox('{{ asset('tema/javanese1/assets/images/story.webp') }}', 'Momen Manis di Pelataran Keraton')" data-tilt data-tilt-max="10">
                        <img src="{{ asset('tema/javanese1/assets/images/story.webp') }}" alt="Foto 4" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-sogan-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-emas-400 text-sogan-950 flex items-center justify-center shadow-lg"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                        </div>
                    </div>

                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl border border-emas-400/50 cursor-pointer card-3d-keraton p-1.5" onclick="openLightbox('{{ asset('tema/javanese1/assets/images/proposal.webp') }}', 'Momen Lamaran Sakral')" data-tilt data-tilt-max="10">
                        <img src="{{ asset('tema/javanese1/assets/images/proposal.webp') }}" alt="Foto 5" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-sogan-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-emas-400 text-sogan-950 flex items-center justify-center shadow-lg"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                        </div>
                    </div>

                    <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl border border-emas-400/50 cursor-pointer card-3d-keraton p-1.5" onclick="openLightbox('{{ asset('tema/javanese1/assets/images/couple-hero.webp') }}', 'Senyum Bahagia Bersama')" data-tilt data-tilt-max="10">
                        <img src="{{ asset('tema/javanese1/assets/images/couple-hero.webp') }}" alt="Foto 6" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-sogan-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="w-10 h-10 rounded-full bg-emas-400 text-sogan-950 flex items-center justify-center shadow-lg"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Video Klip Pawiwahan -->
                <div class="mt-14 card-3d-keraton rounded-3xl p-6 sm:p-8 max-w-2xl mx-auto shadow-2xl" data-tilt data-tilt-max="5">
                    <h3 class="font-serifJawa font-bold text-2xl text-gold-foil mb-2">Video Klip Pawiwahan</h3>
                    <p class="text-xs text-krem-200/75 mb-5">Cuplikan video prewedding dan doa restu kedua keluarga:</p>
                    <div class="aspect-video w-full rounded-2xl overflow-hidden border border-emas-400/40 shadow-inner">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/VDbVXpJWA-k" title="Video Prewedding Jawa" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 8: SIARAN LANGSUNG (LIVE STREAMING) -->
        <section id="streaming" class="relative py-20 px-4 bg-sogan-950 text-center overflow-hidden">
            <div class="max-w-2xl mx-auto card-3d-keraton rounded-3xl p-8 sm:p-10 relative z-10" data-tilt data-tilt-max="6">
                <span class="inline-block px-4 py-1 rounded-full bg-emas-500/20 text-emas-300 border border-emas-400/40 text-xs uppercase tracking-widest font-semibold mb-3">
                    <i class="fa-solid fa-satellite-dish mr-1.5 animate-pulse text-red-400"></i>Virtual Attendance
                </span>
                <h3 class="font-serifJawa font-bold text-3xl text-gold-foil">Siaran Langsung Pawiwahan</h3>
                <p class="text-xs sm:text-sm text-krem-200/80 mt-3 leading-relaxed max-w-lg mx-auto">
                    Bagi para sesepuh, sanak kadang, dan sahabat yang berhalangan hadir secara langsung di Pendopo Agung, dapat menyaksikan prosesi akad nikah kami secara daring:
                </p>
                <div class="mt-6">
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg transition hover:scale-105">
                        <i class="fa-brands fa-youtube text-base"></i>
                        <span>Tonton Siaran Langsung YouTube</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- SECTION 9: TANDA KASIH (AMPLOP DIGITAL & KADO FISIK) -->
        <section id="amplop" class="relative py-24 px-4 bg-gradient-to-b from-sogan-950 via-sogan-900 to-sogan-950 overflow-hidden">
            <div class="max-w-4xl mx-auto relative z-10 text-center">
                <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold">Tanda Kasih</p>
                <h2 class="font-serifJawa font-bold text-4xl sm:text-5xl text-gold-foil mt-2">Amplop Digital 3D &amp; Kado</h2>
                <p class="text-krem-200/80 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                    Kehadiran dan doa restu Bapak/Ibu/Saudara/i merupakan anugerah terindah. Namun apabila ingin memberikan tanda kasih secara digital maupun kado fisik, dapat melalui informasi berikut:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                    <!-- Kartu BCA -->
                    <div class="card-3d-keraton rounded-3xl p-7 text-left relative overflow-hidden" data-tilt data-tilt-max="10" data-tilt-glare="true" data-tilt-max-glare="0.25">
                        <div class="absolute -right-8 -bottom-8 w-36 opacity-20 pointer-events-none asset-slot-gunungan"></div>
                        <div class="card-3d-inner">
                            <div class="flex justify-between items-center mb-6">
                                <span class="font-serifJawa font-bold text-2xl text-gold-foil">BANK BCA</span>
                                <i class="fa-solid fa-sim-card text-2xl text-emas-300"></i>
                            </div>
                            <p class="text-[11px] uppercase tracking-widest text-krem-200/60">Nomor Rekening</p>
                            <p class="font-mono text-2xl font-bold tracking-widest text-emas-200 my-1">8472 0918 27</p>
                            <p class="text-xs text-krem-100/90 mb-5">a.n. Raden Bagus Aditya</p>
                            <button onclick="copyText('8472091827', 'Rekening BCA')" class="w-full py-3 rounded-xl bg-emas-400/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 text-xs font-bold uppercase tracking-wider transition-all">
                                <i class="fa-regular fa-copy mr-1.5"></i>Salin Rekening BCA
                            </button>
                        </div>
                    </div>

                    <!-- Kartu Mandiri -->
                    <div class="card-3d-keraton rounded-3xl p-7 text-left relative overflow-hidden" data-tilt data-tilt-max="10" data-tilt-glare="true" data-tilt-max-glare="0.25">
                        <div class="absolute -right-8 -bottom-8 w-36 opacity-20 pointer-events-none asset-slot-gunungan"></div>
                        <div class="card-3d-inner">
                            <div class="flex justify-between items-center mb-6">
                                <span class="font-serifJawa font-bold text-2xl text-gold-foil">BANK MANDIRI</span>
                                <i class="fa-solid fa-sim-card text-2xl text-emas-300"></i>
                            </div>
                            <p class="text-[11px] uppercase tracking-widest text-krem-200/60">Nomor Rekening</p>
                            <p class="font-mono text-2xl font-bold tracking-widest text-emas-200 my-1">1370 0192 8374 1</p>
                            <p class="text-xs text-krem-100/90 mb-5">a.n. Roro Ayu Kirana</p>
                            <button onclick="copyText('1370019283741', 'Rekening Mandiri')" class="w-full py-3 rounded-xl bg-emas-400/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 text-xs font-bold uppercase tracking-wider transition-all">
                                <i class="fa-regular fa-copy mr-1.5"></i>Salin Rekening Mandiri
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kirim Kado Fisik -->
                <div class="mt-6 card-3d-keraton rounded-3xl p-7 text-left relative overflow-hidden" data-tilt data-tilt-max="6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-serifJawa font-bold text-2xl text-gold-foil">Kirim Kado Fisik</span>
                        <i class="fa-solid fa-box-open text-2xl text-emas-400"></i>
                    </div>
                    <p class="text-xs text-krem-200/70">Alamat Pengiriman Hadiah:</p>
                    <p id="alamat-kado-fisik" class="text-xs sm:text-sm text-krem-100 mt-1 leading-relaxed">
                        Ndalem Suryokusuman, Jl. Rotowijayan No. 15, Kadipaten, Kraton, Kota Yogyakarta, D.I. Yogyakarta 55132 (Penerima: Keluarga Aditya &amp; Kirana)
                    </p>
                    <div class="mt-4 text-right">
                        <button onclick="copyAlamat()" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-emas-400/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 text-xs font-bold uppercase tracking-wider transition-all">
                            <i class="fa-regular fa-copy"></i>
                            <span>Salin Alamat Kado</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 10: BUKU TAMU & DOA RESTU (RSVP) -->
        <section id="ucapan" class="relative py-24 px-4 pb-36 bg-sogan-950 overflow-hidden">
            <div class="absolute inset-0 opacity-15 dynamic-batik-bg pointer-events-none"></div>
            <div class="max-w-3xl mx-auto relative z-10">
                <div class="text-center mb-10">
                    <p class="text-emas-300 uppercase tracking-[0.3em] text-xs font-semibold">Atur Pangandikan</p>
                    <h2 class="font-serifJawa font-bold text-4xl sm:text-5xl text-gold-foil mt-2">Doa Restu &amp; Kehadiran</h2>
                </div>

                <form id="rsvp-form" onsubmit="handleRSVP(event)" class="card-3d-keraton rounded-3xl p-6 sm:p-10 mb-10 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-emas-300 mb-2">Nama Lengkap</label>
                            <input type="text" id="rsvp-name" required placeholder="Nama Bapak/Ibu/Saudara/i" class="w-full px-4 py-3 rounded-xl bg-sogan-950/90 border border-emas-400/40 text-krem-100 text-sm focus:outline-none focus:border-emas-300">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-emas-300 mb-2">Konfirmasi Kehadiran</label>
                            <select id="rsvp-status" class="w-full px-4 py-3 rounded-xl bg-sogan-950/90 border border-emas-400/40 text-krem-100 text-sm focus:outline-none focus:border-emas-300">
                                <option value="Hadir">Insya Allah Hadir</option>
                                <option value="Berhalangan">Mohon Maaf, Berhalangan</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-emas-300 mb-2">Untaian Doa Restu</label>
                        <textarea id="rsvp-message" rows="3" required placeholder="Tuliskan doa restu untuk kedua mempelai..." class="w-full px-4 py-3 rounded-xl bg-sogan-950/90 border border-emas-400/40 text-krem-100 text-sm focus:outline-none focus:border-emas-300"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-emas-500 via-emas-400 to-emas-500 text-sogan-950 font-bold text-xs sm:text-sm uppercase tracking-wider shadow-lg hover:brightness-110 transition-all">
                        <i class="fa-solid fa-paper-plane mr-2"></i>Kirim Doa Restu
                    </button>
                </form>

                <div id="wishes-list" class="space-y-4 max-h-96 overflow-y-auto pr-2"></div>

                <!-- Footer Penutup -->
                <div class="text-center mt-20 pt-10 border-t border-emas-400/20">
                    <div class="w-48 mx-auto mb-3 asset-slot-joglo"></div>
                    <h3 class="font-aksen text-5xl text-gold-foil">Matur Nuwun</h3>
                    <p class="font-serifJawa italic text-krem-200/80 mt-1">Memayu Hayuning Kulawarga • Rahayu Nir Ing Sambikala</p>
                </div>
            </div>
        </section>
    </main>

    <!-- 6. MODAL STUDIO ASSET JAWA (PREVIEW & DOWNLOAD SVG, PNG, ZIP) -->
    <div id="asset-studio-modal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md hidden items-center justify-center p-4 overflow-y-auto">
        <div class="card-3d-keraton rounded-3xl max-w-5xl w-full p-6 sm:p-8 my-8 border border-emas-400 max-h-[90vh] flex flex-col">
            <div class="flex flex-wrap items-center justify-between gap-4 pb-5 border-b border-emas-400/30">
                <div>
                    <span class="text-xs uppercase tracking-[0.25em] text-emas-300 font-semibold">Modular Vector Pack</span>
                    <h2 class="font-serifJawa font-bold text-2xl sm:text-3xl text-gold-foil">Studio Download Asset Ornamen Jawa</h2>
                    <p class="text-xs text-krem-200/75 mt-0.5">Semua ilustrasi (Rumah Joglo, Gunungan, Bunga Melati, Daun Angin, Ukiran &amp; Batik) terpisah dan siap diunduh.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="downloadAllAssetsZip()" id="btn-zip-all" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emas-500 via-emas-300 to-emas-500 text-sogan-950 font-bold text-xs uppercase tracking-wider shadow-lg hover:scale-105 transition-transform flex items-center gap-2">
                        <i class="fa-solid fa-file-zipper text-sm"></i>
                        <span>Download Semua (.ZIP)</span>
                    </button>
                    <button onclick="closeAssetModal()" class="w-10 h-10 rounded-full bg-sogan-800 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>

            <div id="asset-gallery-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 py-6 overflow-y-auto pr-1"></div>
        </div>
    </div>

    <!-- 7. FLOATING AUDIO CONTROL & BOTTOM NAVIGATION BAR -->
    <button id="btn-audio" onclick="toggleGamelan()" title="Putar/Jeda Gending Jawa" class="fixed bottom-24 right-5 z-40 w-12 h-12 rounded-full bg-sogan-900 border-2 border-emas-400 text-emas-300 shadow-[0_0_20px_rgba(212,175,55,0.4)] flex items-center justify-center hover:scale-110 transition-transform">
        <i id="audio-icon" class="fa-solid fa-compact-disc text-xl animate-spin"></i>
    </button>

    <nav class="fixed bottom-4 left-1/2 -translate-x-1/2 z-40 bg-sogan-900/95 backdrop-blur-md border border-emas-400/50 rounded-full px-4 sm:px-6 py-2.5 shadow-2xl flex items-center gap-4 sm:gap-6 max-w-[95vw] overflow-x-auto">
        <a href="#hero-3d-stage" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-solid fa-landmark-dome text-sm mb-0.5"></i><span>Joglo 3D</span>
        </a>
        <a href="#mempelai" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-solid fa-heart text-sm mb-0.5"></i><span>Mempelai</span>
        </a>
        <a href="#acara" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-regular fa-calendar-check text-sm mb-0.5"></i><span>Acara</span>
        </a>
        <a href="#cerita" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-solid fa-book-open text-sm mb-0.5"></i><span>Kisah</span>
        </a>
        <a href="#galeri" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-regular fa-images text-sm mb-0.5"></i><span>Galeri</span>
        </a>
        <a href="#amplop" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-solid fa-gift text-sm mb-0.5"></i><span>Hadiah</span>
        </a>
        <a href="#ucapan" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-regular fa-comments text-sm mb-0.5"></i><span>Ucapan</span>
        </a>
    </nav>

    <!-- Custom Toast Notification -->
    <div id="toast-box" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-sogan-900 border border-emas-400 text-emas-200 px-6 py-3 rounded-full shadow-2xl flex items-center gap-3 text-xs sm:text-sm pointer-events-none opacity-0 -translate-y-4 transition-all duration-300">
        <i class="fa-solid fa-circle-check text-emas-400"></i>
        <span id="toast-text">Berhasil!</span>
    </div>

    <!-- JAVASCRIPT & THREE.JS LOGIC -->
    <script>
        const SHARED_SVG_DEFS = `
            <defs>
                <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#FFF8DC"/>
                    <stop offset="35%" stop-color="#D4AF37"/>
                    <stop offset="70%" stop-color="#9A6F0A"/>
                    <stop offset="100%" stop-color="#F6E39F"/>
                </linearGradient>
                <linearGradient id="woodRoofGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#5C321C"/>
                    <stop offset="55%" stop-color="#381E11"/>
                    <stop offset="100%" stop-color="#1E0E07"/>
                </linearGradient>
                <radialGradient id="warmLantern" cx="50%" cy="50%" r="50%">
                    <stop offset="0%" stop-color="#FFF9E6" stop-opacity="1"/>
                    <stop offset="40%" stop-color="#F59E0B" stop-opacity="0.65"/>
                    <stop offset="100%" stop-color="#D97706" stop-opacity="0"/>
                </radialGradient>
            </defs>
        `;

        const JAVANESE_ASSETS = {
            'joglo-keraton': {
                title: 'Rumah Adat Joglo Keraton',
                filename: 'joglo-keraton',
                width: 800,
                height: 500,
                description: 'Rumah Joglo Jawa beratap Brunjung & Tumpang Sari lengkap dengan lentera dan siluet pengantin.',
                svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 310" width="100%" height="100%">
                    ${SHARED_SVG_DEFS}
                    <circle cx="250" cy="175" r="115" fill="url(#warmLantern)" opacity="0.45"/>
                    <rect x="65" y="262" width="370" height="10" rx="2" fill="#2E170D" stroke="url(#goldGrad)" stroke-width="1.2"/>
                    <rect x="85" y="252" width="330" height="10" rx="2" fill="#462415" stroke="url(#goldGrad)" stroke-width="1.2"/>
                    <rect x="170" y="252" width="160" height="20" fill="#1C0E08" stroke="url(#goldGrad)" stroke-width="1"/>
                    <line x1="180" y1="258" x2="320" y2="258" stroke="url(#goldGrad)" stroke-width="0.9"/>
                    <line x1="175" y1="265" x2="325" y2="265" stroke="url(#goldGrad)" stroke-width="0.9"/>
                    <rect x="130" y="160" width="240" height="92" fill="#241107" stroke="url(#goldGrad)" stroke-width="1.2"/>
                    <path d="M215,252 L215,182 C215,165 285,165 285,182 L285,252 Z" fill="#462415" stroke="url(#goldGrad)" stroke-width="1.8"/>
                    <circle cx="250" cy="210" r="46" fill="url(#warmLantern)" class="lentera-pendar"/>
                    <g fill="#1C0E08" opacity="0.9">
                        <path d="M240,252 C240,228 248,228 248,252 Z"/>
                        <circle cx="244" cy="222" r="4.8"/>
                        <path d="M252,252 C252,230 260,230 260,252 Z"/>
                        <circle cx="256" cy="224" r="4.2"/>
                    </g>
                    <rect x="150" y="184" width="44" height="44" rx="3" fill="#160B06" stroke="url(#goldGrad)" stroke-width="1.1"/>
                    <path d="M172,184 L172,228 M150,206 L194,206" stroke="url(#goldGrad)" stroke-width="0.8"/>
                    <rect x="306" y="184" width="44" height="44" rx="3" fill="#160B06" stroke="url(#goldGrad)" stroke-width="1.1"/>
                    <path d="M328,184 L328,228 M306,206 L350,206" stroke="url(#goldGrad)" stroke-width="0.8"/>
                    <rect x="110" y="158" width="10" height="94" fill="#5C321C" stroke="url(#goldGrad)" stroke-width="1"/>
                    <rect x="380" y="158" width="10" height="94" fill="#5C321C" stroke="url(#goldGrad)" stroke-width="1"/>
                    <rect x="192" y="148" width="12" height="104" fill="#63341E" stroke="url(#goldGrad)" stroke-width="1.3"/>
                    <rect x="296" y="148" width="12" height="104" fill="#63341E" stroke="url(#goldGrad)" stroke-width="1.3"/>
                    <path d="M188,252 L212,252 L209,240 L191,240 Z" fill="url(#goldGrad)"/>
                    <path d="M292,252 L316,252 L313,240 L295,240 Z" fill="url(#goldGrad)"/>
                    <line x1="250" y1="148" x2="250" y2="176" stroke="url(#goldGrad)" stroke-width="1.5"/>
                    <polygon points="242,176 258,176 254,192 246,192" fill="#FFF8DC" stroke="url(#goldGrad)" stroke-width="1.2"/>
                    <circle cx="250" cy="184" r="18" fill="url(#warmLantern)" class="lentera-pendar"/>
                    <path d="M55,160 L150,110 L350,110 L445,160 Z" fill="url(#woodRoofGrad)" stroke="url(#goldGrad)" stroke-width="2"/>
                    <line x1="88" y1="144" x2="412" y2="144" stroke="url(#goldGrad)" stroke-width="0.7" stroke-opacity="0.6"/>
                    <line x1="120" y1="126" x2="380" y2="126" stroke="url(#goldGrad)" stroke-width="0.7" stroke-opacity="0.6"/>
                    <path d="M145,112 L210,44 L290,44 L355,112 Z" fill="url(#woodRoofGrad)" stroke="url(#goldGrad)" stroke-width="2.2"/>
                    <line x1="170" y1="90" x2="330" y2="90" stroke="url(#goldGrad)" stroke-width="0.7" stroke-opacity="0.6"/>
                    <line x1="192" y1="66" x2="308" y2="66" stroke="url(#goldGrad)" stroke-width="0.7" stroke-opacity="0.6"/>
                    <path d="M208,44 L292,44" stroke="url(#goldGrad)" stroke-width="4" stroke-linecap="round"/>
                    <path d="M250,12 L240,44 L260,44 Z" fill="url(#goldGrad)"/>
                    <circle cx="250" cy="24" r="5.5" fill="#FFF8DC" stroke="url(#goldGrad)" stroke-width="1.5"/>
                    <path d="M55,160 Q42,154 46,142" stroke="url(#goldGrad)" stroke-width="2.2" fill="none" stroke-linecap="round"/>
                    <path d="M445,160 Q458,154 454,142" stroke="url(#goldGrad)" stroke-width="2.2" fill="none" stroke-linecap="round"/>
                </svg>`
            },
            'gunungan-wayang': {
                title: 'Gunungan Wayang Kayon Emas',
                filename: 'gunungan-wayang',
                width: 500,
                height: 800,
                description: 'Simbol Pohon Hayat (Kalpataru) Jawa dengan ukiran keraton berlapis emas.',
                svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="-60 -100 120 200" width="100%" height="100%">
                    ${SHARED_SVG_DEFS}
                    <path d="M0,-92 C-28,-54 -52,-10 -48,38 C-44,68 -24,84 0,92 C24,84 44,68 48,38 C52,-10 28,-54 0,-92 Z" fill="url(#goldGrad)" fill-opacity="0.22" stroke="url(#goldGrad)" stroke-width="2.2"/>
                    <path d="M0,-78 C-22,-45 -42,-6 -38,34 C-35,58 -18,72 0,80 C18,72 35,58 38,34 C42,-6 22,-45 0,-78 Z" fill="none" stroke="url(#goldGrad)" stroke-width="1.2" stroke-dasharray="3,2"/>
                    <path d="M0,80 L0,-55 M0,35 C-18,24 -26,8 -14,-4 M0,35 C18,24 26,8 14,-4 M0,2 C-15,-10 -22,-25 -10,-35 M0,2 C15,-10 22,-25 10,-35" stroke="url(#goldGrad)" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                    <path d="M-20,78 L-20,50 L-26,50 L0,34 L26,50 L20,50 L20,78 Z" fill="url(#goldGrad)" opacity="0.75"/>
                    <circle cx="0" cy="-58" r="5" fill="#FFF8DC" stroke="url(#goldGrad)" stroke-width="1.5"/>
                    <circle cx="-14" cy="-4" r="3" fill="#FFF8DC"/>
                    <circle cx="14" cy="-4" r="3" fill="#FFF8DC"/>
                </svg>`
            },
            'daun-angin-jawa': {
                title: 'Dedaunan Jawa & Ronce Melati',
                filename: 'daun-angin-jawa',
                width: 650,
                height: 500,
                description: 'Rangkaian ranting daun beringin tropis, bunga cempaka, dan untaian ronce melati gantung.',
                svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 260 200" width="100%" height="100%">
                    ${SHARED_SVG_DEFS}
                    <path d="M0,0 Q85,35 175,88" stroke="#AA820A" stroke-width="2.8" fill="none"/>
                    <path d="M40,18 C68,4 90,20 78,42 C58,44 45,30 40,18 Z" fill="#2A473A" stroke="url(#goldGrad)" stroke-width="0.9"/>
                    <path d="M88,42 C115,24 142,40 130,64 C104,68 92,54 88,42 Z" fill="#1B3027" stroke="url(#goldGrad)" stroke-width="0.9"/>
                    <path d="M135,68 C162,54 188,68 178,90 C154,92 142,80 135,68 Z" fill="#2A473A" stroke="url(#goldGrad)" stroke-width="0.9"/>
                    <path d="M62,32 C46,58 62,82 86,72 C88,52 74,40 62,32 Z" fill="#3B6251" stroke="url(#goldGrad)" stroke-width="0.8"/>
                    <path d="M112,56 C96,82 114,106 138,94 C138,74 124,64 112,56 Z" fill="#2A473A" stroke="url(#goldGrad)" stroke-width="0.8"/>
                    <g class="ronce-ayun-1" transform="translate(38, 12)">
                        <line x1="0" y1="0" x2="0" y2="115" stroke="url(#goldGrad)" stroke-width="1.2" stroke-dasharray="2,2"/>
                        <circle cx="0" cy="18" r="4" fill="#FFFDF9"/><circle cx="0" cy="34" r="4.5" fill="#FFFDF9"/>
                        <circle cx="0" cy="50" r="4" fill="#FFFDF9"/><circle cx="0" cy="66" r="4.5" fill="#FFFDF9"/>
                        <circle cx="0" cy="82" r="4" fill="#FFFDF9"/><circle cx="0" cy="98" r="5.5" fill="#D4AF37"/>
                        <path d="M0,106 L-4,122 L0,118 L4,122 Z" fill="url(#goldGrad)"/>
                    </g>
                    <g class="ronce-ayun-2" transform="translate(92, 42) scale(0.82)">
                        <line x1="0" y1="0" x2="0" y2="110" stroke="url(#goldGrad)" stroke-width="1.2" stroke-dasharray="2,2"/>
                        <circle cx="0" cy="18" r="4" fill="#FFFDF9"/><circle cx="0" cy="34" r="4.5" fill="#FFFDF9"/>
                        <circle cx="0" cy="50" r="4" fill="#FFFDF9"/><circle cx="0" cy="66" r="4.5" fill="#FFFDF9"/>
                        <circle cx="0" cy="82" r="5" fill="#D4AF37"/>
                    </g>
                    <g transform="translate(132, 68)">
                        <circle cx="0" cy="-7" r="4.5" fill="#FFFDF9"/><circle cx="6" cy="-3" r="4.5" fill="#FFFDF9"/>
                        <circle cx="6" cy="4" r="4.5" fill="#FFFDF9"/><circle cx="0" cy="7" r="4.5" fill="#FFFDF9"/>
                        <circle cx="-6" cy="4" r="4.5" fill="#FFFDF9"/><circle cx="-6" cy="-3" r="4.5" fill="#FFFDF9"/>
                        <circle cx="0" cy="0" r="3.5" fill="url(#goldGrad)"/>
                    </g>
                </svg>`
            },
            'bunga-melati-cempaka': {
                title: 'Bunga Melati & Cempaka Keraton',
                filename: 'bunga-melati-cempaka',
                width: 500,
                height: 350,
                description: 'Buket bunga melati putih gading dan kuncup cempaka emas dengan dedaunan.',
                svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="-100 -60 200 120" width="100%" height="100%">
                    ${SHARED_SVG_DEFS}
                    <path d="M-80,20 C-50,-10 -20,0 0,20 C-25,35 -55,35 -80,20 Z" fill="#2A473A" stroke="url(#goldGrad)" stroke-width="1"/>
                    <path d="M80,20 C50,-10 20,0 0,20 C25,35 55,35 80,20 Z" fill="#2A473A" stroke="url(#goldGrad)" stroke-width="1"/>
                    <path d="M-45,-15 C-25,-35 -5,-20 0,10 C-20,10 -35,0 -45,-15 Z" fill="#3B6251" stroke="url(#goldGrad)" stroke-width="0.9"/>
                    <path d="M45,-15 C25,-35 5,-20 0,10 C20,10 35,0 45,-15 Z" fill="#3B6251" stroke="url(#goldGrad)" stroke-width="0.9"/>
                    <g transform="translate(0, 12) scale(1.6)">
                        <path d="M0,0 C-8,-10 -5,-24 0,-30 C5,-24 8,-10 0,0 Z" fill="url(#goldGrad)"/>
                        <path d="M0,0 C-8,-10 -5,-24 0,-30 C5,-24 8,-10 0,0 Z" fill="url(#goldGrad)" transform="rotate(42)" opacity="0.9"/>
                        <path d="M0,0 C-8,-10 -5,-24 0,-30 C5,-24 8,-10 0,0 Z" fill="url(#goldGrad)" transform="rotate(-42)" opacity="0.9"/>
                        <path d="M0,0 C-6,-8 -4,-18 0,-22 C4,-18 6,-8 0,0 Z" fill="#FFFDF9" transform="rotate(20)"/>
                        <path d="M0,0 C-6,-8 -4,-18 0,-22 C4,-18 6,-8 0,0 Z" fill="#FFFDF9" transform="rotate(-20)"/>
                    </g>
                    <g transform="translate(-38, 16) scale(1.3)">
                        <circle cx="0" cy="-6" r="4" fill="#FFFDF9"/><circle cx="5" cy="-3" r="4" fill="#FFFDF9"/>
                        <circle cx="5" cy="3" r="4" fill="#FFFDF9"/><circle cx="0" cy="6" r="4" fill="#FFFDF9"/>
                        <circle cx="-5" cy="3" r="4" fill="#FFFDF9"/><circle cx="-5" cy="-3" r="4" fill="#FFFDF9"/>
                        <circle cx="0" cy="0" r="3" fill="url(#goldGrad)"/>
                    </g>
                    <g transform="translate(38, 16) scale(1.3)">
                        <circle cx="0" cy="-6" r="4" fill="#FFFDF9"/><circle cx="5" cy="-3" r="4" fill="#FFFDF9"/>
                        <circle cx="5" cy="3" r="4" fill="#FFFDF9"/><circle cx="0" cy="6" r="4" fill="#FFFDF9"/>
                        <circle cx="-5" cy="3" r="4" fill="#FFFDF9"/><circle cx="-5" cy="-3" r="4" fill="#FFFDF9"/>
                        <circle cx="0" cy="0" r="3" fill="url(#goldGrad)"/>
                    </g>
                </svg>`
            },
            'bingkai-ukiran-gebyok': {
                title: 'Ornamen Sudut Ukiran Gebyok',
                filename: 'bingkai-ukiran-gebyok',
                width: 400,
                height: 400,
                description: 'Ornamen sudut ukiran kayu jati berlapis emas untuk bingkai undangan.',
                svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" width="100%" height="100%">
                    ${SHARED_SVG_DEFS}
                    <path d="M3,3 L62,3 C42,8 34,16 28,28 C16,34 8,42 3,62 Z" fill="url(#goldGrad)" opacity="0.28"/>
                    <path d="M3,3 L74,3 M3,3 L3,74" stroke="url(#goldGrad)" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <path d="M10,10 L54,10 C38,14 26,26 22,42 C18,30 14,22 10,54 Z" stroke="url(#goldGrad)" stroke-width="1.5" fill="none"/>
                    <circle cx="16" cy="16" r="3.5" fill="url(#goldGrad)"/>
                    <circle cx="62" cy="10" r="2.5" fill="url(#goldGrad)"/>
                    <circle cx="10" cy="62" r="2.5" fill="url(#goldGrad)"/>
                </svg>`
            },
            'motif-batik-kawung': {
                title: 'Pola Seamless Batik Kawung Emas',
                filename: 'motif-batik-kawung',
                width: 400,
                height: 400,
                description: 'Pola berulang (seamless pattern) Batik Kawung Keraton untuk latar belakang.',
                svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" width="100%" height="100%">
                    ${SHARED_SVG_DEFS}
                    <rect width="60" height="60" fill="#160B06"/>
                    <g fill="none" stroke="url(#goldGrad)" stroke-width="1.1">
                        <path d="M30 0 C14 14 14 46 30 60 C46 46 46 14 30 0 Z"/>
                        <path d="M0 30 C14 14 46 14 60 30 C46 46 14 46 0 30 Z"/>
                        <circle cx="30" cy="30" r="3.5" fill="url(#goldGrad)"/>
                        <circle cx="30" cy="12" r="1.8" fill="url(#goldGrad)"/>
                        <circle cx="30" cy="48" r="1.8" fill="url(#goldGrad)"/>
                        <circle cx="12" cy="30" r="1.8" fill="url(#goldGrad)"/>
                        <circle cx="48" cy="30" r="1.8" fill="url(#goldGrad)"/>
                    </g>
                </svg>`
            }
        };

        function injectModularAssets() {
            document.querySelectorAll('.asset-slot-joglo').forEach(el => el.innerHTML = JAVANESE_ASSETS['joglo-keraton'].svg);
            document.querySelectorAll('.asset-slot-gunungan').forEach(el => el.innerHTML = JAVANESE_ASSETS['gunungan-wayang'].svg);
            document.querySelectorAll('.asset-slot-daun-kiri').forEach(el => el.innerHTML = JAVANESE_ASSETS['daun-angin-jawa'].svg);
            document.querySelectorAll('.asset-slot-daun-kanan').forEach(el => el.innerHTML = `<div class="transform scale-x-[-1] w-full h-full">${JAVANESE_ASSETS['daun-angin-jawa'].svg}</div>`);
            document.querySelectorAll('.asset-slot-bunga-tengah, .asset-slot-bunga-sudut').forEach(el => el.innerHTML = JAVANESE_ASSETS['bunga-melati-cempaka'].svg);
            document.querySelectorAll('.asset-slot-ukiran').forEach(el => el.innerHTML = JAVANESE_ASSETS['bingkai-ukiran-gebyok'].svg);

            const batikEncoded = 'data:image/svg+xml;utf8,' + encodeURIComponent(JAVANESE_ASSETS['motif-batik-kawung'].svg);
            document.querySelectorAll('.dynamic-batik-bg').forEach(el => {
                el.style.backgroundImage = `url("${batikEncoded}")`;
                el.style.backgroundSize = '64px 64px';
            });

            const grid = document.getElementById('asset-gallery-grid');
            if (grid) {
                grid.innerHTML = Object.keys(JAVANESE_ASSETS).map(key => {
                    const item = JAVANESE_ASSETS[key];
                    return `
                        <div class="bg-sogan-950/90 border border-emas-400/40 rounded-2xl p-4 flex flex-col justify-between">
                            <div>
                                <div class="h-40 rounded-xl bg-sogan-900/80 border border-emas-400/20 flex items-center justify-center p-3 mb-3 overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center">${item.svg}</div>
                                </div>
                                <h3 class="font-serifJawa font-bold text-lg text-emas-200">${item.title}</h3>
                                <p class="text-[11px] text-krem-200/70 mt-0.5 leading-relaxed">${item.description}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-4 pt-3 border-t border-emas-400/20">
                                <button onclick="downloadSingleSVG('${key}')" class="py-2 px-3 rounded-lg bg-emas-400/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 text-xs font-semibold transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-bezier-curve"></i><span>Unduh .SVG</span>
                                </button>
                                <button onclick="downloadSinglePNG('${key}')" class="py-2 px-3 rounded-lg bg-sogan-800 hover:bg-emas-400 text-krem-100 hover:text-sogan-950 border border-emas-400/30 text-xs font-semibold transition-colors flex items-center justify-center gap-1.5">
                                    <i class="fa-regular fa-image"></i><span>Unduh .PNG</span>
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

        function openAssetModal() {
            const modal = document.getElementById('asset-studio-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeAssetModal() {
            const modal = document.getElementById('asset-studio-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function downloadSingleSVG(key) {
            const item = JAVANESE_ASSETS[key];
            const blob = new Blob([item.svg], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            triggerDownload(url, `${item.filename}.svg`);
            URL.revokeObjectURL(url);
            showToast(`File ${item.filename}.svg berhasil diunduh!`);
        }

        function downloadSinglePNG(key) {
            const item = JAVANESE_ASSETS[key];
            const img = new Image();
            const svgBlob = new Blob([item.svg], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(svgBlob);

            img.onload = function () {
                const canvas = document.createElement('canvas');
                canvas.width = item.width * 2;
                canvas.height = item.height * 2;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                URL.revokeObjectURL(url);

                const pngUrl = canvas.toDataURL('image/png');
                triggerDownload(pngUrl, `${item.filename}-hd.png`);
                showToast(`File ${item.filename}-hd.png berhasil diunduh!`);
            };
            img.src = url;
        }

        async function downloadAllAssetsZip() {
            if (typeof JSZip === 'undefined') {
                showToast('Library JSZip sedang dimuat, coba sesaat lagi.');
                return;
            }
            const btn = document.getElementById('btn-zip-all');
            const originalText = btn.innerHTML;
            btn.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i><span>Membuat .ZIP...</span>`;

            try {
                const zip = new JSZip();
                const svgFolder = zip.folder('asset-jawa-svg');

                Object.keys(JAVANESE_ASSETS).forEach(key => {
                    const item = JAVANESE_ASSETS[key];
                    svgFolder.file(`${item.filename}.svg`, item.svg);
                });

                const content = await zip.generateAsync({ type: 'blob' });
                const zipUrl = URL.createObjectURL(content);
                triggerDownload(zipUrl, 'pawiwahan-jawa-3d-assets.zip');
                URL.revokeObjectURL(zipUrl);
                showToast('Semua asset berhasil diunduh dalam 1 file .ZIP!');
            } catch (err) {
                console.error(err);
                showToast('Gagal membuat bundel ZIP.');
            } finally {
                btn.innerHTML = originalText;
            }
        }

        function triggerDownload(url, filename) {
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        // Lightbox Functions
        const galleryImages = [
            { src: '{{ asset('tema/javanese1/assets/images/couple-hero.webp') }}', caption: 'Potret Anggun Busana Keraton Jawa' },
            { src: '{{ asset('tema/javanese1/assets/images/groom.webp') }}', caption: 'Mempelai Pria — Raden Bagus Aditya' },
            { src: '{{ asset('tema/javanese1/assets/images/bride.webp') }}', caption: 'Mempelai Wanita — Roro Ayu Kirana' },
            { src: '{{ asset('tema/javanese1/assets/images/story.webp') }}', caption: 'Momen Manis di Pelataran Keraton' },
            { src: '{{ asset('tema/javanese1/assets/images/proposal.webp') }}', caption: 'Momen Lamaran Sakral' },
            { src: '{{ asset('tema/javanese1/assets/images/couple-hero.webp') }}', caption: 'Senyum Bahagia Bersama' }
        ];
        let currentLightboxIndex = 0;

        function openLightbox(src, caption) {
            const modal = document.getElementById('lightbox-modal');
            const img = document.getElementById('lightbox-img');
            const cap = document.getElementById('lightbox-caption');

            currentLightboxIndex = galleryImages.findIndex(i => i.src === src);
            if (currentLightboxIndex === -1) currentLightboxIndex = 0;

            img.src = src;
            cap.textContent = caption || '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLightbox() {
            const modal = document.getElementById('lightbox-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function changeLightbox(step) {
            currentLightboxIndex = (currentLightboxIndex + step + galleryImages.length) % galleryImages.length;
            const item = galleryImages[currentLightboxIndex];
            document.getElementById('lightbox-img').src = item.src;
            document.getElementById('lightbox-caption').textContent = item.caption;
        }

        // Three.js 3D Particles
        let scene, camera, renderer, jasminePetals = [], firefliesGeo, firefliesMat;
        let mouseX = 0, mouseY = 0;

        function initThreeJS3D() {
            const canvas = document.getElementById('three-canvas');
            if (!canvas || typeof THREE === 'undefined') return;

            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 35;

            renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            const petalShape = new THREE.Shape();
            petalShape.moveTo(0, 0);
            petalShape.quadraticCurveTo(0.45, 0.4, 0, 1.1);
            petalShape.quadraticCurveTo(-0.45, 0.4, 0, 0);
            const petalGeo = new THREE.ShapeGeometry(petalShape, 6);

            const petalMat = new THREE.MeshBasicMaterial({
                color: 0xFFFDF5,
                side: THREE.DoubleSide,
                transparent: true,
                opacity: 0.78
            });

            for (let i = 0; i < 38; i++) {
                const mesh = new THREE.Mesh(petalGeo, petalMat);
                mesh.position.set(
                    (Math.random() - 0.5) * 65,
                    (Math.random() - 0.5) * 50,
                    (Math.random() - 0.5) * 25
                );
                const scale = Math.random() * 0.55 + 0.35;
                mesh.scale.set(scale, scale, scale);
                mesh.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, Math.random() * Math.PI);

                mesh.userData = {
                    speedY: Math.random() * 0.04 + 0.02,
                    speedX: Math.random() * 0.025 + 0.01,
                    rotX: (Math.random() - 0.5) * 0.02,
                    rotY: (Math.random() - 0.5) * 0.025,
                    swayOffset: Math.random() * 100
                };
                scene.add(mesh);
                jasminePetals.push(mesh);
            }

            const fireflyCount = 85;
            firefliesGeo = new THREE.BufferGeometry();
            const positions = new Float32Array(fireflyCount * 3);
            for (let i = 0; i < fireflyCount * 3; i += 3) {
                positions[i] = (Math.random() - 0.5) * 70;
                positions[i + 1] = (Math.random() - 0.5) * 60;
                positions[i + 2] = (Math.random() - 0.5) * 30;
            }
            firefliesGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));

            firefliesMat = new THREE.PointsMaterial({
                color: 0xD4AF37,
                size: 0.38,
                transparent: true,
                opacity: 0.85
            });
            const fireflyPoints = new THREE.Points(firefliesGeo, firefliesMat);
            scene.add(fireflyPoints);

            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });

            let clockTick = 0;
            function animate3D() {
                requestAnimationFrame(animate3D);
                clockTick += 0.015;

                jasminePetals.forEach(p => {
                    p.position.y -= p.userData.speedY;
                    p.position.x += p.userData.speedX + Math.sin(clockTick + p.userData.swayOffset) * 0.018;
                    p.rotation.x += p.userData.rotX;
                    p.rotation.y += p.userData.rotY;

                    if (p.position.y < -28) {
                        p.position.y = 28;
                        p.position.x = (Math.random() - 0.5) * 65;
                    }
                    if (p.position.x > 35) {
                        p.position.x = -35;
                    }
                });

                camera.position.x += (mouseX * 3.5 - camera.position.x) * 0.05;
                camera.position.y += (-mouseY * 2.5 - camera.position.y) * 0.05;
                camera.lookAt(scene.position);

                renderer.render(scene, camera);
            }
            animate3D();
        }

        function initParallaxAndGSAP() {
            const heroLayers = document.querySelectorAll('#hero-3d-stage .layer-3d');

            window.addEventListener('mousemove', (e) => {
                mouseX = (e.clientX / window.innerWidth) - 0.5;
                mouseY = (e.clientY / window.innerHeight) - 0.5;

                heroLayers.forEach(layer => {
                    const depth = parseFloat(layer.getAttribute('data-depth') || 0.2);
                    const moveX = mouseX * depth * -95;
                    const moveY = mouseY * depth * -65;
                    const rotY = mouseX * depth * 12;
                    const rotX = -mouseY * depth * 10;
                    layer.style.transform = `translate3d(${moveX}px, ${moveY}px, 0) rotateX(${rotX}deg) rotateY(${rotY}deg)`;
                });
            });

            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);

                gsap.to('#parallax-layer-sky', {
                    yPercent: 25,
                    ease: 'none',
                    scrollTrigger: { trigger: '#hero-3d-stage', start: 'top top', end: 'bottom top', scrub: true }
                });
                gsap.to('#parallax-layer-kayon', {
                    yPercent: -18,
                    scale: 1.18,
                    ease: 'none',
                    scrollTrigger: { trigger: '#hero-3d-stage', start: 'top top', end: 'bottom top', scrub: true }
                });
                gsap.to('#parallax-layer-joglo', {
                    yPercent: -8,
                    scale: 0.94,
                    ease: 'none',
                    scrollTrigger: { trigger: '#hero-3d-stage', start: 'top top', end: 'bottom top', scrub: true }
                });

                gsap.utils.toArray('.gsap-fade-up').forEach(el => {
                    gsap.from(el, {
                        y: 50, opacity: 0, duration: 1, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 88%' }
                    });
                });
                gsap.utils.toArray('.gsap-fade-left').forEach(el => {
                    gsap.from(el, {
                        x: -60, opacity: 0, duration: 1, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 85%' }
                    });
                });
                gsap.utils.toArray('.gsap-fade-right').forEach(el => {
                    gsap.from(el, {
                        x: 60, opacity: 0, duration: 1, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 85%' }
                    });
                });
            }
        }

        // Web Audio Gamelan Pelog Synthesizer
        let audioCtx = null, isPlayingGamelan = false;

        function open3DGate() {
            const gate = document.getElementById('gate-cover');
            const centerCard = document.getElementById('gate-center-card');
            const body = document.getElementById('body-root');

            centerCard.classList.add('scale-75', 'opacity-0', 'pointer-events-none');
            gate.classList.add('gate-open');
            body.classList.remove('overflow-y-hidden');

            setTimeout(() => {
                gate.classList.add('pointer-events-none', 'hidden');
            }, 1750);

            startGamelanSynth();
        }

        function playGamelanTone(freq, duration = 2.6, vol = 0.055) {
            if (!audioCtx) return;
            const now = audioCtx.currentTime;
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(freq, now);
            gain.gain.setValueAtTime(0.001, now);
            gain.gain.exponentialRampToValueAtTime(vol, now + 0.08);
            gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start(now);
            osc.stop(now + duration);
        }

        function startGamelanSynth() {
            try {
                if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                if (audioCtx.state === 'suspended') audioCtx.resume();
                const pelog = [293.66, 311.13, 369.99, 440.00, 466.16, 587.33];
                const melody = [0, 2, 3, 4, 3, 2, 1, 0];
                let idx = 0;
                isPlayingGamelan = true;
                playGamelanTone(146.83, 4.0, 0.08);

                setInterval(() => {
                    if (!isPlayingGamelan) return;
                    playGamelanTone(pelog[melody[idx % melody.length]], 2.5, 0.05);
                    if (idx % 4 === 0) playGamelanTone(146.83, 3.8, 0.075);
                    idx++;
                }, 1350);
            } catch (e) { console.warn(e); }
        }

        function toggleGamelan() {
            if (!audioCtx) { startGamelanSynth(); return; }
            isPlayingGamelan = !isPlayingGamelan;
            const icon = document.getElementById('audio-icon');
            icon.classList.toggle('animate-spin', isPlayingGamelan);
            showToast(isPlayingGamelan ? 'Gending Jawa diputar' : 'Gending Jawa dijeda');
        }

        function initCountdown() {
            const target = new Date('2026-12-20T08:00:00+07:00').getTime();
            setInterval(() => {
                const diff = Math.max(0, target - Date.now());
                document.getElementById('cd-days').textContent = String(Math.floor(diff / 86400000)).padStart(2, '0');
                document.getElementById('cd-hours').textContent = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
                document.getElementById('cd-minutes').textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
                document.getElementById('cd-seconds').textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            }, 1000);
        }

        function copyText(num, label) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(num).then(() => {
                    showToast(`${label} berhasil disalin!`);
                }).catch(() => fallbackCopy(num, `${label} berhasil disalin!`));
            } else {
                fallbackCopy(num, `${label} berhasil disalin!`);
            }
        }

        function copyAlamat() {
            const text = document.getElementById('alamat-kado-fisik').innerText.trim();
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast('Alamat kado fisik berhasil disalin!');
                }).catch(() => fallbackCopy(text, 'Alamat kado fisik berhasil disalin!'));
            } else {
                fallbackCopy(text, 'Alamat kado fisik berhasil disalin!');
            }
        }

        function fallbackCopy(text, msg) {
            const area = document.createElement('textarea');
            area.value = text;
            document.body.appendChild(area);
            area.select();
            document.execCommand('copy');
            document.body.removeChild(area);
            showToast(msg);
        }

        function showToast(msg) {
            const box = document.getElementById('toast-box');
            document.getElementById('toast-text').textContent = msg;
            box.classList.remove('opacity-0', '-translate-y-4');
            box.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                box.classList.remove('opacity-100', 'translate-y-0');
                box.classList.add('opacity-0', '-translate-y-4');
            }, 2800);
        }

        const wishesData = [
            { name: 'K.R.T. Suryodiningrat', status: 'Hadir', time: 'Baru saja', msg: 'Nderek mangayubagyo atas pawiwahan Ananda Aditya & Kirana. Semoga langgeng kaken-kaken ninen-ninen.' },
            { name: 'R.Ay. Pramesti & Keluarga', status: 'Hadir', time: '20 menit lalu', msg: 'Selamat menempuh hidup baru, semoga menjadi keluarga Sakinah Mawaddah Warahmah.' }
        ];

        function renderWishes() {
            document.getElementById('wishes-list').innerHTML = wishesData.map(w => `
                <div class="card-3d-keraton rounded-2xl p-4 sm:p-5">
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="font-serifJawa font-bold text-lg text-emas-200">${w.name}</h4>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase ${w.status === 'Hadir' ? 'bg-emas-400/20 text-emas-300 border border-emas-400/40' : 'bg-sogan-800 text-krem-200/60'}">${w.status}</span>
                    </div>
                    <p class="text-sm text-krem-100/90 leading-relaxed">${w.msg}</p>
                    <span class="block text-[10px] text-krem-200/50 mt-2">${w.time}</span>
                </div>
            `).join('');
        }

        function handleRSVP(e) {
            e.preventDefault();
            const name = document.getElementById('rsvp-name').value.trim();
            const status = document.getElementById('rsvp-status').value;
            const msg = document.getElementById('rsvp-message').value.trim();
            if (!name || !msg) return;
            wishesData.unshift({ name, status, time: 'Baru saja', msg });
            renderWishes();
            e.target.reset();
            showToast('Matur nuwun! Doa restu Anda telah tersimpan.');
        }

        window.onload = function () {
            const params = new URLSearchParams(window.location.search);
            const guest = params.get('to') || params.get('kepada');
            if (guest) document.getElementById('guest-name-target').textContent = guest;

            injectModularAssets();
            initThreeJS3D();
            initParallaxAndGSAP();
            initCountdown();
            renderWishes();
        };
    </script>
</body>
</html>

