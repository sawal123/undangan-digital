<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding Celebration — Vino &amp; Ivelle | Celebrate</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ivory: '#FDFBF7',
                        cream: '#F5EFE6',
                        champagne: '#EAE0D2',
                        sage: {
                            50: '#F4F7F4',
                            100: '#E5ECE5',
                            200: '#C9D8C9',
                            300: '#A3BDA3',
                            400: '#7D9D7D',
                            500: '#5F7E5F',
                            600: '#496349',
                            700: '#3B503B',
                            800: '#2E3E2E',
                        },
                        rose: {
                            dusty: '#C8A29C',
                            soft: '#EBDAD7',
                        },
                        gold: {
                            muted: '#B59B6D',
                            light: '#D9C8A9',
                        },
                        espresso: '#3A322C'
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                        script: ['"Great Vibes"', 'cursive'],
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --bg-ivory: #FDFBF7;
            --bg-cream: #F5EFE6;
            --accent-sage: #5F7E5F;
            --accent-gold: #B59B6D;
            --text-dark: #3A322C;
        }
        body {
            background-color: var(--bg-ivory);
            color: var(--text-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }
        .arch-frame {
            border-radius: 9999px 9999px 24px 24px;
        }
        .arch-full {
            border-radius: 9999px;
        }
        @keyframes floatPetal {
            0% {
                transform: translateY(-10vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            15% {
                opacity: 0.65;
            }
            85% {
                opacity: 0.65;
            }
            100% {
                transform: translateY(105vh) translateX(45px) rotate(360deg);
                opacity: 0;
            }
        }
        .petal {
            position: fixed;
            top: -5%;
            pointer-events: none;
            z-index: 30;
            animation: floatPetal linear infinite;
        }
        @keyframes sway {
            0%, 100% { transform: rotate(-2deg) scale(1); }
            50% { transform: rotate(2.5deg) scale(1.02); }
        }
        .ornament-sway {
            animation: sway 7s ease-in-out infinite;
            transform-origin: bottom center;
        }
        .ornament-sway-reverse {
            animation: sway 8s ease-in-out infinite reverse;
            transform-origin: top center;
        }
        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .spin-slow {
            animation: spinSlow 9s linear infinite;
        }
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.85s cubic-bezier(0.22, 1, 0.36, 1), transform 0.85s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        #opening-cover {
            transition: transform 1.1s cubic-bezier(0.65, 0, 0.35, 1), opacity 0.9s ease;
        }
        #opening-cover.opened {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }
        .paper-texture {
            background-image: radial-gradient(rgba(181, 155, 109, 0.09) 1px, transparent 0);
            background-size: 24px 24px;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F5EFE6;
        }
        ::-webkit-scrollbar-thumb {
            background: #A3BDA3;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="antialiased selection:bg-sage-200 selection:text-espresso overflow-hidden" id="page-body">

    <!-- Floating Botanical Petals Container -->
    <div id="petals-container" class="fixed inset-0 pointer-events-none z-30 overflow-hidden"></div>

    <!-- Toast Notification -->
    <div id="toast-notification" class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] pointer-events-none opacity-0 -translate-y-4 transition-all duration-300">
        <div class="bg-espresso/95 text-ivory px-5 py-3 rounded-full shadow-xl border border-gold-muted/40 flex items-center gap-2.5 text-xs sm:text-sm font-medium backdrop-blur-md">
            <span id="toast-icon" class="text-sage-300">✦</span>
            <span id="toast-message">Tersalin ke clipboard</span>
        </div>
    </div>

    <!-- Lightbox Modal for Gallery & Previews -->
    <div id="lightbox-modal" class="fixed inset-0 z-[90] bg-espresso/90 backdrop-blur-md hidden items-center justify-center p-4">
        <button id="lightbox-close" type="button" aria-label="Tutup preview" class="absolute top-5 right-5 w-11 h-11 rounded-full bg-ivory/15 hover:bg-ivory/25 text-ivory flex items-center justify-center transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button id="lightbox-prev" type="button" aria-label="Foto sebelumnya" class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-ivory/15 hover:bg-ivory/25 text-ivory flex items-center justify-center transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="max-w-3xl w-full flex flex-col items-center">
            <img id="lightbox-img" src="{{ asset('tema/celebrate/assets/images/couple-hero.webp') }}" alt="Gallery Preview" class="max-h-[78vh] w-auto rounded-2xl shadow-2xl border-2 border-ivory/20 object-contain">
            <p id="lightbox-caption" class="text-ivory/90 font-serif text-sm sm:text-base mt-3 text-center tracking-wide"></p>
        </div>
        <button id="lightbox-next" type="button" aria-label="Foto berikutnya" class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-ivory/15 hover:bg-ivory/25 text-ivory flex items-center justify-center transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    <!-- ========================================== -->
    <!-- 1. FULLSCREEN OPENING COVER OVERLAY        -->
    <!-- ========================================== -->
    <div id="opening-cover" class="fixed inset-0 z-[70] bg-ivory flex flex-col justify-between items-center text-center px-4 py-8 overflow-hidden paper-texture">
        <!-- Corner Floral SVG Ornaments -->
        <svg class="w-36 sm:w-52 h-36 sm:h-52 text-sage-400/35 absolute -top-4 -left-4 pointer-events-none ornament-sway-reverse" viewBox="0 0 200 200" fill="none">
            <path d="M10,10 C60,15 110,45 145,95 C110,80 65,90 30,130 C45,85 35,45 10,10 Z" stroke="currentColor" stroke-width="1.5" fill="currentColor" fill-opacity="0.12"/>
            <path d="M5,45 C45,50 85,75 110,120" stroke="#B59B6D" stroke-width="1.2" stroke-dasharray="3 3"/>
            <circle cx="85" cy="55" r="4" fill="#C8A29C" fill-opacity="0.6"/>
            <circle cx="115" cy="85" r="3" fill="#B59B6D" fill-opacity="0.6"/>
            <circle cx="55" cy="95" r="3.5" fill="#C8A29C" fill-opacity="0.5"/>
        </svg>
        <svg class="w-36 sm:w-52 h-36 sm:h-52 text-sage-400/35 absolute -top-4 -right-4 scale-x-[-1] pointer-events-none ornament-sway" viewBox="0 0 200 200" fill="none">
            <path d="M10,10 C60,15 110,45 145,95 C110,80 65,90 30,130 C45,85 35,45 10,10 Z" stroke="currentColor" stroke-width="1.5" fill="currentColor" fill-opacity="0.12"/>
            <path d="M5,45 C45,50 85,75 110,120" stroke="#B59B6D" stroke-width="1.2" stroke-dasharray="3 3"/>
            <circle cx="85" cy="55" r="4" fill="#C8A29C" fill-opacity="0.6"/>
            <circle cx="115" cy="85" r="3" fill="#B59B6D" fill-opacity="0.6"/>
        </svg>
        <svg class="w-36 sm:w-52 h-36 sm:h-52 text-sage-400/35 absolute -bottom-4 -left-4 scale-y-[-1] pointer-events-none ornament-sway" viewBox="0 0 200 200" fill="none">
            <path d="M10,10 C60,15 110,45 145,95 C110,80 65,90 30,130 C45,85 35,45 10,10 Z" stroke="currentColor" stroke-width="1.5" fill="currentColor" fill-opacity="0.12"/>
            <circle cx="85" cy="55" r="4" fill="#C8A29C" fill-opacity="0.6"/>
        </svg>
        <svg class="w-36 sm:w-52 h-36 sm:h-52 text-sage-400/35 absolute -bottom-4 -right-4 scale-[-1] pointer-events-none ornament-sway-reverse" viewBox="0 0 200 200" fill="none">
            <path d="M10,10 C60,15 110,45 145,95 C110,80 65,90 30,130 C45,85 35,45 10,10 Z" stroke="currentColor" stroke-width="1.5" fill="currentColor" fill-opacity="0.12"/>
            <circle cx="85" cy="55" r="4" fill="#C8A29C" fill-opacity="0.6"/>
        </svg>

        <!-- Top Monogram -->
        <div class="relative z-10 pt-2">
            <p class="text-[11px] uppercase tracking-[0.35em] text-sage-600 font-medium">The Wedding Celebration Of</p>
        </div>

        <!-- Center Arch Frame & Couple Names -->
        <div class="relative z-10 flex flex-col items-center my-auto max-w-sm w-full">
            <div class="relative w-48 h-64 sm:w-56 sm:h-72 p-2 rounded-t-full rounded-b-3xl border border-gold-muted/50 bg-cream/60 shadow-xl mb-5">
                <div class="w-full h-full overflow-hidden rounded-t-full rounded-b-2xl relative">
                    <img src="{{ asset('tema/celebrate/assets/images/couple-hero.webp') }}" alt="Vino &amp; Ivelle" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-3.5 left-1/2 -translate-x-1/2 bg-ivory border border-gold-light/90 px-4 py-1 rounded-full shadow-md">
                    <span class="font-serif italic text-xs text-gold-muted">#VowsofViVelle</span>
                </div>
            </div>

            <h1 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso tracking-tight">
                Vino <span class="font-script text-3xl text-gold-muted font-normal">&amp;</span> Ivelle
            </h1>
            <p class="text-xs uppercase tracking-[0.25em] text-sage-700 font-medium mt-1">Sabtu, 20 Juni 2026</p>

            <!-- Personalized Guest Box -->
            <div class="mt-6 px-5 py-3.5 rounded-2xl bg-cream/70 border border-gold-light/60 max-w-xs w-full shadow-sm">
                <p class="text-[10px] uppercase tracking-widest text-espresso/60">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                <p id="cover-guest-name" class="font-serif text-lg font-semibold text-espresso mt-0.5">Tamu Undangan</p>
            </div>

            <!-- Open Invitation Button -->
            <button id="step-inside-btn" type="button" onclick="if(window.celebrateOpenCover){window.celebrateOpenCover();}else{document.getElementById('opening-cover')?.classList.add('opened');document.getElementById('page-body')?.classList.remove('overflow-hidden');}" class="mt-7 group relative inline-flex items-center justify-center gap-3 px-8 py-3.5 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-[0.25em] font-medium shadow-lg hover:shadow-xl transition-all duration-300">
                <span>Buka Undangan</span>
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>

        <div class="relative z-10 pb-2">
            <p class="text-[10px] tracking-wider text-espresso/50 uppercase">Ketuk untuk membuka undangan &amp; memutar musik</p>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- DESKTOP SPLIT WRAPPER & MOBILE CONTAINER   -->
    <!-- ========================================== -->
    <div class="min-h-screen lg:flex lg:justify-center">

        <!-- Left Fixed Branding & Couple Aside on Desktop -->
        <aside class="hidden lg:flex lg:w-7/12 xl:w-8/12 h-screen sticky top-0 flex-col justify-between p-12 bg-cream/40 border-r border-gold-light/50 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ asset('tema/celebrate/assets/images/couple-hero.webp') }}" alt="Vino &amp; Ivelle Prewedding" class="absolute inset-0 w-full h-full object-cover opacity-85 scale-105 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-espresso/85 via-espresso/30 to-transparent"></div>
                <div class="absolute inset-5 border border-ivory/25 rounded-3xl pointer-events-none"></div>
            </div>

            <div class="relative z-10 text-ivory">
                <p class="text-xs uppercase tracking-[0.35em] text-ivory/80">The Wedding Celebration Of</p>
                <h2 class="font-serif text-5xl xl:text-6xl font-semibold mt-2 drop-shadow">Vino &amp; Ivelle</h2>
                <p class="font-serif italic text-gold-light text-lg mt-1 tracking-wider">#VowsofViVelle</p>
            </div>

            <div class="relative z-10 text-ivory max-w-md">
                <p class="text-xs uppercase tracking-[0.2em] text-ivory/70">Waktu &amp; Lokasi</p>
                <p class="font-serif text-2xl font-medium mt-1">Sabtu, 20 Juni 2026</p>
                <p class="text-sm text-ivory/85 mt-1">Taman Kajoe, Cilandak, Jakarta Selatan</p>
                <div class="mt-4 pt-4 border-t border-ivory/20 flex items-center gap-3">
                    <span class="text-xs text-ivory/80">Kepada Yth:</span>
                    <span id="aside-guest-name" class="font-serif text-lg font-medium text-gold-light">Tamu Undangan</span>
                </div>
            </div>
        </aside>

        <!-- Right Scrollable Mobile-First Invitation Container -->
        <main class="w-full lg:w-5/12 xl:w-4/12 max-w-[520px] mx-auto bg-ivory shadow-2xl relative overflow-hidden paper-texture pb-24">

            <!-- ========================================== -->
            <!-- 2. HERO & SAVE THE DATE SECTION            -->
            <!-- ========================================== -->
            <section id="section-home" class="relative min-h-screen flex flex-col items-center justify-between text-center px-6 pt-12 pb-16 overflow-hidden">
                <!-- Botanical Top Ornament -->
                <div class="w-full flex justify-center mb-2 ornament-sway">
                    <svg class="w-40 h-12 text-sage-500/50" viewBox="0 0 240 60" fill="none">
                        <path d="M20,30 Q120,5 220,30" stroke="currentColor" stroke-width="1.2"/>
                        <path d="M70,22 C85,10 105,12 120,25 C135,12 155,10 170,22" stroke="#B59B6D" stroke-width="1.2"/>
                        <circle cx="120" cy="25" r="4" fill="#C8A29C"/>
                        <circle cx="90" cy="20" r="2.5" fill="#5F7E5F"/>
                        <circle cx="150" cy="20" r="2.5" fill="#5F7E5F"/>
                    </svg>
                </div>

                <div class="reveal">
                    <p class="text-xs uppercase tracking-[0.3em] text-sage-600 font-medium">Bound by Love</p>
                    <h2 class="font-serif text-4xl sm:text-5xl font-semibold text-espresso mt-2">Vino &amp; Ivelle</h2>
                    <p class="text-xs font-serif italic text-gold-muted mt-1 tracking-wider">#VowsofViVelle</p>
                </div>

                <!-- Cover Frame Image -->
                <div class="relative my-6 w-64 sm:w-72 h-80 sm:h-96 p-2.5 bg-cream border border-gold-muted/45 arch-frame shadow-xl reveal">
                    <div class="w-full h-full overflow-hidden arch-frame relative">
                        <img src="{{ asset('tema/celebrate/assets/images/couple-hero.webp') }}" alt="Vino &amp; Ivelle" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Date & Countdown -->
                <div class="reveal w-full max-w-sm">
                    <div class="flex items-center justify-center gap-3 text-espresso/70 text-xs uppercase tracking-[0.25em]">
                        <span>Sabtu</span>
                        <span>✦</span>
                        <span>20 Juni 2026</span>
                    </div>

                    <!-- Countdown Cards -->
                    <div class="grid grid-cols-4 gap-2 sm:gap-2.5 mt-5">
                        <div class="bg-cream/90 border border-gold-light/80 p-2.5 rounded-2xl shadow-sm">
                            <span id="cd-days" class="font-serif text-2xl font-semibold text-espresso block">00</span>
                            <span class="text-[10px] uppercase tracking-wider text-sage-700">Hari</span>
                        </div>
                        <div class="bg-cream/90 border border-gold-light/80 p-2.5 rounded-2xl shadow-sm">
                            <span id="cd-hours" class="font-serif text-2xl font-semibold text-espresso block">00</span>
                            <span class="text-[10px] uppercase tracking-wider text-sage-700">Jam</span>
                        </div>
                        <div class="bg-cream/90 border border-gold-light/80 p-2.5 rounded-2xl shadow-sm">
                            <span id="cd-minutes" class="font-serif text-2xl font-semibold text-espresso block">00</span>
                            <span class="text-[10px] uppercase tracking-wider text-sage-700">Menit</span>
                        </div>
                        <div class="bg-cream/90 border border-gold-light/80 p-2.5 rounded-2xl shadow-sm">
                            <span id="cd-seconds" class="font-serif text-2xl font-semibold text-espresso block">00</span>
                            <span class="text-[10px] uppercase tracking-wider text-sage-700">Detik</span>
                        </div>
                    </div>

                    <!-- Add to Google Calendar -->
                    <div class="mt-6 flex flex-col items-center gap-2">
                        <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=The+Wedding+of+Vino+%26+Ivelle&dates=20260620T090000Z/20260620T140000Z&details=The+Wedding+Celebration+of+Vino+and+Ivelle.+Location:+Taman+Kajoe,+Jakarta+Selatan&location=Taman+Kajoe,+Jakarta+Selatan" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-cream hover:bg-champagne border border-gold-light text-espresso text-xs uppercase tracking-widest font-medium transition shadow-sm">
                            <svg class="w-4 h-4 text-sage-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Simpan ke Kalender</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 3. SACRED AYAT / QUOTE SECTION             -->
            <!-- ========================================== -->
            <section class="py-14 px-6 text-center relative bg-cream/40 border-t border-gold-light/40">
                <div class="reveal max-w-sm mx-auto">
                    <span class="font-serif text-4xl text-gold-muted leading-none">“</span>
                    <p class="font-serif italic text-base sm:text-lg text-espresso/90 leading-relaxed -mt-2">
                        Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.
                    </p>
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-700 font-medium mt-4">— QS. Ar-Rum: 21 —</p>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 4. MEET THE BRIDE & GROOM SECTION          -->
            <!-- ========================================== -->
            <section id="section-couple" class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center relative">
                <div class="reveal max-w-sm mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">The Happy Couple</p>
                    <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Kedua Mempelai</h2>
                    <p class="text-xs text-espresso/70 mt-2 leading-relaxed">
                        Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Anda untuk merayakan ikatan suci pernikahan kami.
                    </p>
                </div>

                <!-- Groom -->
                <div class="mt-12 flex flex-col items-center reveal">
                    <div class="w-36 h-48 sm:w-40 sm:h-52 p-1.5 rounded-full border border-gold-muted/60 bg-ivory shadow-md mb-4">
                        <img src="{{ asset('tema/celebrate/assets/images/groom.webp') }}" alt="Vino Laurent" class="w-full h-full object-cover arch-full">
                    </div>
                    <h3 class="font-serif text-2xl font-semibold text-espresso">Vino Laurent, S.T.</h3>
                    <p class="text-xs text-sage-700 font-medium uppercase tracking-wider mt-0.5">Mempelai Pria</p>
                    <p class="text-xs text-espresso/75 mt-2 max-w-xs leading-relaxed">
                        Putra pertama dari Bapak <strong class="text-espresso">Laurentius Hendra</strong><br>&amp; Ibu <strong class="text-espresso">Christina Dewi</strong>
                    </p>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-1.5 text-xs text-sage-700 hover:text-sage-900 transition">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span>@vinolaurent</span>
                    </a>
                </div>

                <!-- Romantic Separator Monogram -->
                <div class="my-8 flex items-center justify-center gap-3 text-gold-muted reveal">
                    <span class="w-12 h-px bg-gold-light"></span>
                    <span class="font-script text-3xl font-normal">&amp;</span>
                    <span class="w-12 h-px bg-gold-light"></span>
                </div>

                <!-- Bride -->
                <div class="flex flex-col items-center reveal">
                    <div class="w-36 h-48 sm:w-40 sm:h-52 p-1.5 rounded-full border border-gold-muted/60 bg-ivory shadow-md mb-4">
                        <img src="{{ asset('tema/celebrate/assets/images/bride.webp') }}" alt="Ivelle Rosalie" class="w-full h-full object-cover arch-full">
                    </div>
                    <h3 class="font-serif text-2xl font-semibold text-espresso">Ivelle Rosalie, S.Ds.</h3>
                    <p class="text-xs text-sage-700 font-medium uppercase tracking-wider mt-0.5">Mempelai Wanita</p>
                    <p class="text-xs text-espresso/75 mt-2 max-w-xs leading-relaxed">
                        Putri kedua dari Bapak <strong class="text-espresso">Rosalino Baskara</strong><br>&amp; Ibu <strong class="text-espresso">Eveline Permata</strong>
                    </p>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-1.5 text-xs text-sage-700 hover:text-sage-900 transition">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span>@ivellerosalie</span>
                    </a>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 5. LOVE STORY (INTERACTIVE CAROUSEL)       -->
            <!-- ========================================== -->
            <section id="section-story" class="py-16 px-6 text-center relative">
                <div class="reveal">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Our Journey</p>
                    <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Kisah Cinta Kami</h2>
                </div>

                <!-- Interactive Story Carousel Card -->
                <div class="mt-8 bg-cream/85 border border-gold-light/70 rounded-3xl p-5 sm:p-6 shadow-md reveal">
                    <div class="relative h-56 sm:h-64 rounded-2xl overflow-hidden mb-5 border border-gold-light/40">
                        <img id="story-slide-img" src="{{ asset('tema/celebrate/assets/images/story.webp') }}" alt="Love Story Chapter" class="w-full h-full object-cover transition-all duration-500">
                        <div class="absolute top-3 left-3 bg-ivory/90 backdrop-blur-md px-3 py-1 rounded-full border border-gold-light/60">
                            <span id="story-chapter-badge" class="font-serif text-xs font-semibold text-sage-700">Bab 01</span>
                        </div>
                    </div>

                    <h3 id="story-chapter-title" class="font-serif text-2xl font-semibold text-espresso">Pertemuan Pertama</h3>
                    <p id="story-chapter-text" class="text-xs text-espresso/80 mt-2.5 leading-relaxed min-h-[4rem]">
                        Di tengah rutinitas perkuliahan dan percakapan sederhana, takdir mempertemukan kami. Pertemuan yang sederhana perlahan menumbuhkan rasa nyaman dan keyakinan di antara kami berdua.
                    </p>

                    <!-- Carousel Controls -->
                    <div class="mt-6 flex items-center justify-between pt-4 border-t border-gold-light/40">
                        <button id="story-prev-btn" type="button" class="w-9 h-9 rounded-full bg-ivory border border-gold-light flex items-center justify-center text-espresso hover:bg-sage-100 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <div class="flex items-center gap-1.5" id="story-indicators">
                            <span class="w-6 h-1.5 rounded-full bg-sage-600 transition-all"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-gold-light transition-all"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-gold-light transition-all"></span>
                        </div>
                        <button id="story-next-btn" type="button" class="w-9 h-9 rounded-full bg-ivory border border-gold-light flex items-center justify-center text-espresso hover:bg-sage-100 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 6. GALLERY & MOMENTS SECTION               -->
            <!-- ========================================== -->
            <section id="section-gallery" class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center">
                <div class="reveal">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Moments in Love</p>
                    <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Galeri Momen</h2>
                    <p class="text-xs text-espresso/70 mt-1.5">Setiap jepretan menyimpan cerita dan kenangan berharga kami.</p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-8 reveal">
                    <div class="space-y-3 sm:space-y-4">
                        <div class="gallery-item relative rounded-2xl overflow-hidden aspect-[4/5] shadow-md border border-gold-light/50 group cursor-pointer" data-caption="Botanical Walk">
                            <img src="{{ asset('tema/celebrate/assets/images/couple-hero.webp') }}" alt="Botanical Walk" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="gallery-item relative rounded-2xl overflow-hidden aspect-square shadow-md border border-gold-light/50 group cursor-pointer" data-caption="Glasshouse Conservatory">
                            <img src="{{ asset('tema/celebrate/assets/images/story.webp') }}" alt="Glasshouse Conservatory" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="gallery-item relative rounded-2xl overflow-hidden aspect-[4/5] shadow-md border border-gold-light/50 group cursor-pointer" data-caption="The Proposal Morning">
                            <img src="{{ asset('tema/celebrate/assets/images/proposal.webp') }}" alt="The Proposal Morning" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        <div class="gallery-item relative rounded-2xl overflow-hidden aspect-square shadow-md border border-gold-light/50 group cursor-pointer" data-caption="Groom Portrait">
                            <img src="{{ asset('tema/celebrate/assets/images/groom.webp') }}" alt="Groom Portrait" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="gallery-item relative rounded-2xl overflow-hidden aspect-[4/5] shadow-md border border-gold-light/50 group cursor-pointer" data-caption="Bride Portrait">
                            <img src="{{ asset('tema/celebrate/assets/images/bride.webp') }}" alt="Bride Portrait" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="gallery-item relative rounded-2xl overflow-hidden aspect-square shadow-md border border-gold-light/50 group cursor-pointer" data-caption="Captured in Motion Film">
                            <img src="{{ asset('tema/celebrate/assets/images/story.webp') }}" alt="Captured in Motion Film" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition duration-700">
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 7. WEDDING EVENTS & SCHEDULE               -->
            <!-- ========================================== -->
            <section id="section-events" class="py-16 px-6 text-center">
                <div class="reveal">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">The Celebration</p>
                    <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Rangkaian Acara</h2>
                    <p class="text-xs text-espresso/70 mt-1.5">Kehadiran dan doa restu Anda adalah kehormatan bagi kami.</p>
                </div>

                <div class="mt-8 space-y-6 reveal">
                    <!-- Event 1: Akad Nikah -->
                    <div class="bg-cream/80 border border-gold-light rounded-3xl p-6 shadow-md relative overflow-hidden text-center">
                        <span class="inline-block px-3.5 py-1 rounded-full bg-ivory border border-gold-light text-sage-700 font-serif italic text-xs mb-2">Sacred Matrimony</span>
                        <h3 class="font-serif text-3xl font-semibold text-espresso">Akad Nikah</h3>
                        
                        <div class="my-4 h-px w-16 bg-gold-light mx-auto"></div>

                        <div class="space-y-1 text-xs text-espresso/80">
                            <p class="font-semibold text-sm text-espresso">Sabtu, 20 Juni 2026</p>
                            <p>Pukul 08:00 – 10:00 WIB</p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gold-light/50 text-xs text-espresso/75">
                            <p class="font-semibold text-espresso">Taman Kajoe Glasshouse</p>
                            <p class="mt-0.5">Jl. Melati Putih No. 42, Cilandak, Jakarta Selatan</p>
                        </div>

                        <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-widest font-medium transition shadow">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Petunjuk Lokasi</span>
                        </a>
                    </div>

                    <!-- Event 2: Resepsi Pernikahan -->
                    <div class="bg-cream/80 border border-gold-light rounded-3xl p-6 shadow-md relative overflow-hidden text-center">
                        <span class="inline-block px-3.5 py-1 rounded-full bg-ivory border border-gold-light text-sage-700 font-serif italic text-xs mb-2">Evening Gathering</span>
                        <h3 class="font-serif text-3xl font-semibold text-espresso">Resepsi Pernikahan</h3>
                        
                        <div class="my-4 h-px w-16 bg-gold-light mx-auto"></div>

                        <div class="space-y-1 text-xs text-espresso/80">
                            <p class="font-semibold text-sm text-espresso">Sabtu, 20 Juni 2026</p>
                            <p>Pukul 11:30 – 14:00 WIB</p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gold-light/50 text-xs text-espresso/75">
                            <p class="font-semibold text-espresso">Taman Kajoe Outdoor Garden</p>
                            <p class="mt-0.5">Jl. Melati Putih No. 42, Cilandak, Jakarta Selatan</p>
                        </div>

                        <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-widest font-medium transition shadow">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Petunjuk Lokasi</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 8. RUNDOWN & DRESSCODE                     -->
            <!-- ========================================== -->
            <section class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center">
                <!-- Dresscode -->
                <div class="reveal max-w-sm mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Panduan Busana</p>
                    <h3 class="font-serif text-3xl font-semibold text-espresso mt-1">Dresscode</h3>
                    <p class="text-xs text-espresso/70 mt-1.5 leading-relaxed">
                        Kami mengundang Anda mengenakan busana bernuansa lembut dan elegan agar selaras dengan suasana pernikahan.
                    </p>

                    <!-- Color Swatches -->
                    <div class="mt-5 flex items-center justify-center gap-2.5">
                        <span title="Cream" class="w-8 h-8 rounded-full bg-[#F5EFE6] border border-espresso/20 shadow-sm"></span>
                        <span title="Beige" class="w-8 h-8 rounded-full bg-[#DFD3C3] border border-espresso/20 shadow-sm"></span>
                        <span title="Sage" class="w-8 h-8 rounded-full bg-[#A3BDA3] border border-espresso/20 shadow-sm"></span>
                        <span title="Dusty Rose" class="w-8 h-8 rounded-full bg-[#C8A29C] border border-espresso/20 shadow-sm"></span>
                        <span title="Soft Grey" class="w-8 h-8 rounded-full bg-[#D1D1CE] border border-espresso/20 shadow-sm"></span>
                        <span title="Muted Gold" class="w-8 h-8 rounded-full bg-[#B59B6D] border border-espresso/20 shadow-sm"></span>
                    </div>
                    <p class="text-xs italic font-serif text-espresso/80 mt-3">
                        Cream, beige, sage green, dusty rose, soft grey, dan earth tones.
                    </p>
                </div>

                <!-- Event Rundown -->
                <div class="mt-14 pt-10 border-t border-gold-light/50 reveal">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Jadwal Acara</p>
                    <h3 class="font-serif text-3xl font-semibold text-espresso mt-1">Rundown</h3>

                    <div class="mt-6 relative max-w-xs mx-auto text-left">
                        <div class="absolute left-[74px] top-2 bottom-2 w-px bg-gold-light"></div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <span class="w-16 text-right text-xs font-semibold text-sage-700 shrink-0">08:00 WIB</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-sage-600 ring-4 ring-ivory shrink-0 z-10"></span>
                                <span class="font-serif text-base font-medium text-espresso">Prosesi Akad Nikah</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="w-16 text-right text-xs font-semibold text-sage-700 shrink-0">10:00 WIB</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-gold-muted ring-4 ring-ivory shrink-0 z-10"></span>
                                <span class="font-serif text-base font-medium text-espresso">Sesi Foto Keluarga</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="w-16 text-right text-xs font-semibold text-sage-700 shrink-0">11:30 WIB</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-sage-600 ring-4 ring-ivory shrink-0 z-10"></span>
                                <span class="font-serif text-base font-medium text-espresso">Pembukaan Resepsi</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="w-16 text-right text-xs font-semibold text-sage-700 shrink-0">12:00 WIB</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-gold-muted ring-4 ring-ivory shrink-0 z-10"></span>
                                <span class="font-serif text-base font-medium text-espresso">Ramah Tamah &amp; Santap Siang</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="w-16 text-right text-xs font-semibold text-sage-700 shrink-0">13:30 WIB</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-dusty ring-4 ring-ivory shrink-0 z-10"></span>
                                <span class="font-serif text-base font-medium text-espresso">Sesi Foto Tamu &amp; Penutup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 9. RSVP FORM                               -->
            <!-- ========================================== -->
            <section id="section-rsvp" class="py-16 px-6 text-center">
                <div class="reveal max-w-sm mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Konfirmasi Kehadiran</p>
                    <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">RSVP</h2>
                    <p class="text-xs text-espresso/70 mt-1.5 leading-relaxed">
                        Mohon konfirmasikan kehadiran Anda untuk membantu kami menyiapkan jamuan terbaik.
                    </p>
                </div>

                <form id="rsvp-form" class="mt-8 bg-cream/80 border border-gold-light rounded-3xl p-6 text-left space-y-4 shadow-sm reveal">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Nama Lengkap</label>
                        <input type="text" id="rsvp-input-name" required placeholder="Masukkan nama Anda" class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Status Kehadiran</label>
                        <select id="rsvp-input-status" class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600">
                            <option value="hadir">Ya, Saya Akan Hadir</option>
                            <option value="tidak_hadir">Maaf, Tidak Bisa Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Jumlah Tamu</label>
                        <select id="rsvp-input-pax" class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Pesan / Catatan (Opsional)</label>
                        <textarea id="rsvp-input-notes" rows="2" placeholder="Catatan singkat..." class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600"></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-widest font-medium transition shadow-md">
                        Kirim Konfirmasi
                    </button>
                </form>
            </section>

            <!-- ========================================== -->
            <!-- 10. DIGITAL GIFT / TANDA KASIH             -->
            <!-- ========================================== -->
            <section id="section-gift" class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center">
                <div class="reveal max-w-sm mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Tanda Kasih</p>
                    <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Titip Hadiah</h2>
                    <p class="text-xs text-espresso/70 mt-1.5 leading-relaxed">
                        Doa restu Anda adalah hadiah terindah. Namun jika ingin memberikan tanda kasih secara digital, Anda dapat melalui rekening di bawah ini:
                    </p>
                </div>

                <div class="mt-8 space-y-4 reveal">
                    <!-- Bank Account 1 -->
                    <div class="bg-ivory border border-gold-light rounded-2xl p-5 shadow-sm text-left">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-serif text-lg font-semibold text-espresso">Bank Central Asia (BCA)</span>
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-cream text-sage-700 font-medium border border-gold-light">BCA</span>
                        </div>
                        <p class="text-xs text-espresso/70">Nomor Rekening:</p>
                        <div class="flex items-center justify-between mt-1">
                            <strong class="font-mono text-base text-espresso tracking-wider" id="acc-num-1">8415289912</strong>
                            <button type="button" onclick="copyToClipboard('8415289912', 'Nomor rekening BCA tersalin!')" class="px-3.5 py-1.5 rounded-full bg-cream hover:bg-sage-600 text-espresso hover:text-ivory border border-gold-light text-xs font-medium transition">
                                Salin
                            </button>
                        </div>
                        <p class="text-xs text-espresso/70 mt-1">a.n. <strong>Vino Laurent</strong></p>
                    </div>

                    <!-- Bank Account 2 -->
                    <div class="bg-ivory border border-gold-light rounded-2xl p-5 shadow-sm text-left">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-serif text-lg font-semibold text-espresso">Bank Mandiri</span>
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-cream text-sage-700 font-medium border border-gold-light">Mandiri</span>
                        </div>
                        <p class="text-xs text-espresso/70">Nomor Rekening:</p>
                        <div class="flex items-center justify-between mt-1">
                            <strong class="font-mono text-base text-espresso tracking-wider" id="acc-num-2">1370018920192</strong>
                            <button type="button" onclick="copyToClipboard('1370018920192', 'Nomor rekening Mandiri tersalin!')" class="px-3.5 py-1.5 rounded-full bg-cream hover:bg-sage-600 text-espresso hover:text-ivory border border-gold-light text-xs font-medium transition">
                                Salin
                            </button>
                        </div>
                        <p class="text-xs text-espresso/70 mt-1">a.n. <strong>Ivelle Rosalie</strong></p>
                    </div>

                    <!-- Physical Gift Address -->
                    <div class="bg-ivory border border-gold-light rounded-2xl p-5 shadow-sm text-left">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-serif text-lg font-semibold text-espresso">Kirim Kado Fisik</span>
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-cream text-sage-700 font-medium border border-gold-light">Alamat</span>
                        </div>
                        <p class="text-xs text-espresso/80 leading-relaxed">
                            Penerima: <strong>Vino &amp; Ivelle</strong><br>
                            Jl. Cilandak Indah Blok B No. 12, Pasar Minggu, Jakarta Selatan 12560 (Telp: 0812-3456-7890)
                        </p>
                        <div class="mt-3 text-right">
                            <button type="button" onclick="copyToClipboard('Jl. Cilandak Indah Blok B No. 12, Pasar Minggu, Jakarta Selatan 12560', 'Alamat kado fisik tersalin!')" class="px-3.5 py-1.5 rounded-full bg-cream hover:bg-sage-600 text-espresso hover:text-ivory border border-gold-light text-xs font-medium transition">
                                Salin Alamat
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 11. WISHES & PRAYERS (GUESTBOOK)           -->
            <!-- ========================================== -->
            <section id="section-wishes" class="py-16 px-6 text-center">
                <div class="reveal max-w-sm mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Buku Tamu</p>
                    <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Doa &amp; Ucapan</h2>
                    <p class="text-xs text-espresso/70 mt-1.5 leading-relaxed">
                        Tinggalkan doa dan pesan terbaik untuk kedua mempelai.
                    </p>
                </div>

                <!-- Wish Submission Form -->
                <form id="wish-form" class="mt-8 bg-cream/80 border border-gold-light rounded-3xl p-5 text-left space-y-3.5 shadow-sm reveal">
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Nama Anda</label>
                        <input type="text" id="wish-name-input" required placeholder="Masukkan nama Anda" class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Doa / Ucapan</label>
                        <textarea id="wish-message-input" rows="3" required placeholder="Tuliskan doa &amp; ucapan untuk Vino &amp; Ivelle..." class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-widest font-medium transition shadow">
                        Kirim Ucapan
                    </button>
                </form>

                <!-- Wishes Feed List -->
                <div id="wishes-list-container" class="mt-6 space-y-3 text-left reveal">
                    <!-- Populated dynamically via JS -->
                </div>
                <div class="mt-4">
                    <button id="show-more-wishes-btn" type="button" class="px-5 py-2 rounded-full bg-cream hover:bg-champagne border border-gold-light text-xs uppercase tracking-widest text-espresso font-medium transition shadow-sm">
                        Tampilkan Lebih Banyak
                    </button>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 12. CLOSING & FOOTER                       -->
            <!-- ========================================== -->
            <footer class="py-16 px-6 bg-cream border-t border-gold-light/60 text-center relative overflow-hidden">
                <div class="reveal max-w-xs mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Terima Kasih</p>
                    <h2 class="font-serif text-3xl font-semibold text-espresso mt-1">Salam Hangat Kami</h2>
                    <p class="font-serif italic text-sm sm:text-base text-espresso/80 mt-3 leading-relaxed">
                        “Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu bagi lembaran baru kehidupan kami.”
                    </p>

                    <div class="my-6 h-px w-20 bg-gold-light mx-auto"></div>

                    <p class="text-[11px] uppercase tracking-[0.3em] text-sage-600">Kami yang berbahagia</p>
                    <h3 class="font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-2 flex items-center justify-center gap-2.5">
                        <span>Vino</span>
                        <span class="font-script text-3xl text-gold-muted font-normal">&amp;</span>
                        <span>Ivelle</span>
                    </h3>
                    <p class="text-xs font-serif italic text-gold-muted mt-1">Beserta Keluarga Besar Kedua Mempelai</p>

                    <div class="mt-10 pt-6 border-t border-gold-light/40 text-[11px] text-espresso/50">
                        <p>Dibuat dengan segenap cinta oleh <a href="{{ url('/') }}" class="font-semibold text-espresso/75 hover:text-sage-700 transition">WayaeNikah</a></p>
                    </div>
                </div>
            </footer>

        </main>
    </div>

    <!-- ========================================== -->
    <!-- FLOATING AUDIO CONTROLLER & BOTTOM NAV     -->
    <!-- ========================================== -->
    <!-- Floating Music Disc Button -->
    <button id="music-toggle-btn" type="button" aria-label="Nyalakan/Matikan Musik" class="fixed bottom-20 right-4 sm:right-6 z-50 w-11 h-11 rounded-full bg-espresso/90 text-gold-light border border-gold-light/50 shadow-xl flex items-center justify-center transition hover:scale-105">
        <svg id="music-disc-icon" class="w-5 h-5 spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
        </svg>
    </button>

    <!-- Bottom Sticky Quick Navigation Dock -->
    <nav class="fixed bottom-3 left-1/2 -translate-x-1/2 z-50 bg-ivory/95 backdrop-blur-md border border-gold-light/80 rounded-full px-3 py-1.5 shadow-xl flex items-center gap-1 sm:gap-2">
        <a href="#section-home" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Home</a>
        <a href="#section-couple" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Mempelai</a>
        <a href="#section-story" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Cerita</a>
        <a href="#section-events" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Acara</a>
        <a href="#section-gift" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Hadiah</a>
        <a href="#section-wishes" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Doa</a>
    </nav>

    <!-- ========================================== -->
    <!-- INTERACTIVE APPLICATION LOGIC              -->
    <!-- ========================================== -->
    <script>
        // 1. Toast Notification Helper
        let toastTimeout = null;
        function showToast(message, icon = '✦') {
            const toast = document.getElementById('toast-notification');
            const msgEl = document.getElementById('toast-message');
            const iconEl = document.getElementById('toast-icon');
            if (!toast || !msgEl || !iconEl) return;
            msgEl.textContent = message;
            iconEl.textContent = icon;
            toast.classList.remove('opacity-0', '-translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
            if (toastTimeout) clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', '-translate-y-4');
            }, 3000);
        }

        function copyToClipboard(text, successMsg = 'Berhasil disalin!') {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast(successMsg, '✓');
                }).catch(() => {
                    fallbackCopy(text, successMsg);
                });
            } else {
                fallbackCopy(text, successMsg);
            }
        }

        function fallbackCopy(text, successMsg) {
            const temp = document.createElement('textarea');
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            try {
                document.execCommand('copy');
                showToast(successMsg, '✓');
            } catch (err) {
                showToast('Gagal menyalin', '✕');
            }
            document.body.removeChild(temp);
        }

        // 2. Web Audio API Romantic Music Synthesizer
        let audioCtx = null;
        let isMusicPlaying = false;
        let melodyInterval = null;
        const romanticNotes = [523.25, 659.25, 783.99, 659.25, 880.00, 783.99, 659.25, 587.33, 523.25, 587.33, 659.25, 523.25];
        let noteIdx = 0;

        function playRomanticNote(freq) {
            if (!audioCtx || !isMusicPlaying) return;
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(freq, audioCtx.currentTime);

            gain.gain.setValueAtTime(0.001, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.045, audioCtx.currentTime + 0.08);
            gain.gain.exponentialRampToValueAtTime(0.0008, audioCtx.currentTime + 1.4);

            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 1.45);
        }

        function startAmbientMusic() {
            try {
                if (!audioCtx) {
                    const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                    audioCtx = new AudioContextClass();
                }
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                isMusicPlaying = true;
                const icon = document.getElementById('music-disc-icon');
                if (icon) icon.classList.add('spin-slow');
                if (melodyInterval) clearInterval(melodyInterval);
                playRomanticNote(romanticNotes[noteIdx % romanticNotes.length]);
                melodyInterval = setInterval(() => {
                    if (!isMusicPlaying) return;
                    noteIdx = (noteIdx + 1) % romanticNotes.length;
                    playRomanticNote(romanticNotes[noteIdx]);
                }, 1100);
            } catch (e) {
                isMusicPlaying = false;
            }
        }

        function toggleAmbientMusic() {
            if (isMusicPlaying) {
                isMusicPlaying = false;
                if (melodyInterval) clearInterval(melodyInterval);
                const icon = document.getElementById('music-disc-icon');
                if (icon) icon.classList.remove('spin-slow');
                showToast('Musik dijeda', '♪');
            } else {
                startAmbientMusic();
                showToast('Memutar musik pernikahan', '♫');
            }
        }

        const musicToggleBtn = document.getElementById('music-toggle-btn');
        if (musicToggleBtn) {
            musicToggleBtn.addEventListener('click', toggleAmbientMusic);
        }

        // 3. Opening Cover
        window.celebrateOpenCover = function() {
            const openingCover = document.getElementById('opening-cover');
            const pageBody = document.getElementById('page-body');
            if (openingCover) openingCover.classList.add('opened');
            if (pageBody) pageBody.classList.remove('overflow-hidden');
            startAmbientMusic();
            showToast('Selamat datang di pernikahan Vino & Ivelle', '🕊️');
        };

        const stepInsideBtn = document.getElementById('step-inside-btn');
        if (stepInsideBtn) {
            stepInsideBtn.addEventListener('click', window.celebrateOpenCover);
        }

        // 4. Floating Botanical Petals Generator
        function createFloatingPetals() {
            const container = document.getElementById('petals-container');
            if (!container) return;
            const colors = ['#EBDAD7', '#C9D8C9', '#EAE0D2', '#C8A29C'];
            for (let i = 0; i < 12; i++) {
                const petal = document.createElement('div');
                petal.className = 'petal';
                const size = 8 + Math.random() * 8;
                petal.style.width = `${size}px`;
                petal.style.height = `${size * 1.35}px`;
                petal.style.left = `${Math.random() * 100}%`;
                petal.style.backgroundColor = colors[i % colors.length];
                petal.style.borderRadius = '60% 40% 60% 40%';
                petal.style.animationDuration = `${11 + Math.random() * 9}s`;
                petal.style.animationDelay = `${Math.random() * 8}s`;
                container.appendChild(petal);
            }
        }

        // 5. Countdown Timer
        const targetDate = new Date(Date.now() + (54 * 86400000) + (8 * 3600000) + (42 * 60000)).getTime();

        function updateCountdownDisplay() {
            const now = Date.now();
            const diff = Math.max(0, targetDate - now);

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const mins = Math.floor((diff / 1000 / 60) % 60);
            const secs = Math.floor((diff / 1000) % 60);

            const dEl = document.getElementById('cd-days');
            const hEl = document.getElementById('cd-hours');
            const mEl = document.getElementById('cd-minutes');
            const sEl = document.getElementById('cd-seconds');

            if (dEl) dEl.textContent = String(days).padStart(2, '0');
            if (hEl) hEl.textContent = String(hours).padStart(2, '0');
            if (mEl) mEl.textContent = String(mins).padStart(2, '0');
            if (sEl) sEl.textContent = String(secs).padStart(2, '0');
        }

        // 6. Love Story Carousel
        const storyChapters = [
            {
                badge: 'Bab 01',
                title: 'Pertemuan Pertama',
                text: 'Di tengah rutinitas perkuliahan dan percakapan sederhana, takdir mempertemukan kami. Pertemuan yang sederhana perlahan menumbuhkan rasa nyaman dan keyakinan di antara kami berdua.',
                img: '{{ asset("tema/celebrate/assets/images/story.webp") }}'
            },
            {
                badge: 'Bab 02',
                title: 'Perjalanan Bersama',
                text: 'Melewati berbagai cerita, suka dan duka bersama. Belajar untuk saling memahami, menerima, dan bertumbuh bersama hingga menyadari bahwa kami saling melengkapi.',
                img: '{{ asset("tema/celebrate/assets/images/couple-hero.webp") }}'
            },
            {
                badge: 'Bab 03',
                title: 'Komitmen Menuju Selamanya',
                text: 'Di hari yang tenang dan penuh makna, kami memutuskan untuk melangkah ke jenjang yang lebih sakral. Berjanji untuk saling setia dan membangun keluarga yang penuh keberkahan.',
                img: '{{ asset("tema/celebrate/assets/images/proposal.webp") }}'
            }
        ];
        let currentStoryIdx = 0;

        function renderStorySlide() {
            const chapter = storyChapters[currentStoryIdx];
            const bEl = document.getElementById('story-chapter-badge');
            const tEl = document.getElementById('story-chapter-title');
            const txtEl = document.getElementById('story-chapter-text');
            const imgEl = document.getElementById('story-slide-img');
            const indContainer = document.getElementById('story-indicators');

            if (bEl) bEl.textContent = chapter.badge;
            if (tEl) tEl.textContent = chapter.title;
            if (txtEl) txtEl.textContent = chapter.text;
            if (imgEl) imgEl.src = chapter.img;

            if (indContainer) {
                indContainer.innerHTML = '';
                storyChapters.forEach((_, i) => {
                    const dot = document.createElement('span');
                    dot.className = i === currentStoryIdx
                        ? 'w-6 h-1.5 rounded-full bg-sage-600 transition-all'
                        : 'w-1.5 h-1.5 rounded-full bg-gold-light transition-all';
                    indContainer.appendChild(dot);
                });
            }
        }

        const prevBtn = document.getElementById('story-prev-btn');
        const nextBtn = document.getElementById('story-next-btn');
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                currentStoryIdx = (currentStoryIdx - 1 + storyChapters.length) % storyChapters.length;
                renderStorySlide();
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                currentStoryIdx = (currentStoryIdx + 1) % storyChapters.length;
                renderStorySlide();
            });
        }

        // 7. Lightbox Gallery Modal
        const galleryItems = document.querySelectorAll('.gallery-item');
        const lightboxModal = document.getElementById('lightbox-modal');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxPrev = document.getElementById('lightbox-prev');
        const lightboxNext = document.getElementById('lightbox-next');
        let currentGalleryIdx = 0;

        function openLightbox(idx) {
            currentGalleryIdx = idx;
            const item = galleryItems[currentGalleryIdx];
            if (!item) return;
            const img = item.querySelector('img');
            const cap = item.getAttribute('data-caption') || img?.alt || 'Momen Bahagia';
            if (lightboxImg && img) lightboxImg.src = img.src;
            if (lightboxCaption) lightboxCaption.textContent = cap;
            if (lightboxModal) {
                lightboxModal.classList.remove('hidden');
                lightboxModal.classList.add('flex');
            }
        }

        function closeLightbox() {
            if (lightboxModal) {
                lightboxModal.classList.add('hidden');
                lightboxModal.classList.remove('flex');
            }
        }

        galleryItems.forEach((item, idx) => {
            item.addEventListener('click', () => openLightbox(idx));
        });

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxModal) {
            lightboxModal.addEventListener('click', (e) => {
                if (e.target === lightboxModal) closeLightbox();
            });
        }
        if (lightboxPrev) {
            lightboxPrev.addEventListener('click', () => {
                const nextIdx = (currentGalleryIdx - 1 + galleryItems.length) % galleryItems.length;
                openLightbox(nextIdx);
            });
        }
        if (lightboxNext) {
            lightboxNext.addEventListener('click', () => {
                const nextIdx = (currentGalleryIdx + 1) % galleryItems.length;
                openLightbox(nextIdx);
            });
        }

        // 8. RSVP Form Simulation
        const rsvpForm = document.getElementById('rsvp-form');
        if (rsvpForm) {
            rsvpForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const name = document.getElementById('rsvp-input-name')?.value || 'Tamu';
                const status = document.getElementById('rsvp-input-status')?.value;
                const statusText = status === 'hadir' ? 'Hadir' : (status === 'ragu' ? 'Masih Ragu' : 'Tidak Bisa Hadir');
                showToast(`Terima kasih ${name}, konfirmasi (${statusText}) berhasil dicatat!`, '✓');
            });
        }

        // 9. Wishes / Guestbook Feed Simulation
        const sampleWishes = [
            {
                name: 'Clarissa & Daniel',
                date: 'Hari ini, 09:20 WIB',
                message: 'Selamat menempuh hidup baru Vino & Ivelle! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Bahagia selalu selamanya! 🕊️✨'
            },
            {
                name: 'Bima Satria',
                date: 'Kemarin, 19:45 WIB',
                message: 'Happy wedding bro Vino & Ivelle! Doa terbaik untuk petualangan baru kalian berdua. Lancar sampai hari H ya!'
            },
            {
                name: 'Keluarga Besar Wicaksono',
                date: '2 hari yang lalu',
                message: 'Selamat berbahagia untuk kedua mempelai dan keluarga besar. Semoga ikatan suci ini senantiasa diberkahi kasih dan ketenteraman.'
            },
            {
                name: 'Andira Permata',
                date: '3 hari yang lalu',
                message: 'So happy for both of you! Pasangan yang sangat serasi. Can’t wait to celebrate with you guys!'
            }
        ];
        let visibleWishesCount = 3;

        function renderWishesFeed() {
            const container = document.getElementById('wishes-list-container');
            if (!container) return;
            container.innerHTML = '';
            sampleWishes.slice(0, visibleWishesCount).forEach((w) => {
                const item = document.createElement('div');
                item.className = 'bg-cream/70 border border-gold-light/70 rounded-2xl p-4 shadow-sm';
                item.innerHTML = `
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="font-serif text-lg font-semibold text-espresso">${w.name}</span>
                        <span class="text-[10px] text-espresso/55">${w.date}</span>
                    </div>
                    <p class="text-xs text-espresso/80 leading-relaxed">${w.message}</p>
                `;
                container.appendChild(item);
            });
            const moreBtn = document.getElementById('show-more-wishes-btn');
            if (moreBtn) {
                if (visibleWishesCount >= sampleWishes.length) {
                    moreBtn.classList.add('hidden');
                } else {
                    moreBtn.classList.remove('hidden');
                }
            }
        }

        const wishForm = document.getElementById('wish-form');
        if (wishForm) {
            wishForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const nameInput = document.getElementById('wish-name-input');
                const msgInput = document.getElementById('wish-message-input');
                const name = nameInput?.value.trim() || 'Tamu Undangan';
                const message = msgInput?.value.trim();
                if (!message) return;

                sampleWishes.unshift({
                    name: name,
                    date: 'Baru saja',
                    message: message
                });
                if (msgInput) msgInput.value = '';
                visibleWishesCount = Math.max(visibleWishesCount, 4);
                renderWishesFeed();
                showToast('Doa & ucapan Anda berhasil terkirim!', '🕊️');
            });
        }

        const showMoreBtn = document.getElementById('show-more-wishes-btn');
        if (showMoreBtn) {
            showMoreBtn.addEventListener('click', () => {
                visibleWishesCount = sampleWishes.length;
                renderWishesFeed();
            });
        }

        // 10. Scroll Reveal Observer
        function initScrollReveal() {
            if (!('IntersectionObserver' in window)) {
                document.querySelectorAll('.reveal').forEach((el) => el.classList.add('visible'));
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
        }

        // Initialize on Window Load
        window.addEventListener('DOMContentLoaded', () => {
            createFloatingPetals();
            updateCountdownDisplay();
            setInterval(updateCountdownDisplay, 1000);
            renderStorySlide();
            renderWishesFeed();
            initScrollReveal();
        });
    </script>
</body>
</html>
