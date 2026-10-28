@php
    use Carbon\Carbon;

    Carbon::setLocale('id');

    $birthday = $data->birthdayProfile;
    $birthdayName = $birthday?->name ?? $data->title ?? 'Birthday';
    $birthdayNickname = $birthday?->nickname ?? $birthdayName;
    $birthdayAge = (int) ($birthday?->age ?? 0);
    $storageUrl = fn ($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
    $birthdayPhoto = $storageUrl($birthday?->photo) ?? asset('tema/princess-fairytale/assets/images/child-photo.webp');
    $firstEvent = $acara ?? $data->acara?->first();
    $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
    $eventTime = $firstEvent?->jam_start ?: '00:00';
    $eventDateTime = $eventDate
        ? Carbon::parse($firstEvent->date . ' ' . $eventTime, config('app.timezone', 'Asia/Jakarta'))
        : null;
    $eventDateText = $eventDate?->translatedFormat('l, d F Y') ?? 'Tanggal acara';
    $eventTimeLabel = trim(collect([$firstEvent?->jam_start, $firstEvent?->zona_waktu])->filter()->join(' '));
    $venueName = $firstEvent?->vanue ?? $firstEvent?->nama_acara ?? 'Birthday Celebration';
    $address = $firstEvent?->alamat ?? 'Lokasi acara';
    $familyName = $data->eventDetail?->host_name ?? $birthday?->parent_name ?? 'Keluarga ' . $birthdayName;
    $dressCode = $data->eventDetail?->dress_code ?? 'Pastel Pink · Lilac · Cream';
    $gallery = collect($poto ?? [])->filter()->map(fn ($photo, $index) => [
        'src' => $storageUrl($photo),
        'caption' => $index === 0 ? 'Our little princess' : 'A precious memory',
        'alt' => 'Foto ' . $birthdayNickname,
    ])->values()->all();
    if (! $gallery) {
        $gallery = [
            ['src' => $birthdayPhoto, 'caption' => 'Our little princess', 'alt' => 'Foto ' . $birthdayNickname],
            ['src' => asset('tema/princess-fairytale/assets/images/garden.svg'), 'caption' => 'A magical little world', 'alt' => 'Taman pastel penuh bunga'],
            ['src' => asset('tema/princess-fairytale/assets/images/castle.svg'), 'caption' => 'A castle of dreams', 'alt' => 'Ilustrasi kastel dongeng'],
            ['src' => asset('tema/princess-fairytale/assets/images/carriage.svg'), 'caption' => 'And a little fairy dust', 'alt' => 'Ilustrasi kereta kuda kerajaan'],
        ];
    }
    $schedule = $data->acara?->map(fn ($item) => [
        'time' => trim(collect([$item->jam_start, $item->zona_waktu])->filter()->join(' ')),
        'name' => $item->nama_acara ?: 'Birthday celebration',
        'detail' => $item->alamat ?: 'A magical moment with family and friends',
        'icon' => '✧',
    ])->values()->all() ?: [];
    $ucapanIsActive = $data->FiturUcapan?->isActive ?? true;
    $ucapanPublicIsActive = $data->FiturUcapan?->publicIsActive ?? true;
    $ucapanViewIsActive = $data->FiturUcapan?->viewIsActive ?? true;
    $sampleWishes = $ucapanViewIsActive
        ? $ucapan->map(fn ($item) => [
            'name' => $item->tamu?->nama ?? 'Tamu',
            'message' => $item->ucapan,
        ])->values()->all()
        : [];
    $giftEnabled = $data->fiturKado?->isActive && $data->kado?->isNotEmpty();
    $giftAccounts = $giftEnabled ? $data->kado : collect();
    $pageTitle = ($data->eventDetail?->headline ?? 'Princess Birthday') . ' · ' . $birthdayNickname;
    $invitationConfig = [
        'childName' => $birthdayName,
        'childNickname' => $birthdayNickname,
        'turningAge' => $birthdayAge,
        'childPhoto' => $birthdayPhoto,
        'familyName' => $familyName,
        'eventDate' => $eventDateTime?->format('c') ?: '',
        'eventTimeZone' => config('app.timezone', 'Asia/Jakarta'),
        'eventTimeLabel' => $eventTimeLabel ?: 'Waktu acara',
        'venueName' => $venueName,
        'address' => $address,
        'mapsQuery' => trim($venueName . ' ' . $address),
        'mapsUrl' => $firstEvent?->maps,
        'dressCode' => $dressCode,
        'music' => ['enabled' => false],
        'schedule' => $schedule,
        'gallery' => $gallery,
        'sampleWishes' => $sampleWishes,
        'backend' => ['rsvp' => $ucapanIsActive && ($ucapanPublicIsActive || $kode)],
        'gift' => ['demo' => false],
    ];
@endphp
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta name="theme-color" content="#f8dce9" />
  <meta name="description" content="Undangan ulang tahun putri kecil kami. A little celebration full of magic, love and sweet memories." />
  <title>Princess Birthday — Undangan Ulang Tahun</title>
  <!-- Tailwind CSS sudah di-compile secara lokal: tidak memerlukan koneksi/CDN. -->
  <meta property="og:title" content="{{ $data->title ?? $pageTitle }}" />
  <meta property="og:description" content="Acara akan dilaksanakan pada {{ $eventDateText }}." />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:type" content="website" />
  @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title ?? $pageTitle])
  <link rel="stylesheet" href="{{ asset('tema/princess-fairytale/assets/css/tailwind.css') }}" />
  <link rel="stylesheet" href="{{ asset('tema/princess-fairytale/assets/css/style.css') }}" />
  <script>
    window.INVITATION_CONFIG = {!! json_encode($invitationConfig, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
  </script>
  <script src="{{ asset('tema/princess-fairytale/assets/js/app.js') }}" defer></script>
</head>
<body>
  <svg class="svg-symbols" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <symbol id="i-heart" viewBox="0 0 24 24"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z"/></symbol>
    <symbol id="i-music" viewBox="0 0 24 24"><path d="M9 18V5l12-2v13M9 9l12-2"/><ellipse cx="6" cy="18" rx="3" ry="2"/><ellipse cx="18" cy="16" rx="3" ry="2"/></symbol>
    <symbol id="i-sound-off" viewBox="0 0 24 24"><path d="M9 18V5l12-2v13M9 9l12-2"/><path d="m3 3 18 18"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4m10-4v4M3 10h18"/></symbol>
    <symbol id="i-pin" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></symbol>
    <symbol id="i-gift" viewBox="0 0 24 24"><rect x="3" y="9" width="18" height="12" rx="1"/><path d="M2 9h20M12 9v12M12 9c-8 0-10-8-5-8 3 0 5 4 5 8Zm0 0c8 0 10-8 5-8-3 0-5 4-5 8Z"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14m-6-6 6 6-6 6"/></symbol>
    <symbol id="i-sparkle" viewBox="0 0 24 24"><path d="m12 2 2.1 7.9L22 12l-7.9 2.1L12 22l-2.1-7.9L2 12l7.9-2.1Z"/></symbol>
    <symbol id="i-share" viewBox="0 0 24 24"><path d="M12 15V3m-5 5 5-5 5 5M5 13v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7"/></symbol>
    <symbol id="i-copy" viewBox="0 0 24 24"><rect x="8" y="8" width="12" height="13" rx="2"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3"/></symbol>
    <symbol id="i-close" viewBox="0 0 24 24"><path d="M5 5 19 19M19 5 5 19"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></symbol>
  </svg>

  <div id="scroll-progress" class="scroll-progress" aria-hidden="true"></div>
  <div class="desktop-glow" aria-hidden="true"></div>
  <div class="desktop-decoration desktop-decoration-left" aria-hidden="true"><img src="{{ asset('tema/princess-fairytale/assets/images/floral-corner.svg') }}" alt="" /></div>
  <div class="desktop-decoration desktop-decoration-right" aria-hidden="true"><img src="{{ asset('tema/princess-fairytale/assets/images/floral-corner.svg') }}" alt="" /></div>

  <div class="site-shell relative mx-auto overflow-hidden" id="page">
    <main id="main-content">
      <section class="hero relative min-h-screen overflow-hidden text-center" id="beranda" aria-labelledby="hero-name">
        <div class="hero-sky" aria-hidden="true"></div>
        <div class="hero-halo" aria-hidden="true"></div>
        <div class="hero-floral hero-floral-left" aria-hidden="true"></div>
        <div class="hero-floral hero-floral-right" aria-hidden="true"></div>
        <div class="sparkle-field" id="hero-sparkles" aria-hidden="true"></div>
        <img class="butterfly butterfly-left" src="{{ asset('tema/princess-fairytale/assets/images/butterfly.svg') }}" alt="" aria-hidden="true" />
        <img class="butterfly butterfly-right" src="{{ asset('tema/princess-fairytale/assets/images/butterfly.svg') }}" alt="" aria-hidden="true" />

        <div class="relative z-10 flex min-h-screen flex-col items-center justify-start px-7 pb-16 pt-14">
          <div class="hero-top reveal-fade">
            <p class="eyebrow mb-3">a little princess is turning two</p>
            <div class="royal-rule"><span>✦</span><span>✧</span><span>✦</span></div>
            <p class="invited-copy">You're invited to</p>
            <p class="tiny-script">a magical birthday</p>
          </div>
          <div class="portrait-stage relative mt-6">
            <img class="hero-crown" src="{{ asset('tema/princess-fairytale/assets/images/crown.svg') }}" alt="" aria-hidden="true" />
            <div class="portrait-ring">
              <div class="portrait-inner"><img data-child-photo src="{{ $birthdayPhoto }}" alt="Foto {{ $birthdayNickname }}" /></div>
            </div>
            <span class="portrait-star portrait-star-a" aria-hidden="true">✦</span>
            <span class="portrait-star portrait-star-b" aria-hidden="true">✧</span>
            <span class="portrait-star portrait-star-c" aria-hidden="true">✦</span>
          </div>
          <div class="relative z-10 mt-5">
            <span class="age-pill"><span>✦</span> Our sweet little princess <span>✦</span></span>
            <h1 id="hero-name" class="hero-name mt-2" data-bind="childName">Alenna Elise</h1>
            <p class="hero-birthday" data-age-title>2nd Birthday Celebration</p>
            <div class="flex justify-center py-3"><div class="ornamental-divider">❦ <span>✧</span> ❦</div></div>
            <p class="hero-date" data-event-date-full>Friday, October 23, 2026</p>
            <p class="hero-time" data-bind="eventTimeLabel">2:00 PM · Friday</p>
          </div>
          <img class="hero-castle" src="{{ asset('tema/princess-fairytale/assets/images/castle.svg') }}" alt="" aria-hidden="true" />
          <div class="hero-scroll-note mt-auto pt-9" aria-hidden="true"><span>SCROLL TO EXPLORE</span><i></i></div>
        </div>
        <div class="wave-divider wave-cream" aria-hidden="true"></div>
      </section>

      <section class="invitation-section relative overflow-hidden px-8 pb-16 pt-14 text-center" id="undangan">
        <span class="section-small-icon reveal">✧</span>
        <p class="eyebrow reveal" data-reveal-delay="80">an invitation from the heart</p>
        <h2 class="section-title reveal" data-reveal-delay="120">A little magic<br /><em>is in the air</em></h2>
        <p class="body-copy reveal" data-reveal-delay="180">Once upon a time, a tiny princess filled our world with love, laughter, and endless wonder.</p>
        <p class="body-copy reveal" data-reveal-delay="220">With hearts full of joy, we invite you to celebrate the birthday of our precious little one.</p>
        <div class="invitation-monogram reveal" data-reveal-delay="250">
          <img src="{{ asset('tema/princess-fairytale/assets/images/crown.svg') }}" alt="" aria-hidden="true" />
          <div class="child-script" data-bind="childNickname">Alenna</div>
          <small>WITH LOVE FROM OUR FAMILY</small>
        </div>
      </section>

      <section class="countdown-section relative px-7 py-16 text-center" id="countdown" aria-labelledby="countdown-heading">
        <div class="section-frame reveal">
          <p class="eyebrow">counting down to a magical day</p>
          <h2 id="countdown-heading" class="section-title section-title-sm">The magic<br /><em>begins in</em></h2>
          <div class="countdown-grid mt-8 grid grid-cols-4 gap-2" role="timer" aria-label="Hitung mundur menuju acara">
            <div class="countdown-tile"><strong id="days">00</strong><small>DAYS</small></div>
            <div class="countdown-tile"><strong id="hours">00</strong><small>HOURS</small></div>
            <div class="countdown-tile"><strong id="minutes">00</strong><small>MINS</small></div>
            <div class="countdown-tile"><strong id="seconds">00</strong><small>SECS</small></div>
          </div>
          <p class="countdown-footer" id="countdown-caption">We can't wait to celebrate with you!</p>
        </div>
      </section>

      <section class="details-section relative px-7 pb-16 pt-16 text-center" id="acara" aria-labelledby="details-heading">
        <div class="section-head reveal">
          <span class="section-small-icon">♛</span>
          <p class="eyebrow">save the magical date</p>
          <h2 id="details-heading" class="section-title">The royal <em>party</em></h2>
          <p class="body-copy max-w-sm mx-auto">A royal celebration filled with giggles, wishes, cake, and fairy-tale memories.</p>
        </div>
        <div class="event-card reveal" data-reveal-delay="130">
          <div class="card-edge card-edge-top" aria-hidden="true"></div>
          <div class="event-card-inner">
            <div class="event-icon">✧</div>
            <h3 class="event-title">Birthday Celebration</h3>
            <p class="event-date-value" data-event-date-full>Friday, 23 October 2026</p>
            <div class="card-hairline"></div>
            <div class="flex items-center justify-center gap-2 event-detail"><svg class="mini-icon"><use href="#i-calendar" /></svg><span data-bind="eventTimeLabel">2:00 PM</span></div>
            <div class="flex items-center justify-center gap-2 event-detail"><svg class="mini-icon"><use href="#i-pin" /></svg><span data-bind="venueName">Sky Hall · Seaside City</span></div>
            <p class="event-address" data-bind="address">Cebu South Coastal Road, Cebu City</p>
            <a href="#lokasi" class="primary-button inline-flex items-center justify-center gap-2 mt-6">View the location <svg class="mini-icon"><use href="#i-arrow" /></svg></a>
          </div>
          <div class="card-edge card-edge-bottom" aria-hidden="true"></div>
        </div>
        <div class="dress-code reveal" data-reveal-delay="170"><span class="dress-icon">♡</span><div><span class="eyebrow">dress code</span><p data-bind="dressCode">Pastel Pink • Lilac • Cream</p></div></div>
      </section>

      @php
        $activeRundowns = $rundowns ?? ($data->rundowns ? $data->rundowns->where('is_active', true)->values() : collect());
      @endphp
      @if ($activeRundowns->isNotEmpty())
      <section class="timeline-section relative px-8 py-16 text-center" id="rundown">
        <p class="eyebrow reveal">the day's little wonders</p>
        <h2 class="section-title reveal">A day of <em>wishes</em></h2>
        <div class="timeline mt-10 text-left" id="timeline-list">
          @foreach ($activeRundowns as $item)
            <div class="timeline-item reveal mb-6" style="padding-left: 1.5rem; border-left: 2px dashed #f4a2b8; position: relative;">
              <span style="position: absolute; left: -7px; top: 0; width: 12px; height: 12px; border-radius: 50%; background: #e06d8a;"></span>
              <div class="flex items-center gap-2 mb-1">
                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold text-white" style="background: linear-gradient(135deg, #e06d8a, #c84b6c);">
                  {{ $item->waktu_mulai }}{{ $item->waktu_selesai ? ' - ' . $item->waktu_selesai : '' }}
                </span>
                @if ($item->acara?->nama_acara)
                  <span class="text-xs text-pink-700 opacity-80">({{ $item->acara->nama_acara }})</span>
                @endif
              </div>
              <h3 class="font-bold text-base text-gray-800" style="font-family: inherit;">{{ $item->nama_kegiatan }}</h3>
              @if ($item->keterangan)<p class="text-xs text-gray-600 mt-0.5">{{ $item->keterangan }}</p>@endif
              @if ($item->lokasi)<p class="text-xs text-pink-600 mt-1">📍 {{ $item->lokasi }}</p>@endif
            </div>
          @endforeach
        </div>
      </section>
      @endif

      <section class="gallery-section relative px-6 pb-16 pt-16 text-center" id="galeri" aria-labelledby="gallery-heading">
        <span class="section-small-icon reveal">✿</span>
        <p class="eyebrow reveal">little moments, big memories</p>
        <h2 id="gallery-heading" class="section-title reveal">Our <em>fairy tale</em></h2>
        <p class="body-copy reveal">A few precious moments of our little princess.</p>
        <div class="gallery-grid mt-9 grid grid-cols-2 gap-3" id="gallery-grid"></div>
        <p class="gallery-hint mt-6">✧ tap a memory to see it closer ✧</p>
      </section>

      <section class="location-section px-7 py-16 text-center" id="lokasi" aria-labelledby="location-heading">
        <p class="eyebrow reveal">follow the path to magic</p>
        <h2 id="location-heading" class="section-title reveal">Find the <em>castle</em></h2>
        <div class="map-card reveal mt-7" data-reveal-delay="100">
          <div class="map-topline"><svg class="mini-icon"><use href="#i-pin" /></svg> THE CELEBRATION PLACE</div>
          <div class="map-frame"><iframe id="map-iframe" title="Peta lokasi ulang tahun" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
          <div class="map-card-bottom"><h3 data-bind="venueName">Sky Hall · Seaside City</h3><p data-bind="address">Cebu South Coastal Rd, Cebu City</p><a id="map-link" class="primary-button inline-flex items-center justify-center gap-2 mt-5" target="_blank" rel="noopener noreferrer">Open Google Maps <svg class="mini-icon"><use href="#i-arrow" /></svg></a></div>
        </div>
      </section>

      <section class="rsvp-section relative px-7 py-16" id="rsvp" aria-labelledby="rsvp-heading">
        <div class="text-center"><span class="section-small-icon reveal">♡</span><p class="eyebrow reveal">your presence is our present</p><h2 class="section-title reveal" id="rsvp-heading">Kindly <em>RSVP</em></h2><p class="body-copy reveal">Let us know if you can join our magical celebration.</p></div>
        @if ($ucapanIsActive && ($ucapanPublicIsActive || $kode))
        <form id="rsvp-form" class="form-card reveal mt-8" data-reveal-delay="100" method="POST" action="{{ route('savedoa') }}">
          @csrf
          <input type="hidden" name="dataId" value="{{ $data->id }}">
          @if ($kode)<input type="hidden" name="kode" value="{{ $kode }}">@endif
          <input type="hidden" name="nama" id="backend-name">
          <input type="hidden" name="status" id="backend-status">
          <input type="hidden" name="ucapan" id="backend-wish">
          <label class="field-label" for="guest-name">Your name</label>
          <input id="guest-name" name="name" type="text" maxlength="70" minlength="2" placeholder="Enter your name" autocomplete="name" required />
          <label class="field-label mt-5" for="attendance">Will you attend?</label>
          <select id="attendance" name="attendance" required><option value="" selected disabled>Choose your answer</option><option value="yes">Happily accept ♡</option><option value="no">Sorry, can't make it</option><option value="maybe">Still confirming</option></select>
          <div id="guests-field" class="mt-5" hidden><label class="field-label" for="guests">Number of guests</label><select id="guests" name="guests"><option value="1">1 guest</option><option value="2">2 guests</option><option value="3">3 guests</option><option value="4">4 guests</option><option value="5">5 guests</option></select></div>
          <label class="field-label mt-5" for="wish-text">A sweet birthday wish <span>(optional)</span></label>
          <textarea id="wish-text" name="wish" rows="4" maxlength="255" placeholder="Write a lovely wish for the birthday princess..." required></textarea>
          <button type="submit" class="primary-button w-full mt-6 flex items-center justify-center gap-2">Send my wishes <svg class="mini-icon"><use href="#i-heart" /></svg></button>
          <p class="form-note" id="rsvp-note">Preview mode: your RSVP is saved in this browser.</p>
        </form>
        @else
          <p class="form-note reveal mt-8">Form ucapan belum tersedia untuk undangan ini.</p>
        @endif
      </section>

      @if ($ucapanViewIsActive)
      <section class="wishes-section px-7 pb-16 pt-12" id="ucapan" aria-labelledby="wishes-heading">
        <div class="text-center"><p class="eyebrow reveal">messages sprinkled with love</p><h2 class="section-title reveal" id="wishes-heading">Sweet <em>wishes</em></h2><p class="body-copy reveal">Every loving wish makes this day even more special.</p></div>
        <div id="wishes-list" class="mt-8 space-y-4" aria-live="polite"></div>
      </section>
      @endif

      @if ($giftEnabled)
      <section class="gift-section relative px-7 py-16 text-center" id="hadiah" aria-labelledby="gift-heading">
        <div class="gift-art reveal"><img src="{{ asset('tema/princess-fairytale/assets/images/carriage.svg') }}" alt="Ilustrasi kereta putri kerajaan" /></div>
        <p class="eyebrow reveal">a little note of thanks</p>
        <h2 class="section-title reveal" id="gift-heading">Gifts &amp; <em>blessings</em></h2>
        <p class="body-copy reveal">Your love, prayers, and presence are the greatest gift. For those who wish to send something special:</p>
        <button class="outline-button mt-7 reveal" id="open-gift" type="button"><svg class="mini-icon"><use href="#i-gift" /></svg> Gift information</button>
      </section>
      @endif

      <footer class="footer-section relative px-8 pb-32 pt-16 text-center" id="penutup">
        <img class="footer-crown mx-auto" src="{{ asset('tema/princess-fairytale/assets/images/crown.svg') }}" alt="" aria-hidden="true" />
        <p class="eyebrow mt-4">thank you for being part of our story</p>
        <h2 class="footer-heading">See you<br /><em>at the castle!</em></h2>
        <p class="body-copy mt-5">With lots of love,</p>
        <p class="family-signature" data-bind="familyName">Alenna's Family</p>
        <div class="footer-share mt-8 flex flex-wrap items-center justify-center gap-3">
          <button class="outline-button footer-button" type="button" id="share-btn"><svg class="mini-icon"><use href="#i-share" /></svg> Share</button>
          <button class="outline-button footer-button" type="button" id="calendar-btn"><svg class="mini-icon"><use href="#i-calendar" /></svg> Add to calendar</button>
        </div>
        <p class="footer-credit mt-12">MADE WITH ♡ · PRINCESS FAIRYTALE BIRTHDAY</p>
      </footer>
    </main>
  </div>

  <nav class="bottom-nav" aria-label="Navigasi undangan">
    <a href="#beranda" class="nav-item is-active" data-nav="beranda"><span>♛</span><small>Home</small></a>
    <a href="#acara" class="nav-item" data-nav="acara"><svg><use href="#i-calendar" /></svg><small>Event</small></a>
    <a href="#galeri" class="nav-item" data-nav="galeri"><span>✿</span><small>Gallery</small></a>
    <a href="#rsvp" class="nav-item" data-nav="rsvp"><svg><use href="#i-heart" /></svg><small>RSVP</small></a>
    @if ($giftEnabled)<a href="#hadiah" class="nav-item" data-nav="hadiah"><svg><use href="#i-gift" /></svg><small>Gift</small></a>@endif
  </nav>
  @if ($data->sound?->isActive && $data->sound?->sound && $data->sound?->sound !== 'null')
    <button type="button" class="music-button" id="musicToggle" title="Putar atau jeda musik" aria-label="Putar atau jeda musik" aria-pressed="false"><svg><use href="#i-music" /></svg><i class="hidden" aria-hidden="true"></i><span class="music-signal"></span></button>
    @include('tema.partials.music', ['data' => $data])
  @endif

  <div id="cover-screen" class="cover-screen" role="dialog" aria-modal="true" aria-labelledby="cover-title">
    <div class="cover-scene">
      <div class="cover-top-flowers" aria-hidden="true"></div>
      <div class="cover-top-flowers cover-top-flowers-right" aria-hidden="true"></div>
      <div class="cover-shine" aria-hidden="true"></div>
      <div class="cover-content relative z-10 flex flex-col items-center text-center">
        <img class="cover-crown" src="{{ asset('tema/princess-fairytale/assets/images/crown.svg') }}" alt="" aria-hidden="true" />
        <p class="eyebrow">you are cordially invited to</p>
        <h2 class="cover-script">A royal birthday</h2>
        <div class="cover-photo-frame"><img data-child-photo src="{{ $birthdayPhoto }}" alt="Foto {{ $birthdayNickname }}" /></div>
        <h2 id="cover-title" class="cover-name" data-bind="childName">Alenna Elise</h2>
        <p class="cover-age" data-age-title>2nd Birthday Celebration</p>
        <div class="royal-rule cover-rule">✧ ✦ ✧</div>
        <div class="guest-to"><span>SPECIAL INVITATION FOR</span><strong id="invited-guest">{{ $tamu ?? 'Tamu Undangan' }}</strong></div>
        <button type="button" class="primary-button cover-open-button" id="open-invitation">✧ &nbsp; Open Invitation &nbsp; ✧</button>
        <p class="cover-instruction">Tap to open your magical invitation</p>
      </div>
      <img class="cover-castle" src="{{ asset('tema/princess-fairytale/assets/images/castle.svg') }}" alt="" aria-hidden="true" />
      <div class="cover-bottom-clouds" aria-hidden="true"></div>
    </div>
  </div>

  @if ($giftEnabled)
  <div class="modal-overlay" id="gift-modal" hidden>
    <div class="modal-sheet" role="dialog" aria-modal="true" aria-labelledby="gift-modal-title" tabindex="-1">
      <button type="button" class="modal-close" data-close-modal="gift-modal" aria-label="Tutup"><svg><use href="#i-close" /></svg></button>
      <div class="modal-heading-icon">✧</div>
      <p class="eyebrow">with all our love</p><h2 id="gift-modal-title" class="section-title section-title-sm">Little <em>gifts</em></h2>
      <p class="body-copy">Your prayers and warm wishes mean the world to us.</p>
      @foreach ($giftAccounts as $gift)
        <div class="bank-card mt-5" id="bank-card"><small>{{ $gift->giftPay?->nama_pay ?? 'Transfer' }}</small><strong>{{ $gift->nomorPay }}</strong><span>{{ $gift->namaPay }}</span><button type="button" class="copy-button" data-copy-account="{{ $gift->nomorPay }}"><svg><use href="#i-copy" /></svg> Copy account number</button></div>
      @endforeach
      <p class="demo-warning" id="gift-demo-warning">DATA DEMO — bukan rekening aktif. Ganti di config.js sebelum digunakan.</p>
      <div class="gift-shipping" id="gift-shipping" hidden><strong>Send a physical gift</strong><p id="gift-shipping-address"></p></div>
    </div>
  </div>
  @endif

  <div class="modal-overlay" id="gallery-modal" hidden>
    <div class="gallery-modal-content" role="dialog" aria-modal="true" aria-label="Foto galeri diperbesar" tabindex="-1"><button type="button" class="modal-close gallery-close" data-close-modal="gallery-modal" aria-label="Tutup"><svg><use href="#i-close" /></svg></button><img id="gallery-large" src="" alt="" /><p id="gallery-caption"></p></div>
  </div>

  <div id="toast" class="toast" role="status" aria-live="polite"></div>
</body>
</html>
