<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @php
    use Carbon\Carbon;
    Carbon::setLocale('id');

    $storageUrl = fn($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;

    $birthday = $data->birthdayProfile;
    $childName = $birthday?->name ?? $data->title ?? 'Kapten Leo Pratama';
    $childNickname = $birthday?->nickname ?? $childName;
    $childAge = $birthday?->age ?? '5';
    $parentsName = $birthday?->parent_name ?? ($data->setting?->orang_tua ?? '');
    $greeting = $birthday?->description ?? $data->teksUndangan?->teks ?? 'Halo teman-teman dan keluarga terkasih! Kami mengundang kalian semua menjadi kru astronot spesial untuk merayakan petualangan ruang angkasa penuh tawa, kue bulan, dan sulap kosmik!';
    $headline = $data->eventDetail?->headline ?? 'Misi Ulang Tahun Antariksa';
    $dressCode = $data->eventDetail?->dress_code ?? 'Biru / Putih / Kosmik';

    $childPhoto = $storageUrl($birthday?->photo) ?? 
                  $storageUrl($data->coverUndangan?->cover_satu) ?? 
                  ((count($poto ?? []) ? $storageUrl($poto[0]) : null) ?? asset('tema/astronot/assets/images/captain-avatar.webp'));

    $heroPhoto = $storageUrl($data->coverUndangan?->cover_dua) ?? 
                 ((count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null) ?? $childPhoto);

    $firstEvent = $data->acara?->first();
    $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
    $eventTime = $firstEvent?->jam_start ?: '15:00';
    $eventEndTime = $firstEvent?->jam_end ?: 'Selesai';
    $timezone = $firstEvent?->zona_waktu ?: 'WIB';
    $eventDateText = $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Minggu, 15 November 2026';
    $countdownDate = $eventDate
        ? Carbon::parse($firstEvent->date . ' ' . (preg_match('/^\d{1,2}:\d{2}/', $eventTime) ? $eventTime : '00:00'))->format('Y-m-d\TH:i:s')
        : now()->addDays(20)->format('Y-m-d\TH:i:s');

    $venueName = $firstEvent?->vanue ?? $firstEvent?->lokasi ?? 'Starlight Kids Cafe & Hall';
    $venueAddress = $firstEvent?->alamat ?? 'Jakarta';
    $venueMaps = $firstEvent?->maps ?? ($firstEvent?->link_map ?? 'https://maps.google.com');

    $pageTitle = "{$headline} — {$childNickname} ke-{$childAge}";
    $guestName = $tamu ?? 'Sahabat Petualang';
    $activeRundowns = $rundowns ?? collect();
    $bgMusicUrl = $data->sound?->audio ? asset('storage/' . $data->sound->audio) : null;

    $galleryPhotos = count($poto ?? []) ? $poto : $data->galery->pluck('poto')->filter()->values()->toArray();
  @endphp
  <title>{{ $pageTitle }}</title>
  <meta name="robots" content="noindex, nofollow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:site_name" content="Wayae Nikah">
  <meta property="og:title" content="{{ $data->title ?? $pageTitle }}">
  <meta property="og:description" content="Misi Ulang Tahun ke-{{ $childAge }} {{ $childNickname }} pada {{ $eventDateText }}.">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="website">
  @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title ?? $pageTitle])

  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            display: ['Fredoka', 'sans-serif'],
          },
          colors: {
            space: {
              950: '#060818',
              900: '#0B102B',
              800: '#131C47',
              700: '#1E2B67',
            },
            nebula: {
              cyan: '#38BDF8',
              orange: '#FB923C',
              amber: '#FBBF24',
              purple: '#A855F7',
              pink: '#F472B6',
            }
          }
        }
      }
    }
  </script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #060818;
      color: #F8FAFC;
      overflow-x: hidden;
    }
    .font-display {
      font-family: 'Fredoka', sans-serif;
    }
    @keyframes floatSlow {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-12px) rotate(2deg); }
    }
    @keyframes floatReverse {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(10px) rotate(-3deg); }
    }
    @keyframes pulseGlow {
      0%, 100% { box-shadow: 0 0 20px rgba(56, 189, 248, 0.35), 0 0 40px rgba(168, 85, 247, 0.2); }
      50% { box-shadow: 0 0 30px rgba(251, 146, 60, 0.55), 0 0 60px rgba(56, 189, 248, 0.4); }
    }
    .animate-float {
      animation: floatSlow 5s ease-in-out infinite;
    }
    .animate-float-reverse {
      animation: floatReverse 6s ease-in-out infinite;
    }
    .animate-glow {
      animation: pulseGlow 4s ease-in-out infinite;
    }
    .glass-card {
      background: rgba(19, 28, 71, 0.68);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(148, 163, 184, 0.2);
    }
    .glass-pill {
      background: rgba(11, 16, 43, 0.82);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(56, 189, 248, 0.3);
    }
    .cosmic-bg {
      background:
        radial-gradient(circle at 15% 20%, rgba(168, 85, 247, 0.22) 0%, transparent 40%),
        radial-gradient(circle at 85% 15%, rgba(56, 189, 248, 0.20) 0%, transparent 38%),
        radial-gradient(circle at 50% 60%, rgba(251, 146, 60, 0.12) 0%, transparent 45%),
        radial-gradient(circle at 20% 85%, rgba(244, 114, 182, 0.16) 0%, transparent 40%),
        linear-gradient(180deg, #060818 0%, #0B102B 50%, #060818 100%);
    }
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #060818;
    }
    ::-webkit-scrollbar-thumb {
      background: #1E2B67;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #38BDF8;
    }
  </style>
</head>
<body class="cosmic-bg min-h-screen text-slate-100 selection:bg-sky-400 selection:text-slate-950 relative">

  <!-- Background Music Tag -->
  @if ($bgMusicUrl)
    <audio id="bg-music" src="{{ $bgMusicUrl }}" loop preload="auto"></audio>
  @endif

  <!-- Animated Starfield Background Canvas -->
  <canvas id="starfieldCanvas" class="fixed inset-0 pointer-events-none z-0"></canvas>

  <!-- ========================================== -->
  <!-- 1. FULLSCREEN OPENING COVER GATE           -->
  <!-- ========================================== -->
  <div id="coverGate" class="fixed inset-0 z-50 flex items-center justify-center p-4 cosmic-bg transition-all duration-700">
    <div class="max-w-md w-full glass-card rounded-3xl p-6 sm:p-8 text-center relative overflow-hidden shadow-2xl border border-sky-400/30">
      <!-- Decorative glowing orbs -->
      <div class="absolute -top-16 -right-16 w-36 h-36 bg-purple-500/30 rounded-full blur-2xl pointer-events-none"></div>
      <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-sky-400/30 rounded-full blur-2xl pointer-events-none"></div>

      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/20 border border-sky-400/40 text-sky-300 text-xs font-semibold tracking-wider uppercase mb-4">
        <span>🚀</span> Panggilan Misi Antariksa
      </div>

      <div class="relative w-36 h-36 sm:w-44 sm:h-44 mx-auto mb-5 rounded-full p-1.5 bg-gradient-to-tr from-amber-400 via-sky-400 to-purple-500 animate-glow">
        <img
          src="{{ $childPhoto }}"
          alt="{{ $childName }}"
          class="w-full h-full object-cover rounded-full border-4 border-space-950"
        />
        <div class="absolute -bottom-2 -right-1 bg-amber-400 text-slate-950 text-xs font-bold px-3 py-1 rounded-full shadow-lg border-2 border-space-950">
          {{ $childAge }} Tahun!
        </div>
      </div>

      <h1 class="font-display font-bold text-2xl sm:text-3xl text-white tracking-wide">
        {{ $childName }}
      </h1>
      <p class="text-xs sm:text-sm text-sky-200 mt-1">
        Misi Ulang Tahun ke-<span class="font-semibold text-amber-300">{{ $childAge }}</span> di Galaksi Ceria
      </p>

      <div class="mt-6 p-4 rounded-2xl bg-space-900/80 border border-slate-700/80 text-left space-y-1">
        <p class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Kepada Rekan Astronot:</p>
        <p id="coverGuestName" class="font-display font-semibold text-base sm:text-lg text-sky-300">
          {{ $guestName }}
        </p>
      </div>

      <button
        id="openInvitationBtn"
        type="button"
        onclick="window.astronotOpenGate()"
        class="mt-6 w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-sky-400 via-cyan-400 to-amber-400 hover:from-sky-300 hover:to-amber-300 text-slate-950 font-display font-bold text-sm tracking-wider uppercase shadow-xl hover:shadow-cyan-500/40 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-200 flex items-center justify-center gap-2"
      >
        <span>Buka Akses Kontrol</span>
        <span class="text-base">🚀</span>
      </button>

      @if ($parentsName)
        <p class="text-[11px] text-slate-400 mt-4 flex items-center justify-center gap-1">
          <span>👨‍🚀</span> Disiapkan oleh {{ $parentsName }}
        </p>
      @endif
    </div>
  </div>

  <!-- ========================================== -->
  <!-- 2. STICKY TOP HEADER                       -->
  <!-- ========================================== -->
  <header class="sticky top-0 z-30 glass-pill border-b border-slate-800/80">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3">
      <a href="#beranda" class="flex items-center gap-2.5">
        <span class="text-2xl animate-float">🛸</span>
        <div>
          <p class="font-display font-bold text-sm sm:text-base text-white tracking-wide leading-none">
            {{ $childNickname }}
          </p>
          <p class="text-[10px] text-sky-300 mt-0.5 font-medium tracking-wider">HUT KE-{{ $childAge }}</p>
        </div>
      </a>

      <nav class="hidden md:flex items-center gap-1 text-xs font-medium text-slate-300">
        <a href="#beranda" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Beranda</a>
        @if ($firstEvent)
          <a href="#jadwal" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Waktu &amp; Lokasi</a>
        @endif
        @if ($activeRundowns->isNotEmpty())
          <a href="#rundown" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Misi Acara</a>
        @endif
        @if (count($galleryPhotos) > 0)
          <a href="#galeri" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Galeri</a>
        @endif
        @if ($data->FiturUcapan?->status ?? true)
          <a href="#rsvp" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">RSVP &amp; Doa</a>
        @endif
        @if ($data->fiturKado || ($data->kado && $data->kado->isNotEmpty()))
          <a href="#kado" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Tanda Kasih</a>
        @endif
      </nav>

      <div class="flex items-center gap-2">
        <button
          id="toggleAudioBtn"
          type="button"
          class="px-3 py-1.5 rounded-xl bg-space-800/90 border border-sky-400/40 text-xs font-semibold text-sky-200 hover:bg-sky-500/20 hover:text-white transition flex items-center gap-1.5"
          title="Nyalakan/Matikan Musik Kosmik"
        >
          <span id="audioIcon">🎵</span>
          <span id="audioLabel" class="hidden sm:inline">Musik</span>
        </button>

        <button
          id="launchConfettiBtn"
          type="button"
          class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-amber-400 to-orange-400 text-slate-950 font-bold text-xs hover:brightness-110 transition shadow-md flex items-center gap-1"
          title="Luncurkan Kembang Api Antariksa!"
        >
          <span>✨</span>
          <span class="hidden sm:inline">Roket!</span>
        </button>
      </div>
    </div>
  </header>

  <!-- ========================================== -->
  <!-- 3. MAIN CONTENT CONTAINER                  -->
  <!-- ========================================== -->
  <main class="relative z-10 max-w-5xl mx-auto px-4 pt-6 pb-28 md:pb-16 space-y-16 sm:space-y-24">

    <!-- BERANDA / HERO SECTION -->
    <section id="beranda" class="pt-2 sm:pt-6">
      <div class="glass-card rounded-3xl p-6 sm:p-10 lg:p-12 relative overflow-hidden border border-sky-400/25">
        <!-- Floating planets illustrations -->
        <div class="absolute -top-10 -right-10 w-36 h-36 sm:w-48 sm:h-48 rounded-full bg-gradient-to-br from-purple-600/30 to-pink-500/20 blur-xl pointer-events-none animate-float"></div>
        <div class="absolute -bottom-10 -left-10 w-36 h-36 sm:w-48 sm:h-48 rounded-full bg-gradient-to-tr from-sky-400/30 to-cyan-300/10 blur-xl pointer-events-none animate-float-reverse"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
          <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/15 border border-sky-400/30 text-sky-300 text-xs font-semibold tracking-wider uppercase">
              <span>🛰️</span> {{ $headline }}
            </div>

            <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white leading-tight">
              Yuk, Ikut Jelajah Galaksi Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-300 via-amber-300 to-orange-300">{{ $childName }}</span>!
            </h2>

            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
              {{ $greeting }}
            </p>

            <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-3">
              @if ($firstEvent)
                <a
                  href="#jadwal"
                  class="px-5 py-2.5 rounded-xl bg-sky-400 hover:bg-sky-300 text-slate-950 font-display font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-sky-400/20"
                >
                  Lihat Jadwal Misi 🪐
                </a>
              @endif
              <a
                href="#rsvp"
                class="px-5 py-2.5 rounded-xl bg-space-800/90 hover:bg-space-700 text-sky-200 border border-slate-700 font-display font-semibold text-xs uppercase tracking-wider transition"
              >
                Konfirmasi Kehadiran 📝
              </a>
            </div>

            <!-- Countdown Panel -->
            @if ($eventDate)
              <div class="pt-4">
                <p class="text-xs uppercase tracking-widest text-slate-400 font-semibold mb-3">
                  Waktu Menuju Peluncuran Roket (T-Minus):
                </p>
                <div class="grid grid-cols-4 gap-2 sm:gap-3 max-w-sm mx-auto lg:mx-0">
                  <div class="bg-space-900/90 border border-slate-700/80 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span id="cdDays" class="font-display font-bold text-xl sm:text-2xl text-amber-300 block">00</span>
                    <span class="text-[10px] text-slate-400 uppercase font-medium">Hari</span>
                  </div>
                  <div class="bg-space-900/90 border border-slate-700/80 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span id="cdHours" class="font-display font-bold text-xl sm:text-2xl text-sky-300 block">00</span>
                    <span class="text-[10px] text-slate-400 uppercase font-medium">Jam</span>
                  </div>
                  <div class="bg-space-900/90 border border-slate-700/80 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span id="cdMinutes" class="font-display font-bold text-xl sm:text-2xl text-purple-300 block">00</span>
                    <span class="text-[10px] text-slate-400 uppercase font-medium">Menit</span>
                  </div>
                  <div class="bg-space-900/90 border border-slate-700/80 rounded-2xl p-2.5 sm:p-3 text-center">
                    <span id="cdSeconds" class="font-display font-bold text-xl sm:text-2xl text-pink-300 block">00</span>
                    <span class="text-[10px] text-slate-400 uppercase font-medium">Detik</span>
                  </div>
                </div>
              </div>
            @endif
          </div>

          <div class="lg:col-span-5 flex justify-center">
            <div class="relative w-64 sm:w-72 lg:w-80 aspect-square">
              <div class="absolute inset-0 rounded-3xl bg-gradient-to-tr from-sky-400 to-purple-600 blur-2xl opacity-40 animate-pulse"></div>
              <img
                src="{{ $heroPhoto }}"
                alt="{{ $childName }}"
                class="w-full h-full object-cover rounded-3xl border-4 border-sky-400/50 shadow-2xl relative z-10"
              />
              <div class="absolute -bottom-3 -right-3 z-20 bg-space-900/95 border border-amber-400/50 rounded-2xl p-3 shadow-xl backdrop-blur-md flex items-center gap-2">
                <span class="text-2xl">🎂</span>
                <div>
                  <p class="text-[10px] text-slate-400 uppercase font-medium">Target Misi</p>
                  <p class="font-display font-bold text-xs text-amber-300">Tiup Lilin ke-{{ $childAge }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================================== -->
    <!-- 4. WAKTU & STASIUN RUANG ANGKASA (ACARA)   -->
    <!-- ========================================== -->
    @if ($data->acara && $data->acara->isNotEmpty())
      <section id="jadwal" class="space-y-8">
        <div class="text-center space-y-2">
          <span class="px-3.5 py-1 rounded-full bg-purple-500/20 border border-purple-400/30 text-purple-300 text-xs font-semibold uppercase tracking-wider">
            Koordinat Acara
          </span>
          <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
            Waktu &amp; Stasiun Ruang Angkasa
          </h3>
          <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
            Pastikan pakaian antariksa siap sebelum meluncur ke lokasi pendaratan pesta.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <!-- Tanggal & Waktu -->
          <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border border-sky-400/25 hover:border-sky-400/50 transition">
            <div class="space-y-3">
              <div class="w-12 h-12 rounded-2xl bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-2xl">
                📅
              </div>
              <h4 class="font-display font-bold text-lg text-white">Waktu &amp; Tanggal</h4>
              <p class="text-xs text-slate-300">
                Peluncuran dijadwalkan pada:
              </p>
              <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-1">
                <p class="font-display font-bold text-sky-300 text-base">{{ $eventDateText }}</p>
                <p class="text-xs text-amber-300 font-medium">Pukul {{ $eventTime }} – {{ $eventEndTime }} {{ $timezone }}</p>
              </div>
            </div>
            @php
              $calStartDate = $eventDate ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Ymd\THis') : now()->format('Ymd\THis');
              $calEndDate = $eventDate ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->addHours(3)->format('Ymd\THis') : now()->addHours(3)->format('Ymd\THis');
              $calTitle = urlencode("Ulang Tahun {$childName} ke-{$childAge}");
              $calLocation = urlencode(($venueName ? $venueName . ', ' : '') . ($venueAddress ?? ''));
              $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calStartDate}/{$calEndDate}&details={$calTitle}&location={$calLocation}";
            @endphp
            <a
              href="{{ $googleCalUrl }}"
              target="_blank"
              rel="noopener noreferrer"
              class="mt-5 w-full py-2.5 px-4 rounded-xl bg-sky-500/20 hover:bg-sky-500/30 border border-sky-400/40 text-xs font-semibold text-sky-200 transition flex items-center justify-center gap-1.5"
            >
              <span>Simpan ke Kalender</span>
              <span>🗓️</span>
            </a>
          </div>

          <!-- Lokasi Pesta -->
          <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border border-purple-400/25 hover:border-purple-400/50 transition">
            <div class="space-y-3">
              <div class="w-12 h-12 rounded-2xl bg-purple-500/20 border border-purple-400/30 flex items-center justify-center text-2xl">
                🪐
              </div>
              <h4 class="font-display font-bold text-lg text-white">Stasiun Pesta</h4>
              <p class="text-xs text-slate-300">
                Stasiun ruang angkasa bertempat di:
              </p>
              <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-1">
                <p class="font-display font-bold text-purple-300 text-base">{{ $venueName }}</p>
                @if ($venueAddress)
                  <p class="text-xs text-slate-300 leading-relaxed">{{ $venueAddress }}</p>
                @endif
              </div>
            </div>
            <a
              href="{{ $venueMaps }}"
              target="_blank"
              rel="noopener noreferrer"
              class="mt-5 w-full py-2.5 px-4 rounded-xl bg-purple-500/20 hover:bg-purple-500/30 border border-purple-400/40 text-xs font-semibold text-purple-200 transition flex items-center justify-center gap-1.5"
            >
              <span>Buka Peta Stasiun</span>
              <span>🗺️</span>
            </a>
          </div>

          <!-- Dress Code -->
          <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border border-amber-400/25 hover:border-amber-400/50 transition">
            <div class="space-y-3">
              <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-2xl">
                🧑‍🚀
              </div>
              <h4 class="font-display font-bold text-lg text-white">Kode Seragam Kru</h4>
              <p class="text-xs text-slate-300">
                Kenakan pakaian antariksa terbaikmu:
              </p>
              <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-2">
                <p class="font-display font-bold text-amber-300 text-base">{{ $dressCode }}</p>
                <p class="text-xs text-slate-300 leading-relaxed">
                  Boleh mengenakan kostum astronot, alien lucu, atau pakaian bernuansa luar angkasa!
                </p>
              </div>
            </div>
            <div class="mt-5 py-2.5 px-3 rounded-xl bg-amber-400/10 border border-amber-400/20 text-[11px] text-amber-300 text-center font-medium">
              ✨ Disediakan bando bintang &amp; stiker antariksa di pintu masuk!
            </div>
          </div>
        </div>
      </section>
    @endif

    <!-- ========================================== -->
    <!-- 5. TAHAPAN MISI ANTARIKSA (RUNDOWN)        -->
    <!-- ========================================== -->
    @if ($activeRundowns->isNotEmpty())
      <section id="rundown" class="space-y-8">
        <div class="text-center space-y-2">
          <span class="px-3.5 py-1 rounded-full bg-cyan-500/20 border border-cyan-400/30 text-cyan-300 text-xs font-semibold uppercase tracking-wider">
            Timeline Kegiatan
          </span>
          <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
            Tahapan Misi Antariksa
          </h3>
          <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
            Susunan agenda kegiatan yang dirancang untuk keseruan seluruh kru astronot cilik.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          @foreach ($activeRundowns as $rdIdx => $rd)
            <div class="glass-card rounded-3xl p-5 border border-slate-700/80 relative overflow-hidden group hover:border-sky-400/50 transition">
              <div class="flex items-center justify-between mb-3">
                <span class="w-8 h-8 rounded-full bg-sky-500/20 text-sky-300 font-display font-bold text-sm flex items-center justify-center">
                  {{ str_pad($rdIdx + 1, 2, '0', STR_PAD_LEFT) }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-sky-300 text-[11px] font-semibold border border-sky-400/30">
                  {{ $rd->waktu_mulai ?? $rd->jam_start }}{{ ($rd->waktu_selesai ?? $rd->jam_end) ? ' - ' . ($rd->waktu_selesai ?? $rd->jam_end) : '' }}
                </span>
              </div>
              <h4 class="font-display font-bold text-base text-white group-hover:text-sky-300 transition">
                {{ $rd->nama_kegiatan ?? $rd->nama_acara }}
              </h4>
              @if ($rd->keterangan ?? $rd->deskripsi)
                <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                  {{ $rd->keterangan ?? $rd->deskripsi }}
                </p>
              @endif
              @if ($rd->lokasi)
                <p class="text-[11px] text-slate-400 mt-3 font-medium">📍 {{ $rd->lokasi }}</p>
              @endif
            </div>
          @endforeach
        </div>
      </section>
    @endif

    <!-- ========================================== -->
    <!-- 6. GALERI MISI KAPTEN CILIK               -->
    <!-- ========================================== -->
    @if (count($galleryPhotos) > 0)
      <section id="galeri" class="space-y-8">
        <div class="text-center space-y-2">
          <span class="px-3.5 py-1 rounded-full bg-pink-500/20 border border-pink-400/30 text-pink-300 text-xs font-semibold uppercase tracking-wider">
            Momen Ceria
          </span>
          <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
            Galeri Misi Kapten Cilik
          </h3>
          <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
            Kilas balik kenangan manis perjalanan ceria {{ $childNickname }}.
          </p>
        </div>

        <div id="galleryGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          @foreach ($galleryPhotos as $gIdx => $gPhoto)
            <div class="gallery-item group relative rounded-3xl overflow-hidden glass-card border border-sky-400/30 cursor-pointer aspect-square" data-caption="Momen Ceria {{ $childNickname }} #{{ $gIdx + 1 }}">
              <img
                src="{{ $storageUrl($gPhoto) }}"
                alt="Foto {{ $gIdx + 1 }}"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                loading="lazy"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-space-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                <p class="text-xs text-white font-medium">✨ Momen Ceria {{ $childNickname }} #{{ $gIdx + 1 }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </section>
    @endif

    <!-- ========================================== -->
    <!-- 7. RSVP & DO SAHABAT ASTRONOT             -->
    <!-- ========================================== -->
    @if ($data->FiturUcapan?->status ?? true)
      <section id="rsvp" class="space-y-8">
        <div class="text-center space-y-2">
          <span class="px-3.5 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold uppercase tracking-wider">
            Konfirmasi Kehadiran
          </span>
          <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
            RSVP &amp; Doa Sahabat Astronot
          </h3>
          <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
            Bantu kami menyiapkan porsi makanan lezat &amp; suvenir dengan mengonfirmasi kehadiran kru.
          </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          <!-- Form Kehadiran -->
          <div class="lg:col-span-5 glass-card rounded-3xl p-6 sm:p-7 border border-sky-400/30">
            <h4 class="font-display font-bold text-lg text-white mb-1 flex items-center gap-2">
              <span>🧑‍🚀</span> Formulir Kehadiran Kru
            </h4>
            <p class="text-xs text-slate-300 mb-5">Kirimkan konfirmasi &amp; doa terbaik untuk {{ $childNickname }}.</p>

            <form action="{{ route('savedoa') }}" method="POST" class="space-y-4">
              @csrf
              <input type="hidden" name="dataId" value="{{ $data->id }}">
              <input type="hidden" name="kode" value="{{ $kode ?? '' }}">

              <div>
                <label for="rsvpName" class="block text-xs font-semibold text-slate-300 mb-1.5">Nama Lengkap / Keluarga</label>
                <input
                  type="text"
                  name="nama"
                  id="rsvpName"
                  value="{{ $guestName !== 'Sahabat Petualang' && $guestName !== 'Tamu Undangan' ? $guestName : '' }}"
                  required
                  placeholder="Contoh: Sarah &amp; Kenzie"
                  class="w-full px-4 py-2.5 rounded-xl bg-space-950/80 border border-slate-700 text-sm text-white focus:outline-none focus:border-sky-400 transition"
                />
              </div>

              <div>
                <label for="rsvpStatus" class="block text-xs font-semibold text-slate-300 mb-1.5">Konfirmasi Kehadiran</label>
                <select
                  name="status"
                  id="rsvpStatus"
                  required
                  class="w-full px-3 py-2.5 rounded-xl bg-space-950/80 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-sky-400 transition"
                >
                  <option value="hadir">🚀 Ya, Pasti Hadir</option>
                  <option value="ragu">🤔 Masih Ragu</option>
                  <option value="tidak_hadir">🛸 Maaf, Berhalangan Hadir</option>
                </select>
              </div>

              <div>
                <label for="rsvpMessage" class="block text-xs font-semibold text-slate-300 mb-1.5">Pesan Doa &amp; Ucapan</label>
                <textarea
                  name="ucapan"
                  id="rsvpMessage"
                  rows="3"
                  required
                  placeholder="Tuliskan harapan dan doa terbaik untuk {{ $childNickname }}..."
                  class="w-full px-4 py-2.5 rounded-xl bg-space-950/80 border border-slate-700 text-sm text-white focus:outline-none focus:border-sky-400 transition resize-none"
                ></textarea>
              </div>

              <button
                type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-400 to-cyan-400 hover:from-sky-300 hover:to-cyan-300 text-slate-950 font-display font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-sky-400/25 flex items-center justify-center gap-1.5"
              >
                <span>Kirim Doa &amp; Konfirmasi</span>
                <span>🛰️</span>
              </button>
            </form>
          </div>

          <!-- Daftar Doa / Guestbook Feed -->
          <div class="lg:col-span-7 glass-card rounded-3xl p-6 sm:p-7 border border-purple-400/30 space-y-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div>
                <h4 class="font-display font-bold text-lg text-white">Pesan dari Kru Antariksa</h4>
                <p class="text-xs text-slate-300">
                  Total <span class="font-bold text-sky-300">{{ $ucapan ? $ucapan->count() : 0 }}</span> Ucapan Masuk
                </p>
              </div>
            </div>

            @if ($ucapan && $ucapan->isNotEmpty())
              <div id="guestbookList" class="space-y-3 max-h-[420px] overflow-y-auto pr-1">
                @foreach ($ucapan as $uIdx => $uItem)
                  @php
                    $isHadir = in_array(strtolower($uItem->status), ['hadir', 'datang dong']);
                    $isRagu = strtolower($uItem->status) === 'ragu';
                  @endphp
                  <div class="wish-item {{ $uIdx >= 5 ? 'hidden' : '' }} bg-space-950/75 border border-slate-800 rounded-2xl p-4 space-y-2">
                    <div class="flex items-start justify-between gap-2">
                      <div>
                        <h5 class="font-display font-bold text-sm text-white">{{ $uItem->tamu?->nama ?? $uItem->nama ?? 'Kru Astronot' }}</h5>
                        <p class="text-[11px] text-slate-400">{{ $uItem->created_at ? $uItem->created_at->diffForHumans() : '' }}</p>
                      </div>
                      <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $isHadir ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' : ($isRagu ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : 'bg-rose-500/20 text-rose-300 border-rose-500/30') }}">
                        {{ $isHadir ? 'Hadir' : ($isRagu ? 'Ragu' : 'Tidak Hadir') }}
                      </span>
                    </div>
                    <p class="text-xs text-slate-200 leading-relaxed">{{ $uItem->ucapan }}</p>
                  </div>
                @endforeach
              </div>

              @if ($ucapan->count() > 5)
                <div class="pt-2 text-center">
                  <button
                    type="button"
                    onclick="document.querySelectorAll('.wish-item.hidden').forEach(el => el.classList.remove('hidden')); this.parentElement.remove();"
                    class="px-5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-sky-300 text-xs font-semibold border border-slate-700 transition"
                  >
                    Tampilkan Semua Ucapan ({{ $ucapan->count() }})
                  </button>
                </div>
              @endif
            @else
              <div class="text-center py-8 text-xs text-slate-400">
                Belum ada ucapan. Jadilah kru pertama yang mengirimkan doa untuk {{ $childNickname }}! 🚀
              </div>
            @endif
          </div>
        </div>
      </section>
    @endif

    <!-- ========================================== -->
    <!-- 8. TITIP KADO / TANDA KASIH ANTARIKSA      -->
    <!-- ========================================== -->
    @if ($data->fiturKado || ($data->kado && $data->kado->isNotEmpty()))
      <section id="kado" class="space-y-8">
        <div class="text-center space-y-2">
          <span class="px-3.5 py-1 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-300 text-xs font-semibold uppercase tracking-wider">
            Tanda Kasih
          </span>
          <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
            Kado Antariksa untuk {{ $childNickname }}
          </h3>
          <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
            Kehadiran dan doa teman-teman adalah kado terindah bagi kami. Namun bagi yang ingin mengirimkan kado spesial, dapat melalui saluran berikut:
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl mx-auto">
          <!-- Rekening Bank -->
          @if ($data->kado && $data->kado->isNotEmpty())
            @foreach ($data->kado as $kIdx => $kadoItem)
              @php
                $bankName = $kadoItem->giftPay?->nama_pay ?? $kadoItem->giftPay?->nama_bank ?? $kadoItem->nama_bank ?? 'Rekening Bank';
                $accNo = $kadoItem->nomorPay ?? $kadoItem->no_rek ?? '';
                $accOwner = $kadoItem->namaPay ?? $kadoItem->atas_nama ?? '';
              @endphp
              <div class="glass-card rounded-3xl p-6 border border-sky-400/30 flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                  <div class="flex items-center justify-between">
                    <span class="font-display font-bold text-lg text-sky-300">{{ $bankName }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-200 text-xs font-semibold border border-sky-400/30">Transfer Bank</span>
                  </div>
                  <p class="text-xs text-slate-300">Nomor Rekening:</p>
                  <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 flex items-center justify-between">
                    <span class="font-mono font-bold text-base sm:text-lg text-white tracking-wider">{{ $accNo }}</span>
                    <button
                      type="button"
                      onclick="copyTextToClipboard('{{ $accNo }}', 'Nomor rekening {{ $bankName }} tersalin!')"
                      class="px-3 py-1.5 rounded-xl bg-sky-400 hover:bg-sky-300 text-slate-950 text-xs font-bold transition shadow"
                    >
                      Salin No. Rek
                    </button>
                  </div>
                  @if ($accOwner)
                    <p class="text-xs text-slate-400">a.n. <strong class="text-white">{{ $accOwner }}</strong></p>
                  @endif
                </div>
              </div>
            @endforeach
          @endif

          <!-- Alamat Kirim Kado -->
          @if ($data->fiturKado && $data->fiturKado->alamat)
            <div class="glass-card rounded-3xl p-6 border border-purple-400/30 flex flex-col justify-between space-y-4">
              <div class="space-y-2">
                <div class="flex items-center justify-between">
                  <span class="font-display font-bold text-lg text-purple-300">Kado Fisik / Paket</span>
                  <span class="px-2.5 py-0.5 rounded-full bg-purple-500/20 text-purple-200 text-xs font-semibold border border-purple-400/30">Alamat Markas</span>
                </div>
                <p class="text-xs text-slate-300">Alamat Pengiriman Kado ke Rumah:</p>
                <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-2">
                  <p class="text-xs text-slate-200 leading-relaxed">
                    {{ $data->fiturKado->alamat }}
                  </p>
                  <div class="text-right">
                    <button
                      type="button"
                      onclick="copyTextToClipboard('{{ addslashes($data->fiturKado->alamat) }}', 'Alamat pengiriman kado tersalin!')"
                      class="px-3 py-1.5 rounded-xl bg-purple-400 hover:bg-purple-300 text-slate-950 text-xs font-bold transition shadow"
                    >
                      Salin Alamat
                    </button>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </section>
    @endif

    <!-- ========================================== -->
    <!-- 9. FOOTER KOSMIK                           -->
    <!-- ========================================== -->
    <footer class="pt-8 border-t border-slate-800 text-center space-y-3">
      <div class="inline-flex items-center gap-2 text-2xl animate-float">
        <span>🚀</span> <span>✨</span> <span>🪐</span>
      </div>
      <h4 class="font-display font-bold text-xl text-white">
        Terima Kasih, Sahabat Astronot!
      </h4>
      <p class="text-xs sm:text-sm text-slate-400 max-w-md mx-auto">
        Sampai jumpa di hari peluncuran! Salam hangat dari {{ $childName }} dan segenap keluarga besar.
      </p>
      <div class="pt-6 text-[11px] text-slate-500">
        Dibuat dengan segenap cinta oleh <a href="{{ url('/') }}" class="text-sky-400 hover:underline font-semibold">WayaeNikah</a>
      </div>
    </footer>

  </main>

  <!-- ========================================== -->
  <!-- MOBILE BOTTOM STICKY NAVIGATION DOCK       -->
  <!-- ========================================== -->
  <div class="md:hidden fixed bottom-3 left-1/2 -translate-x-1/2 z-40 w-[92%] max-w-sm glass-pill rounded-2xl px-3 py-2 shadow-2xl flex items-center justify-around border border-sky-400/40">
    <a href="#beranda" class="text-center text-slate-300 hover:text-sky-300 transition">
      <span class="block text-base">🛸</span>
      <span class="text-[9px] font-medium block">Beranda</span>
    </a>
    @if ($firstEvent)
      <a href="#jadwal" class="text-center text-slate-300 hover:text-sky-300 transition">
        <span class="block text-base">📅</span>
        <span class="text-[9px] font-medium block">Waktu</span>
      </a>
    @endif
    @if ($activeRundowns->isNotEmpty())
      <a href="#rundown" class="text-center text-slate-300 hover:text-sky-300 transition">
        <span class="block text-base">🪐</span>
        <span class="text-[9px] font-medium block">Misi</span>
      </a>
    @endif
    @if (count($galleryPhotos) > 0)
      <a href="#galeri" class="text-center text-slate-300 hover:text-sky-300 transition">
        <span class="block text-base">📸</span>
        <span class="text-[9px] font-medium block">Galeri</span>
      </a>
    @endif
    @if ($data->FiturUcapan?->status ?? true)
      <a href="#rsvp" class="text-center text-slate-300 hover:text-sky-300 transition">
        <span class="block text-base">📝</span>
        <span class="text-[9px] font-medium block">RSVP</span>
      </a>
    @endif
    @if ($data->fiturKado || ($data->kado && $data->kado->isNotEmpty()))
      <a href="#kado" class="text-center text-slate-300 hover:text-sky-300 transition">
        <span class="block text-base">🎁</span>
        <span class="text-[9px] font-medium block">Kado</span>
      </a>
    @endif
  </div>

  <!-- ========================================== -->
  <!-- MODAL LIGHTBOX GALERI                      -->
  <!-- ========================================== -->
  <div id="lightboxModal" class="fixed inset-0 z-50 bg-space-950/95 backdrop-blur-md hidden items-center justify-center p-4">
    <div class="max-w-2xl w-full glass-card rounded-3xl p-4 sm:p-6 border border-sky-400/40 relative space-y-3">
      <div class="flex items-center justify-between">
        <p id="lightboxCaption" class="text-xs sm:text-sm text-sky-200 font-medium"></p>
        <button id="closeLightboxBtn" type="button" class="w-8 h-8 rounded-full bg-slate-800 text-slate-300 hover:bg-slate-700 flex items-center justify-center text-sm">✕</button>
      </div>
      <img id="lightboxImg" src="{{ $childPhoto }}" alt="Preview Galeri" class="w-full max-h-[60vh] object-contain rounded-2xl mx-auto" />
    </div>
  </div>

  <!-- ========================================== -->
  <!-- TOAST NOTIFICATION                         -->
  <!-- ========================================== -->
  <div id="toastBanner" class="fixed bottom-20 md:bottom-6 right-4 sm:right-6 z-50 transition-all duration-300 transform translate-y-24 opacity-0 pointer-events-none">
    <div class="px-4 py-2.5 rounded-2xl bg-slate-900/95 border border-sky-400/50 text-sky-200 text-xs font-semibold shadow-2xl flex items-center gap-2 backdrop-blur-md">
      <span class="text-base">✨</span>
      <span id="toastMessage">Tersalin ke clipboard!</span>
    </div>
  </div>

  <!-- ========================================== -->
  <!-- SCRIPTS & APPLICATION LOGIC                -->
  <!-- ========================================== -->
  <script>
    // --- 1. Toast Notification Helper ---
    let toastTimer = null;
    function showToast(msg) {
      const banner = document.getElementById('toastBanner');
      const text = document.getElementById('toastMessage');
      if (!banner || !text) return;
      text.textContent = msg;
      banner.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
      banner.classList.add('translate-y-0', 'opacity-100');
      if (toastTimer) clearTimeout(toastTimer);
      toastTimer = setTimeout(() => {
        banner.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
        banner.classList.remove('translate-y-0', 'opacity-100');
      }, 3200);
    }

    // --- 2. Interactive Starfield Canvas ---
    const canvas = document.getElementById('starfieldCanvas');
    const ctx = canvas.getContext('2d');
    let stars = [];
    const STAR_COUNT = 80;
    let animFrameId = null;

    function initCanvas() {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      stars = [];
      for (let i = 0; i < STAR_COUNT; i++) {
        stars.push({
          x: Math.random() * canvas.width,
          y: Math.random() * canvas.height,
          size: Math.random() * 1.8 + 0.4,
          speed: Math.random() * 0.35 + 0.08,
          alpha: Math.random() * 0.8 + 0.2,
          color: ['#38BDF8', '#FBBF24', '#A855F7', '#F8FAFC'][Math.floor(Math.random() * 4)]
        });
      }
    }

    function renderLoop() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      for (let i = 0; i < stars.length; i++) {
        const s = stars[i];
        s.y -= s.speed;
        if (s.y < 0) {
          s.y = canvas.height;
          s.x = Math.random() * canvas.width;
        }
        ctx.fillStyle = s.color;
        ctx.globalAlpha = s.alpha;
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
        ctx.fill();
      }
      ctx.globalAlpha = 1.0;
      animFrameId = requestAnimationFrame(renderLoop);
    }

    window.addEventListener('resize', initCanvas);
    initCanvas();
    renderLoop();

    // --- 3. Synthesized Space Melody (Web Audio API) & BG Audio ---
    const bgAudio = document.getElementById('bg-music');
    let audioCtx = null;
    let isPlayingAudio = false;
    let melodyTimer = null;
    const spaceNotes = [523.25, 659.25, 783.99, 1046.50, 783.99, 659.25];
    let noteIndex = 0;

    function playNote(freq, duration = 0.35) {
      if (!audioCtx) return;
      try {
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
        gain.gain.setValueAtTime(0.001, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.06, audioCtx.currentTime + 0.04);
        gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + duration);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start();
        osc.stop(audioCtx.currentTime + duration);
      } catch (e) {}
    }

    function startSpaceMusic() {
      isPlayingAudio = true;
      const aIcon = document.getElementById('audioIcon');
      const aLabel = document.getElementById('audioLabel');
      if (aIcon) aIcon.textContent = '🔊';
      if (aLabel) aLabel.textContent = 'Musik On';

      if (bgAudio) {
        bgAudio.play().catch(() => playSynthFallback());
      } else {
        playSynthFallback();
      }
    }

    function playSynthFallback() {
      try {
        if (!audioCtx) {
          const AudioContextClass = window.AudioContext || window.webkitAudioContext;
          if (AudioContextClass) audioCtx = new AudioContextClass();
        }
        if (audioCtx && audioCtx.state === 'suspended') audioCtx.resume();
        if (melodyTimer) clearInterval(melodyTimer);
        melodyTimer = setInterval(() => {
          if (!isPlayingAudio) return;
          playNote(spaceNotes[noteIndex % spaceNotes.length], 0.42);
          noteIndex++;
        }, 480);
      } catch (e) {}
    }

    function stopSpaceMusic() {
      isPlayingAudio = false;
      if (bgAudio) bgAudio.pause();
      if (melodyTimer) {
        clearInterval(melodyTimer);
        melodyTimer = null;
      }
      const aIcon = document.getElementById('audioIcon');
      const aLabel = document.getElementById('audioLabel');
      if (aIcon) aIcon.textContent = '🔇';
      if (aLabel) aLabel.textContent = 'Musik Off';
    }

    const toggleAudioBtn = document.getElementById('toggleAudioBtn');
    if (toggleAudioBtn) {
      toggleAudioBtn.addEventListener('click', () => {
        if (isPlayingAudio) {
          stopSpaceMusic();
          showToast('Musik latar dihentikan');
        } else {
          startSpaceMusic();
          showToast('Musik antariksa diputar 🎵');
        }
      });
    }

    // --- 4. Opening Cover Gate ---
    window.astronotOpenGate = function() {
      const coverGate = document.getElementById('coverGate');
      if (coverGate) {
        coverGate.classList.add('opacity-0', 'pointer-events-none');
        setTimeout(() => {
          coverGate.classList.add('hidden');
        }, 650);
      }
      startSpaceMusic();
      showToast('Akses kontrol terbuka! Selamat berpetualang 🚀');
    };

    const openInvitationBtn = document.getElementById('openInvitationBtn');
    if (openInvitationBtn) {
      openInvitationBtn.addEventListener('click', window.astronotOpenGate);
    }

    const launchConfettiBtn = document.getElementById('launchConfettiBtn');
    if (launchConfettiBtn) {
      launchConfettiBtn.addEventListener('click', () => {
        if (audioCtx && isPlayingAudio) playNote(880, 0.25);
        showToast('Roket Bintang Meluncur! 🚀✨');
      });
    }

    // --- 5. Countdown Timer ---
    const targetEventTime = new Date('{{ $countdownDate }}').getTime();

    function updateCountdown() {
      const now = Date.now();
      const diff = Math.max(0, targetEventTime - now);
      const days = Math.floor(diff / (1000 * 60 * 60 * 24));
      const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
      const mins = Math.floor((diff / 1000 / 60) % 60);
      const secs = Math.floor((diff / 1000) % 60);

      const dEl = document.getElementById('cdDays');
      const hEl = document.getElementById('cdHours');
      const mEl = document.getElementById('cdMinutes');
      const sEl = document.getElementById('cdSeconds');
      if (dEl) dEl.textContent = String(days).padStart(2, '0');
      if (hEl) hEl.textContent = String(hours).padStart(2, '0');
      if (mEl) mEl.textContent = String(mins).padStart(2, '0');
      if (sEl) sEl.textContent = String(secs).padStart(2, '0');
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // --- 6. Gallery Lightbox ---
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightboxModal = document.getElementById('lightboxModal');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const closeLightboxBtn = document.getElementById('closeLightboxBtn');

    galleryItems.forEach(item => {
      item.addEventListener('click', () => {
        const img = item.querySelector('img');
        if (img && lightboxImg) lightboxImg.src = img.src;
        if (lightboxCaption) lightboxCaption.textContent = item.getAttribute('data-caption') || '';
        if (lightboxModal) {
          lightboxModal.classList.remove('hidden');
          lightboxModal.classList.add('flex');
        }
      });
    });

    if (closeLightboxBtn && lightboxModal) {
      closeLightboxBtn.addEventListener('click', () => {
        lightboxModal.classList.add('hidden');
        lightboxModal.classList.remove('flex');
      });
    }

    // --- 7. Copy to Clipboard ---
    function copyTextToClipboard(text, msg = 'Teks berhasil disalin ke clipboard! 📋') {
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(() => {
          showToast(msg);
        }).catch(() => {
          fallbackCopy(text, msg);
        });
      } else {
        fallbackCopy(text, msg);
      }
    }

    function fallbackCopy(text, msg) {
      const ta = document.createElement('textarea');
      ta.value = text;
      ta.style.position = 'fixed';
      ta.style.opacity = '0';
      document.body.appendChild(ta);
      ta.select();
      try {
        document.execCommand('copy');
        showToast(msg);
      } catch (err) {}
      document.body.removeChild(ta);
    }
  </script>
</body>
</html>
