<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');

        $pria = $data->pria;
        $wanita = $data->wanita;
        $firstEvent = $data->acara->first();
        $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
        $eventTime = $firstEvent?->jam_start ?: '00:00';
        $eventDateText = $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Tanggal Acara';
        $countdownDate = $eventDate
            ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Y-m-d\TH:i:s')
            : now()->addDays(30)->format('Y-m-d\TH:i:s');

        $storageUrl = fn($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;

        $coverImage =
            $storageUrl($data->coverUndangan?->cover_satu) ??
            ((count($poto ?? []) ? $storageUrl($poto[0]) : null) ?? asset('tema/celebrate/assets/images/couple-hero.webp'));
        $heroImage =
            $storageUrl($data->coverUndangan?->cover_dua) ??
            ((count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null) ?? $coverImage);
        $priaImage = $storageUrl($pria?->image) ?? asset('tema/celebrate/assets/images/groom.webp');
        $wanitaImage = $storageUrl($wanita?->image) ?? asset('tema/celebrate/assets/images/bride.webp');

        $coupleNames = $coupleNames ?? $data->couple_name;
        $coupleFullNames = $coupleFullNames ?? $data->couple_full_name;
        $isWanitaFirst = (bool) ($isWanitaFirst ?? $data->is_wanita_first);

        $firstPerson = $isWanitaFirst ? $wanita : $pria;
        $secondPerson = $isWanitaFirst ? $pria : $wanita;
        $firstPersonRole = $isWanitaFirst ? 'Mempelai Wanita' : 'Mempelai Pria';
        $secondPersonRole = $isWanitaFirst ? 'Mempelai Pria' : 'Mempelai Wanita';
        $firstPersonImg = $isWanitaFirst ? $wanitaImage : $priaImage;
        $secondPersonImg = $isWanitaFirst ? $priaImage : $wanitaImage;

        $pageTitle = ($data->setting?->acara ?? 'The Wedding of') . ' ' . $coupleNames;
        $guestName = $tamu ?? 'Tamu Undangan';
        $activeRundowns = $rundowns ?? collect();
        $bgMusicUrl = $data->sound?->audio ? asset('storage/' . $data->sound->audio) : null;

        // Prepare calendar URL
        $calStartDate = $eventDate ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Ymd\THis') : now()->format('Ymd\THis');
        $calEndDate = $eventDate ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->addHours(4)->format('Ymd\THis') : now()->addHours(4)->format('Ymd\THis');
        $calTitle = urlencode("The Wedding of {$coupleNames}");
        $calVenue = $firstEvent?->vanue ?: $firstEvent?->lokasi;
        $calLocation = urlencode(($calVenue ? $calVenue . ', ' : '') . ($firstEvent?->alamat ?? ''));
        $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calStartDate}/{$calEndDate}&details={$calTitle}&location={$calLocation}";
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:site_name" content="Wayae Nikah">
    <meta property="og:title" content="{{ $data->title ?? $pageTitle }}">
    <meta property="og:description" content="Acara akan dilaksanakan pada {{ $eventDateText }}.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title ?? $pageTitle])

    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @if ($data->dataFont)
        @if ($data->dataFont?->titleFont?->link)
            <link rel="stylesheet" href="{{ $data->dataFont->titleFont->link }}">
        @endif
        @if ($data->dataFont?->subFont?->link)
            <link rel="stylesheet" href="{{ $data->dataFont->subFont->link }}">
        @endif
    @endif
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
            --font-title: @if($data->dataFont?->titleFont) "{{ $data->dataFont->titleFont->nama }}", @endif 'Cormorant Garamond', Georgia, serif;
            --font-body: @if($data->dataFont?->subFont) "{{ $data->dataFont->subFont->nama }}", @endif 'Plus Jakarta Sans', Inter, sans-serif;
        }
        body {
            background-color: var(--bg-ivory);
            color: var(--text-dark);
            font-family: var(--font-body);
            overflow-x: hidden;
        }
        .custom-title-font {
            font-family: var(--font-title);
        }
        .arch-frame {
            border-radius: 9999px 9999px 24px 24px;
        }
        .arch-full {
            border-radius: 9999px;
        }
        @keyframes floatPetal {
            0% { transform: translateY(-10vh) translateX(0) rotate(0deg); opacity: 0; }
            15% { opacity: 0.65; }
            85% { opacity: 0.65; }
            100% { transform: translateY(105vh) translateX(45px) rotate(360deg); opacity: 0; }
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

    @if ($bgMusicUrl)
        <audio id="bg-music" src="{{ $bgMusicUrl }}" loop preload="auto"></audio>
    @endif

    <!-- Floating Botanical Petals Container -->
    <div id="petals-container" class="fixed inset-0 pointer-events-none z-30 overflow-hidden"></div>

    <!-- Toast Notification -->
    <div id="toast-notification" class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] pointer-events-none opacity-0 -translate-y-4 transition-all duration-300">
        <div class="bg-espresso/95 text-ivory px-5 py-3 rounded-full shadow-xl border border-gold-muted/40 flex items-center gap-2.5 text-xs sm:text-sm font-medium backdrop-blur-md">
            <span id="toast-icon" class="text-sage-300">✦</span>
            <span id="toast-message">Tersalin ke clipboard</span>
        </div>
    </div>

    <!-- Lightbox Modal for Gallery -->
    <div id="lightbox-modal" class="fixed inset-0 z-[90] bg-espresso/90 backdrop-blur-md hidden items-center justify-center p-4">
        <button id="lightbox-close" type="button" aria-label="Tutup preview" class="absolute top-5 right-5 w-11 h-11 rounded-full bg-ivory/15 hover:bg-ivory/25 text-ivory flex items-center justify-center transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <button id="lightbox-prev" type="button" aria-label="Foto sebelumnya" class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-ivory/15 hover:bg-ivory/25 text-ivory flex items-center justify-center transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="max-w-3xl w-full flex flex-col items-center">
            <img id="lightbox-img" src="{{ $coverImage }}" alt="Gallery Preview" class="max-h-[78vh] w-auto rounded-2xl shadow-2xl border-2 border-ivory/20 object-contain">
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
            <p class="text-[11px] uppercase tracking-[0.35em] text-sage-600 font-medium">{{ $data->setting?->acara ?? 'The Wedding Celebration Of' }}</p>
        </div>

        <!-- Center Arch Frame & Couple Names -->
        <div class="relative z-10 flex flex-col items-center my-auto max-w-sm w-full">
            <div class="relative w-48 h-64 sm:w-56 sm:h-72 p-2 rounded-t-full rounded-b-3xl border border-gold-muted/50 bg-cream/60 shadow-xl mb-5">
                <div class="w-full h-full overflow-hidden rounded-t-full rounded-b-2xl relative">
                    <img src="{{ $coverImage }}" alt="{{ $coupleNames }}" class="w-full h-full object-cover">
                </div>
                @if ($data->setting?->hashtag)
                    <div class="absolute -bottom-3.5 left-1/2 -translate-x-1/2 bg-ivory border border-gold-light/90 px-4 py-1 rounded-full shadow-md whitespace-nowrap">
                        <span class="font-serif italic text-xs text-gold-muted">{{ $data->setting->hashtag }}</span>
                    </div>
                @endif
            </div>

            <h1 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso tracking-tight">
                {{ $firstPerson?->nama_panggilan ?? ($isWanitaFirst ? 'Wanita' : 'Pria') }}
                <span class="font-script text-3xl text-gold-muted font-normal">&amp;</span>
                {{ $secondPerson?->nama_panggilan ?? ($isWanitaFirst ? 'Pria' : 'Wanita') }}
            </h1>
            <p class="text-xs uppercase tracking-[0.25em] text-sage-700 font-medium mt-1">{{ $eventDateText }}</p>

            <!-- Personalized Guest Box -->
            <div class="mt-6 px-5 py-3.5 rounded-2xl bg-cream/70 border border-gold-light/60 max-w-xs w-full shadow-sm">
                <p class="text-[10px] uppercase tracking-widest text-espresso/60">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                <p id="cover-guest-name" class="font-serif text-lg font-semibold text-espresso mt-0.5">{{ $guestName }}</p>
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
    <!-- DESKTOP SPLIT WRAPPER & MAIN CONTAINER     -->
    <!-- ========================================== -->
    <div class="min-h-screen lg:flex lg:justify-center">

        <!-- Left Fixed Branding & Couple Aside on Desktop -->
        <aside class="hidden lg:flex lg:w-7/12 xl:w-8/12 h-screen sticky top-0 flex-col justify-between p-12 bg-cream/40 border-r border-gold-light/50 relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ $heroImage }}" alt="{{ $coupleNames }}" class="absolute inset-0 w-full h-full object-cover opacity-85 scale-105 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-espresso/85 via-espresso/30 to-transparent"></div>
                <div class="absolute inset-5 border border-ivory/25 rounded-3xl pointer-events-none"></div>
            </div>

            <div class="relative z-10 text-ivory">
                <p class="text-xs uppercase tracking-[0.35em] text-ivory/80">{{ $data->setting?->acara ?? 'The Wedding Celebration Of' }}</p>
                <h2 class="custom-title-font font-serif text-5xl xl:text-6xl font-semibold mt-2 drop-shadow">{{ $coupleNames }}</h2>
                @if ($data->setting?->hashtag)
                    <p class="font-serif italic text-gold-light text-lg mt-1 tracking-wider">{{ $data->setting->hashtag }}</p>
                @endif
            </div>

            <div class="relative z-10 text-ivory max-w-md">
                <p class="text-xs uppercase tracking-[0.2em] text-ivory/70">Waktu &amp; Lokasi</p>
                <p class="font-serif text-2xl font-medium mt-1">{{ $eventDateText }}</p>
                @if ($firstEvent)
                    <p class="text-sm text-ivory/85 mt-1">{{ $firstEvent->vanue ?? $firstEvent->lokasi }} {{ $firstEvent->alamat ? '— ' . $firstEvent->alamat : '' }}</p>
                @endif
                <div class="mt-4 pt-4 border-t border-ivory/20 flex items-center gap-3">
                    <span class="text-xs text-ivory/80">Kepada Yth:</span>
                    <span id="aside-guest-name" class="font-serif text-lg font-medium text-gold-light">{{ $guestName }}</span>
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
                    <p class="text-xs uppercase tracking-[0.3em] text-sage-600 font-medium">{{ $data->setting?->acara ?? 'The Wedding Of' }}</p>
                    <h2 class="custom-title-font font-serif text-4xl sm:text-5xl font-semibold text-espresso mt-2">{{ $coupleNames }}</h2>
                    @if ($data->setting?->hashtag)
                        <p class="text-xs font-serif italic text-gold-muted mt-1 tracking-wider">{{ $data->setting->hashtag }}</p>
                    @endif
                </div>

                <!-- Cover Frame Image -->
                <div class="relative my-6 w-64 sm:w-72 h-80 sm:h-96 p-2.5 bg-cream border border-gold-muted/45 arch-frame shadow-xl reveal">
                    <div class="w-full h-full overflow-hidden arch-frame relative">
                        <img src="{{ $heroImage }}" alt="{{ $coupleNames }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Date & Countdown -->
                <div class="reveal w-full max-w-sm">
                    <div class="flex items-center justify-center gap-3 text-espresso/70 text-xs uppercase tracking-[0.25em]">
                        <span>{{ $eventDate ? $eventDate->translatedFormat('l') : 'Hari Bahagia' }}</span>
                        <span>✦</span>
                        <span>{{ $eventDate ? $eventDate->translatedFormat('d F Y') : '' }}</span>
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
                    @if ($firstEvent)
                        <div class="mt-6 flex flex-col items-center gap-2">
                            <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-cream hover:bg-champagne border border-gold-light text-espresso text-xs uppercase tracking-widest font-medium transition shadow-sm">
                                <svg class="w-4 h-4 text-sage-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Simpan ke Kalender</span>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 3. SACRED AYAT / QUOTE SECTION             -->
            <!-- ========================================== -->
            <section class="py-14 px-6 text-center relative bg-cream/40 border-t border-gold-light/40">
                <div class="reveal max-w-sm mx-auto">
                    <span class="font-serif text-4xl text-gold-muted leading-none">“</span>
                    <p class="font-serif italic text-base sm:text-lg text-espresso/90 leading-relaxed -mt-2">
                        {{ $data->teksUndangan?->teks ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. (QS. Ar-Rum: 21)' }}
                    </p>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 4. MEET THE BRIDE & GROOM SECTION          -->
            <!-- ========================================== -->
            <section id="section-couple" class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center relative">
                <div class="reveal max-w-sm mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Kedua Mempelai</p>
                    <h2 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Mempelai Bahagia</h2>
                    <p class="text-xs text-espresso/70 mt-2 leading-relaxed">
                        Dengan memohon rahmat dan ridho Allah SWT, kami memohon doa restu untuk perjalanan suci pernikahan kami.
                    </p>
                </div>

                <!-- First Person -->
                <div class="mt-12 flex flex-col items-center reveal">
                    <div class="w-36 h-48 sm:w-40 sm:h-52 p-1.5 rounded-full border border-gold-muted/60 bg-ivory shadow-md mb-4">
                        <img src="{{ $firstPersonImg }}" alt="{{ $firstPerson?->nama_panggilan ?? $firstPerson?->nama_lengkap ?? 'Mempelai' }}" class="w-full h-full object-cover arch-full">
                    </div>
                    <h3 class="custom-title-font font-serif text-2xl font-semibold text-espresso">{{ $firstPerson?->nama_lengkap ?? $firstPerson?->nama ?? 'Nama Mempelai' }}</h3>
                    <p class="text-xs text-sage-700 font-medium uppercase tracking-wider mt-0.5">{{ $firstPersonRole }}</p>
                    @if ($firstPerson?->deskripsi)
                        <p class="text-xs text-espresso/75 mt-2 max-w-xs leading-relaxed">{{ $firstPerson->deskripsi }}</p>
                    @elseif ($firstPerson?->ayah || $firstPerson?->ibu)
                        <p class="text-xs text-espresso/75 mt-2 max-w-xs leading-relaxed">
                            {{ $isWanitaFirst ? 'Putri dari' : 'Putra dari' }}
                            @if ($firstPerson->ayah)
                                Bapak <strong class="text-espresso">{{ $firstPerson->ayah }}</strong>
                            @endif
                            @if ($firstPerson->ayah && $firstPerson->ibu)
                                &amp;
                            @endif
                            @if ($firstPerson->ibu)
                                Ibu <strong class="text-espresso">{{ $firstPerson->ibu }}</strong>
                            @endif
                        </p>
                    @endif
                    @if ($firstPerson?->instagram)
                        <a href="https://instagram.com/{{ ltrim($firstPerson->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-1.5 text-xs text-sage-700 hover:text-sage-900 transition">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            <span>{{ $firstPerson->instagram }}</span>
                        </a>
                    @endif
                </div>

                <!-- Romantic Separator Monogram -->
                <div class="my-8 flex items-center justify-center gap-3 text-gold-muted reveal">
                    <span class="w-12 h-px bg-gold-light"></span>
                    <span class="font-script text-3xl font-normal">&amp;</span>
                    <span class="w-12 h-px bg-gold-light"></span>
                </div>

                <!-- Second Person -->
                <div class="flex flex-col items-center reveal">
                    <div class="w-36 h-48 sm:w-40 sm:h-52 p-1.5 rounded-full border border-gold-muted/60 bg-ivory shadow-md mb-4">
                        <img src="{{ $secondPersonImg }}" alt="{{ $secondPerson?->nama_panggilan ?? $secondPerson?->nama_lengkap ?? 'Mempelai' }}" class="w-full h-full object-cover arch-full">
                    </div>
                    <h3 class="custom-title-font font-serif text-2xl font-semibold text-espresso">{{ $secondPerson?->nama_lengkap ?? $secondPerson?->nama ?? 'Nama Mempelai' }}</h3>
                    <p class="text-xs text-sage-700 font-medium uppercase tracking-wider mt-0.5">{{ $secondPersonRole }}</p>
                    @if ($secondPerson?->deskripsi)
                        <p class="text-xs text-espresso/75 mt-2 max-w-xs leading-relaxed">{{ $secondPerson->deskripsi }}</p>
                    @elseif ($secondPerson?->ayah || $secondPerson?->ibu)
                        <p class="text-xs text-espresso/75 mt-2 max-w-xs leading-relaxed">
                            {{ $isWanitaFirst ? 'Putra dari' : 'Putri dari' }}
                            @if ($secondPerson->ayah)
                                Bapak <strong class="text-espresso">{{ $secondPerson->ayah }}</strong>
                            @endif
                            @if ($secondPerson->ayah && $secondPerson->ibu)
                                &amp;
                            @endif
                            @if ($secondPerson->ibu)
                                Ibu <strong class="text-espresso">{{ $secondPerson->ibu }}</strong>
                            @endif
                        </p>
                    @endif
                    @if ($secondPerson?->instagram)
                        <a href="https://instagram.com/{{ ltrim($secondPerson->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex items-center gap-1.5 text-xs text-sage-700 hover:text-sage-900 transition">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            <span>{{ $secondPerson->instagram }}</span>
                        </a>
                    @endif
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 5. LOVE STORY SECTION                      -->
            <!-- ========================================== -->
            @if ($data->kisah && $data->kisah->isNotEmpty())
                <section id="section-story" class="py-16 px-6 text-center relative">
                    <div class="reveal">
                        <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Our Journey</p>
                        <h2 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Kisah Cinta Kami</h2>
                    </div>

                    <div class="mt-8 bg-cream/85 border border-gold-light/70 rounded-3xl p-5 sm:p-6 shadow-md reveal">
                        @php
                            $firstStory = $data->kisah->first();
                            $firstStoryImg = $firstStory?->image?->image ?? $firstStory?->image;
                        @endphp
                        <div class="relative h-56 sm:h-64 rounded-2xl overflow-hidden mb-5 border border-gold-light/40">
                            <img id="story-slide-img" src="{{ $firstStoryImg ? $storageUrl($firstStoryImg) : asset('tema/celebrate/assets/images/story.webp') }}" alt="Love Story Chapter" class="w-full h-full object-cover transition-all duration-500">
                            <div class="absolute top-3 left-3 bg-ivory/90 backdrop-blur-md px-3 py-1 rounded-full border border-gold-light/60">
                                <span id="story-chapter-badge" class="font-serif text-xs font-semibold text-sage-700">Bab 01</span>
                            </div>
                        </div>

                        <h3 id="story-chapter-title" class="font-serif text-2xl font-semibold text-espresso">{{ $firstStory?->title ?? $firstStory?->judul ?? 'Kisah Cinta' }}</h3>
                        <p id="story-chapter-text" class="text-xs text-espresso/80 mt-2.5 leading-relaxed min-h-[4rem]">
                            {{ $firstStory?->deskripsi ?? $firstStory?->cerita ?? '' }}
                        </p>

                        <!-- Carousel Controls -->
                        @if ($data->kisah->count() > 1)
                            <div class="mt-6 flex items-center justify-between pt-4 border-t border-gold-light/40">
                                <button id="story-prev-btn" type="button" class="w-9 h-9 rounded-full bg-ivory border border-gold-light flex items-center justify-center text-espresso hover:bg-sage-100 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <div class="flex items-center gap-1.5" id="story-indicators">
                                    @foreach ($data->kisah as $kIndex => $kItem)
                                        <span class="{{ $kIndex === 0 ? 'w-6 h-1.5 rounded-full bg-sage-600' : 'w-1.5 h-1.5 rounded-full bg-gold-light' }} transition-all"></span>
                                    @endforeach
                                </div>
                                <button id="story-next-btn" type="button" class="w-9 h-9 rounded-full bg-ivory border border-gold-light flex items-center justify-center text-espresso hover:bg-sage-100 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 6. GALLERY & MOMENTS SECTION               -->
            <!-- ========================================== -->
            @php
                $galleryPhotos = count($poto ?? []) ? $poto : $data->galery->pluck('poto')->filter()->values()->toArray();
            @endphp
            @if (count($galleryPhotos) > 0)
                <section id="section-gallery" class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center">
                    <div class="reveal">
                        <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Moments in Love</p>
                        <h2 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Galeri Momen</h2>
                        <p class="text-xs text-espresso/70 mt-1.5">Setiap bingkai foto menyimpan kenangan berharga perjalanan kami.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-8 reveal">
                        @foreach ($galleryPhotos as $gIndex => $gPhoto)
                            <div class="gallery-item relative rounded-2xl overflow-hidden aspect-[4/5] shadow-md border border-gold-light/50 group cursor-pointer" data-caption="Foto {{ $gIndex + 1 }}">
                                <img src="{{ $storageUrl($gPhoto) }}" alt="Momen {{ $gIndex + 1 }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 7. WEDDING EVENTS & SCHEDULE               -->
            <!-- ========================================== -->
            @if ($data->acara && $data->acara->isNotEmpty())
                <section id="section-events" class="py-16 px-6 text-center">
                    <div class="reveal">
                        <p class="text-xs uppercase tracking-[0.25em] text-sage-600">The Celebration</p>
                        <h2 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Rangkaian Acara</h2>
                        <p class="text-xs text-espresso/70 mt-1.5">Kehadiran dan doa restu Anda adalah kehormatan bagi kami.</p>
                    </div>

                    <div class="mt-8 space-y-6 reveal">
                        @foreach ($data->acara as $acaraItem)
                            @php
                                $itemDate = $acaraItem->date ? Carbon::parse($acaraItem->date) : null;
                                $itemDateText = $itemDate ? $itemDate->translatedFormat('l, d F Y') : '';
                            @endphp
                            <div class="bg-cream/80 border border-gold-light rounded-3xl p-6 shadow-md relative overflow-hidden text-center">
                                <span class="inline-block px-3.5 py-1 rounded-full bg-ivory border border-gold-light text-sage-700 font-serif italic text-xs mb-2">{{ $acaraItem->nama_acara }}</span>
                                <h3 class="custom-title-font font-serif text-3xl font-semibold text-espresso">{{ $acaraItem->nama_acara }}</h3>
                                
                                <div class="my-4 h-px w-16 bg-gold-light mx-auto"></div>

                                <div class="space-y-1 text-xs text-espresso/80">
                                    <p class="font-semibold text-sm text-espresso">{{ $itemDateText }}</p>
                                    <p>Pukul {{ $acaraItem->jam_start }} – {{ $acaraItem->jam_end }} {{ $acaraItem->zona_waktu ?? 'WIB' }}</p>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gold-light/50 text-xs text-espresso/75">
                                    <p class="font-semibold text-espresso">{{ $acaraItem->vanue ?? $acaraItem->lokasi }}</p>
                                    @if ($acaraItem->alamat)
                                        <p class="mt-0.5">{{ $acaraItem->alamat }}</p>
                                    @endif
                                </div>

                                @if ($acaraItem->maps)
                                    <a href="{{ $acaraItem->maps }}" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-widest font-medium transition shadow">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Petunjuk Lokasi</span>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 8. RUNDOWN SECTION                         -->
            <!-- ========================================== -->
            @if ($activeRundowns->isNotEmpty())
                <section class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center">
                    <div class="reveal max-w-sm mx-auto">
                        <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Jadwal Acara</p>
                        <h3 class="custom-title-font font-serif text-3xl font-semibold text-espresso mt-1">Rundown</h3>
                        <p class="text-xs text-espresso/70 mt-1.5 leading-relaxed">Susunan rangkaian acara yang akan berlangsung.</p>

                        <div class="mt-8 relative max-w-xs mx-auto text-left">
                            <div class="absolute left-[74px] top-2 bottom-2 w-px bg-gold-light"></div>

                            <div class="space-y-4">
                                @foreach ($activeRundowns as $rd)
                                    <div class="flex items-center gap-4">
                                        <span class="w-20 text-right text-xs font-semibold text-sage-700 shrink-0">
                                            {{ $rd->waktu_mulai ?? $rd->jam_start }}
                                        </span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-sage-600 ring-4 ring-ivory shrink-0 z-10"></span>
                                        <div>
                                            <span class="font-serif text-base font-medium text-espresso block">{{ $rd->nama_kegiatan ?? $rd->nama_acara }}</span>
                                            @if ($rd->keterangan ?? $rd->deskripsi)
                                                <span class="text-[11px] text-espresso/70 block">{{ $rd->keterangan ?? $rd->deskripsi }}</span>
                                            @endif
                                            @if ($rd->lokasi)
                                                <span class="text-[10px] text-espresso/55 block mt-0.5">📍 {{ $rd->lokasi }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 9. LIVE STREAMING (IF AVAILABLE)           -->
            <!-- ========================================== -->
            @if ($data->streaming && $data->streaming->link)
                <section id="section-streaming" class="py-14 px-6 text-center">
                    <div class="bg-cream/80 border border-gold-light rounded-3xl p-6 shadow-sm reveal max-w-sm mx-auto">
                        <span class="inline-block px-3.5 py-1 rounded-full bg-ivory border border-gold-light text-sage-700 font-serif italic text-xs mb-2">Virtual Attendance</span>
                        <h3 class="custom-title-font font-serif text-2xl font-semibold text-espresso">Siaran Langsung</h3>
                        <p class="text-xs text-espresso/75 mt-2 leading-relaxed">
                            Bagi keluarga dan sahabat yang belum dapat hadir secara langsung, Anda dapat menyaksikan prosesi pernikahan kami secara virtual.
                        </p>
                        <a href="{{ $data->streaming->link }}" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-widest font-medium transition shadow">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                            <span>Tonton Siaran Langsung</span>
                        </a>
                    </div>
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 10. DIGITAL GIFT / TANDA KASIH             -->
            <!-- ========================================== -->
            @if ($data->fiturKado || ($data->kado && $data->kado->isNotEmpty()))
                <section id="section-gift" class="py-16 px-6 bg-cream/60 border-y border-gold-light/40 text-center">
                    <div class="reveal max-w-sm mx-auto">
                        <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Tanda Kasih</p>
                        <h2 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Titip Hadiah</h2>
                        <p class="text-xs text-espresso/70 mt-1.5 leading-relaxed">
                            Doa restu Anda adalah hadiah terindah. Namun jika Anda ingin memberikan tanda kasih secara digital, Anda dapat melalui rekening di bawah ini:
                        </p>
                    </div>

                    <div class="mt-8 space-y-4 reveal">
                        @if ($data->kado && $data->kado->isNotEmpty())
                            @foreach ($data->kado as $kadoItem)
                                @php
                                    $bankName = $kadoItem->giftPay?->nama_pay ?? $kadoItem->giftPay?->nama_bank ?? $kadoItem->nama_bank ?? 'Rekening Bank';
                                    $accNo = $kadoItem->nomorPay ?? $kadoItem->no_rek ?? '';
                                    $accOwner = $kadoItem->namaPay ?? $kadoItem->atas_nama ?? $kadoItem->nama_pemilik ?? '';
                                @endphp
                                <div class="bg-ivory border border-gold-light rounded-2xl p-5 shadow-sm text-left">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-serif text-lg font-semibold text-espresso">{{ $bankName }}</span>
                                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-cream text-sage-700 font-medium border border-gold-light">{{ $bankName }}</span>
                                    </div>
                                    <p class="text-xs text-espresso/70">Nomor Rekening:</p>
                                    <div class="flex items-center justify-between mt-1">
                                        <strong class="font-mono text-base text-espresso tracking-wider">{{ $accNo }}</strong>
                                        <button type="button" onclick="copyToClipboard('{{ $accNo }}', 'Nomor rekening {{ $bankName }} tersalin!')" class="px-3.5 py-1.5 rounded-full bg-cream hover:bg-sage-600 text-espresso hover:text-ivory border border-gold-light text-xs font-medium transition">
                                            Salin
                                        </button>
                                    </div>
                                    @if ($accOwner)
                                        <p class="text-xs text-espresso/70 mt-1">a.n. <strong>{{ $accOwner }}</strong></p>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        @if ($data->fiturKado && $data->fiturKado->alamat)
                            <div class="bg-ivory border border-gold-light rounded-2xl p-5 shadow-sm text-left">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-serif text-lg font-semibold text-espresso">Kirim Kado Fisik</span>
                                    <span class="text-xs px-2.5 py-0.5 rounded-full bg-cream text-sage-700 font-medium border border-gold-light">Alamat</span>
                                </div>
                                <p class="text-xs text-espresso/80 leading-relaxed">
                                    {{ $data->fiturKado->alamat }}
                                </p>
                                <div class="mt-3 text-right">
                                    <button type="button" onclick="copyToClipboard('{{ addslashes($data->fiturKado->alamat) }}', 'Alamat kado fisik tersalin!')" class="px-3.5 py-1.5 rounded-full bg-cream hover:bg-sage-600 text-espresso hover:text-ivory border border-gold-light text-xs font-medium transition">
                                        Salin Alamat
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 11. RSVP & WISHES SECTION                  -->
            <!-- ========================================== -->
            @if ($data->FiturUcapan?->status ?? true)
                <section id="section-wishes" class="py-16 px-6 text-center">
                    <div class="reveal max-w-sm mx-auto">
                        <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Buku Tamu</p>
                        <h2 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-1">Doa &amp; Ucapan</h2>
                        <p class="text-xs text-espresso/70 mt-1.5 leading-relaxed">
                            Tinggalkan doa dan pesan terbaik untuk kedua mempelai.
                        </p>
                    </div>

                    <!-- Wish Submission Form -->
                    <form action="{{ route('savedoa') }}" method="POST" class="mt-8 bg-cream/80 border border-gold-light rounded-3xl p-5 text-left space-y-3.5 shadow-sm reveal">
                        @csrf
                        <input type="hidden" name="dataId" value="{{ $data->id }}">
                        <input type="hidden" name="kode" value="{{ $kode ?? '' }}">

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ $guestName !== 'Tamu Undangan' ? $guestName : '' }}" required placeholder="Masukkan nama Anda" class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600">
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Konfirmasi Kehadiran</label>
                            <select name="status" required class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600">
                                <option value="hadir">Ya, Saya Akan Hadir</option>
                                <option value="tidak_hadir">Maaf, Tidak Bisa Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-espresso/70 mb-1">Doa &amp; Ucapan</label>
                            <textarea name="ucapan" rows="3" required placeholder="Tuliskan ucapan dan doa terbaik Anda..." class="w-full px-3.5 py-2.5 rounded-xl bg-ivory border border-gold-light text-sm focus:outline-none focus:border-sage-600"></textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-full bg-sage-600 hover:bg-sage-700 text-ivory text-xs uppercase tracking-widest font-medium transition shadow">
                            Kirim Ucapan
                        </button>
                    </form>

                    <!-- Wishes Feed List -->
                    @if ($ucapan && $ucapan->isNotEmpty())
                        <div id="wishes-list-container" class="mt-6 space-y-3 text-left reveal">
                            @foreach ($ucapan as $uIndex => $uItem)
                                <div class="wish-item {{ $uIndex >= 4 ? 'hidden' : '' }} bg-cream/70 border border-gold-light/70 rounded-2xl p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="font-serif text-lg font-semibold text-espresso">{{ $uItem->tamu?->nama ?? $uItem->nama ?? 'Tamu' }}</span>
                                            @if ($uItem->status)
                                                <span class="text-[10px] px-2 py-0.5 rounded-full {{ in_array($uItem->status, ['hadir', 'Hadir', 'Datang Dong']) ? 'bg-sage-100 text-sage-800' : 'bg-rose-soft text-rose-dusty' }} font-medium">
                                                    {{ in_array($uItem->status, ['hadir', 'Hadir', 'Datang Dong']) ? 'Hadir' : 'Tidak Hadir' }}
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-espresso/55">{{ $uItem->created_at ? $uItem->created_at->diffForHumans() : '' }}</span>
                                    </div>
                                    <p class="text-xs text-espresso/80 leading-relaxed">{{ $uItem->ucapan }}</p>
                                </div>
                            @endforeach
                        </div>

                        @if ($ucapan->count() > 4)
                            <div class="mt-4">
                                <button id="show-more-wishes-btn" type="button" onclick="document.querySelectorAll('.wish-item.hidden').forEach(el => el.classList.remove('hidden')); this.parentElement.remove();" class="px-5 py-2 rounded-full bg-cream hover:bg-champagne border border-gold-light text-xs uppercase tracking-widest text-espresso font-medium transition shadow-sm">
                                    Tampilkan Lebih Banyak
                                </button>
                            </div>
                        @endif
                    @endif
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 12. CLOSING & FOOTER                       -->
            <!-- ========================================== -->
            <footer class="py-16 px-6 bg-cream border-t border-gold-light/60 text-center relative overflow-hidden">
                <div class="reveal max-w-xs mx-auto">
                    <p class="text-xs uppercase tracking-[0.25em] text-sage-600">Terima Kasih</p>
                    <h2 class="custom-title-font font-serif text-3xl font-semibold text-espresso mt-1">Salam Hangat Kami</h2>
                    <p class="font-serif italic text-sm sm:text-base text-espresso/80 mt-3 leading-relaxed">
                        “Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu bagi lembaran baru kehidupan kami.”
                    </p>

                    <div class="my-6 h-px w-20 bg-gold-light mx-auto"></div>

                    <p class="text-[11px] uppercase tracking-[0.3em] text-sage-600">Kami yang berbahagia</p>
                    <h3 class="custom-title-font font-serif text-3xl sm:text-4xl font-semibold text-espresso mt-2 flex items-center justify-center gap-2.5">
                        <span>{{ $firstPerson?->nama_panggilan }}</span>
                        <span class="font-script text-3xl text-gold-muted font-normal">&amp;</span>
                        <span>{{ $secondPerson?->nama_panggilan }}</span>
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
        @if ($data->kisah && $data->kisah->isNotEmpty())
            <a href="#section-story" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Cerita</a>
        @endif
        @if ($data->acara && $data->acara->isNotEmpty())
            <a href="#section-events" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Acara</a>
        @endif
        @if ($data->fiturKado || ($data->kado && $data->kado->isNotEmpty()))
            <a href="#section-gift" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Hadiah</a>
        @endif
        @if ($data->FiturUcapan?->status ?? true)
            <a href="#section-wishes" class="px-3 py-1.5 rounded-full text-[11px] font-medium text-espresso/80 hover:bg-sage-100 hover:text-sage-800 transition">Doa</a>
        @endif
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

        // 2. Audio Controller (HTML5 Audio or Web Audio API Synth Fallback)
        const bgAudio = document.getElementById('bg-music');
        let audioCtx = null;
        let isMusicPlaying = false;
        let melodyInterval = null;
        const romanticNotes = [523.25, 659.25, 783.99, 659.25, 880.00, 783.99, 659.25, 587.33, 523.25, 587.33, 659.25, 523.25];
        let noteIdx = 0;

        function playRomanticSynthNote(freq) {
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

        function startMusic() {
            isMusicPlaying = true;
            const icon = document.getElementById('music-disc-icon');
            if (icon) icon.classList.add('spin-slow');

            if (bgAudio) {
                bgAudio.play().catch(() => {
                    // Fallback to synth if browser blocks media element
                    startSynth();
                });
            } else {
                startSynth();
            }
        }

        function startSynth() {
            try {
                if (!audioCtx) {
                    const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                    audioCtx = new AudioContextClass();
                }
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                if (melodyInterval) clearInterval(melodyInterval);
                playRomanticSynthNote(romanticNotes[noteIdx % romanticNotes.length]);
                melodyInterval = setInterval(() => {
                    if (!isMusicPlaying) return;
                    noteIdx = (noteIdx + 1) % romanticNotes.length;
                    playRomanticSynthNote(romanticNotes[noteIdx]);
                }, 1100);
            } catch (e) {
                isMusicPlaying = false;
            }
        }

        function toggleMusic() {
            const icon = document.getElementById('music-disc-icon');
            if (isMusicPlaying) {
                isMusicPlaying = false;
                if (bgAudio) bgAudio.pause();
                if (melodyInterval) clearInterval(melodyInterval);
                if (icon) icon.classList.remove('spin-slow');
                showToast('Musik dijeda', '♪');
            } else {
                startMusic();
                showToast('Memutar musik pernikahan', '♫');
            }
        }

        const musicToggleBtn = document.getElementById('music-toggle-btn');
        if (musicToggleBtn) {
            musicToggleBtn.addEventListener('click', toggleMusic);
        }

        // 3. Opening Cover
        window.celebrateOpenCover = function() {
            const openingCover = document.getElementById('opening-cover');
            const pageBody = document.getElementById('page-body');
            if (openingCover) openingCover.classList.add('opened');
            if (pageBody) pageBody.classList.remove('overflow-hidden');
            startMusic();
            showToast('Selamat datang di pernikahan {{ addslashes($coupleNames) }}', '🕊️');
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

        // 5. Dynamic Countdown Timer
        const targetCountdown = new Date('{{ $countdownDate }}').getTime();

        function updateCountdownDisplay() {
            const now = Date.now();
            const diff = Math.max(0, targetCountdown - now);

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

        // 6. Dynamic Love Story Carousel
        @php
            $storyItemsData = [];
            if ($data->kisah && $data->kisah->isNotEmpty()) {
                foreach ($data->kisah as $ki => $kv) {
                    $storyImg = $kv->image?->image ?? $kv->image;
                    $storyItemsData[] = [
                        'badge' => 'Bab ' . str_pad($ki + 1, 2, '0', STR_PAD_LEFT),
                        'title' => $kv->title ?? $kv->judul ?? 'Kisah Cinta',
                        'text' => $kv->deskripsi ?? $kv->cerita ?? '',
                        'img' => $storyImg ? $storageUrl($storyImg) : asset('tema/celebrate/assets/images/story.webp')
                    ];
                }
            }
        @endphp
        const storyChapters = {!! json_encode($storyItemsData) !!};
        let currentStoryIdx = 0;

        function renderStorySlide() {
            if (!storyChapters.length) return;
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

        // 8. Scroll Reveal Observer
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
            initScrollReveal();
        });
    </script>
</body>
</html>
