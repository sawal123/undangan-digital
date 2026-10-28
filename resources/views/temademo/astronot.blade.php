<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Misi Ulang Tahun Antariksa — Demo Undangan Digital</title>
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
          src="{{ asset('tema/astronot/assets/images/captain-avatar.webp') }}"
          alt="Kapten Astronot Cilik"
          class="w-full h-full object-cover rounded-full border-4 border-space-950"
        />
        <div class="absolute -bottom-2 -right-1 bg-amber-400 text-slate-950 text-xs font-bold px-3 py-1 rounded-full shadow-lg border-2 border-space-950">
          5 Tahun!
        </div>
      </div>

      <h1 class="font-display font-bold text-2xl sm:text-3xl text-white tracking-wide">
        Kapten Leo Pratama
      </h1>
      <p class="text-xs sm:text-sm text-sky-200 mt-1">
        Misi Ulang Tahun ke-<span class="font-semibold text-amber-300">5</span> di Galaksi Ceria
      </p>

      <div class="mt-6 p-4 rounded-2xl bg-space-900/80 border border-slate-700/80 text-left space-y-1">
        <p class="text-[11px] text-slate-400 uppercase tracking-wider font-medium">Kepada Rekan Astronot:</p>
        <p id="coverGuestName" class="font-display font-semibold text-base sm:text-lg text-sky-300">
          Sahabat Petualang Antariksa
        </p>
      </div>

      <button
        id="openInvitationBtn"
        type="button"
        class="mt-6 w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-sky-400 via-cyan-400 to-amber-400 hover:from-sky-300 hover:to-amber-300 text-slate-950 font-display font-bold text-sm tracking-wider uppercase shadow-xl hover:shadow-cyan-500/40 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-200 flex items-center justify-center gap-2"
      >
        <span>Buka Akses Kontrol</span>
        <span class="text-base">🚀</span>
      </button>

      <p class="text-[11px] text-slate-400 mt-4 flex items-center justify-center gap-1">
        <span>👨‍🚀</span> Disiapkan oleh Bunda Rina &amp; Ayah Fajar
      </p>
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
            Misi Leo
          </p>
          <p class="text-[10px] text-sky-300 mt-0.5 font-medium tracking-wider">HUT KE-5</p>
        </div>
      </a>

      <nav class="hidden md:flex items-center gap-1 text-xs font-medium text-slate-300">
        <a href="#beranda" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Beranda</a>
        <a href="#jadwal" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Waktu &amp; Lokasi</a>
        <a href="#rundown" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Misi Acara</a>
        <a href="#galeri" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Galeri</a>
        <a href="#rsvp" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">RSVP &amp; Doa</a>
        <a href="#kado" class="px-3 py-1.5 rounded-lg hover:text-white hover:bg-slate-800/80 transition">Tanda Kasih</a>
      </nav>

      <div class="flex items-center gap-2">
        <!-- Floating Sound Button -->
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
              <span>🛰️</span> Misi Eksplorasi Antariksa
            </div>

            <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white leading-tight">
              Yuk, Ikut Jelajah Galaksi Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-300 via-amber-300 to-orange-300">Kapten Leo Pratama</span>!
            </h2>

            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
              Halo teman-teman dan keluarga terkasih! Kapten Leo akan segera mencapai orbit usia ke-<strong class="text-amber-300 font-bold">5 tahun</strong>. Kami mengundang kalian semua menjadi kru astronot spesial untuk merayakan petualangan ruang angkasa penuh tawa, kue bulan, dan sulap kosmik!
            </p>

            <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-3">
              <a
                href="#jadwal"
                class="px-5 py-2.5 rounded-xl bg-sky-400 hover:bg-sky-300 text-slate-950 font-display font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-sky-400/20"
              >
                Lihat Jadwal Misi 🪐
              </a>
              <a
                href="#rsvp"
                class="px-5 py-2.5 rounded-xl bg-space-800/90 hover:bg-space-700 text-sky-200 border border-slate-700 font-display font-semibold text-xs uppercase tracking-wider transition"
              >
                Konfirmasi Kehadiran 📝
              </a>
            </div>

            <!-- Countdown Panel -->
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
          </div>

          <div class="lg:col-span-5 flex justify-center">
            <div class="relative w-64 sm:w-72 lg:w-80 aspect-square">
              <div class="absolute inset-0 rounded-3xl bg-gradient-to-tr from-sky-400 to-purple-600 blur-2xl opacity-40 animate-pulse"></div>
              <img
                src="{{ asset('tema/astronot/assets/images/captain-avatar.webp') }}"
                alt="Ilustrasi Astronot Ulang Tahun"
                class="w-full h-full object-cover rounded-3xl border-4 border-sky-400/50 shadow-2xl relative z-10"
              />
              <div class="absolute -bottom-3 -right-3 z-20 bg-space-900/95 border border-amber-400/50 rounded-2xl p-3 shadow-xl backdrop-blur-md flex items-center gap-2">
                <span class="text-2xl">🎂</span>
                <div>
                  <p class="text-[10px] text-slate-400 uppercase font-medium">Target Misi</p>
                  <p class="font-display font-bold text-xs text-amber-300">Tiup Lilin ke-5</p>
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
              Peluncuran dijadwalkan tepat waktu pada:
            </p>
            <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-1">
              <p class="font-display font-bold text-sky-300 text-base">Minggu, 15 November 2026</p>
              <p class="text-xs text-amber-300 font-medium">Pukul 15:00 – 18:00 WIB</p>
            </div>
          </div>
          <button
            id="saveCalendarBtn"
            type="button"
            class="mt-5 w-full py-2.5 px-4 rounded-xl bg-sky-500/20 hover:bg-sky-500/30 border border-sky-400/40 text-xs font-semibold text-sky-200 transition flex items-center justify-center gap-1.5"
          >
            <span>Simpan ke Kalender</span>
            <span>🗓️</span>
          </button>
        </div>

        <!-- Lokasi Pesta -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border border-purple-400/25 hover:border-purple-400/50 transition">
          <div class="space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-purple-500/20 border border-purple-400/30 flex items-center justify-center text-2xl">
              🪐
            </div>
            <h4 class="font-display font-bold text-lg text-white">Stasiun Pesta</h4>
            <p class="text-xs text-slate-300">
              Stasiun ruang angkasa utama bertempat di:
            </p>
            <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-1">
              <p class="font-display font-bold text-purple-300 text-base">Starlight Kids Cafe &amp; Hall</p>
              <p class="text-xs text-slate-300 leading-relaxed">
                Lt. 2 Galaxy Mall, Jl. Antariksa Raya No. 45, Jakarta Selatan
              </p>
            </div>
          </div>
          <button
            id="openMapModalBtn"
            type="button"
            class="mt-5 w-full py-2.5 px-4 rounded-xl bg-purple-500/20 hover:bg-purple-500/30 border border-purple-400/40 text-xs font-semibold text-purple-200 transition flex items-center justify-center gap-1.5"
          >
            <span>Buka Peta Stasiun</span>
            <span>🗺️</span>
          </button>
        </div>

        <!-- Dress Code -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border border-amber-400/25 hover:border-amber-400/50 transition">
          <div class="space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center text-2xl">
              🧑‍🚀
            </div>
            <h4 class="font-display font-bold text-lg text-white">Kode Seragam Kru</h4>
            <p class="text-xs text-slate-300">
              Kenakan seragam terbaikmu saat menjelajah:
            </p>
            <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-2">
              <p class="font-display font-bold text-amber-300 text-base">Biru / Putih / Kosmik</p>
              <p class="text-xs text-slate-300 leading-relaxed">
                Boleh mengenakan kostum astronot, alien lucu, atau kaos bertema galaksi bintang!
              </p>
            </div>
          </div>
          <div class="mt-5 py-2.5 px-3 rounded-xl bg-amber-400/10 border border-amber-400/20 text-[11px] text-amber-300 text-center font-medium">
            ✨ Disediakan bando bintang &amp; stiker antariksa di pintu masuk!
          </div>
        </div>
      </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. TAHAPAN MISI ANTARIKSA (RUNDOWN)        -->
    <!-- ========================================== -->
    <section id="rundown" class="space-y-8">
      <div class="text-center space-y-2">
        <span class="px-3.5 py-1 rounded-full bg-cyan-500/20 border border-cyan-400/30 text-cyan-300 text-xs font-semibold uppercase tracking-wider">
          Timeline Kegiatan
        </span>
        <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
          Tahapan Misi Antariksa
        </h3>
        <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
          Setiap menit petualangan dirancang untuk keceriaan anak-anak dan keluarga.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Step 1 -->
        <div class="glass-card rounded-3xl p-5 border border-slate-700/80 relative overflow-hidden group hover:border-sky-400/50 transition">
          <div class="flex items-center justify-between mb-3">
            <span class="w-8 h-8 rounded-full bg-sky-500/20 text-sky-300 font-display font-bold text-sm flex items-center justify-center">
              01
            </span>
            <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-sky-300 text-[11px] font-semibold border border-sky-400/30">
              15:00 - 15:30
            </span>
          </div>
          <h4 class="font-display font-bold text-base text-white group-hover:text-sky-300 transition">
            Check-In Astronot
          </h4>
          <p class="text-xs text-slate-300 mt-2 leading-relaxed">
            Pemasangan ID Badge kru antariksa, pembagian bando bintang, dan foto di photo booth bulan.
          </p>
          <p class="text-[11px] text-slate-400 mt-3 font-medium">📍 Area Pintu Masuk</p>
        </div>

        <!-- Step 2 -->
        <div class="glass-card rounded-3xl p-5 border border-slate-700/80 relative overflow-hidden group hover:border-purple-400/50 transition">
          <div class="flex items-center justify-between mb-3">
            <span class="w-8 h-8 rounded-full bg-purple-500/20 text-purple-300 font-display font-bold text-sm flex items-center justify-center">
              02
            </span>
            <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-purple-300 text-[11px] font-semibold border border-purple-400/30">
              15:30 - 16:30
            </span>
          </div>
          <h4 class="font-display font-bold text-base text-white group-hover:text-purple-300 transition">
            Games &amp; Sulap Kosmik
          </h4>
          <p class="text-xs text-slate-300 mt-2 leading-relaxed">
            Permainan berburu asteroid berhadiah, kuis ruang angkasa, dan pertunjukan sulap sains seru!
          </p>
          <p class="text-[11px] text-slate-400 mt-3 font-medium">📍 Panggung Utama</p>
        </div>

        <!-- Step 3 -->
        <div class="glass-card rounded-3xl p-5 border border-slate-700/80 relative overflow-hidden group hover:border-amber-400/50 transition">
          <div class="flex items-center justify-between mb-3">
            <span class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-300 font-display font-bold text-sm flex items-center justify-center">
              03
            </span>
            <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-amber-300 text-[11px] font-semibold border border-amber-400/30">
              16:30 - 17:15
            </span>
          </div>
          <h4 class="font-display font-bold text-base text-white group-hover:text-amber-300 transition">
            Tiup Lilin &amp; Potong Kue
          </h4>
          <p class="text-xs text-slate-300 mt-2 leading-relaxed">
            Puncak selebrasi ulang tahun ke-5, menyanyikan lagu antariksa, tiup lilin roket, dan doa bersama.
          </p>
          <p class="text-[11px] text-slate-400 mt-3 font-medium">📍 Area Kue Bintang</p>
        </div>

        <!-- Step 4 -->
        <div class="glass-card rounded-3xl p-5 border border-slate-700/80 relative overflow-hidden group hover:border-pink-400/50 transition">
          <div class="flex items-center justify-between mb-3">
            <span class="w-8 h-8 rounded-full bg-pink-500/20 text-pink-300 font-display font-bold text-sm flex items-center justify-center">
              04
            </span>
            <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-pink-300 text-[11px] font-semibold border border-pink-400/30">
              17:15 - 18:00
            </span>
          </div>
          <h4 class="font-display font-bold text-base text-white group-hover:text-pink-300 transition">
            Makan Bersama &amp; Souvenir
          </h4>
          <p class="text-xs text-slate-300 mt-2 leading-relaxed">
            Menikmati hidangan lezat dan pembagian goodie bag bingkisan roket sebelum kembali ke orbit rumah!
          </p>
          <p class="text-[11px] text-slate-400 mt-3 font-medium">📍 Ruang Jamuan</p>
        </div>
      </div>
    </section>

    <!-- ========================================== -->
    <!-- 6. GALERI MISI KAPTEN CILIK               -->
    <!-- ========================================== -->
    <section id="galeri" class="space-y-8">
      <div class="text-center space-y-2">
        <span class="px-3.5 py-1 rounded-full bg-pink-500/20 border border-pink-400/30 text-pink-300 text-xs font-semibold uppercase tracking-wider">
          Momen Ceria
        </span>
        <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
          Galeri Misi Kapten Cilik
        </h3>
        <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
          Kilas balik petualangan manis Leo sebelum melangkah ke usia 5 tahun.
        </p>
      </div>

      <!-- Gallery Filter Tabs -->
      <div class="flex items-center justify-center flex-wrap gap-2">
        <button type="button" data-gallery-filter="all" class="gallery-tab px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-sky-400 text-slate-950 transition">
          Semua Foto (3)
        </button>
        <button type="button" data-gallery-filter="seru" class="gallery-tab px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
          Misi Seru
        </button>
        <button type="button" data-gallery-filter="kue" class="gallery-tab px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
          Kue Bintang
        </button>
        <button type="button" data-gallery-filter="roket" class="gallery-tab px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
          Roket
        </button>
      </div>

      <!-- Gallery Grid -->
      <div id="galleryGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Photo 1 -->
        <div class="gallery-item group relative rounded-3xl overflow-hidden glass-card border border-sky-400/30 cursor-pointer aspect-square" data-category="seru" data-caption="Kapten Leo siap menjelajahi galaksi baru!">
          <img
            src="{{ asset('tema/astronot/assets/images/captain-avatar.webp') }}"
            alt="Kapten Astronot Melambai"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-space-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
            <p class="text-xs text-white font-medium">✨ Kapten Leo siap menjelajahi galaksi baru!</p>
          </div>
        </div>

        <!-- Photo 2 -->
        <div class="gallery-item group relative rounded-3xl overflow-hidden glass-card border border-amber-400/30 cursor-pointer aspect-square" data-category="kue" data-caption="Kue ulang tahun bertabur bintang di kawah bulan.">
          <img
            src="{{ asset('tema/astronot/assets/images/moon-cake.webp') }}"
            alt="Kue Ulang Tahun di Bulan"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-space-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
            <p class="text-xs text-white font-medium">🎂 Kue ulang tahun bertabur bintang di kawah bulan.</p>
          </div>
        </div>

        <!-- Photo 3 -->
        <div class="gallery-item group relative rounded-3xl overflow-hidden glass-card border border-purple-400/30 cursor-pointer aspect-square" data-category="roket" data-caption="Roket kosmik meluncur membawa sejuta harapan manis.">
          <img
            src="{{ asset('tema/astronot/assets/images/rocket-launch.webp') }}"
            alt="Peluncuran Roket Antariksa"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-space-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
            <p class="text-xs text-white font-medium">🚀 Roket kosmik meluncur membawa sejuta harapan manis.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================================== -->
    <!-- 7. RSVP & DO SAHABAT ASTRONOT             -->
    <!-- ========================================== -->
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
          <p class="text-xs text-slate-300 mb-5">Kirimkan konfirmasi &amp; doa terbaik untuk Leo.</p>

          <form id="rsvpForm" class="space-y-4">
            <div>
              <label for="rsvpName" class="block text-xs font-semibold text-slate-300 mb-1.5">Nama Anak / Keluarga</label>
              <input
                type="text"
                id="rsvpName"
                required
                placeholder="Contoh: Sarah &amp; Kenzie"
                class="w-full px-4 py-2.5 rounded-xl bg-space-950/80 border border-slate-700 text-sm text-white focus:outline-none focus:border-sky-400 transition"
              />
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label for="rsvpStatus" class="block text-xs font-semibold text-slate-300 mb-1.5">Konfirmasi</label>
                <select
                  id="rsvpStatus"
                  class="w-full px-3 py-2.5 rounded-xl bg-space-950/80 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-sky-400 transition"
                >
                  <option value="Hadir">🚀 Pasti Hadir</option>
                  <option value="Ragu">🤔 Masih Ragu</option>
                  <option value="Tidak Hadir">🛸 Maaf, Berhalangan</option>
                </select>
              </div>

              <div>
                <label for="rsvpCount" class="block text-xs font-semibold text-slate-300 mb-1.5">Jumlah Kru</label>
                <select
                  id="rsvpCount"
                  class="w-full px-3 py-2.5 rounded-xl bg-space-950/80 border border-slate-700 text-xs sm:text-sm text-white focus:outline-none focus:border-sky-400 transition"
                >
                  <option value="1 Anak + 1 Pendamping">1 Anak + 1 Pendamping</option>
                  <option value="2 Anak + 1 Pendamping">2 Anak + 1 Pendamping</option>
                  <option value="2 Anak + 2 Pendamping">2 Anak + 2 Pendamping</option>
                  <option value="1 Orang Saja">1 Orang Saja</option>
                  <option value="Lebih dari 3 Orang">&gt; 3 Orang</option>
                </select>
              </div>
            </div>

            <div>
              <label for="rsvpMessage" class="block text-xs font-semibold text-slate-300 mb-1.5">Pesan Doa &amp; Ucapan</label>
              <textarea
                id="rsvpMessage"
                rows="3"
                required
                placeholder="Tuliskan harapan dan doa terbaik untuk Kapten Leo..."
                class="w-full px-4 py-2.5 rounded-xl bg-space-950/80 border border-slate-700 text-sm text-white focus:outline-none focus:border-sky-400 transition resize-none"
              ></textarea>
            </div>

            <button
              type="submit"
              class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-400 to-cyan-400 hover:from-sky-300 hover:to-cyan-300 text-slate-950 font-display font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-sky-400/25 flex items-center justify-center gap-1.5"
            >
              <span>Kirim Konfirmasi Misi</span>
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
                <span id="statAttending" class="font-bold text-emerald-400">2</span> Kru Hadir • Total <span id="statTotalMessages" class="font-bold text-sky-300">3</span> Ucapan
              </p>
            </div>

            <div class="flex items-center gap-1">
              <button type="button" data-rsvp-filter="all" class="rsvp-filter-btn px-3 py-1 rounded-lg text-xs font-semibold bg-sky-400 text-slate-950 transition">
                Semua
              </button>
              <button type="button" data-rsvp-filter="Hadir" class="rsvp-filter-btn px-3 py-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
                Hadir
              </button>
              <button type="button" data-rsvp-filter="Tidak Hadir" class="rsvp-filter-btn px-3 py-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
                Absen
              </button>
            </div>
          </div>

          <div id="guestbookList" class="space-y-3 max-h-[420px] overflow-y-auto pr-1">
            <!-- Dynamic entries via JS -->
          </div>
        </div>
      </div>
    </section>

    <!-- ========================================== -->
    <!-- 8. TITIP KADO / TANDA KASIH ANTARIKSA      -->
    <!-- ========================================== -->
    <section id="kado" class="space-y-8">
      <div class="text-center space-y-2">
        <span class="px-3.5 py-1 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-300 text-xs font-semibold uppercase tracking-wider">
          Tanda Kasih
        </span>
        <h3 class="font-display font-bold text-2xl sm:text-3xl text-white">
          Kado Antariksa untuk Leo
        </h3>
        <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
          Kehadiran dan doa teman-teman adalah kado terindah bagi kami. Namun bagi yang ingin mengirimkan kado spesial, dapat melalui saluran berikut:
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-3xl mx-auto">
        <!-- Rekening Bank -->
        <div class="glass-card rounded-3xl p-6 border border-sky-400/30 flex flex-col justify-between space-y-4">
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <span class="font-display font-bold text-lg text-sky-300">Bank Central Asia (BCA)</span>
              <span class="px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-200 text-xs font-semibold border border-sky-400/30">Transfer Bank</span>
            </div>
            <p class="text-xs text-slate-300">Nomor Rekening Tabungan Pendidikan Leo:</p>
            <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 flex items-center justify-between">
              <span id="bankNumberText" class="font-mono font-bold text-base sm:text-lg text-white tracking-wider">8291039481</span>
              <button
                type="button"
                data-copy-target="bankNumberText"
                class="copy-btn px-3 py-1.5 rounded-xl bg-sky-400 hover:bg-sky-300 text-slate-950 text-xs font-bold transition shadow"
              >
                Salin No. Rek
              </button>
            </div>
            <p class="text-xs text-slate-400">a.n. <strong class="text-white">Rina Wulandari (Ibunda)</strong></p>
          </div>
        </div>

        <!-- Alamat Kirim Kado -->
        <div class="glass-card rounded-3xl p-6 border border-purple-400/30 flex flex-col justify-between space-y-4">
          <div class="space-y-2">
            <div class="flex items-center justify-between">
              <span class="font-display font-bold text-lg text-purple-300">Kado Fisik / Paket</span>
              <span class="px-2.5 py-0.5 rounded-full bg-purple-500/20 text-purple-200 text-xs font-semibold border border-purple-400/30">Alamat Markas</span>
            </div>
            <p class="text-xs text-slate-300">Alamat Pengiriman Kado ke Rumah:</p>
            <div class="p-3.5 rounded-2xl bg-space-900/90 border border-slate-700/80 space-y-2">
              <p id="giftAddressText" class="text-xs text-slate-200 leading-relaxed">
                Jl. Antariksa Indah Blok B4 No. 12, Cilandak, Jakarta Selatan, 12430 (Up: Bunda Rina / Kapten Leo)
              </p>
              <div class="text-right">
                <button
                  type="button"
                  data-copy-target="giftAddressText"
                  class="copy-btn px-3 py-1.5 rounded-xl bg-purple-400 hover:bg-purple-300 text-slate-950 text-xs font-bold transition shadow"
                >
                  Salin Alamat
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

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
        Sampai jumpa di hari peluncuran! Salam hangat dari Kapten Leo Pratama dan segenap keluarga besar.
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
    <a href="#jadwal" class="text-center text-slate-300 hover:text-sky-300 transition">
      <span class="block text-base">📅</span>
      <span class="text-[9px] font-medium block">Waktu</span>
    </a>
    <a href="#rundown" class="text-center text-slate-300 hover:text-sky-300 transition">
      <span class="block text-base">🪐</span>
      <span class="text-[9px] font-medium block">Misi</span>
    </a>
    <a href="#galeri" class="text-center text-slate-300 hover:text-sky-300 transition">
      <span class="block text-base">📸</span>
      <span class="text-[9px] font-medium block">Galeri</span>
    </a>
    <a href="#rsvp" class="text-center text-slate-300 hover:text-sky-300 transition">
      <span class="block text-base">📝</span>
      <span class="text-[9px] font-medium block">RSVP</span>
    </a>
    <a href="#kado" class="text-center text-slate-300 hover:text-sky-300 transition">
      <span class="block text-base">🎁</span>
      <span class="text-[9px] font-medium block">Kado</span>
    </a>
  </div>

  <!-- ========================================== -->
  <!-- MODAL PETA STASIUN                         -->
  <!-- ========================================== -->
  <div id="mapModal" class="fixed inset-0 z-50 bg-space-950/90 backdrop-blur-md hidden items-center justify-center p-4">
    <div class="max-w-md w-full glass-card rounded-3xl p-6 border border-sky-400/40 relative space-y-4">
      <div class="flex items-center justify-between">
        <h4 class="font-display font-bold text-lg text-white flex items-center gap-2">
          <span>🪐</span> Peta Stasiun Pesta
        </h4>
        <button id="closeMapModalBtn" type="button" class="w-8 h-8 rounded-full bg-slate-800 text-slate-300 hover:bg-slate-700 flex items-center justify-center text-sm">✕</button>
      </div>

      <div class="w-full h-48 rounded-2xl bg-space-900 border border-slate-700 flex flex-col items-center justify-center text-center p-4 relative overflow-hidden">
        <span class="text-4xl mb-2 animate-bounce">📍</span>
        <p class="font-display font-bold text-sm text-sky-300">Starlight Kids Cafe &amp; Hall</p>
        <p class="text-xs text-slate-300 mt-1">Lt. 2 Galaxy Mall, Jakarta Selatan</p>
      </div>

      <button
        id="openExternalMapsBtn"
        type="button"
        class="w-full py-3 rounded-xl bg-sky-400 hover:bg-sky-300 text-slate-950 font-display font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 shadow"
      >
        <span>Buka di Google Maps</span>
        <span>🚀</span>
      </button>
    </div>
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
      <img id="lightboxImg" src="{{ asset('tema/astronot/assets/images/captain-avatar.webp') }}" alt="Preview Galeri" class="w-full max-h-[60vh] object-contain rounded-2xl mx-auto" />
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
    const STAR_COUNT = 85;
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

    // --- 3. Synthesized Space Melody (Web Audio API) ---
    let audioCtx = null;
    let isPlayingAudio = false;
    let melodyTimer = null;
    const spaceNotes = [523.25, 659.25, 783.99, 1046.50, 783.99, 659.25]; // C5, E5, G5, C6 arpeggio
    let noteIndex = 0;

    function playNote(freq, duration = 0.35) {
      if (!audioCtx) return;
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
    }

    function startSpaceMusic() {
      if (!audioCtx) {
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (AudioContextClass) audioCtx = new AudioContextClass();
      }
      if (!audioCtx) return;
      if (audioCtx.state === 'suspended') audioCtx.resume();
      isPlayingAudio = true;
      document.getElementById('audioIcon').textContent = '🔊';
      document.getElementById('audioLabel').textContent = 'Musik On';
      if (melodyTimer) clearInterval(melodyTimer);
      melodyTimer = setInterval(() => {
        if (!isPlayingAudio) return;
        playNote(spaceNotes[noteIndex % spaceNotes.length], 0.42);
        noteIndex++;
      }, 480);
    }

    function stopSpaceMusic() {
      isPlayingAudio = false;
      if (melodyTimer) {
        clearInterval(melodyTimer);
        melodyTimer = null;
      }
      document.getElementById('audioIcon').textContent = '🔇';
      document.getElementById('audioLabel').textContent = 'Musik Off';
    }

    document.getElementById('toggleAudioBtn').addEventListener('click', () => {
      if (isPlayingAudio) {
        stopSpaceMusic();
        showToast('Musik latar dihentikan');
      } else {
        startSpaceMusic();
        showToast('Musik antariksa diputar 🎵');
      }
    });

    // --- 4. Opening Cover Gate ---
    const coverGate = document.getElementById('coverGate');
    document.getElementById('openInvitationBtn').addEventListener('click', () => {
      coverGate.classList.add('opacity-0', 'pointer-events-none');
      setTimeout(() => {
        coverGate.classList.add('hidden');
      }, 650);
      startSpaceMusic();
      showToast('Akses kontrol terbuka! Selamat berpetualang 🚀');
    });

    document.getElementById('launchConfettiBtn').addEventListener('click', () => {
      if (audioCtx && isPlayingAudio) playNote(880, 0.25);
      showToast('Roket Bintang Meluncur! 🚀✨');
    });

    // --- 5. Countdown Timer ---
    const targetEventTime = new Date('2026-11-15T15:00:00').getTime();

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

    // --- 6. Save to Calendar ---
    document.getElementById('saveCalendarBtn').addEventListener('click', () => {
      const icsContent = [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'BEGIN:VEVENT',
        'SUMMARY:Ulang Tahun Kapten Leo Pratama',
        'DTSTART:20261115T080000Z',
        'DTEND:20261115T110000Z',
        'LOCATION:Starlight Kids Cafe & Hall - Lt. 2 Galaxy Mall, Jakarta Selatan',
        'DESCRIPTION:Misi Ulang Tahun Antariksa bersama Kapten Leo Pratama',
        'END:VEVENT',
        'END:VCALENDAR'
      ].join('\r\n');

      const blob = new Blob([icsContent], { type: 'text/calendar;charset=utf-8' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'jadwal-ulang-tahun-astronot.ics';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
      showToast('Jadwal berhasil diunduh ke Kalender! 📅');
    });

    // --- 7. Gallery Filter & Lightbox ---
    const galleryTabs = document.querySelectorAll('.gallery-tab');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightboxModal = document.getElementById('lightboxModal');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCaption = document.getElementById('lightboxCaption');

    galleryTabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const filter = tab.getAttribute('data-gallery-filter');
        galleryTabs.forEach(t => {
          t.className = 'gallery-tab px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition';
        });
        tab.className = 'gallery-tab px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-sky-400 text-slate-950 transition';

        galleryItems.forEach(item => {
          const cat = item.getAttribute('data-category');
          if (filter === 'all' || cat === filter) {
            item.classList.remove('hidden');
          } else {
            item.classList.add('hidden');
          }
        });
      });
    });

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

    document.getElementById('closeLightboxBtn').addEventListener('click', () => {
      lightboxModal.classList.add('hidden');
      lightboxModal.classList.remove('flex');
    });

    // --- 8. RSVP & Guestbook State ---
    let currentRsvpFilter = 'all';
    const rsvpEntries = [
      {
        id: '1',
        name: 'Bunda Sarah & Kenzie',
        status: 'Hadir',
        count: '1 Anak + 1 Pendamping',
        message: 'Selamat ulang tahun ke-5 Kapten Leo! Semoga makin pintar, sehat selalu, dan jadi kebanggaan mama papa! 🚀🌟',
        time: 'Baru saja'
      },
      {
        id: '2',
        name: 'Keluarga Om Dimas & Aluna',
        status: 'Hadir',
        count: '2 Anak + 1 Pendamping',
        message: 'Siap meluncur ke stasiun pesta! Aluna sudah nggak sabar main bareng Kapten Leo.',
        time: '15 menit lalu'
      },
      {
        id: '3',
        name: 'Tante Maya (Bandung)',
        status: 'Tidak Hadir',
        count: '1 Orang Saja',
        message: 'Happy birthday jagoan ganteng! Maaf Tante belum bisa hadir langsung, kado spesial sudah meluncur ke markas ya! 🎁🛸',
        time: '1 jam lalu'
      }
    ];

    function renderGuestbook() {
      const listEl = document.getElementById('guestbookList');
      if (!listEl) return;
      const attendingCount = rsvpEntries.filter(e => e.status === 'Hadir').length;
      const attEl = document.getElementById('statAttending');
      const totEl = document.getElementById('statTotalMessages');
      if (attEl) attEl.textContent = String(attendingCount);
      if (totEl) totEl.textContent = String(rsvpEntries.length);

      const filtered = rsvpEntries.filter(e => currentRsvpFilter === 'all' || e.status === currentRsvpFilter);
      listEl.innerHTML = '';

      if (filtered.length === 0) {
        listEl.innerHTML = '<div class="text-center py-8 text-xs text-slate-400">Belum ada pesan pada kategori ini.</div>';
        return;
      }

      filtered.forEach(entry => {
        const badgeClass =
          entry.status === 'Hadir'
            ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'
            : entry.status === 'Ragu'
            ? 'bg-amber-500/20 text-amber-300 border-amber-500/30'
            : 'bg-rose-500/20 text-rose-300 border-rose-500/30';

        const card = document.createElement('div');
        card.className = 'bg-space-950/75 border border-slate-800 rounded-2xl p-4 space-y-2';
        card.innerHTML = `
          <div class="flex items-start justify-between gap-2">
            <div>
              <h5 class="font-display font-bold text-sm text-white">${entry.name}</h5>
              <p class="text-[11px] text-slate-400">${entry.count} • ${entry.time}</p>
            </div>
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border ${badgeClass}">
              ${entry.status}
            </span>
          </div>
          <p class="text-xs text-slate-200 leading-relaxed">${entry.message}</p>
        `;
        listEl.appendChild(card);
      });
    }

    document.querySelectorAll('.rsvp-filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        currentRsvpFilter = btn.getAttribute('data-rsvp-filter');
        document.querySelectorAll('.rsvp-filter-btn').forEach(b => {
          b.className = 'rsvp-filter-btn px-3 py-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition';
        });
        btn.className = 'rsvp-filter-btn px-3 py-1 rounded-lg text-xs font-semibold bg-sky-400 text-slate-950 transition';
        renderGuestbook();
      });
    });

    document.getElementById('rsvpForm').addEventListener('submit', e => {
      e.preventDefault();
      const name = document.getElementById('rsvpName').value.trim();
      const status = document.getElementById('rsvpStatus').value;
      const count = document.getElementById('rsvpCount').value;
      const message = document.getElementById('rsvpMessage').value.trim();

      if (!name || !message) return;

      rsvpEntries.unshift({
        id: String(Date.now()),
        name,
        status,
        count,
        message,
        time: 'Baru saja'
      });

      document.getElementById('rsvpName').value = '';
      document.getElementById('rsvpMessage').value = '';
      renderGuestbook();
      showToast('Terima kasih! Konfirmasi & doa berhasil dikirim 🚀');
    });

    renderGuestbook();

    // --- 9. Copy to Clipboard ---
    function copyTextToClipboard(text) {
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).catch(() => fallbackCopy(text));
      } else {
        fallbackCopy(text);
      }
    }

    function fallbackCopy(text) {
      const ta = document.createElement('textarea');
      ta.value = text;
      ta.style.position = 'fixed';
      ta.style.opacity = '0';
      document.body.appendChild(ta);
      ta.select();
      try {
        document.execCommand('copy');
      } catch (err) {}
      document.body.removeChild(ta);
    }

    document.querySelectorAll('.copy-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-copy-target');
        const targetEl = document.getElementById(targetId);
        if (targetEl) {
          copyTextToClipboard(targetEl.textContent.trim());
          showToast('Teks berhasil disalin ke clipboard! 📋');
        }
      });
    });

    // --- 10. Map Modal ---
    const mapModal = document.getElementById('mapModal');
    document.getElementById('openMapModalBtn').addEventListener('click', () => {
      mapModal.classList.remove('hidden');
      mapModal.classList.add('flex');
    });
    document.getElementById('closeMapModalBtn').addEventListener('click', () => {
      mapModal.classList.add('hidden');
      mapModal.classList.remove('flex');
    });
    document.getElementById('openExternalMapsBtn').addEventListener('click', () => {
      const q = encodeURIComponent('Starlight Kids Cafe & Hall Jakarta');
      window.open('https://www.google.com/maps/search/?api=1&query=' + q, '_blank', 'noopener');
    });
  </script>
</body>
</html>
