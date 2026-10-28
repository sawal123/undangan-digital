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
        $firstEvent = $data->acara?->first();
        $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
        $eventTime = $firstEvent?->jam_start ?: '08:00';
        $eventDateText = $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Minggu, 20 Desember 2026';
        $countdownDate = $eventDate
            ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Y-m-d\TH:i:s')
            : now()->addDays(30)->format('Y-m-d\TH:i:s');

        $storageUrl = fn($path) => $path ? (str_starts_with($path, 'http') ? $path : asset('storage/' . ltrim($path, '/'))) : null;

        $coverImage =
            $storageUrl($data->coverUndangan?->cover_satu) ??
            ((count($poto ?? []) ? $storageUrl($poto[0]) : null) ?? asset('tema/javanese-clean/assets/images/couple-hero.webp'));
        $heroImage =
            $storageUrl($data->coverUndangan?->cover_dua) ??
            ((count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null) ?? $coverImage);
        $priaImage = $storageUrl($pria?->image) ?? asset('tema/javanese-clean/assets/images/groom.webp');
        $wanitaImage = $storageUrl($wanita?->image) ?? asset('tema/javanese-clean/assets/images/bride.webp');

        $coupleNames = $coupleNames ?? $data->couple_name;
        $coupleFullNames = $coupleFullNames ?? $data->couple_full_name;
        $isWanitaFirst = (bool) ($isWanitaFirst ?? $data->is_wanita_first);

        $firstPerson = $isWanitaFirst ? $wanita : $pria;
        $secondPerson = $isWanitaFirst ? $pria : $wanita;
        $firstPersonRole = $isWanitaFirst ? 'Mempelai Wanita' : 'Mempelai Pria';
        $secondPersonRole = $isWanitaFirst ? 'Mempelai Pria' : 'Mempelai Wanita';
        $firstPersonImg = $isWanitaFirst ? $wanitaImage : $priaImage;
        $secondPersonImg = $isWanitaFirst ? $priaImage : $wanitaImage;
        $isFirstPersonMale = ! $isWanitaFirst;

        $pageTitle = ($data->setting?->acara ?? 'Pawiwahan Ageng') . ' ' . $coupleNames;
        $guestName = $tamu ?? 'Tamu Undangan';
        $activeRundowns = $rundowns ?? collect();
        $bgMusicUrl = $data->sound?->audio ? (str_starts_with($data->sound->audio, 'http') ? $data->sound->audio : asset('storage/' . $data->sound->audio)) : null;

        // Prepare calendar URL
        $calStartDate = $eventDate ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Ymd\THis') : now()->format('Ymd\THis');
        $calEndDate = $eventDate ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->addHours(4)->format('Ymd\THis') : now()->addHours(4)->format('Ymd\THis');
        $calTitle = urlencode("Pawiwahan Ageng {$coupleNames}");
        $calVenue = $firstEvent?->vanue ?: $firstEvent?->lokasi;
        $calLocation = urlencode(($calVenue ? $calVenue . ', ' : '') . ($firstEvent?->alamat ?? ''));
        $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calStartDate}/{$calEndDate}&details={$calTitle}&location={$calLocation}";

        $galleryPhotos = count($poto ?? []) ? $poto : ($data->galery ? $data->galery->pluck('poto')->filter()->values()->toArray() : []);
        $galleryVideos = count($video ?? []) ? $video : ($data->galery ? $data->galery->pluck('video')->filter()->values()->toArray() : []);
        $hasStory = $data->kisah && $data->kisah->isNotEmpty();
        $hasGallery = count($galleryPhotos) > 0 || count($galleryVideos) > 0;
        $hasGift = $data->fiturKado || ($data->kado && $data->kado->isNotEmpty());
        $hasRundown = $activeRundowns->isNotEmpty();
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:site_name" content="Wayae Nikah">
    <meta property="og:title" content="{{ $data->title ?? $pageTitle }}">
    <meta property="og:description" content="Pawiwahan Ageng {{ $coupleNames }} akan dilaksanakan pada {{ $eventDateText }}.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title ?? $pageTitle])

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @if ($data->dataFont)
        @if ($data->dataFont?->titleFont?->link)
            <link rel="stylesheet" href="{{ $data->dataFont->titleFont->link }}">
        @endif
        @if ($data->dataFont?->subFont?->link)
            <link rel="stylesheet" href="{{ $data->dataFont->subFont->link }}">
        @endif
    @endif

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sogan: {
                            950: '#160B06',
                            900: '#24130B',
                            800: '#381E11',
                            700: '#4E2A18',
                            600: '#6B3B23',
                            500: '#8A4F30',
                        },
                        emas: {
                            100: '#FBF3D5',
                            200: '#F3E09B',
                            300: '#E6C665',
                            400: '#D4AF37',
                            500: '#B8860B',
                            600: '#8F6505',
                        },
                        krem: {
                            50: '#FDFBF7',
                            100: '#F7F1E3',
                            200: '#EFE4CE',
                            300: '#DFD1B3',
                        },
                        daun: {
                            700: '#2D4A3E',
                            800: '#1E352B',
                            900: '#13241C',
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
        .bg-batik-kawung {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23D4AF37' stroke-width='0.6' stroke-opacity='0.14'%3E%3Cpath d='M30 0 C15 15 15 45 30 60 C45 45 45 15 30 0 Z'/%3E%3Cpath d='M0 30 C15 15 45 15 60 30 C45 45 15 45 0 30 Z'/%3E%3Ccircle cx='30' cy='30' r='3' fill='%23D4AF37' fill-opacity='0.1'/%3E%3Ccircle cx='30' cy='12' r='1.5' fill='%23D4AF37' fill-opacity='0.1'/%3E%3Ccircle cx='30' cy='48' r='1.5' fill='%23D4AF37' fill-opacity='0.1'/%3E%3Ccircle cx='12' cy='30' r='1.5' fill='%23D4AF37' fill-opacity='0.1'/%3E%3Ccircle cx='48' cy='30' r='1.5' fill='%23D4AF37' fill-opacity='0.1'/%3E%3C/g%3E%3C/svg%3E");
        }

        .bg-batik-light {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%238F6505' stroke-width='0.6' stroke-opacity='0.1'%3E%3Cpath d='M30 0 C15 15 15 45 30 60 C45 45 45 15 30 0 Z'/%3E%3Cpath d='M0 30 C15 15 45 15 60 30 C45 45 15 45 0 30 Z'/%3E%3Ccircle cx='30' cy='30' r='2.5'/%3E%3C/g%3E%3C/svg%3E");
        }

        @keyframes swaySlow {
            0%, 100% { transform: rotate(0deg) skewX(0deg) scale(1); }
            35% { transform: rotate(4.5deg) skewX(2deg) scale(1.01); }
            70% { transform: rotate(-3deg) skewX(-1.5deg) scale(0.99); }
        }

        @keyframes swayReverse {
            0%, 100% { transform: rotate(0deg) skewX(0deg); }
            40% { transform: rotate(-5.5deg) skewX(-2deg); }
            75% { transform: rotate(3.5deg) skewX(1.5deg); }
        }

        @keyframes swayHanging {
            0%, 100% { transform: rotate(-2deg); }
            50% { transform: rotate(4.5deg) translateX(3px); }
        }

        @keyframes bloomPulse {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.06) rotate(3deg); }
        }

        @keyframes lanternGlow {
            0%, 100% { opacity: 0.7; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.12); }
        }

        @keyframes floatGunungan {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .daun-angin-kiri {
            transform-origin: bottom left;
            animation: swaySlow 6.5s ease-in-out infinite;
        }
        .daun-angin-kanan {
            transform-origin: bottom right;
            animation: swayReverse 7.2s ease-in-out infinite;
        }
        .daun-gantung-1 {
            transform-origin: top center;
            animation: swayHanging 5.5s ease-in-out infinite;
        }
        .daun-gantung-2 {
            transform-origin: top center;
            animation: swayHanging 6.8s ease-in-out infinite 1.2s;
        }
        .daun-cabang {
            transform-box: fill-box;
            transform-origin: 0% 100%;
            animation: swaySlow 5s ease-in-out infinite;
        }
        .daun-cabang-kanan {
            transform-box: fill-box;
            transform-origin: 100% 100%;
            animation: swayReverse 5.8s ease-in-out infinite 0.7s;
        }
        .bunga-mekar {
            transform-box: fill-box;
            transform-origin: center;
            animation: bloomPulse 4.5s ease-in-out infinite;
        }
        .cahaya-pendopo {
            transform-box: fill-box;
            transform-origin: center;
            animation: lanternGlow 3.5s ease-in-out infinite;
        }
        .gunungan-float {
            animation: floatGunungan 4s ease-in-out infinite;
        }

        .text-gold-gradient {
            background: linear-gradient(135deg, #FBF3D5 0%, #D4AF37 45%, #B8860B 75%, #F3E09B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .border-emas-ornamen {
            border: 1px solid rgba(212, 175, 55, 0.45);
            box-shadow: 0 10px 30px -10px rgba(22, 11, 6, 0.5), inset 0 0 15px rgba(212, 175, 55, 0.1);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #160B06;
        }
        ::-webkit-scrollbar-thumb {
            background: #8F6505;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #D4AF37;
        }
    </style>
</head>
<body class="bg-sogan-950 text-krem-100 font-sans antialiased selection:bg-emas-400 selection:text-sogan-950 overflow-x-hidden overflow-y-hidden" id="body-main">

    @if ($bgMusicUrl)
        <audio id="bg-music" src="{{ $bgMusicUrl }}" loop preload="auto"></audio>
    @endif

    <!-- SHARED SVG DEFINITIONS -->
    <svg class="hidden" aria-hidden="true">
        <defs>
            <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#FBF3D5" />
                <stop offset="35%" stop-color="#D4AF37" />
                <stop offset="70%" stop-color="#9A6F0A" />
                <stop offset="100%" stop-color="#F3E09B" />
            </linearGradient>

            <linearGradient id="woodRoofGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#5C321C" />
                <stop offset="50%" stop-color="#3E2010" />
                <stop offset="100%" stop-color="#241107" />
            </linearGradient>

            <radialGradient id="warmLantern" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#FFF7D6" stop-opacity="0.95" />
                <stop offset="40%" stop-color="#F59E0B" stop-opacity="0.55" />
                <stop offset="100%" stop-color="#D97706" stop-opacity="0" />
            </radialGradient>

            <g id="bunga-melati">
                <g class="bunga-mekar">
                    <ellipse cx="0" cy="-7" rx="3.5" ry="7" fill="#FFFDF9" stroke="#E6D7B8" stroke-width="0.5"/>
                    <ellipse cx="0" cy="-7" rx="3.5" ry="7" fill="#FFFDF9" stroke="#E6D7B8" stroke-width="0.5" transform="rotate(60)"/>
                    <ellipse cx="0" cy="-7" rx="3.5" ry="7" fill="#FFFDF9" stroke="#E6D7B8" stroke-width="0.5" transform="rotate(120)"/>
                    <ellipse cx="0" cy="-7" rx="3.5" ry="7" fill="#FFFDF9" stroke="#E6D7B8" stroke-width="0.5" transform="rotate(180)"/>
                    <ellipse cx="0" cy="-7" rx="3.5" ry="7" fill="#FFFDF9" stroke="#E6D7B8" stroke-width="0.5" transform="rotate(240)"/>
                    <ellipse cx="0" cy="-7" rx="3.5" ry="7" fill="#FFFDF9" stroke="#E6D7B8" stroke-width="0.5" transform="rotate(300)"/>
                    <circle cx="0" cy="0" r="2.8" fill="#D4AF37"/>
                    <circle cx="0" cy="0" r="1.4" fill="#FFF7D6"/>
                </g>
            </g>

            <g id="bunga-cempaka">
                <g class="bunga-mekar">
                    <path d="M0,0 C-6,-8 -4,-18 0,-22 C4,-18 6,-8 0,0 Z" fill="url(#goldGrad)" />
                    <path d="M0,0 C-6,-8 -4,-18 0,-22 C4,-18 6,-8 0,0 Z" fill="url(#goldGrad)" transform="rotate(45)" opacity="0.9"/>
                    <path d="M0,0 C-6,-8 -4,-18 0,-22 C4,-18 6,-8 0,0 Z" fill="url(#goldGrad)" transform="rotate(-45)" opacity="0.9"/>
                    <path d="M0,0 C-5,-6 -3,-14 0,-17 C3,-14 5,-6 0,0 Z" fill="#FFFDF9" transform="rotate(22)"/>
                    <path d="M0,0 C-5,-6 -3,-14 0,-17 C3,-14 5,-6 0,0 Z" fill="#FFFDF9" transform="rotate(-22)"/>
                    <circle cx="0" cy="-2" r="3" fill="#B8860B"/>
                </g>
            </g>

            <g id="ronce-melati">
                <line x1="0" y1="0" x2="0" y2="110" stroke="#D4AF37" stroke-width="1" stroke-dasharray="2,2"/>
                <circle cx="0" cy="15" r="3.5" fill="#FFFDF9"/>
                <circle cx="0" cy="28" r="4" fill="#FFFDF9"/>
                <circle cx="0" cy="42" r="3.5" fill="#FFFDF9"/>
                <circle cx="0" cy="56" r="4" fill="#FFFDF9"/>
                <circle cx="0" cy="70" r="3.5" fill="#FFFDF9"/>
                <circle cx="0" cy="84" r="3" fill="#FFFDF9"/>
                <use href="#bunga-melati" x="0" y="98" transform="scale(0.95)"/>
                <path d="M0,108 L-3,120 L0,117 L3,120 Z" fill="url(#goldGrad)"/>
            </g>

            <g id="ukiran-sudut">
                <path d="M2,2 L48,2 C34,6 28,12 24,24 C12,28 6,34 2,48 Z" fill="url(#goldGrad)" opacity="0.25"/>
                <path d="M2,2 L65,2 M2,2 L2,65" stroke="url(#goldGrad)" stroke-width="2" fill="none"/>
                <path d="M8,8 L45,8 C32,12 22,22 18,35 C14,25 10,18 8,45 Z" stroke="url(#goldGrad)" stroke-width="1.2" fill="none"/>
                <circle cx="14" cy="14" r="3" fill="url(#goldGrad)"/>
                <circle cx="52" cy="8" r="2" fill="url(#goldGrad)"/>
                <circle cx="8" cy="52" r="2" fill="url(#goldGrad)"/>
            </g>

            <g id="gunungan-jawa">
                <path d="M0,-85 C-25,-50 -48,-10 -44,35 C-40,62 -22,78 0,85 C22,78 40,62 44,35 C48,-10 25,-50 0,-85 Z" 
                      fill="url(#goldGrad)" fill-opacity="0.18" stroke="url(#goldGrad)" stroke-width="2"/>
                <path d="M0,-72 C-20,-42 -38,-6 -35,32 C-32,54 -16,68 0,74 C16,68 32,54 35,32 C38,-6 20,-42 0,-72 Z" 
                      fill="none" stroke="url(#goldGrad)" stroke-width="1" stroke-dasharray="3,2"/>
                <path d="M0,74 L0,-45 M0,30 C-15,20 -22,5 -12,-5 M0,30 C15,20 22,5 12,-5 M0,0 C-12,-10 -18,-22 -8,-30 M0,0 C12,-10 18,-22 8,-30" 
                      stroke="url(#goldGrad)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                <path d="M-16,70 L-16,48 L-22,48 L0,34 L22,48 L16,48 L16,70 Z" fill="url(#goldGrad)" opacity="0.6"/>
                <circle cx="0" cy="-48" r="4" fill="#FFFDF9"/>
            </g>
        </defs>
    </svg>

    <!-- CANVAS ANIMATION -->
    <canvas id="wind-petals-canvas" class="fixed inset-0 pointer-events-none z-40 w-full h-full"></canvas>

    <!-- FLOATING TOP FOLIAGE -->
    <div class="fixed top-0 left-0 right-0 pointer-events-none z-30 flex justify-between overflow-hidden h-44 sm:h-56">
        <svg class="w-40 sm:w-72 h-auto -ml-3 -mt-2 sm:-ml-4 sm:-mt-3 daun-angin-kiri" viewBox="0 0 260 200" fill="none">
            <g class="daun-cabang">
                <path d="M0,0 Q80,35 165,85" stroke="#8F6505" stroke-width="2.5" fill="none"/>
                <path d="M40,18 C65,5 85,20 75,40 C55,42 45,30 40,18 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.7"/>
                <path d="M85,42 C110,25 135,40 125,62 C100,65 90,52 85,42 Z" fill="#1E352B" stroke="#D4AF37" stroke-width="0.7"/>
                <path d="M130,68 C155,55 180,68 172,88 C150,90 138,78 130,68 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.7"/>
                <path d="M60,30 C45,55 60,78 82,70 C85,50 72,38 60,30 Z" fill="#3A5F50" stroke="#D4AF37" stroke-width="0.6"/>
                <path d="M110,55 C95,80 112,102 135,92 C135,72 122,62 110,55 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.6"/>
                <use href="#bunga-cempaka" x="75" y="42" transform="rotate(135 75 42) scale(0.9)"/>
                <use href="#bunga-melati" x="128" y="68" transform="scale(1.1)"/>
                <use href="#bunga-melati" x="45" y="25" transform="scale(0.9)"/>
            </g>
            <g class="daun-gantung-1" transform="translate(35, 10)">
                <use href="#ronce-melati" />
            </g>
            <g class="daun-gantung-2" transform="translate(85, 35) scale(0.8)">
                <use href="#ronce-melati" />
            </g>
        </svg>

        <svg class="w-40 sm:w-72 h-auto -mr-3 -mt-2 sm:-mr-4 sm:-mt-3 daun-angin-kanan" viewBox="0 0 260 200" fill="none">
            <g transform="scale(-1, 1) translate(-260, 0)">
                <g class="daun-cabang">
                    <path d="M0,0 Q80,35 165,85" stroke="#8F6505" stroke-width="2.5" fill="none"/>
                    <path d="M40,18 C65,5 85,20 75,40 C55,42 45,30 40,18 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.7"/>
                    <path d="M85,42 C110,25 135,40 125,62 C100,65 90,52 85,42 Z" fill="#1E352B" stroke="#D4AF37" stroke-width="0.7"/>
                    <path d="M130,68 C155,55 180,68 172,88 C150,90 138,78 130,68 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.7"/>
                    <path d="M60,30 C45,55 60,78 82,70 C85,50 72,38 60,30 Z" fill="#3A5F50" stroke="#D4AF37" stroke-width="0.6"/>
                    <path d="M110,55 C95,80 112,102 135,92 C135,72 122,62 110,55 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.6"/>
                    <use href="#bunga-cempaka" x="75" y="42" transform="rotate(135 75 42) scale(0.9)"/>
                    <use href="#bunga-melati" x="128" y="68" transform="scale(1.1)"/>
                    <use href="#bunga-melati" x="45" y="25" transform="scale(0.9)"/>
                </g>
                <g class="daun-gantung-2" transform="translate(35, 10)">
                    <use href="#ronce-melati" />
                </g>
                <g class="daun-gantung-1" transform="translate(85, 35) scale(0.8)">
                    <use href="#ronce-melati" />
                </g>
            </g>
        </svg>
    </div>

    <!-- LIGHTBOX MODAL -->
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

    <!-- OPENING COVER MODAL -->
    <div id="cover-modal" class="fixed inset-0 z-50 bg-sogan-950 bg-batik-kawung flex flex-col justify-between items-center p-4 sm:p-8 transition-all duration-1000 ease-in-out overflow-y-auto">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_15%,#160B06_95%)] pointer-events-none"></div>

        <div class="relative z-10 text-center mt-6 sm:mt-8">
            <p class="text-emas-300 tracking-[0.3em] uppercase text-xs sm:text-sm font-medium mb-1">{{ $data->setting?->acara ?? 'Pawiwahan Ageng' }}</p>
            <div class="w-24 h-0.5 bg-gradient-to-r from-transparent via-emas-400 to-transparent mx-auto"></div>
        </div>

        <div class="relative z-10 max-w-xl w-full text-center my-auto py-4">
            <!-- ILUSTRASI RUMAH JOGLO JAWA -->
            <div class="relative w-full max-w-md mx-auto mb-4">
                <svg viewBox="0 0 500 310" class="w-full h-auto drop-shadow-[0_12px_25px_rgba(0,0,0,0.7)]">
                    <circle cx="250" cy="165" r="115" fill="url(#warmLantern)" opacity="0.35" />
                    <circle cx="250" cy="165" r="95" fill="none" stroke="url(#goldGrad)" stroke-width="0.8" stroke-dasharray="4,4" opacity="0.6"/>

                    <g class="daun-cabang" transform="translate(55, 250)">
                        <path d="M40,0 Q-10,-40 -35,-95" stroke="#4E6E58" stroke-width="2" fill="none"/>
                        <path d="M15,-25 C-15,-30 -30,-15 -10,0 C5,2 12,-12 15,-25 Z" fill="#1E352B" stroke="#D4AF37" stroke-width="0.6"/>
                        <path d="M-5,-55 C-35,-65 -48,-45 -28,-30 C-12,-25 -5,-40 -5,-55 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.6"/>
                        <path d="M-22,-82 C-45,-98 -55,-78 -38,-62 C-25,-58 -20,-70 -22,-82 Z" fill="#3A5F50" stroke="#D4AF37" stroke-width="0.6"/>
                        <path d="M0,-40 C10,-65 28,-65 20,-42 C14,-32 5,-35 0,-40 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.6"/>
                        <use href="#bunga-melati" x="-25" y="-65" />
                        <use href="#bunga-cempaka" x="-35" y="-92" transform="rotate(-35 -35 -92) scale(0.75)"/>
                    </g>

                    <g class="daun-cabang-kanan" transform="translate(445, 250)">
                        <path d="M-40,0 Q10,-40 35,-95" stroke="#4E6E58" stroke-width="2" fill="none"/>
                        <path d="M-15,-25 C15,-30 30,-15 10,0 C-5,2 -12,-12 -15,-25 Z" fill="#1E352B" stroke="#D4AF37" stroke-width="0.6"/>
                        <path d="M5,-55 C35,-65 48,-45 28,-30 C12,-25 5,-40 5,-55 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.6"/>
                        <path d="M22,-82 C45,-98 55,-78 38,-62 C25,-58 20,-70 22,-82 Z" fill="#3A5F50" stroke="#D4AF37" stroke-width="0.6"/>
                        <path d="M0,-40 C-10,-65 -28,-65 -20,-42 C-14,-32 -5,-35 0,-40 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.6"/>
                        <use href="#bunga-melati" x="25" y="-65" />
                        <use href="#bunga-cempaka" x="35" y="-92" transform="rotate(35 35 -92) scale(0.75)"/>
                    </g>

                    <!-- ARSITEKTUR RUMAH JOGLO -->
                    <g id="rumah-joglo-utama">
                        <rect x="75" y="255" width="350" height="10" rx="2" fill="#381E11" stroke="url(#goldGrad)" stroke-width="1"/>
                        <rect x="95" y="246" width="310" height="9" rx="1" fill="#4E2A18" stroke="url(#goldGrad)" stroke-width="1"/>
                        <rect x="175" y="246" width="150" height="19" fill="#24130B" stroke="url(#goldGrad)" stroke-width="0.8"/>
                        <line x1="185" y1="252" x2="315" y2="252" stroke="url(#goldGrad)" stroke-width="0.8"/>
                        <line x1="180" y1="258" x2="320" y2="258" stroke="url(#goldGrad)" stroke-width="0.8"/>

                        <rect x="135" y="160" width="230" height="86" fill="#2A150B" stroke="url(#goldGrad)" stroke-width="1"/>
                        <path d="M220,246 L220,182 C220,168 280,168 280,182 L280,246 Z" fill="#4E2A18" stroke="url(#goldGrad)" stroke-width="1.5"/>
                        <circle cx="250" cy="205" r="42" fill="url(#warmLantern)" class="cahaya-pendopo"/>

                        <g opacity="0.85" fill="#24130B">
                            <path d="M241,246 C241,226 248,226 248,246 Z"/>
                            <circle cx="244.5" cy="221" r="4.5"/>
                            <path d="M252,246 C252,228 259,228 259,246 Z"/>
                            <circle cx="255.5" cy="223" r="4"/>
                        </g>

                        <rect x="155" y="182" width="42" height="42" rx="3" fill="#1E0E07" stroke="url(#goldGrad)" stroke-width="1"/>
                        <path d="M176,182 L176,224 M155,203 L197,203" stroke="url(#goldGrad)" stroke-width="0.7"/>
                        <rect x="303" y="182" width="42" height="42" rx="3" fill="#1E0E07" stroke="url(#goldGrad)" stroke-width="1"/>
                        <path d="M324,182 L324,224 M303,203 L345,203" stroke="url(#goldGrad)" stroke-width="0.7"/>

                        <rect x="115" y="158" width="9" height="88" fill="#5C321C" stroke="url(#goldGrad)" stroke-width="0.9"/>
                        <rect x="376" y="158" width="9" height="88" fill="#5C321C" stroke="url(#goldGrad)" stroke-width="0.9"/>
                        <rect x="195" y="148" width="11" height="98" fill="#6B3B23" stroke="url(#goldGrad)" stroke-width="1.2"/>
                        <rect x="294" y="148" width="11" height="98" fill="#6B3B23" stroke="url(#goldGrad)" stroke-width="1.2"/>
                        <path d="M191,246 L209,246 L207,236 L193,236 Z" fill="url(#goldGrad)"/>
                        <path d="M291,246 L309,246 L307,236 L293,236 Z" fill="url(#goldGrad)"/>
                        <path d="M112,246 L127,246 L125,238 L114,238 Z" fill="url(#goldGrad)"/>
                        <path d="M373,246 L388,246 L386,238 L375,238 Z" fill="url(#goldGrad)"/>

                        <line x1="250" y1="150" x2="250" y2="176" stroke="url(#goldGrad)" stroke-width="1.2"/>
                        <polygon points="243,176 257,176 254,190 246,190" fill="#FFF7D6" stroke="url(#goldGrad)" stroke-width="1"/>
                        <circle cx="250" cy="183" r="14" fill="url(#warmLantern)" class="cahaya-pendopo"/>

                        <path d="M65,160 L155,112 L345,112 L435,160 Z" fill="url(#woodRoofGrad)" stroke="url(#goldGrad)" stroke-width="1.8"/>
                        <line x1="95" y1="145" x2="405" y2="145" stroke="url(#goldGrad)" stroke-width="0.6" stroke-opacity="0.5"/>
                        <line x1="125" y1="128" x2="375" y2="128" stroke="url(#goldGrad)" stroke-width="0.6" stroke-opacity="0.5"/>

                        <path d="M150,114 L212,48 L288,48 L350,114 Z" fill="url(#woodRoofGrad)" stroke="url(#goldGrad)" stroke-width="2"/>
                        <line x1="172" y1="92" x2="328" y2="92" stroke="url(#goldGrad)" stroke-width="0.6" stroke-opacity="0.5"/>
                        <line x1="192" y1="70" x2="308" y2="70" stroke="url(#goldGrad)" stroke-width="0.6" stroke-opacity="0.5"/>

                        <path d="M210,48 L290,48" stroke="url(#goldGrad)" stroke-width="3.5" stroke-linecap="round"/>
                        <path d="M250,18 L242,48 L258,48 Z" fill="url(#goldGrad)"/>
                        <circle cx="250" cy="28" r="5" fill="#FFFDF9" stroke="url(#goldGrad)" stroke-width="1.5"/>
                        <path d="M65,160 Q52,155 56,144" stroke="url(#goldGrad)" stroke-width="2" fill="none" stroke-linecap="round"/>
                        <path d="M435,160 Q448,155 444,144" stroke="url(#goldGrad)" stroke-width="2" fill="none" stroke-linecap="round"/>
                    </g>

                    <g class="daun-cabang" transform="translate(80, 265)">
                        <path d="M0,0 C-20,-15 -35,-5 -20,10 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.7"/>
                        <path d="M15,2 C35,-12 45,2 25,12 Z" fill="#1E352B" stroke="#D4AF37" stroke-width="0.7"/>
                        <use href="#bunga-cempaka" x="5" y="0" transform="scale(0.85)"/>
                        <use href="#bunga-melati" x="-12" y="5" transform="scale(1.1)"/>
                        <use href="#bunga-melati" x="22" y="6" transform="scale(0.95)"/>
                    </g>

                    <g class="daun-cabang-kanan" transform="translate(420, 265)">
                        <path d="M0,0 C20,-15 35,-5 20,10 Z" fill="#2D4A3E" stroke="#D4AF37" stroke-width="0.7"/>
                        <path d="M-15,2 C-35,-12 -45,2 -25,12 Z" fill="#1E352B" stroke="#D4AF37" stroke-width="0.7"/>
                        <use href="#bunga-cempaka" x="-5" y="0" transform="scale(0.85)"/>
                        <use href="#bunga-melati" x="12" y="5" transform="scale(1.1)"/>
                        <use href="#bunga-melati" x="-22" y="6" transform="scale(0.95)"/>
                    </g>
                </svg>
            </div>

            <!-- Nama Pasangan -->
            <h1 class="font-aksen text-5xl sm:text-6xl text-gold-gradient py-1 drop-shadow">
                {{ $coupleNames }}
            </h1>
            <p class="font-serifJawa italic text-krem-200 text-base sm:text-lg tracking-widest mt-1">
                {{ $eventDateText }}
            </p>

            <!-- Tamu Undangan -->
            <div class="mt-6 mx-auto max-w-xs bg-sogan-900/85 backdrop-blur-md border-emas-ornamen rounded-2xl p-4">
                <p class="text-xs text-krem-200/80 uppercase tracking-widest mb-1">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                <h2 id="guest-name-display" class="font-serifJawa font-bold text-xl text-emas-200 tracking-wide my-1">
                    {{ $guestName }}
                </h2>
                <p class="text-[11px] text-krem-200/60 italic">Di Tempat</p>
            </div>

            <!-- Tombol Buka Undangan -->
            <button id="btn-open-invitation" onclick="openInvitation()" class="mt-6 group relative inline-flex items-center gap-3 px-8 py-3.5 rounded-full bg-gradient-to-r from-emas-500 via-emas-400 to-emas-500 text-sogan-950 font-semibold text-sm tracking-wider uppercase shadow-[0_0_25px_rgba(212,175,55,0.45)] hover:shadow-[0_0_35px_rgba(212,175,55,0.75)] hover:scale-105 active:scale-95 transition-all duration-300">
                <i class="fa-solid fa-envelope-open-text text-base transition-transform group-hover:-rotate-12"></i>
                <span>Buka Undangan</span>
            </button>
        </div>

        <div class="relative z-10 text-center pb-2">
            <p class="text-[11px] text-emas-300/60 tracking-widest uppercase">Memayu Hayuning Bawana</p>
        </div>
    </div>

    <!-- MAIN INVITATION CONTENT -->
    <main id="main-content" class="relative z-10">

        <!-- 1. HERO SECTION -->
        <section id="beranda" class="relative min-h-screen flex flex-col justify-center items-center px-4 pt-24 pb-20 bg-sogan-950 bg-batik-kawung overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-sogan-950/80 via-transparent to-sogan-950 pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl w-full bg-sogan-900/70 backdrop-blur-sm border-emas-ornamen rounded-3xl p-6 sm:p-12 text-center">
                <svg class="w-12 h-12 absolute top-3 left-3 pointer-events-none"><use href="#ukiran-sudut"/></svg>
                <svg class="w-12 h-12 absolute top-3 right-3 pointer-events-none transform scale-x-[-1]"><use href="#ukiran-sudut"/></svg>
                <svg class="w-12 h-12 absolute bottom-3 left-3 pointer-events-none transform scale-y-[-1]"><use href="#ukiran-sudut"/></svg>
                <svg class="w-12 h-12 absolute bottom-3 right-3 pointer-events-none transform scale-[-1]"><use href="#ukiran-sudut"/></svg>

                <div class="w-20 h-28 mx-auto mb-3 gunungan-float">
                    <svg viewBox="-50 -90 100 180" class="w-full h-full">
                        <use href="#gunungan-jawa"/>
                    </svg>
                </div>

                <p class="text-emas-300 tracking-[0.28em] uppercase text-xs sm:text-sm mb-2">{{ $data->setting?->acara ?? 'Undangan Pawiwahan Ageng' }}</p>
                <h1 class="font-aksen text-5xl sm:text-7xl text-gold-gradient leading-tight py-2">
                    {{ $coupleFullNames ?? $coupleNames }}
                </h1>
                <p class="font-serifJawa text-lg sm:text-xl text-krem-200 mt-2 tracking-wide">
                    {{ $firstEvent?->lokasi ?? $firstEvent?->vanue ?? 'Yogyakarta' }}, {{ $eventDateText }}
                </p>

                <!-- Divider Bunga Melati -->
                <div class="flex items-center justify-center gap-3 my-6">
                    <div class="h-px w-16 sm:w-28 bg-gradient-to-r from-transparent to-emas-400"></div>
                    <svg class="w-7 h-7" viewBox="-15 -15 30 30"><use href="#bunga-melati"/></svg>
                    <svg class="w-9 h-9" viewBox="-25 -25 50 30"><use href="#bunga-cempaka"/></svg>
                    <svg class="w-7 h-7" viewBox="-15 -15 30 30"><use href="#bunga-melati"/></svg>
                    <div class="h-px w-16 sm:w-28 bg-gradient-to-l from-transparent to-emas-400"></div>
                </div>

                @if ($data->qoute?->qoute)
                    <blockquote class="max-w-xl mx-auto">
                        <p class="font-serifJawa italic text-base sm:text-lg text-krem-100/90 leading-relaxed">
                            "{{ $data->qoute->qoute }}"
                        </p>
                        @if ($data->qoute->kesimpulan)
                            <footer class="mt-3 text-xs uppercase tracking-widest text-emas-400 font-semibold">
                                — {{ $data->qoute->kesimpulan }} —
                            </footer>
                        @endif
                    </blockquote>
                @else
                    <blockquote class="max-w-xl mx-auto">
                        <p class="font-serifJawa italic text-base sm:text-lg text-krem-100/90 leading-relaxed">
                            "Witing tresna jalaran saka kulina. Di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya."
                        </p>
                        <footer class="mt-3 text-xs uppercase tracking-widest text-emas-400 font-semibold">
                            — QS. Ar-Rum: 21 &amp; Pepatah Jawa —
                        </footer>
                    </blockquote>
                @endif
            </div>
        </section>

        <!-- 2. PROFIL MEMPELAI -->
        <section id="mempelai" class="relative py-20 px-4 bg-krem-100 text-sogan-900 bg-batik-light overflow-hidden">
            <svg class="w-28 sm:w-40 h-auto absolute top-10 -left-4 pointer-events-none opacity-85 daun-angin-kiri" viewBox="0 0 150 200">
                <g class="daun-cabang">
                    <path d="M0,100 Q60,80 110,40" stroke="#6B3B23" stroke-width="2" fill="none"/>
                    <path d="M35,85 C50,60 75,65 65,88 C50,95 42,90 35,85 Z" fill="#2D4A3E"/>
                    <path d="M70,65 C85,40 110,45 100,68 C85,75 78,70 70,65 Z" fill="#1E352B"/>
                    <use href="#bunga-cempaka" x="105" y="42" transform="rotate(60 105 42) scale(0.8)"/>
                    <use href="#bunga-melati" x="65" y="75"/>
                </g>
            </svg>
            <svg class="w-28 sm:w-40 h-auto absolute bottom-10 -right-4 pointer-events-none opacity-85 daun-angin-kanan" viewBox="0 0 150 200">
                <g transform="scale(-1,1) translate(-150,0)">
                    <g class="daun-cabang">
                        <path d="M0,100 Q60,80 110,40" stroke="#6B3B23" stroke-width="2" fill="none"/>
                        <path d="M35,85 C50,60 75,65 65,88 C50,95 42,90 35,85 Z" fill="#2D4A3E"/>
                        <path d="M70,65 C85,40 110,45 100,68 C85,75 78,70 70,65 Z" fill="#1E352B"/>
                        <use href="#bunga-cempaka" x="105" y="42" transform="rotate(60 105 42) scale(0.8)"/>
                        <use href="#bunga-melati" x="65" y="75"/>
                    </g>
                </g>
            </svg>

            <div class="max-w-5xl mx-auto text-center relative z-10">
                <p class="text-emas-600 uppercase tracking-[0.25em] text-xs font-semibold">
                    {{ $data->teksUndangan?->salam ?? "Assalamu’alaikum Warahmatullahi Wabarakatuh" }}
                </p>
                <h2 class="font-serifJawa font-bold text-3xl sm:text-5xl text-sogan-900 mt-2">Mempelai Berbahagia</h2>
                <p class="max-w-xl mx-auto text-sogan-700 text-sm sm:text-base mt-3 leading-relaxed">
                    {{ $data->teksUndangan?->teks_satu ?? 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, perkenankanlah kami menyelenggarakan resepsi pernikahan putra-putri kami:' }}
                </p>

                <!-- Grid Mempelai Pria & Wanita (Dinamis Sesuai Urutan isWanitaFirst) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-12 items-center">
                    
                    <!-- Mempelai Pertama -->
                    <div class="bg-krem-50/90 border border-emas-400/50 rounded-3xl p-8 shadow-xl relative group hover:-translate-y-1 transition-all duration-300">
                        <div class="w-40 h-40 mx-auto relative mb-6">
                            <div class="absolute inset-0 rounded-full border-2 border-dashed border-emas-500 animate-[spin_25s_linear_infinite]"></div>
                            <div class="w-full h-full rounded-full bg-gradient-to-b from-sogan-800 to-sogan-950 p-2 flex items-center justify-center overflow-hidden shadow-inner">
                                @if ($firstPerson?->image)
                                    <img src="{{ $firstPersonImg }}" alt="{{ $firstPerson?->nama_panggilan ?? $firstPersonRole }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <svg viewBox="0 0 120 120" class="w-full h-full">
                                        <circle cx="60" cy="60" r="56" fill="none" stroke="url(#goldGrad)" stroke-width="1.5"/>
                                        @if ($isFirstPersonMale)
                                            <path d="M25,115 C25,85 95,85 95,115 Z" fill="#24130B" stroke="url(#goldGrad)" stroke-width="1.2"/>
                                            <path d="M48,88 L60,102 L72,88" fill="none" stroke="url(#goldGrad)" stroke-width="1.5"/>
                                            <circle cx="60" cy="48" r="18" fill="#E6C699"/>
                                            <path d="M40,44 C40,26 80,26 80,44 L83,48 L37,48 Z" fill="#4E2A18" stroke="url(#goldGrad)" stroke-width="1.2"/>
                                            <circle cx="60" cy="34" r="3" fill="url(#goldGrad)"/>
                                            <path d="M44,90 Q60,115 76,90" fill="none" stroke="#FFFDF9" stroke-width="3" stroke-dasharray="3,3"/>
                                        @else
                                            <ellipse cx="60" cy="45" rx="25" ry="18" fill="#1A0F0A"/>
                                            <path d="M28,115 C28,86 92,86 92,115 Z" fill="#381E11" stroke="url(#goldGrad)" stroke-width="1.2"/>
                                            <circle cx="60" cy="95" r="4.5" fill="url(#goldGrad)"/>
                                            <circle cx="60" cy="50" r="17" fill="#EDD0A8"/>
                                            <path d="M43,45 Q60,30 77,45 Q68,36 60,42 Q52,36 43,45 Z" fill="#1A0F0A"/>
                                            <line x1="60" y1="28" x2="60" y2="16" stroke="url(#goldGrad)" stroke-width="1.5"/>
                                            <circle cx="60" cy="15" r="3" fill="url(#goldGrad)"/>
                                            <path d="M77,50 Q82,72 78,92" fill="none" stroke="#FFFDF9" stroke-width="3.5" stroke-dasharray="3,3"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                            <svg class="w-8 h-8 absolute -bottom-2 right-4" viewBox="-15 -15 30 30"><use href="#bunga-melati"/></svg>
                        </div>

                        <span class="inline-block px-3 py-1 rounded-full bg-sogan-900/10 text-sogan-800 text-xs font-semibold uppercase tracking-wider mb-2 border border-emas-400/30">
                            {{ $firstPersonRole }}
                        </span>
                        <h3 class="font-aksen text-4xl text-sogan-800">{{ $firstPerson?->nama_lengkap ?? $firstPerson?->nama_panggilan ?? '' }}</h3>
                        
                        @if ($firstPerson?->deskripsi)
                            <p class="font-serifJawa text-base sm:text-lg text-sogan-800 font-semibold mt-3 leading-relaxed">
                                {{ $firstPerson->deskripsi }}
                            </p>
                        @endif

                        @if ($firstPerson?->instagram)
                            <div class="mt-4">
                                <a href="https://instagram.com/{{ ltrim($firstPerson->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sogan-900/10 hover:bg-sogan-900 text-sogan-900 hover:text-emas-300 border border-emas-400/40 text-xs font-medium transition">
                                    <i class="fa-brands fa-instagram"></i>
                                    <span>{{ '@' . ltrim($firstPerson->instagram, '@') }}</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Mempelai Kedua -->
                    <div class="bg-krem-50/90 border border-emas-400/50 rounded-3xl p-8 shadow-xl relative group hover:-translate-y-1 transition-all duration-300">
                        <div class="w-40 h-40 mx-auto relative mb-6">
                            <div class="absolute inset-0 rounded-full border-2 border-dashed border-emas-500 animate-[spin_25s_linear_infinite]"></div>
                            <div class="w-full h-full rounded-full bg-gradient-to-b from-sogan-800 to-sogan-950 p-2 flex items-center justify-center overflow-hidden shadow-inner">
                                @if ($secondPerson?->image)
                                    <img src="{{ $secondPersonImg }}" alt="{{ $secondPerson?->nama_panggilan ?? $secondPersonRole }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <svg viewBox="0 0 120 120" class="w-full h-full">
                                        <circle cx="60" cy="60" r="56" fill="none" stroke="url(#goldGrad)" stroke-width="1.5"/>
                                        @if ($isFirstPersonMale)
                                            <!-- Kedua adalah Wanita -->
                                            <ellipse cx="60" cy="45" rx="25" ry="18" fill="#1A0F0A"/>
                                            <path d="M28,115 C28,86 92,86 92,115 Z" fill="#381E11" stroke="url(#goldGrad)" stroke-width="1.2"/>
                                            <circle cx="60" cy="95" r="4.5" fill="url(#goldGrad)"/>
                                            <circle cx="60" cy="50" r="17" fill="#EDD0A8"/>
                                            <path d="M43,45 Q60,30 77,45 Q68,36 60,42 Q52,36 43,45 Z" fill="#1A0F0A"/>
                                            <line x1="60" y1="28" x2="60" y2="16" stroke="url(#goldGrad)" stroke-width="1.5"/>
                                            <circle cx="60" cy="15" r="3" fill="url(#goldGrad)"/>
                                            <path d="M77,50 Q82,72 78,92" fill="none" stroke="#FFFDF9" stroke-width="3.5" stroke-dasharray="3,3"/>
                                        @else
                                            <!-- Kedua adalah Pria -->
                                            <path d="M25,115 C25,85 95,85 95,115 Z" fill="#24130B" stroke="url(#goldGrad)" stroke-width="1.2"/>
                                            <path d="M48,88 L60,102 L72,88" fill="none" stroke="url(#goldGrad)" stroke-width="1.5"/>
                                            <circle cx="60" cy="48" r="18" fill="#E6C699"/>
                                            <path d="M40,44 C40,26 80,26 80,44 L83,48 L37,48 Z" fill="#4E2A18" stroke="url(#goldGrad)" stroke-width="1.2"/>
                                            <circle cx="60" cy="34" r="3" fill="url(#goldGrad)"/>
                                            <path d="M44,90 Q60,115 76,90" fill="none" stroke="#FFFDF9" stroke-width="3" stroke-dasharray="3,3"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                            <svg class="w-8 h-8 absolute -bottom-2 right-4" viewBox="-15 -15 30 30"><use href="#bunga-melati"/></svg>
                        </div>

                        <span class="inline-block px-3 py-1 rounded-full bg-sogan-900/10 text-sogan-800 text-xs font-semibold uppercase tracking-wider mb-2 border border-emas-400/30">
                            {{ $secondPersonRole }}
                        </span>
                        <h3 class="font-aksen text-4xl text-sogan-800">{{ $secondPerson?->nama_lengkap ?? $secondPerson?->nama_panggilan ?? '' }}</h3>
                        
                        @if ($secondPerson?->deskripsi)
                            <p class="font-serifJawa text-base sm:text-lg text-sogan-800 font-semibold mt-3 leading-relaxed">
                                {{ $secondPerson->deskripsi }}
                            </p>
                        @endif

                        @if ($secondPerson?->instagram)
                            <div class="mt-4">
                                <a href="https://instagram.com/{{ ltrim($secondPerson->instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sogan-900/10 hover:bg-sogan-900 text-sogan-900 hover:text-emas-300 border border-emas-400/40 text-xs font-medium transition">
                                    <i class="fa-brands fa-instagram"></i>
                                    <span>{{ '@' . ltrim($secondPerson->instagram, '@') }}</span>
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. RANGKAIAN ACARA & VENUE + HITUNG MUNDUR -->
        <section id="acara" class="relative py-20 px-4 bg-sogan-950 bg-batik-kawung overflow-hidden">
            <div class="max-w-4xl mx-auto text-center relative z-10">
                
                <p class="text-emas-300 uppercase tracking-[0.25em] text-xs">Insya Allah Akan Diselenggarakan Pada</p>
                <h2 class="font-serifJawa font-bold text-3xl sm:text-5xl text-gold-gradient mt-2">Rangkaian Pawiwahan</h2>

                <!-- Live Countdown Timer -->
                <div class="grid grid-cols-4 gap-3 sm:gap-6 max-w-lg mx-auto my-10">
                    <div class="bg-sogan-900/90 border-emas-ornamen rounded-2xl p-3 sm:p-4">
                        <span id="cd-days" class="block font-serifJawa font-bold text-2xl sm:text-4xl text-emas-300">00</span>
                        <span class="text-[11px] sm:text-xs uppercase tracking-wider text-krem-200/70">Hari</span>
                    </div>
                    <div class="bg-sogan-900/90 border-emas-ornamen rounded-2xl p-3 sm:p-4">
                        <span id="cd-hours" class="block font-serifJawa font-bold text-2xl sm:text-4xl text-emas-300">00</span>
                        <span class="text-[11px] sm:text-xs uppercase tracking-wider text-krem-200/70">Jam</span>
                    </div>
                    <div class="bg-sogan-900/90 border-emas-ornamen rounded-2xl p-3 sm:p-4">
                        <span id="cd-minutes" class="block font-serifJawa font-bold text-2xl sm:text-4xl text-emas-300">00</span>
                        <span class="text-[11px] sm:text-xs uppercase tracking-wider text-krem-200/70">Menit</span>
                    </div>
                    <div class="bg-sogan-900/90 border-emas-ornamen rounded-2xl p-3 sm:p-4">
                        <span id="cd-seconds" class="block font-serifJawa font-bold text-2xl sm:text-4xl text-emas-300">00</span>
                        <span class="text-[11px] sm:text-xs uppercase tracking-wider text-krem-200/70">Detik</span>
                    </div>
                </div>

                <!-- Kartu Acara Dinamis -->
                @if ($data->acara && $data->acara->isNotEmpty())
                    <div class="grid grid-cols-1 {{ $data->acara->count() > 1 ? 'md:grid-cols-2' : 'max-w-xl mx-auto' }} gap-8 mt-8">
                        @foreach ($data->acara as $acaraItem)
                            @php
                                $itemDate = $acaraItem->date ? Carbon::parse($acaraItem->date) : null;
                                $itemDateText = $itemDate ? $itemDate->translatedFormat('l, d F Y') : '';
                            @endphp
                            <div class="bg-sogan-900/80 backdrop-blur-md border-emas-ornamen rounded-3xl p-8 relative overflow-hidden text-center">
                                <svg class="w-10 h-10 absolute top-2 left-2 opacity-70"><use href="#ukiran-sudut"/></svg>
                                <svg class="w-10 h-10 absolute top-2 right-2 opacity-70 transform scale-x-[-1]"><use href="#ukiran-sudut"/></svg>

                                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-sogan-800 border border-emas-400/40 flex items-center justify-center">
                                    <i class="fa-solid fa-mosque text-2xl text-emas-300"></i>
                                </div>

                                <h3 class="font-serifJawa font-bold text-2xl sm:text-3xl text-emas-200">{{ $acaraItem->nama_acara }}</h3>
                                <div class="w-16 h-0.5 bg-emas-400/50 mx-auto my-4"></div>

                                @if ($itemDateText)
                                    <p class="font-semibold text-krem-100">{{ $itemDateText }}</p>
                                @endif
                                <p class="text-sm text-emas-300 mt-1">
                                    <i class="fa-regular fa-clock mr-1.5"></i>Pukul {{ $acaraItem->jam_start }} – {{ $acaraItem->jam_end }} {{ $acaraItem->zona_waktu ?? 'WIB' }}
                                </p>

                                <div class="mt-5 pt-5 border-t border-emas-400/20">
                                    <p class="font-serifJawa font-bold text-lg text-krem-100">{{ $acaraItem->vanue ?? $acaraItem->lokasi }}</p>
                                    @if ($acaraItem->alamat)
                                        <p class="text-xs text-krem-200/75 mt-1 leading-relaxed">{{ $acaraItem->alamat }}</p>
                                    @endif
                                </div>

                                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                                    @if ($acaraItem->maps)
                                        <a href="{{ $acaraItem->maps }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emas-500/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 transition text-xs font-semibold uppercase tracking-wider">
                                            <i class="fa-solid fa-map-location-dot"></i>
                                            <span>Google Maps</span>
                                        </a>
                                    @endif
                                    <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-sogan-800 hover:bg-emas-500/30 text-krem-200 border border-emas-400/40 transition text-xs font-semibold uppercase tracking-wider">
                                        <i class="fa-regular fa-calendar-plus"></i>
                                        <span>Simpan Kalender</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- 4. TATA LAMPAH ADICARA (RUNDOWN ACARA JIKA AKTIF) -->
        @if ($hasRundown)
            <section id="rundown" class="relative py-20 px-4 bg-krem-100 text-sogan-900 bg-batik-light overflow-hidden">
                <div class="max-w-3xl mx-auto text-center relative z-10">
                    <p class="text-emas-600 uppercase tracking-[0.25em] text-xs font-semibold">Susunan Acara</p>
                    <h2 class="font-serifJawa font-bold text-3xl sm:text-5xl text-sogan-900 mt-2">Tata Lampah Adicara</h2>
                    <p class="text-sogan-700 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                        Jadwal dan susunan prosesi acara pernikahan yang akan berlangsung:
                    </p>

                    <div class="mt-12 relative max-w-md mx-auto text-left">
                        <div class="absolute left-6 top-3 bottom-3 w-0.5 bg-emas-400/60"></div>

                        <div class="space-y-6">
                            @foreach ($activeRundowns as $rd)
                                <div class="relative flex items-start gap-5 group">
                                    <div class="w-12 h-12 rounded-full bg-sogan-900 border-2 border-emas-400 flex items-center justify-center text-emas-300 shrink-0 z-10 shadow-md">
                                        <i class="fa-solid fa-clock text-sm"></i>
                                    </div>
                                    <div class="bg-krem-50 border border-emas-400/40 rounded-2xl p-4 shadow-sm flex-1">
                                        <span class="text-xs font-bold text-emas-600 tracking-wider">
                                            {{ $rd->waktu_mulai ?? $rd->jam_start }} @if ($rd->waktu_selesai) – {{ $rd->waktu_selesai }} @endif
                                        </span>
                                        <h4 class="font-serifJawa font-bold text-lg text-sogan-900 mt-0.5">{{ $rd->nama_kegiatan ?? $rd->nama_acara }}</h4>
                                        @if ($rd->keterangan ?? $rd->deskripsi)
                                            <p class="text-xs text-sogan-700 mt-1 leading-relaxed">{{ $rd->keterangan ?? $rd->deskripsi }}</p>
                                        @endif
                                        @if ($rd->lokasi)
                                            <p class="text-[11px] text-emas-700 font-medium mt-1"><i class="fa-solid fa-location-dot mr-1"></i>{{ $rd->lokasi }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- 5. KISAH CINTA (CARIYOS KATRESNAN) -->
        @if ($hasStory)
            <section id="cerita" class="relative py-20 px-4 bg-sogan-950 bg-batik-kawung overflow-hidden">
                <div class="max-w-4xl mx-auto text-center relative z-10">
                    <p class="text-emas-300 uppercase tracking-[0.25em] text-xs">Perjalanan Kasih</p>
                    <h2 class="font-serifJawa font-bold text-3xl sm:text-5xl text-gold-gradient mt-2">Cariyos Katresnan</h2>
                    <p class="text-krem-200/80 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                        Kisah cinta yang dipintal dengan doa, kesabaran, dan restu kedua orang tua:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-{{ min(count($data->kisah), 3) }} gap-6 mt-12 text-left">
                        @foreach ($data->kisah as $sIndex => $story)
                            @php
                                $storyImg = $story->image?->image ?? $story->image;
                            @endphp
                            <div class="bg-sogan-900/80 border-emas-ornamen rounded-3xl p-6 flex flex-col justify-between group hover:-translate-y-1 transition duration-300">
                                <div>
                                    @if ($storyImg)
                                        <div class="h-44 rounded-2xl overflow-hidden mb-4 border border-emas-400/30">
                                            <img src="{{ $storageUrl($storyImg) }}" alt="{{ $story->title ?? 'Kisah Cinta' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        </div>
                                    @endif
                                    <span class="inline-block px-3 py-1 rounded-full bg-sogan-800 text-emas-300 text-xs font-semibold tracking-wider uppercase mb-2 border border-emas-400/40">
                                        Bab 0{{ $sIndex + 1 }}
                                    </span>
                                    <h3 class="font-serifJawa font-bold text-xl text-emas-200 mt-1">{{ $story->title ?? $story->judul ?? 'Kisah Cinta' }}</h3>
                                    <p class="text-xs text-krem-200/80 mt-2 leading-relaxed">
                                        {{ $story->deskripsi ?? $story->cerita ?? '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- 6. GALERI FOTO & VIDEO -->
        @if ($hasGallery)
            <section id="galeri" class="relative py-20 px-4 bg-krem-100 text-sogan-900 bg-batik-light overflow-hidden">
                <div class="max-w-5xl mx-auto text-center relative z-10">
                    <p class="text-emas-600 uppercase tracking-[0.25em] text-xs font-semibold">Dokumentasi Kenangan</p>
                    <h2 class="font-serifJawa font-bold text-3xl sm:text-5xl text-sogan-900 mt-2">Pawartos Foto &amp; Galeri</h2>
                    <p class="text-sogan-700 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                        Koleksi potret kasih dan momen bahagia kedua mempelai:
                    </p>

                    @if (count($galleryPhotos) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6 mt-12">
                            @foreach ($galleryPhotos as $pIndex => $pItem)
                                <div class="group relative aspect-[4/5] rounded-2xl overflow-hidden shadow-lg border border-emas-400/50 cursor-pointer" onclick="openLightbox('{{ $storageUrl($pItem) }}', 'Momen Foto {{ $pIndex + 1 }}')">
                                    <img src="{{ $storageUrl($pItem) }}" alt="Galeri Foto {{ $pIndex + 1 }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy">
                                    <div class="absolute inset-0 bg-sogan-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <span class="w-10 h-10 rounded-full bg-emas-400 text-sogan-950 flex items-center justify-center shadow-lg"><i class="fa-solid fa-magnifying-glass-plus"></i></span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (count($galleryVideos) > 0)
                        <div class="mt-12 space-y-6 max-w-2xl mx-auto">
                            @foreach ($galleryVideos as $vIndex => $vItem)
                                <div class="bg-krem-50 border border-emas-400/60 rounded-3xl p-6 sm:p-8 shadow-md">
                                    <h3 class="font-serifJawa font-bold text-2xl text-sogan-900 mb-2">Video Pawiwahan</h3>
                                    <div class="aspect-video w-full rounded-2xl overflow-hidden border border-emas-400/40 shadow-inner">
                                        @if (str_contains($vItem, 'youtube.com') || str_contains($vItem, 'youtu.be'))
                                            @php
                                                $ytId = '';
                                                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vItem, $match)) {
                                                    $ytId = $match[1];
                                                }
                                            @endphp
                                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}" title="Video Pawiwahan" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        @else
                                            <video class="w-full h-full object-cover" controls>
                                                <source src="{{ $storageUrl($vItem) }}" type="video/mp4">
                                            </video>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- 7. SIARAN LANGSUNG (LIVE STREAMING) -->
        @if ($data->streaming && $data->streaming->link)
            <section id="streaming" class="relative py-16 px-4 bg-sogan-950 bg-batik-kawung text-center overflow-hidden">
                <div class="max-w-2xl mx-auto bg-sogan-900/85 border-emas-ornamen rounded-3xl p-8 relative z-10">
                    <span class="inline-block px-4 py-1 rounded-full bg-emas-500/20 text-emas-300 border border-emas-400/40 text-xs uppercase tracking-widest font-semibold mb-3">
                        <i class="fa-solid fa-satellite-dish mr-1.5 animate-pulse text-red-400"></i>Virtual Attendance
                    </span>
                    <h3 class="font-serifJawa font-bold text-3xl text-gold-gradient">Siaran Langsung Pawiwahan</h3>
                    <p class="text-xs sm:text-sm text-krem-200/80 mt-3 leading-relaxed max-w-lg mx-auto">
                        Bagi para sesepuh, sanak kadang, dan sahabat yang berhalangan hadir secara langsung, dapat menyaksikan prosesi pernikahan kami secara daring:
                    </p>
                    <div class="mt-6">
                        <a href="{{ $data->streaming->link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 px-7 py-3 rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold text-xs uppercase tracking-wider shadow-lg transition">
                            <i class="fa-brands fa-youtube text-base"></i>
                            <span>Tonton Live Streaming</span>
                        </a>
                    </div>
                </div>
            </section>
        @endif

        <!-- 8. TANDA KASIH (AMPLOP DIGITAL & KADO FISIK) -->
        @if ($hasGift)
            <section id="amplop" class="relative py-20 px-4 bg-krem-100 text-sogan-900 bg-batik-light">
                <div class="max-w-3xl mx-auto text-center">
                    <p class="text-emas-600 uppercase tracking-[0.25em] text-xs font-semibold">Tanda Kasih</p>
                    <h2 class="font-serifJawa font-bold text-3xl sm:text-5xl text-sogan-900 mt-2">Amplop Digital &amp; Kado</h2>
                    <p class="text-sogan-700 text-sm sm:text-base mt-3 max-w-xl mx-auto">
                        Doa restu Bapak/Ibu/Saudara/i merupakan karunia yang sangat berarti bagi kami. Namun apabila ingin memberikan tanda kasih, dapat melalui rekening maupun alamat berikut:
                    </p>

                    @if ($data->kado && $data->kado->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-{{ min($data->kado->count(), 2) }} gap-6 mt-10">
                            @foreach ($data->kado as $kIndex => $kadoItem)
                                @php
                                    $bankName = $kadoItem->giftPay?->nama_pay ?? $kadoItem->giftPay?->nama_bank ?? $kadoItem->nama_bank ?? 'Rekening Bank';
                                    $accNo = $kadoItem->nomorPay ?? $kadoItem->no_rek ?? '';
                                    $accOwner = $kadoItem->namaPay ?? $kadoItem->atas_nama ?? $kadoItem->nama_pemilik ?? '';
                                @endphp
                                <div class="bg-sogan-900 text-krem-100 rounded-2xl p-6 border-emas-ornamen text-left relative overflow-hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="font-serifJawa font-bold text-xl text-emas-300">{{ $bankName }}</span>
                                        <i class="fa-solid fa-credit-card text-emas-400 text-xl"></i>
                                    </div>
                                    <p class="text-xs text-krem-200/70">Nomor Rekening:</p>
                                    <p id="rek-{{ $kIndex }}" class="font-mono text-xl sm:text-2xl font-semibold tracking-wider text-emas-200 my-1">{{ $accNo }}</p>
                                    @if ($accOwner)
                                        <p class="text-xs text-krem-200/90 mb-4">a.n. {{ $accOwner }}</p>
                                    @endif

                                    @if ($kadoItem->qris)
                                        <div class="mb-4">
                                            <button type="button" onclick="openLightbox('{{ $storageUrl($kadoItem->qris) }}', 'QRIS {{ $bankName }}')" class="w-full py-2 rounded-xl bg-sogan-800 hover:bg-sogan-700 text-emas-300 border border-emas-400/40 text-xs font-semibold uppercase tracking-wider transition">
                                                <i class="fa-solid fa-qrcode mr-1.5"></i>Lihat Kode QRIS
                                            </button>
                                        </div>
                                    @endif

                                    <button onclick="copyRekening('{{ $accNo }}', '{{ $bankName }}')" class="w-full py-2.5 rounded-xl bg-emas-500/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 text-xs font-semibold uppercase tracking-wider transition-all">
                                        <i class="fa-regular fa-copy mr-1.5"></i>Salin Nomor Rekening
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Kirim Kado Fisik -->
                    @if ($data->fiturKado && $data->fiturKado->alamat)
                        <div class="mt-6 bg-sogan-900 text-krem-100 rounded-2xl p-6 border-emas-ornamen text-left relative">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-serifJawa font-bold text-xl text-emas-300">Kirim Kado Fisik</span>
                                <i class="fa-solid fa-box-open text-emas-400 text-xl"></i>
                            </div>
                            <p class="text-xs text-krem-200/70">Alamat Pengiriman:</p>
                            <p id="alamat-kado" class="text-xs sm:text-sm text-krem-100 mt-1 leading-relaxed">
                                {{ $data->fiturKado->alamat }}
                            </p>
                            <div class="mt-4 text-right">
                                <button onclick="copyAlamat()" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-emas-500/20 hover:bg-emas-400 text-emas-200 hover:text-sogan-950 border border-emas-400/50 text-xs font-semibold uppercase tracking-wider transition-all">
                                    <i class="fa-regular fa-copy"></i>
                                    <span>Salin Alamat Kado</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- 9. UCAPAN, DOA & KONFIRMASI KEHADIRAN (RSVP) -->
        @if ($data->FiturUcapan?->status ?? true)
            <section id="ucapan" class="relative py-20 px-4 pb-32 bg-sogan-950 bg-batik-kawung">
                <div class="max-w-3xl mx-auto relative z-10">
                    <div class="text-center mb-10">
                        <p class="text-emas-300 uppercase tracking-[0.25em] text-xs">Atur Pangandikan &amp; Doa Restu</p>
                        <h2 class="font-serifJawa font-bold text-3xl sm:text-5xl text-gold-gradient mt-2">Konfirmasi &amp; Doa Restu</h2>
                    </div>

                    <!-- Flash Message Feedback -->
                    @if (session('success'))
                        <div class="mb-6 p-4 rounded-2xl bg-emas-500/20 border border-emas-400 text-emas-200 text-sm text-center">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 p-4 rounded-2xl bg-red-900/40 border border-red-500/50 text-red-200 text-sm text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Form RSVP -->
                    <form action="{{ route('savedoa') }}" method="POST" class="bg-sogan-900/85 border-emas-ornamen rounded-3xl p-6 sm:p-8 mb-10 space-y-4">
                        @csrf
                        <input type="hidden" name="dataId" value="{{ $data->id }}">
                        <input type="hidden" name="kode" value="{{ $kode ?? '' }}">

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-emas-300 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ $guestName !== 'Tamu Undangan' ? $guestName : '' }}" required placeholder="Tuliskan nama Anda..." class="w-full px-4 py-3 rounded-xl bg-sogan-950/90 border border-emas-400/40 text-krem-100 text-sm focus:outline-none focus:border-emas-300">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-emas-300 mb-2">Konfirmasi Kehadiran</label>
                            <select name="status" required class="w-full px-4 py-3 rounded-xl bg-sogan-950/90 border border-emas-400/40 text-krem-100 text-sm focus:outline-none focus:border-emas-300">
                                <option value="hadir">Insya Allah Hadir</option>
                                <option value="tidak_hadir">Mohon Maaf, Berhalangan Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-emas-300 mb-2">Ucapan &amp; Doa Restu</label>
                            <textarea name="ucapan" rows="3" required placeholder="Semoga menjadi keluarga Sakinah, Mawaddah, Warahmah..." class="w-full px-4 py-3 rounded-xl bg-sogan-950/90 border border-emas-400/40 text-krem-100 text-sm focus:outline-none focus:border-emas-300"></textarea>
                        </div>
                        <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-emas-500 via-emas-400 to-emas-500 text-sogan-950 font-semibold text-sm uppercase tracking-wider shadow-lg hover:brightness-110 transition-all">
                            <i class="fa-solid fa-paper-plane mr-2"></i>Kirim Ucapan &amp; Doa
                        </button>
                    </form>

                    <!-- Daftar Ucapan Tamu -->
                    @if ($ucapan && $ucapan->isNotEmpty())
                        <div id="wishes-container" class="space-y-4 max-h-96 overflow-y-auto pr-2">
                            @foreach ($ucapan as $uIndex => $uItem)
                                <div class="wish-item {{ $uIndex >= 4 ? 'hidden' : '' }} bg-sogan-900/75 border border-emas-400/30 rounded-2xl p-4 sm:p-5">
                                    <div class="flex items-center justify-between gap-2 mb-1.5">
                                        <h4 class="font-serifJawa font-bold text-lg text-emas-200">
                                            {{ $uItem->tamu?->nama ?? $uItem->nama ?? 'Tamu Undangan' }}
                                        </h4>
                                        @if ($uItem->status)
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ in_array($uItem->status, ['hadir', 'Hadir', 'Datang Dong']) ? 'bg-emas-500/25 text-emas-300 border border-emas-400/40' : 'bg-sogan-800 text-krem-200/70' }}">
                                                {{ in_array($uItem->status, ['hadir', 'Hadir', 'Datang Dong']) ? 'Hadir' : 'Tidak Hadir' }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-krem-100/90 leading-relaxed">{{ $uItem->ucapan }}</p>
                                    @if ($uItem->created_at)
                                        <span class="block text-[11px] text-krem-200/50 mt-2">
                                            <i class="fa-regular fa-clock mr-1"></i>{{ $uItem->created_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        @if ($ucapan->count() > 4)
                            <div class="mt-4 text-center">
                                <button type="button" onclick="document.querySelectorAll('.wish-item.hidden').forEach(el => el.classList.remove('hidden')); this.parentElement.remove();" class="px-5 py-2 rounded-full bg-sogan-900 hover:bg-sogan-800 border border-emas-400 text-xs uppercase tracking-widest text-emas-300 font-medium transition shadow-sm">
                                    Tampilkan Lebih Banyak
                                </button>
                            </div>
                        @endif
                    @endif

                    <!-- Penutup Matur Nuwun -->
                    <div class="text-center mt-16 pt-10 border-t border-emas-400/20">
                        <h3 class="font-aksen text-4xl sm:text-5xl text-gold-gradient">Matur Nuwun</h3>
                        <p class="font-serifJawa italic text-krem-200/80 mt-2">
                            {{ $data->teksPenutup?->teks_satu ?? 'Kami yang berbahagia, Keluarga Besar Kedua Mempelai' }}
                        </p>
                        <p class="font-serifJawa font-bold text-xl text-emas-300 mt-1">{{ $coupleNames }}</p>
                    </div>
                </div>
            </section>
        @endif

    </main>

    <!-- FLOATING AUDIO & BOTTOM NAVIGATION -->
    <button id="btn-music" onclick="toggleGamelanMusic()" title="Putar / Hentikan Musik" class="fixed bottom-24 right-5 z-40 w-12 h-12 rounded-full bg-sogan-900 border-2 border-emas-400 text-emas-300 shadow-[0_0_20px_rgba(212,175,55,0.4)] flex items-center justify-center hover:scale-110 transition-transform">
        <i id="music-icon" class="fa-solid fa-compact-disc text-xl"></i>
    </button>

    <!-- Navigasi Bawah Lengkap -->
    <nav class="fixed bottom-4 left-1/2 -translate-x-1/2 z-40 bg-sogan-900/90 backdrop-blur-md border border-emas-400/50 rounded-full px-4 sm:px-6 py-2.5 shadow-2xl flex items-center gap-4 sm:gap-6 max-w-[95vw] overflow-x-auto">
        <a href="#beranda" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-solid fa-house-chimney text-sm mb-0.5"></i>
            <span>Beranda</span>
        </a>
        <a href="#mempelai" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-solid fa-heart text-sm mb-0.5"></i>
            <span>Mempelai</span>
        </a>
        <a href="#acara" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-regular fa-calendar-check text-sm mb-0.5"></i>
            <span>Acara</span>
        </a>
        @if ($hasStory)
            <a href="#cerita" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
                <i class="fa-solid fa-book-open text-sm mb-0.5"></i>
                <span>Kisah</span>
            </a>
        @endif
        @if ($hasGallery)
            <a href="#galeri" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
                <i class="fa-regular fa-images text-sm mb-0.5"></i>
                <span>Galeri</span>
            </a>
        @endif
        @if ($hasGift)
            <a href="#amplop" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
                <i class="fa-solid fa-gift text-sm mb-0.5"></i>
                <span>Hadiah</span>
            </a>
        @endif
        <a href="#ucapan" class="flex flex-col items-center text-emas-300 hover:text-emas-100 text-[10px] sm:text-[11px] transition-colors shrink-0">
            <i class="fa-regular fa-comments text-sm mb-0.5"></i>
            <span>Ucapan</span>
        </a>
    </nav>

    <!-- Toast Notification Box -->
    <div id="toast-notification" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-sogan-900 border border-emas-400 text-emas-200 px-6 py-3 rounded-full shadow-2xl flex items-center gap-3 text-sm pointer-events-none opacity-0 -translate-y-4 transition-all duration-300">
        <i class="fa-solid fa-circle-check text-emas-400"></i>
        <span id="toast-message">Berhasil disalin!</span>
    </div>

    <!-- JAVASCRIPT LOGIC & ANIMATIONS -->
    <script>
        let isMusicPlaying = false;
        let gamelanInterval = null;
        let audioCtx = null;
        const bgAudioElement = document.getElementById('bg-music');

        function openInvitation() {
            const cover = document.getElementById('cover-modal');
            const body = document.getElementById('body-main');
            
            cover.classList.add('opacity-0', 'pointer-events-none', '-translate-y-full');
            body.classList.remove('overflow-y-hidden');
            
            startBackgroundMusic();
        }

        function playGamelanNote(freq, duration = 2.4, volume = 0.06) {
            if (!audioCtx) return;
            const now = audioCtx.currentTime;
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();

            osc.type = 'sine';
            osc.frequency.setValueAtTime(freq, now);

            gain.gain.setValueAtTime(0.001, now);
            gain.gain.exponentialRampToValueAtTime(volume, now + 0.08);
            gain.gain.exponentialRampToValueAtTime(0.0001, now + duration);

            osc.connect(gain);
            gain.connect(audioCtx.destination);

            osc.start(now);
            osc.stop(now + duration);
        }

        function startBackgroundMusic() {
            if (bgAudioElement) {
                bgAudioElement.play().then(() => {
                    isMusicPlaying = true;
                    updateMusicButtonUI();
                }).catch(() => {
                    startGamelanMelody();
                });
            } else {
                startGamelanMelody();
            }
        }

        function startGamelanMelody() {
            try {
                if (!audioCtx) {
                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }

                const pelogScale = [293.66, 311.13, 369.99, 440.00, 466.16, 587.33];
                const pattern = [0, 2, 3, 2, 4, 3, 1, 0];
                let step = 0;

                isMusicPlaying = true;
                updateMusicButtonUI();

                playGamelanNote(pelogScale[0], 3, 0.07);

                gamelanInterval = setInterval(() => {
                    if (!isMusicPlaying) return;
                    const noteFreq = pelogScale[pattern[step % pattern.length]];
                    playGamelanNote(noteFreq, 2.6, 0.055);

                    if (step % 4 === 0) {
                        playGamelanNote(146.83, 4.0, 0.08);
                    }
                    step++;
                }, 1350);
            } catch (e) {
                console.warn('Audio Context tidak diizinkan otomatis:', e);
            }
        }

        function toggleGamelanMusic() {
            if (bgAudioElement) {
                if (isMusicPlaying) {
                    bgAudioElement.pause();
                    isMusicPlaying = false;
                } else {
                    bgAudioElement.play().then(() => {
                        isMusicPlaying = true;
                    }).catch(() => {});
                }
            } else {
                if (!audioCtx) {
                    startGamelanMelody();
                    return;
                }
                isMusicPlaying = !isMusicPlaying;
            }
            updateMusicButtonUI();
            showToast(isMusicPlaying ? 'Musik diputar' : 'Musik dijeda');
        }

        function updateMusicButtonUI() {
            const icon = document.getElementById('music-icon');
            if (isMusicPlaying) {
                icon.classList.add('animate-spin');
                icon.classList.replace('fa-volume-xmark', 'fa-compact-disc');
            } else {
                icon.classList.remove('animate-spin');
                icon.classList.replace('fa-compact-disc', 'fa-volume-xmark');
            }
        }

        // Canvas Wind Particles
        const canvas = document.getElementById('wind-petals-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        class WindParticle {
            constructor() {
                this.reset(true);
            }
            reset(initial = false) {
                this.x = Math.random() * canvas.width;
                this.y = initial ? Math.random() * canvas.height : -20;
                this.size = Math.random() * 5 + 3.5;
                this.speedY = Math.random() * 0.55 + 0.25;
                this.speedX = Math.random() * 0.45 + 0.15;
                this.angle = Math.random() * Math.PI * 2;
                this.spin = (Math.random() - 0.5) * 0.015;
                this.swayOffset = Math.random() * 100;
                const rand = Math.random();
                this.type = rand < 0.55 ? 'melati' : (rand < 0.85 ? 'emas' : 'daun');
                this.opacity = Math.random() * 0.5 + 0.25;
            }
            update(tick) {
                this.y += this.speedY;
                this.x += this.speedX + Math.sin(tick * 0.012 + this.swayOffset) * 0.45;
                this.angle += this.spin;

                if (this.y > canvas.height + 20 || this.x > canvas.width + 20) {
                    this.reset(false);
                    if (Math.random() > 0.7) {
                        this.x = -15;
                        this.y = Math.random() * canvas.height * 0.6;
                    }
                }
            }
            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.angle);
                ctx.globalAlpha = this.opacity;

                if (this.type === 'melati') {
                    ctx.fillStyle = '#FFFDF9';
                    ctx.beginPath();
                    ctx.ellipse(0, 0, this.size, this.size * 0.55, 0, 0, Math.PI * 2);
                    ctx.fill();
                } else if (this.type === 'daun') {
                    ctx.fillStyle = '#3A5F50';
                    ctx.beginPath();
                    ctx.moveTo(-this.size, 0);
                    ctx.quadraticCurveTo(0, -this.size * 0.7, this.size, 0);
                    ctx.quadraticCurveTo(0, this.size * 0.7, -this.size, 0);
                    ctx.fill();
                } else {
                    ctx.fillStyle = '#D4AF37';
                    ctx.beginPath();
                    ctx.arc(0, 0, this.size * 0.4, 0, Math.PI * 2);
                    ctx.fill();
                }
                ctx.restore();
            }
        }

        for (let i = 0; i < 28; i++) {
            particles.push(new WindParticle());
        }

        let tick = 0;
        function animateWindCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            tick++;
            particles.forEach(p => {
                p.update(tick);
                p.draw();
            });
            requestAnimationFrame(animateWindCanvas);
        }

        // Countdown Timer
        const weddingDate = new Date('{{ $countdownDate }}').getTime();
        function updateCountdown() {
            const now = new Date().getTime();
            const diff = Math.max(0, weddingDate - now);

            const d = Math.floor(diff / (1000 * 60 * 60 * 24));
            const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((diff % (1000 * 60)) / 1000);

            const elD = document.getElementById('cd-days');
            const elH = document.getElementById('cd-hours');
            const elM = document.getElementById('cd-minutes');
            const elS = document.getElementById('cd-seconds');

            if (elD) elD.textContent = String(d).padStart(2, '0');
            if (elH) elH.textContent = String(h).padStart(2, '0');
            if (elM) elM.textContent = String(m).padStart(2, '0');
            if (elS) elS.textContent = String(s).padStart(2, '0');
        }
        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Toast & Copy Functions
        function showToast(message) {
            const toast = document.getElementById('toast-notification');
            document.getElementById('toast-message').textContent = message;
            toast.classList.remove('opacity-0', '-translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');

            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', '-translate-y-4');
            }, 2800);
        }

        function copyRekening(number, bankName) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(number).then(() => {
                    showToast(`Nomor Rekening ${bankName} berhasil disalin!`);
                }).catch(() => fallbackCopy(number, `Nomor Rekening ${bankName} berhasil disalin!`));
            } else {
                fallbackCopy(number, `Nomor Rekening ${bankName} berhasil disalin!`);
            }
        }

        function copyAlamat() {
            const text = document.getElementById('alamat-kado')?.innerText?.trim();
            if (!text) return;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast('Alamat kado fisik berhasil disalin!');
                }).catch(() => fallbackCopy(text, 'Alamat kado fisik berhasil disalin!'));
            } else {
                fallbackCopy(text, 'Alamat kado fisik berhasil disalin!');
            }
        }

        function fallbackCopy(text, msg) {
            const temp = document.createElement('textarea');
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            showToast(msg);
        }

        // Lightbox Functions
        const galleryList = @json(array_map(fn($p) => ['src' => $storageUrl($p), 'caption' => 'Galeri Foto'], $galleryPhotos));
        let currentLightboxIndex = 0;

        function openLightbox(src, caption) {
            const modal = document.getElementById('lightbox-modal');
            const img = document.getElementById('lightbox-img');
            const cap = document.getElementById('lightbox-caption');

            currentLightboxIndex = galleryList.findIndex(i => i.src === src);
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
            if (!galleryList.length) return;
            currentLightboxIndex = (currentLightboxIndex + step + galleryList.length) % galleryList.length;
            const item = galleryList[currentLightboxIndex];
            document.getElementById('lightbox-img').src = item.src;
            document.getElementById('lightbox-caption').textContent = item.caption;
        }

        window.onload = function () {
            animateWindCanvas();
        };
    </script>
</body>
</html>

