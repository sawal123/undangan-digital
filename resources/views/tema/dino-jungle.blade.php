@php
    use Carbon\Carbon;

    Carbon::setLocale('id');

    $birthday = $data->birthdayProfile;
    $birthdayName = $birthday?->name ?? $data->title ?? 'Birthday';
    $birthdayNickname = $birthday?->nickname ?? $birthdayName;
    $birthdayAge = (int) ($birthday?->age ?? 1);
    $storageUrl = fn ($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
    $birthdayPhoto = $storageUrl($birthday?->photo) ?? $storageUrl($data->pria?->image);
    $firstEvent = $acara ?? $data->acara?->first();
    $timezoneAbbreviation = $firstEvent?->zona_waktu ?: 'WIB';
    $timezone = match ($timezoneAbbreviation) {
        'WITA' => 'Asia/Makassar',
        'WIT' => 'Asia/Jayapura',
        'WIB' => 'Asia/Jakarta',
        default => config('app.timezone', 'Asia/Jakarta'),
    };
    $eventDate = null;
    $eventDateTime = null;
    $eventEndDateTime = null;

    if ($firstEvent?->date) {
        $eventDate = Carbon::parse($firstEvent->date);
        $eventDateTime = Carbon::parse($firstEvent->date . ' ' . ($firstEvent->jam_start ?: '00:00'), $timezone);
        $eventEndDateTime = $firstEvent->jam_end
            ? Carbon::parse($firstEvent->date . ' ' . $firstEvent->jam_end, $timezone)
            : $eventDateTime->copy()->addHours(3);
    }

    $venueName = $firstEvent?->vanue ?? $firstEvent?->nama_acara ?? 'Dino Jungle Party';
    $address = $firstEvent?->alamat ?? 'Lokasi acara';
    $mapsUrl = $firstEvent?->maps ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($venueName . ', ' . $address);
    $familyName = $data->eventDetail?->host_name ?? $birthday?->parent_name ?? 'Keluarga ' . $birthdayName;
    $dressCode = $data->eventDetail?->dress_code ?? 'Pakai baju favoritmu warna hijau, cokelat, atau kuning!';

    $gallery = collect($poto ?? [])
        ->filter()
        ->map(fn ($photo, $index) => [
            'src' => $storageUrl($photo),
            'caption' => $index === 0 ? 'Momen ulang tahun ' . $birthdayNickname : 'Petualangan seru bersama',
        ])
        ->filter(fn ($item) => $item['src'])
        ->values()
        ->all();

    if (! $gallery) {
        $gallery = [
            ['src' => asset('tema/dino-jungle/assets/images/gallery-cake.svg'), 'caption' => 'Kue ulang tahun dino'],
            ['src' => asset('tema/dino-jungle/assets/images/gallery-balloons.svg'), 'caption' => 'Dekorasi pesta jungle'],
            ['src' => asset('tema/dino-jungle/assets/images/gallery-hats.svg'), 'caption' => 'Topi penjelajah kecil'],
            ['src' => asset('tema/dino-jungle/assets/images/gallery-gifts.svg'), 'caption' => 'Kejutan manis'],
        ];
    }

    $agenda = $data->acara?->map(fn ($item) => [
        'time' => trim(collect([$item->jam_start, $item->zona_waktu])->filter()->join(' ')),
        'emoji' => '🦕',
        'title' => $item->nama_acara ?: 'Dino adventure',
        'description' => $item->alamat ?: 'Momen seru bersama keluarga dan teman',
    ])->values()->all() ?: [];

    $fiturUcapan = $data->FiturUcapan;
    $ucapanIsActive = $fiturUcapan?->isActive ?? true;
    $ucapanPublicIsActive = $fiturUcapan?->publicIsActive ?? true;
    $ucapanViewIsActive = $fiturUcapan?->viewIsActive ?? true;
    $giftEnabled = (bool) ($data->fiturKado?->isActive && $data->kado?->isNotEmpty());
    $giftAccounts = $giftEnabled ? $data->kado : collect();
    $wishesSeed = $ucapanViewIsActive
        ? $ucapan->map(fn ($item) => [
            'name' => $item->tamu?->nama ?? 'Tamu',
            'message' => $item->ucapan,
            'at' => $item->created_at?->toIso8601String(),
        ])->values()->all()
        : [];
    $pageTitle = ($data->title ?? 'Dino Jungle Birthday') . ' · ' . $birthdayNickname;
    $invitationConfig = [
        'childName' => $birthdayName,
        'childAge' => $birthdayAge,
        'childPhoto' => $birthdayPhoto ?: '',
        'fallbackImage' => asset('tema/dino-jungle/assets/images/gallery-gifts.svg'),
        'dateTimeISO' => $eventDateTime?->toIso8601String() ?: '',
        'endDateTimeISO' => $eventEndDateTime?->toIso8601String() ?: '',
        'timezone' => $timezone,
        'timezoneAbbreviation' => $timezoneAbbreviation,
        'venue' => $venueName,
        'address' => $address,
        'mapsUrl' => $mapsUrl,
        'hosts' => $familyName,
        'guestFallbackName' => $tamu ?: 'Teman Spesial',
        'dressCode' => $dressCode,
        'agenda' => $agenda,
        'gallery' => $gallery,
        'wishesSeed' => $wishesSeed,
        'milestones' => [],
        'birthdayVideo' => ['enabled' => false, 'url' => ''],
        'streaming' => [
            'enabled' => (bool) ($data->streaming?->isActive && $data->streaming?->link),
            'url' => $data->streaming?->link ?: '',
        ],
        'instagramUrl' => '',
        'gifts' => ['enabled' => $giftEnabled, 'serverRendered' => $giftEnabled],
        'music' => ['enabled' => (bool) ($data->sound?->isActive && $data->sound?->sound && $data->sound?->sound !== 'null'), 'startPlayingOnOpen' => true],
        'backend' => [
            'rsvp' => $ucapanIsActive && ($ucapanPublicIsActive || $kode),
            'wishes' => $ucapanIsActive && ($ucapanPublicIsActive || $kode),
        ],
    ];
@endphp
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <meta name="theme-color" content="#164a31" />
  <meta name="description" content="Undangan ulang tahun {{ $birthdayName }}. Yuk jelajahi Dino Jungle Birthday Party paling seru!" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="{{ $data->title ?? $pageTitle }}" />
  <meta property="og:description" content="Petualangan dinosaurus seru menanti di ulang tahun {{ $birthdayName }}." />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:title" content="Dino Jungle Birthday — You're Invited!" />
  <meta property="og:description" content="Petualangan dinosaurus seru menantimu. Jangan lewatkan pestanya!" />
  <!-- Ganti OG image menjadi URL absolut setelah dihosting. -->
  <meta property="og:image" content="{{ asset('tema/dino-jungle/assets/images/og-preview.jpg') }}" />
  @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title ?? $pageTitle])
  <title>Dino Jungle Birthday — Undangan Ulang Tahun Anak</title>
  <link rel="icon" href="{{ asset('tema/dino-jungle/assets/images/dino-egg.svg') }}" type="image/svg+xml" />
  <link rel="stylesheet" href="{{ asset('tema/dino-jungle/assets/css/tailwind.css') }}" />
  <link rel="stylesheet" href="{{ asset('tema/dino-jungle/assets/css/style.css') }}" />
  <script>
    window.DINO_BIRTHDAY_CONFIG = {!! json_encode($invitationConfig, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
  </script>
  <script src="{{ asset('tema/dino-jungle/assets/js/app.js') }}" defer></script>
</head>
<body class="is-closed">
  <svg class="symbol-bank" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <symbol id="i-home" viewBox="0 0 24 24"><path d="m3 10 9-7 9 7v10H3Zm6 10v-7h6v7"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l4 3"/></symbol>
    <symbol id="i-pin" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></symbol>
    <symbol id="i-music" viewBox="0 0 24 24"><path d="M9 18V5l12-2v13M9 9l12-2"/><ellipse cx="6" cy="18" rx="3" ry="2"/><ellipse cx="18" cy="16" rx="3" ry="2"/></symbol>
    <symbol id="i-music-off" viewBox="0 0 24 24"><path d="M9 18V5l12-2v13M9 9l12-2"/><ellipse cx="6" cy="18" rx="3" ry="2"/><ellipse cx="18" cy="16" rx="3" ry="2"/><path d="M3 3l18 18"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M4 12h16m-6-6 6 6-6 6"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18"/></symbol>
    <symbol id="i-camera" viewBox="0 0 24 24"><path d="M3 7h5l2-3h4l2 3h5v13H3Z"/><circle cx="12" cy="13" r="4"/></symbol>
    <symbol id="i-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 7 9-7"/></symbol>
    <symbol id="i-gift" viewBox="0 0 24 24"><rect x="3" y="9" width="18" height="12" rx="2"/><path d="M2 9h20m-10 0v12m0-12C3 9 4 1 8 2c3 0 4 4 4 7Zm0 0c9 0 8-8 4-7-3 0-4 4-4 7Z"/></symbol>
    <symbol id="i-share" viewBox="0 0 24 24"><path d="M12 16V3m-5 5 5-5 5 5M5 13v7h14v-7"/></symbol>
    <symbol id="i-copy" viewBox="0 0 24 24"><rect x="8" y="8" width="12" height="13" rx="2"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><path d="m4 12 5 5L20 6"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24"><path d="M5 5l14 14M19 5 5 19"/></symbol>
    <symbol id="i-chat" viewBox="0 0 24 24"><path d="M4 5h16v13H9l-5 3Z"/></symbol>
    <symbol id="i-volume" viewBox="0 0 24 24"><path d="M4 9h4l5-4v14l-5-4H4Zm12-1a6 6 0 0 1 0 8"/></symbol>
  </svg>
  <div class="desktop-atmosphere" aria-hidden="true"><span class="deco-sun"></span><span class="big-side-label">ROAR!</span><img class="desk-dino left" src="{{ asset('tema/dino-jungle/assets/images/dino-bronto-blue.svg') }}" alt=""/><img class="desk-dino right" src="{{ asset('tema/dino-jungle/assets/images/dino-trex-orange.svg') }}" alt=""/></div>
  <div class="page-shell" id="page">
    <div class="reading-progress" id="reading-progress" aria-hidden="true"></div>
    <main id="main-content">
      <!-- HERO -->
      <section class="hero relative overflow-hidden" id="home" aria-labelledby="main-title">
        <div class="hero-sky" aria-hidden="true"></div>
        <img class="corner-leaf leaf-tl" src="{{ asset('tema/dino-jungle/assets/images/jungle-leaves.svg') }}" alt="" aria-hidden="true" />
        <img class="corner-leaf leaf-tr" src="{{ asset('tema/dino-jungle/assets/images/jungle-leaves.svg') }}" alt="" aria-hidden="true" />
        <span class="floating-shape star-1" aria-hidden="true">✳</span><span class="floating-shape star-2" aria-hidden="true">✦</span>
        <header class="hero-top flex items-center justify-between relative z-10"><div class="jungle-brand"><span class="brand-paw">🐾</span><span>DINO <small>JUNGLE CLUB</small></span></div><div class="top-ticket">✦ YOU'RE INVITED ✦</div></header>
        <div class="hero-title-block relative z-10 text-center">
          <p class="hero-overline">ARE YOU READY FOR AN ADVENTURE?</p>
          <div class="roar-heading" aria-hidden="true">ROAR<span>!</span></div>
          <p class="hero-present">LET'S CELEBRATE A</p>
          <h1 class="hero-name" id="main-title"><span data-name-first>RAKA'S</span><br/><span class="name-second">DINO BIRTHDAY!</span></h1>
          <div class="hero-age-pill"><span class="pill-star">★</span> <span data-age-label>TURNING 5!</span> <span class="pill-star">★</span></div>
        </div>
        <div class="hero-scene relative" aria-label="Ilustrasi empat dinosaurus lucu di hutan prasejarah">
          <img class="scene-image" src="{{ asset('tema/dino-jungle/assets/images/jungle-scene.svg') }}" alt="" />
          <img class="dino dino-green" src="{{ asset('tema/dino-jungle/assets/images/dino-rex-green.svg') }}" alt="Tiranosaurus hijau yang tersenyum" />
          <img class="dino dino-orange" src="{{ asset('tema/dino-jungle/assets/images/dino-trex-orange.svg') }}" alt="Dinosaurus oranye yang tersenyum" />
          <img class="dino dino-blue" src="{{ asset('tema/dino-jungle/assets/images/dino-bronto-blue.svg') }}" alt="Dinosaurus biru berleher panjang" />
          <img class="dino dino-tri" src="{{ asset('tema/dino-jungle/assets/images/dino-tricera-lime.svg') }}" alt="Triceratops hijau muda" />
          <div class="hero-info-plaque"><span class="plaque-label">THE ADVENTURE BEGINS</span><strong data-date-short>SABTU, 28 NOV 2026</strong><span data-time-short>15.00 WIB</span></div>
        </div>
        <div class="hero-bottom flex flex-col items-center"><a class="scroll-down" href="#invitation">EXPLORE THE PARTY <span>↓</span></a><span class="hero-groundline" aria-hidden="true"></span></div>
      </section>
      <div class="jungle-marquee" aria-hidden="true"><div class="marquee-track">✦ ROAR-SOME BIRTHDAY ✦ DINO PARTY ✦ LITTLE EXPLORER ✦ ROAR-SOME BIRTHDAY ✦ DINO PARTY ✦ LITTLE EXPLORER ✦</div></div>
      <!-- INVITATION -->
      <section class="section-pad intro-section relative" id="invitation">
        <span class="section-speck speck-a" aria-hidden="true">✿</span><span class="section-speck speck-b" aria-hidden="true">✦</span>
        <p class="eyebrow reveal">A SPECIAL INVITATION FOR YOU</p>
        <h2 class="section-title reveal">Hey, Little<br/><em>Explorer!</em> <span>🦕</span></h2>
        <div class="intro-paper reveal"><div class="intro-stamp">DINO<br/>MAIL <span>✉</span></div><p class="intro-hello">Halo, <strong data-guest-name>Teman Spesial</strong>!</p><p>Kami mengundangmu untuk ikut berpetualang di pesta ulang tahun <strong data-child-name>Raka</strong>. Akan ada banyak kejutan, tawa, permainan, dan kue ulang tahun!</p><p class="intro-sign">See you in the jungle! <span>🌿</span></p></div>
        <div class="child-photo-wrap reveal" id="child-photo-wrap" hidden><div class="child-photo-frame"><img id="child-photo" alt="Foto anak yang berulang tahun" loading="lazy"/><span>✦ THE BIRTHDAY STAR ✦</span></div></div>
        <div class="age-highlight reveal"><span>THE BIRTHDAY EXPLORER IS</span><strong><span data-child-age>5</span> <small>YEARS<br/>OLD!</small></strong><img src="{{ asset('tema/dino-jungle/assets/images/dino-egg.svg') }}" alt="Telur dinosaurus" loading="lazy" /></div>
      </section>
      <!-- COUNTDOWN -->
      <section class="section-pad countdown-section text-center relative" id="countdown"><span class="countdown-deco d1" aria-hidden="true">✴</span><span class="countdown-deco d2" aria-hidden="true">✦</span><p class="eyebrow eyebrow-sand reveal">TICK TOCK... THE DINOS ARE COMING!</p><h2 class="section-title on-dark reveal">Countdown to<br/><em>Adventure!</em></h2><div class="timer-grid grid grid-cols-4 gap-2 reveal" role="timer" aria-label="Hitung mundur ke hari pesta"><div class="timer-cell"><strong id="cd-days">00</strong><span>HARI</span></div><div class="timer-cell"><strong id="cd-hours">00</strong><span>JAM</span></div><div class="timer-cell"><strong id="cd-minutes">00</strong><span>MENIT</span></div><div class="timer-cell"><strong id="cd-seconds">00</strong><span>DETIK</span></div></div><p class="countdown-caption reveal" id="countdown-caption">Siapkan sepatu petualangmu. Pestanya segera dimulai!</p><img class="countdown-egg" src="{{ asset('tema/dino-jungle/assets/images/dino-egg.svg') }}" alt="" loading="lazy"/></section>
      <!-- DETAILS -->
      <section class="section-pad details-section" id="details"><p class="eyebrow reveal">MARK YOUR CALENDAR</p><h2 class="section-title reveal">Your Dino<br/><em>Adventure Pass</em></h2><p class="section-caption reveal">Ini tiket spesialmu untuk masuk ke hutan penuh keseruan.</p><div class="event-ticket reveal"><div class="ticket-header"><span>🎟 EXPLORER PASS</span><span>ADMIT ONE</span></div><div class="ticket-body"><div class="ticket-row"><div class="ticket-icon"><svg><use href="#i-calendar"/></svg></div><div><span class="ticket-kicker">HARI & TANGGAL</span><strong data-event-date>Sabtu, 28 November 2026</strong></div></div><div class="ticket-row"><div class="ticket-icon"><svg><use href="#i-clock"/></svg></div><div><span class="ticket-kicker">WAKTU</span><strong data-event-time>15.00 - 18.00 WIB</strong></div></div><div class="ticket-row"><div class="ticket-icon"><svg><use href="#i-pin"/></svg></div><div><span class="ticket-kicker">TEMPAT</span><strong data-venue>Jungle Party House</strong><small data-address>Alamat lokasi pesta</small></div></div></div><div class="ticket-divider"></div><div class="ticket-footer"><span>✦ DINO JUNGLE CLUB ✦</span><span class="ticket-serial">#DINO-001</span></div></div><div class="button-stack flex flex-col gap-3 reveal"><a href="https://maps.google.com" id="maps-link" class="action-btn action-orange" target="_blank" rel="noopener noreferrer"><svg><use href="#i-pin"/></svg> PETUNJUK LOKASI <span>↗</span></a><button type="button" id="calendar-btn" class="action-btn action-outline"><svg><use href="#i-calendar"/></svg> SIMPAN KE KALENDER <span>↓</span></button></div></section>
      <!-- ITINERARY -->
      @php
        $activeRundowns = $rundowns ?? ($data->rundowns ? $data->rundowns->where('is_active', true)->values() : collect());
      @endphp
      @if ($activeRundowns->isNotEmpty())
      <section class="section-pad agenda-section" id="activities"><p class="eyebrow reveal">WHAT'S THE PLAN?</p><h2 class="section-title reveal">Jurassic<br/><em>Fun Schedule!</em></h2>
        <div id="agenda-list" class="agenda-list flex flex-col gap-3 my-6">
          @foreach ($activeRundowns as $item)
            <div class="agenda-card p-4 rounded-2xl bg-amber-50/80 border border-amber-200/60 shadow-sm text-left">
              <div class="flex items-center justify-between gap-2 mb-2">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold text-white bg-amber-600">
                  ⏰ {{ $item->waktu_mulai }}{{ $item->waktu_selesai ? ' - ' . $item->waktu_selesai : '' }}
                </span>
                @if ($item->acara?->nama_acara)
                  <span class="text-xs font-semibold text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full">
                    {{ $item->acara->nama_acara }}
                  </span>
                @endif
              </div>
              <h3 class="font-bold text-base text-amber-950">{{ $item->nama_kegiatan }}</h3>
              @if ($item->keterangan)<p class="text-xs text-amber-900/80 mt-1">{{ $item->keterangan }}</p>@endif
              @if ($item->lokasi)<p class="text-xs text-amber-700 font-medium mt-1">📍 {{ $item->lokasi }}</p>@endif
            </div>
          @endforeach
        </div>
        <div class="dress-card reveal"><div class="dress-icon">🧢</div><div><strong>Explorer Dress Code</strong><p data-dress-code>Pakai baju favoritmu warna hijau, cokelat, atau kuning!</p></div></div></section>
      @endif
      <!-- GALLERY -->
      <section class="section-pad gallery-section" id="gallery"><p class="eyebrow reveal">SMILES, FUN & MEMORIES</p><h2 class="section-title reveal">Dino Memory<br/><em>Gallery</em></h2><p class="section-caption reveal">Cuplikan petualangan kecil sebelum hari yang besar.</p><div class="gallery-grid grid grid-cols-2 gap-3 mt-6" id="gallery-grid"></div><p class="gallery-hint reveal">Ketuk gambar untuk melihat lebih besar <svg><use href="#i-camera"/></svg></p></section>
      <!-- RSVP -->
      <section class="section-pad rsvp-section" id="rsvp"><p class="eyebrow reveal">DON'T MISS THE FUN!</p><h2 class="section-title reveal">Are You<br/><em>Coming?</em></h2><p class="section-caption reveal">Konfirmasi kehadiran, ya! Para dino sudah tidak sabar bertemu denganmu.</p>
        @if ($ucapanIsActive && ($ucapanPublicIsActive || $kode))
        <form id="rsvp-form" class="form-card mt-6 reveal" novalidate method="POST" action="{{ route('savedoa') }}">
          @csrf
          <input type="hidden" name="dataId" value="{{ $data->id }}">
          @if ($kode)<input type="hidden" name="kode" value="{{ $kode }}">@endif
          <input type="hidden" name="nama" id="backend-rsvp-name">
          <input type="hidden" name="status" id="backend-rsvp-status">
          <input type="hidden" name="ucapan" id="backend-rsvp-message" value="Konfirmasi kehadiran di pesta ulang tahun.">
          <label for="rsvp-name">Nama tamu</label><input id="rsvp-name" name="name" maxlength="80" autocomplete="name" placeholder="Nama lengkapmu" required/><label for="rsvp-attendance">Konfirmasi kehadiran</label><select id="rsvp-attendance" name="attendance" required><option value="">Pilih jawaban...</option><option value="yes">🦖 Ya, aku akan datang!</option><option value="no">Maaf, belum bisa hadir</option></select><div id="rsvp-guest-count-wrap"><label for="rsvp-count">Jumlah yang hadir</label><select id="rsvp-count" name="count"><option value="1">1 orang</option><option value="2">2 orang</option><option value="3">3 orang</option><option value="4">4 orang</option><option value="5">5 orang</option></select></div><button type="submit" class="form-submit">KIRIM KONFIRMASI <span>➜</span></button><p class="form-note">Konfirmasi akan disimpan ke undangan ini.</p>
        </form>
        @else
          <p class="form-note">Form konfirmasi belum tersedia untuk undangan ini.</p>
        @endif
        <div class="rsvp-results reveal"><span>EXPLORER CHECK-IN</span><strong id="rsvp-total">0</strong><small>orang dikonfirmasi hadir di perangkat ini</small></div></section>
      <!-- WISHES -->
      @if ($ucapanViewIsActive)
      <section class="section-pad wishes-section" id="wishes"><p class="eyebrow reveal">LEAVE A LITTLE LOVE</p><h2 class="section-title reveal">Birthday<br/><em>Wishes!</em> 💌</h2><p class="section-caption reveal">Tinggalkan ucapan manis untuk penjelajah kecil kita.</p>
        @if ($ucapanIsActive && ($ucapanPublicIsActive || $kode))
        <form id="wishes-form" class="form-card reveal" novalidate method="POST" action="{{ route('savedoa') }}">
          @csrf
          <input type="hidden" name="dataId" value="{{ $data->id }}">
          @if ($kode)<input type="hidden" name="kode" value="{{ $kode }}">@endif
          <input type="hidden" name="nama" id="backend-wish-name">
          <input type="hidden" name="status" value="ragu">
          <input type="hidden" name="ucapan" id="backend-wish-message">
          <label for="wish-name">Nama kamu</label><input id="wish-name" name="name" maxlength="80" autocomplete="name" placeholder="Tuliskan namamu" required/><label for="wish-message">Pesan &amp; doa</label><textarea id="wish-message" name="message" maxlength="255" rows="4" placeholder="Selamat ulang tahun! Semoga..." required></textarea><button type="submit" class="form-submit">KIRIM UCAPAN <span>➜</span></button>
        </form>
        @else
          <p class="form-note">Form ucapan belum tersedia untuk undangan ini.</p>
        @endif
        <div id="wishes-list" class="wishes-list" aria-live="polite"></div></section>
      @endif
      <!-- OPTIONAL DIGITAL GIFT -->
      @if ($giftEnabled)
      <section class="section-pad gift-section" id="gift"><p class="eyebrow reveal">A LITTLE EXTRA HUG</p><h2 class="section-title reveal">A Gift of <em>Love</em></h2><p class="section-caption reveal">Doa dan kehadiranmu adalah hadiah terindah. Jika berkenan, tersedia pilihan berikut.</p><div class="gift-card reveal"><div class="gift-symbol">🎁</div>
        @foreach ($giftAccounts as $gift)
          <small>{{ $gift->giftPay?->nama_pay ?? 'TRANSFER HADIAH' }}</small>
          <strong>{{ $gift->nomorPay }}</strong>
          <span>a.n. {{ $gift->namaPay }}</span>
          <button type="button" class="copy-button" data-copy-account="{{ $gift->nomorPay }}"><svg><use href="#i-copy"/></svg> SALIN NOMOR REKENING</button>
          @if ($gift->qris)<img class="qris-image" src="{{ $storageUrl($gift->qris) }}" alt="Kode QRIS hadiah digital" loading="lazy"/>@endif
        @endforeach
      </div></section>
      @endif
      <!-- OPTIONAL VIDEO / STREAM -->
      <section class="section-pad extras-section" id="extras" hidden><p class="eyebrow reveal">EXTRA EXPLORER CORNER</p><h2 class="section-title reveal">More Dino <em>Fun</em></h2><div id="milestones-list" class="extras-list"></div><div id="birthday-video-box" hidden><h3>A Little Dino Story 🎬</h3><video id="birthday-video" controls preload="none" playsinline></video></div><a id="streaming-link" class="action-btn action-orange" target="_blank" rel="noopener noreferrer" hidden>LIHAT LIVE STREAM ↗</a><a id="instagram-link" class="action-btn action-outline" target="_blank" rel="noopener noreferrer" hidden>LIHAT INSTAGRAM ↗</a></section>
      <!-- FINAL -->
      <footer class="footer-section section-pad relative" id="closing"><img src="{{ asset('tema/dino-jungle/assets/images/dino-rex-green.svg') }}" class="footer-dino" alt="Dinosaurus hijau melambaikan salam" loading="lazy"/><p class="eyebrow eyebrow-sand reveal">UNTIL WE MEET IN THE JUNGLE</p><h2 class="footer-title reveal">See you<br/><em>there!</em></h2><p class="footer-message reveal">Terima kasih sudah menjadi bagian dari cerita bahagia <strong data-child-name>Raka</strong>. Sampai jumpa di pesta!</p><p class="footer-from reveal">WITH LOVE, <span data-hosts>Raka &amp; Family</span></p><div class="footer-actions flex justify-center gap-2 reveal"><button type="button" class="share-button" id="share-button"><svg><use href="#i-share"/></svg> BAGIKAN UNDANGAN</button></div><div class="footer-small">DINO JUNGLE BIRTHDAY · MADE WITH ♥</div></footer>
    </main>
    <nav class="bottom-nav" aria-label="Navigasi undangan"><a href="#home" class="nav-item active"><svg><use href="#i-home"/></svg><span>Beranda</span></a><a href="#details" class="nav-item"><svg><use href="#i-calendar"/></svg><span>Acara</span></a><a href="#gallery" class="nav-item"><svg><use href="#i-camera"/></svg><span>Galeri</span></a><a href="#rsvp" class="nav-item"><svg><use href="#i-check"/></svg><span>RSVP</span></a><a href="#wishes" class="nav-item"><svg><use href="#i-chat"/></svg><span>Ucapan</span></a></nav>
    <button type="button" id="musicToggle" class="music-toggle" aria-label="Putar musik" aria-pressed="false"><svg><use href="#i-music"/></svg><i class="hidden" aria-hidden="true"></i></button>
    <div id="toast" class="toast" role="status" aria-live="polite"></div>
    <!-- Tap-to-open cover: user gesture triggers optional audio. -->
    <div class="cover" id="cover" role="dialog" aria-modal="true" aria-labelledby="cover-title">
      <div class="cover-scene" aria-hidden="true"><img class="cover-bg" src="{{ asset('tema/dino-jungle/assets/images/jungle-scene.svg') }}" alt=""/><img class="cover-leaf cover-leaf-a" src="{{ asset('tema/dino-jungle/assets/images/jungle-leaves.svg') }}" alt=""/><img class="cover-leaf cover-leaf-b" src="{{ asset('tema/dino-jungle/assets/images/jungle-leaves.svg') }}" alt=""/><img class="cover-rex" src="{{ asset('tema/dino-jungle/assets/images/dino-rex-green.svg') }}" alt=""/><img class="cover-bronto" src="{{ asset('tema/dino-jungle/assets/images/dino-bronto-blue.svg') }}" alt=""/><img class="cover-orange" src="{{ asset('tema/dino-jungle/assets/images/dino-trex-orange.svg') }}" alt=""/></div>
      <div class="cover-body"><div class="cover-stamp">✦ A ROAR-SOME INVITATION ✦</div><p class="cover-roar" aria-hidden="true">ROAR!</p><h2 id="cover-title">You're Invited to<br/><strong><span data-child-name>Raka</span>'s Birthday!</strong></h2><p class="cover-sub">Petualangan dinosaurus menantimu! 🌴🦕</p><div class="guest-invite"><small>KEPADA YTH.</small><strong data-guest-name>Teman Spesial</strong></div><button type="button" id="open-invitation" class="open-invitation"><svg><use href="#i-mail"/></svg> BUKA UNDANGAN <span>➜</span></button><p class="cover-note">Ketuk untuk membuka undangan <span>✦</span> Musik opsional</p></div>
    </div>
    <div class="lightbox" id="lightbox" hidden role="dialog" aria-modal="true" aria-label="Pratinjau foto"><button type="button" id="lightbox-close" class="lightbox-close" aria-label="Tutup foto"><svg><use href="#i-x"/></svg></button><img id="lightbox-image" alt=""/><p id="lightbox-caption"></p></div>
  </div>
  @include('tema.partials.music')
</body>
</html>
