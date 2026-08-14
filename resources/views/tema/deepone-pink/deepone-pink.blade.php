<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    @php
        use Carbon\Carbon;

        Carbon::setLocale('id');

        $pria = $data->pria;
        $wanita = $data->wanita;
        $firstEvent = $acara ?? $data->acara->first();
        $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
        $eventTime = $firstEvent?->jam_start ?: '00:00';
        $eventDateText = $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Tanggal acara';
        $countdownDate = $eventDate
            ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Y-m-d\TH:i:s')
            : now()->format('Y-m-d\TH:i:s');
        $storageUrl = fn($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
        $coverImage =
            $storageUrl($data->coverUndangan?->cover_satu) ??
            ((count($poto ?? []) ? $storageUrl($poto[0]) : null) ??
                'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&auto=format');
        $heroImage =
            $storageUrl($data->coverUndangan?->cover_dua) ??
            ((count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null) ??
                'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&auto=format');
        $priaImage =
            $storageUrl($pria?->image) ??
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format';
        $wanitaImage =
            $storageUrl($wanita?->image) ??
            'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=400&auto=format';
        $coupleNames = ($pria?->nama_panggilan ?? 'Mempelai') . ' & ' . ($wanita?->nama_panggilan ?? 'Mempelai');
        $pageTitle = ($data->setting?->acara ?? 'The Wedding Of') . ' ' . $coupleNames;
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:site_name" content="Wayae Nikah">
    <meta property="og:title" content="{{ $data->title ?? $pageTitle }}">
    <meta property="og:image" content="{{ url('storage/' . ($data->thumbnailWas?->thumbnail ?? '')) }}">
    <meta property="og:image:secure_url" content="{{ url('storage/' . ($data->thumbnailWas?->thumbnail ?? '')) }}">
    <meta property="og:description" content="Acara akan dilaksanakan pada {{ $eventDateText }}.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fff5f8;
            overflow-x: hidden;
            color: #5e3a4a;
            position: relative;
            min-height: 100vh;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: radial-gradient(circle at 20% 20%, rgba(247, 190, 221, 0.26) 0 6px, transparent 7px),
                radial-gradient(circle at 80% 35%, rgba(245, 169, 199, 0.2) 0 8px, transparent 9px),
                radial-gradient(circle at 35% 85%, rgba(255, 217, 232, 0.24) 0 7px, transparent 8px);
            background-size: 120px 120px;
            animation: swayBunga 20s infinite alternate ease-in-out;
        }

        @keyframes swayBunga {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.6;
            }

            100% {
                transform: translateY(15px) rotate(3deg);
                opacity: 0.9;
            }
        }

        .phone-container {
            max-width: 500px;
            margin: 0 auto;
            background: #fffafc;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
            min-height: 100vh;
            position: relative;
            z-index: 2;
        }

        .cover-screen {
            position: fixed;
            inset: 0;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            height: 100vh;
            background: #2d1e24;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            opacity: 1;
        }

        .cover-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.5);
            z-index: -1;
        }

        .cover-content {
            padding: 32px 24px;
            color: white;
            z-index: 2;
            animation: fadeInUp 1s ease;
        }

        .cover-content h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            letter-spacing: 2px;
            font-size: 1rem;
            margin-bottom: 16px;
        }

        .cover-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            margin: 12px 0;
            line-height: 1.2;
        }

        .cover-date {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 32px;
        }

        .guest-card {
            background: rgba(255, 255, 245, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 48px;
            padding: 16px 24px;
            margin: 24px 0;
            border: 1px solid rgba(255, 200, 220, 0.5);
        }

        .guest-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-top: 6px;
            color: #ffe0f0;
        }

        .btn-gold {
            background: #e9a2c0;
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 1rem;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 20px;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
        }

        .btn-gold:active {
            transform: scale(0.96);
            background: #db8aac;
        }

        .main-content {
            display: none;
            opacity: 0;
            transition: opacity 0.5s;
        }

        .main-content.show {
            display: block;
            opacity: 1;
        }

        section {
            padding: 48px 24px;
            border-bottom: 1px solid #fbe4ef;
            position: relative;
            transition: transform 0.6s ease, opacity 0.6s ease;
            transform: translateY(35px);
            opacity: 0;
            background-color: rgba(255, 253, 249, 0.85);
        }

        section.section-visible {
            transform: translateY(0);
            opacity: 1;
        }

        .hero-bg-section {
            background: linear-gradient(rgba(80, 40, 55, 0.65), rgba(60, 30, 40, 0.7)), url('{{ $heroImage }}');
            background-size: cover;
            background-position: center 30%;
            border-radius: 0 0 48px 48px;
            margin-top: -20px;
            padding-top: 60px;
            color: #fff;
        }

        .hero-bg-section .couple-names-hero,
        .hero-bg-section .hero-date,
        .hero-bg-section .quote-block,
        .hero-bg-section .countdown .cd-card {
            color: #fff9f0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .hero-bg-section .countdown .cd-card {
            background: rgba(245, 200, 220, 0.25);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 200, 220, 0.6);
        }

        .hero-bg-section .quote-block {
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(4px);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            text-align: center;
            margin-bottom: 32px;
            color: #c27e9b;
            letter-spacing: -0.3px;
        }

        .floral-divider {
            text-align: center;
            font-size: 1.2rem;
            color: #e9a2c0;
            margin: 24px 0;
            animation: gentleFloat 3s ease-in-out infinite;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .floral-divider span {
            display: inline-block;
            animation: softSpin 6s infinite alternate;
        }

        @keyframes gentleFloat {

            0%,
            100% {
                transform: translateY(0);
                opacity: 0.7;
            }

            50% {
                transform: translateY(5px);
                opacity: 1;
            }
        }

        @keyframes softSpin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(8deg);
            }
        }

        .couple-names-hero {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .hero-date {
            text-align: center;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .quote-block {
            background: #fff0f5;
            padding: 24px;
            border-radius: 28px;
            font-style: italic;
            text-align: center;
            margin: 24px 0;
            color: #a05e7c;
        }

        .countdown {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 28px 0;
        }

        .cd-card {
            background: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            flex: 1;
            text-align: center;
            padding: 14px 6px;
            border: 1px solid #fad5e5;
        }

        .cd-number {
            font-size: 1.8rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            color: #d48db0;
        }

        .couple-card {
            background: #fff7fa;
            border-radius: 32px;
            padding: 24px;
            margin: 24px 0;
            text-align: center;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.05);
        }

        .couple-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 16px;
            border: 3px solid #f5bed9;
        }

        .ampersand {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            text-align: center;
            color: #e9a2c0;
        }

        .timeline-item {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
            position: relative;
            background: #fff8fb;
            padding: 16px;
            border-radius: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            align-items: center;
            flex-wrap: wrap;
        }

        .timeline-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 28px;
            border: 2px solid #f7c0db;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-content strong {
            font-size: 1.1rem;
            display: block;
            color: #b46384;
        }

        .event-card,
        .gift-card {
            background: #fff9fc;
            border-radius: 32px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #fad5e5;
        }

        .btn-outline-gold {
            background: none;
            border: 1.5px solid #e9a2c0;
            padding: 10px 20px;
            border-radius: 40px;
            color: #b15e82;
            font-weight: 500;
            margin-top: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .gallery-grid img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 24px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .gallery-grid img:first-child {
            grid-column: span 2;
            height: 240px;
        }

        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            visibility: hidden;
            opacity: 0;
        }

        .lightbox.active {
            visibility: visible;
            opacity: 1;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 16px;
        }

        .wish-card {
            background: #fff7fa;
            border: 1px solid #fad5e5;
            border-radius: 28px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .wish-alert {
            border-radius: 22px;
            padding: 12px 14px;
            margin-bottom: 14px;
            display: none;
            font-size: 0.9rem;
        }

        .wish-alert.success {
            background: #eef8ed;
            border: 1px solid #a9d8a2;
        }

        .wish-alert.error {
            background: #fff0ee;
            border: 1px solid #e7a59b;
        }

        .floating-music {
            position: fixed;
            bottom: 80px;
            right: 16px;
            z-index: 1200;
            background: #ffeef4cc;
            backdrop-filter: blur(6px);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            color: #d982a8;
            border: 1px solid #f9c2dd;
        }

        .bottom-nav {
            position: fixed;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 32px);
            max-width: 440px;
            background: rgba(255, 240, 245, 0.9);
            backdrop-filter: blur(16px);
            border-radius: 60px;
            display: flex;
            justify-content: space-around;
            padding: 10px 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1100;
            border: 1px solid rgba(245, 190, 210, 0.5);
        }

        .nav-item {
            text-align: center;
            color: #b15e82;
            font-size: 0.7rem;
            transition: 0.2s;
            cursor: pointer;
        }

        .nav-item i {
            font-size: 1.4rem;
            display: block;
            margin-bottom: 4px;
        }

        .nav-item.active {
            background: #e9a2c0;
            color: white;
            box-shadow: 0 2px 8px rgba(233, 162, 192, 0.3);
            border-radius: 40px;
            padding: 6px 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 14px;
            border-radius: 32px;
            border: 1px solid #f7c0db;
            margin-bottom: 14px;
            font-family: inherit;
            background: white;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 500px) {

            .phone-container,
            .cover-screen {
                max-width: 100%;
            }

            .countdown {
                gap: 8px;
            }

            .cd-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="phone-container">
        <div class="cover-screen" id="coverScreen">
            <img class="cover-bg" src="{{ $coverImage }}" alt="wedding cover">
            <div class="cover-content">
                <h3>{{ $data->setting?->acara ?? 'The Wedding Of' }}</h3>
                <h1>{{ $coupleNames }}</h1>
                <div class="cover-date">{{ $eventDateText }}</div>
                <div class="guest-card">
                    <p>Kepada Yth. Bapak/Ibu/Saudara/i</p>
                    <div class="guest-name" id="guestNameDisplay">{{ $tamu }}</div>
                </div>
                <button class="btn-gold" id="openInvitationBtn">Buka Undangan</button>
                <div style="margin-top: 20px; font-size:12px;"><i class="fas fa-chevron-down"></i></div>
            </div>
        </div>

        <div class="main-content" id="mainContent">
            <section id="heroSection" class="hero-bg-section" style="padding-top: 56px;">
                <div class="couple-names-hero">{{ $pria?->nama_lengkap ?? ($pria?->nama_panggilan ?? 'Mempelai') }} <span
                        style="font-weight:400">&amp;</span>
                    {{ $wanita?->nama_lengkap ?? ($wanita?->nama_panggilan ?? 'Mempelai') }}</div>
                <div class="hero-date">{{ $eventDateText }}</div>
                <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                <div class="quote-block">
                    {{ $data->qoute?->qoute ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu agar kamu merasa tenteram kepadanya.' }}
                    @if ($data->qoute?->subtitle)
                        <br>{{ $data->qoute->subtitle }}
                    @endif
                </div>
                <div class="countdown" id="countdownContainer" data-target="{{ $countdownDate }}">
                    <div class="cd-card"><span class="cd-number" id="days">00</span><br>Hari</div>
                    <div class="cd-card"><span class="cd-number" id="hours">00</span><br>Jam</div>
                    <div class="cd-card"><span class="cd-number" id="minutes">00</span><br>Menit</div>
                    <div class="cd-card"><span class="cd-number" id="seconds">00</span><br>Detik</div>
                </div>
            </section>

            <section id="coupleSection">
                <div class="section-title">Mempelai</div>
                <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                <div class="couple-card">
                    <img class="couple-img" src="{{ $priaImage }}"
                        alt="{{ $pria?->nama_lengkap ?? 'Mempelai Pria' }}">
                    <h3>{{ $pria?->nama_lengkap ?? ($pria?->nama_panggilan ?? 'Mempelai Pria') }}</h3>
                    <p>{{ $pria?->deskripsi ?? 'Mempelai pria' }}</p>
                </div>
                <div class="ampersand">&amp;</div>
                <div class="couple-card">
                    <img class="couple-img" src="{{ $wanitaImage }}"
                        alt="{{ $wanita?->nama_lengkap ?? 'Mempelai Wanita' }}">
                    <h3>{{ $wanita?->nama_lengkap ?? ($wanita?->nama_panggilan ?? 'Mempelai Wanita') }}</h3>
                    <p>{{ $wanita?->deskripsi ?? 'Mempelai wanita' }}</p>
                </div>
            </section>

            <section id="eventSection">
                <div class="section-title">Save The Date</div>
                <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                @foreach ($data->acara as $item)
                    @php
                        if ($item->date) {
                            $startDateTime = Carbon::parse($item->date . ' ' . $item->jam_start)->format('Ymd\THis\Z');
                            $endDateTime =
                                $item->jam_end === 'Selesai'
                                    ? Carbon::parse($item->date . ' ' . $item->jam_start)
                                        ->addHours(2)
                                        ->format('Ymd\THis\Z')
                                    : Carbon::parse($item->date . ' ' . $item->jam_end)->format('Ymd\THis\Z');
                        } else {
                            $startDateTime = '';
                            $endDateTime = '';
                        }
                    @endphp
                    <div class="event-card">
                        <h3><i class="fas fa-ring"></i> {{ $item->nama_acara }}</h3>
                        <p><i class="far fa-calendar-alt"></i>
                            {{ $item->date ? Carbon::parse($item->date)->translatedFormat('l, d F Y') : 'Tanggal belum ditentukan' }}
                        </p>
                        <p><i class="far fa-clock"></i> {{ $item->jam_start }} {{ $item->zona_waktu }} @if ($item->jam_end === 'Selesai')
                                s/d Selesai
                            @else
                                s/d {{ $item->jam_end }} {{ $item->zona_waktu }}
                            @endif
                        </p>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $item->vanue }}<br><span
                                style="font-size:12px;">{{ $item->alamat }}</span></p>
                        <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($item->nama_acara) }}&dates={{ $startDateTime }}/{{ $endDateTime }}&details={{ urlencode('Jangan lewatkan acara ini') }}&location={{ urlencode($item->alamat) }}"
                            target="_blank" class="btn-outline-gold"><i class="fas fa-calendar-check"></i> Simpan
                            Tanggal</a>
                        @if ($item->maps)
                            <a href="{{ $item->maps }}" target="_blank" class="btn-outline-gold"><i
                                    class="fas fa-directions"></i> Petunjuk Lokasi</a>
                        @endif
                    </div>
                @endforeach
            </section>

            @if ($data->kisah?->isNotEmpty())
                <section id="storySection">
                    <div class="section-title">Kisah Kami</div>
                    <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                    @foreach ($data->kisah as $kisah)
                        <div class="timeline-item">
                            <img class="timeline-img" src="{{ $storageUrl($kisah->image?->image) ?? $heroImage }}"
                                alt="{{ $kisah->title }}" loading="lazy">
                            <div class="timeline-content">
                                <strong>{{ $kisah->title }}</strong>
                                <p style="margin-top:4px; font-size:0.9rem;">{{ $kisah->deskripsi }}</p>
                            </div>
                        </div>
                    @endforeach
                </section>
            @endif

            @if ($poto || $video)
                <section id="gallerySection">
                    <div class="section-title">Galeri</div>
                    <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                    @if ($video)
                        <div class="event-card" style="padding: 8px;">
                            <iframe src="{{ $video[0] }}"
                                style="width:100%; height:240px; border:0; border-radius:24px;"></iframe>
                        </div>
                    @endif
                    @if ($poto)
                        <div class="gallery-grid" id="galleryGrid">
                            @foreach ($poto as $po)
                                <img src="{{ $storageUrl($po) }}" class="gallery-img" loading="lazy"
                                    alt="Galeri">
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif

            @if ($data->streaming?->isActive && $data->streaming?->link)
                <section id="streamingSection">
                    <div class="section-title">Live Streaming</div>
                    <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                    <div class="event-card" style="text-align:center">
                        <i class="fas fa-video" style="font-size:2rem; color:#c9a46b;"></i>
                        <p style="margin:12px 0">Turut hadir secara virtual melalui siaran langsung kami.</p>
                        <a class="btn-outline-gold" href="{{ $data->streaming->link }}" target="_blank"><i
                                class="fab fa-youtube"></i> Tonton Streaming</a>
                    </div>
                </section>
            @endif

            @if ($data->fiturKado?->isActive && $data->kado?->isNotEmpty())
                <section id="giftSection">
                    <div class="section-title">Wedding Gift</div>
                    <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                    <p style="text-align:center; margin-bottom:24px;">Doa restu Anda merupakan hadiah terindah. Tanpa
                        mengurangi rasa hormat, tanda kasih dapat disampaikan melalui:</p>
                    @foreach ($data->kado as $gift)
                        <div class="gift-card">
                            <i class="fas fa-university" style="color:#e9a2c0"></i>
                            <strong>{{ $gift->giftPay?->nama_pay ?? 'Hadiah Pernikahan' }}</strong><br>
                            {{ $gift->nomorPay }}<br> a.n {{ $gift->namaPay }}
                            @if ($gift->qris)
                                <img src="{{ $storageUrl($gift->qris) }}" alt="QRIS"
                                    style="display:block; max-width:180px; width:100%; margin:14px auto 0; border-radius:20px;">
                            @endif
                            @if ($gift->nomorPay)
                                <button class="btn-outline-gold copy-btn" data-account="{{ $gift->nomorPay }}"
                                    style="margin-top:12px; display:block;"><i class="far fa-copy"></i> Salin
                                    Nomor</button>
                            @endif
                        </div>
                    @endforeach
                </section>
            @endif

            @if ($data->FiturUcapan?->isActive)
                <section id="rsvpSection">
                    <div class="section-title">Ucapan & Konfirmasi Kehadiran</div>
                    <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                    <div id="wishAlert" class="wish-alert"></div>

                    @if ($data->FiturUcapan?->publicIsActive || $kode)
                        <form id="rsvpForm" action="{{ route('savedoa') }}" method="post">
                            @csrf
                            <input type="hidden" name="dataId" value="{{ $data->id }}">
                            <input type="hidden" name="kode" value="{{ $kode }}">
                            <input type="text" name="nama" placeholder="Nama Anda"
                                value="{{ old('nama', $tamu) }}" required>
                            <select name="status" required>
                                <option value="Datang Dong" @selected(old('status') === 'Datang Dong')>Hadir</option>
                                <option value="Ga bisa Datang Nih" @selected(old('status') === 'Ga bisa Datang Nih')>Tidak Dapat Hadir
                                </option>
                                <option value="Diusahakan Datang Ya" @selected(old('status') === 'Diusahakan Datang Ya')>Diusahakan Hadir
                                </option>
                            </select>
                            <textarea name="ucapan" rows="2" placeholder="Ucapan dan Doa..." required>{{ old('ucapan') }}</textarea>
                            <button type="submit" class="btn-gold" style="width:100%">Kirim Ucapan</button>
                        </form>
                    @else
                        <div class="wish-card">Form ucapan hanya tersedia untuk tamu yang menerima tautan undangan.
                        </div>
                    @endif

                    @if ($data->FiturUcapan?->viewIsActive)
                        <div id="wishesList" style="margin-top: 32px;">
                            @forelse ($ucapan as $item)
                                <div class="wish-card">
                                    <strong>{{ $item->tamu?->nama ?? 'Tamu' }}</strong>
                                    <span
                                        style="background:#fad5e5; border-radius:20px; padding:2px 10px; font-size:12px;">{{ $item->status }}</span>
                                    <p>{{ $item->ucapan }}</p>
                                    <small>{{ $item->created_at?->diffForHumans() }}</small>
                                    @if ($item->balas)
                                        <div
                                            style="margin-top:10px; background:#fff; border-radius:18px; padding:10px; font-size:0.9rem;">
                                            <strong>Balasan:</strong> {{ $item->balas }}</div>
                                    @endif
                                </div>
                            @empty
                                <div class="wish-card">Belum ada ucapan yang dikirim.</div>
                            @endforelse
                        </div>
                    @endif
                </section>
            @endif

            @if ($data->teksPenutup?->mengundang)
                <section>
                    <div class="section-title">Turut Mengundang</div>
                    <div class="wish-card" style="text-align:center;">{!! nl2br(e($data->teksPenutup->mengundang)) !!}</div>
                </section>
            @endif

            <section id="closingSection"
                style="background: linear-gradient(rgba(80,40,55,0.7), rgba(60,30,40,0.8)), url('{{ $heroImage }}'); background-size: cover; background-position: center; color:white; text-align:center; border-bottom: none;">
                <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
                <p style="font-size:1rem;">{!! nl2br(e($data->teksUndangan?->penutup ?? 'Terima kasih atas doa dan kehadiran Anda.')) !!}</p>
                <h1 style="font-family:'Playfair Display'; font-size:2rem; margin:24px 0;">{{ $coupleNames }}</h1>
                <p style="font-style:italic;">Semoga menjadi keluarga yang sakinah, mawaddah, warahmah.</p>
                <div class="floral-divider"><span>*</span><span>+</span><span>*</span></div>
            </section>
        </div>

        @if ($data->sound?->isActive && $data->sound?->sound)
            <div class="floating-music" id="musicToggle">
                <i class="fas fa-music" id="musicIcon"></i>
            </div>
            <audio id="bgMusic" loop preload="auto">
                <source src="{{ $storageUrl($data->sound->sound) }}" type="audio/mpeg">
            </audio>
        @endif

        <div class="bottom-nav" id="bottomNav">
            <div class="nav-item" data-target="heroSection"><i class="fas fa-home"></i><span>Home</span></div>
            <div class="nav-item" data-target="coupleSection"><i class="fas fa-heart"></i><span>Mempelai</span></div>
            <div class="nav-item" data-target="eventSection"><i class="fas fa-calendar-alt"></i><span>Acara</span>
            </div>
            @if ($poto || $video)
                <div class="nav-item" data-target="gallerySection"><i class="fas fa-images"></i><span>Galeri</span>
                </div>
            @endif
            @if ($data->FiturUcapan?->isActive)
                <div class="nav-item" data-target="rsvpSection"><i
                        class="fas fa-comment-dots"></i><span>Ucapan</span></div>
            @endif
        </div>
    </div>

    <div class="lightbox" id="lightbox"><img id="lightboxImg" src="" alt="Galeri"><span
            style="position:absolute; top:20px; right:30px; color:white; font-size:32px; cursor:pointer"
            id="closeLightbox">&times;</span></div>

    <script>
        (function() {
            let musicPlaying = false;
            const audio = document.getElementById('bgMusic');
            const musicIcon = document.getElementById('musicIcon');

            function setText(id, value) {
                const element = document.getElementById(id);
                if (element) element.innerText = String(value).padStart(2, '0');
            }

            function updateCountdown() {
                const container = document.getElementById('countdownContainer');
                const target = new Date(container.dataset.target).getTime();
                const diff = target - new Date().getTime();
                if (diff <= 0) {
                    setText('days', 0);
                    setText('hours', 0);
                    setText('minutes', 0);
                    setText('seconds', 0);
                    return;
                }
                setText('days', Math.floor(diff / (1000 * 60 * 60 * 24)));
                setText('hours', Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
                setText('minutes', Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)));
                setText('seconds', Math.floor((diff % (1000 * 60)) / 1000));
            }
            setInterval(updateCountdown, 1000);
            updateCountdown();

            const musicToggle = document.getElementById('musicToggle');
            if (musicToggle && audio) {
                musicToggle.addEventListener('click', () => {
                    if (musicPlaying) {
                        audio.pause();
                        musicIcon.className = 'fas fa-music';
                        musicPlaying = false;
                    } else {
                        audio.play().catch(() => {});
                        musicIcon.className = 'fas fa-pause';
                        musicPlaying = true;
                    }
                });
            }

            const cover = document.getElementById('coverScreen');
            const main = document.getElementById('mainContent');
            document.getElementById('openInvitationBtn').addEventListener('click', () => {
                cover.style.opacity = '0';
                setTimeout(() => {
                    cover.style.display = 'none';
                    main.classList.add('show');
                    window.scrollTo(0, 0);
                }, 600);
                if (audio) {
                    audio.play().then(() => {
                        musicPlaying = true;
                        if (musicIcon) musicIcon.className = 'fas fa-pause';
                    }).catch(() => {});
                }
            });

            const navItems = document.querySelectorAll('.nav-item');

            function setActiveNav(targetId) {
                navItems.forEach(nav => {
                    nav.classList.toggle('active', nav.dataset.target === targetId);
                });
            }

            navItems.forEach(item => {
                item.addEventListener('click', () => {
                    document.getElementById(item.dataset.target)?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    setActiveNav(item.dataset.target);
                });
            });

            const lightbox = document.getElementById('lightbox');
            document.querySelectorAll('.gallery-img').forEach(img => {
                img.addEventListener('click', (event) => {
                    document.getElementById('lightboxImg').src = event.target.src;
                    lightbox.classList.add('active');
                });
            });
            document.getElementById('closeLightbox').addEventListener('click', () => lightbox.classList.remove(
                'active'));
            lightbox.addEventListener('click', (event) => {
                if (event.target === lightbox) lightbox.classList.remove('active');
            });

            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    navigator.clipboard.writeText(btn.dataset.account);
                    btn.innerHTML = '<i class="far fa-copy"></i> Tersalin';
                    setTimeout(() => btn.innerHTML = '<i class="far fa-copy"></i> Salin Nomor', 1500);
                });
            });

            const sections = document.querySelectorAll('#mainContent section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('section-visible');
                        setActiveNav(entry.target.id);
                    }
                });
            }, {
                threshold: 0.3
            });
            sections.forEach(section => observer.observe(section));

            const rsvpForm = document.getElementById('rsvpForm');
            const wishAlert = document.getElementById('wishAlert');

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                } [char]));
            }

            function showWishAlert(type, message) {
                if (!wishAlert) return;
                wishAlert.className = `wish-alert ${type}`;
                wishAlert.textContent = message;
                wishAlert.style.display = 'block';
            }

            if (rsvpForm) {
                rsvpForm.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const submitButton = rsvpForm.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.textContent : '';
                    const formData = new FormData(rsvpForm);

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Mengirim...';
                    }

                    try {
                        const response = await fetch(rsvpForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const result = await response.json();

                        if (!response.ok) {
                            const errors = result.errors ? Object.values(result.errors).flat() : [];
                            showWishAlert('error', errors[0] || result.message || 'Ucapan gagal dikirim.');
                            return;
                        }

                        showWishAlert('success', result.message || 'Ucapan doa berhasil dikirim');
                        const textarea = rsvpForm.querySelector('textarea[name="ucapan"]');
                        if (textarea) textarea.value = '';

                        const wishesList = document.getElementById('wishesList');
                        if (wishesList && result.doa) {
                            const emptyCard = wishesList.querySelector('.wish-card:only-child');
                            if (emptyCard && emptyCard.textContent.includes('Belum ada ucapan')) {
                                emptyCard.remove();
                            }
                            wishesList.insertAdjacentHTML('afterbegin', `
                                <div class="wish-card">
                                    <strong>${escapeHtml(result.doa.nama)}</strong>
                                    <span style="background:#fad5e5; border-radius:20px; padding:2px 10px; font-size:12px;">${escapeHtml(result.doa.status)}</span>
                                    <p>${escapeHtml(result.doa.ucapan)}</p>
                                    <small>${escapeHtml(result.doa.created_at)}</small>
                                </div>
                            `);
                        }
                    } catch (error) {
                        showWishAlert('error', 'Ucapan gagal dikirim. Silakan coba lagi.');
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalText;
                        }
                    }
                });
            }
        })();
    </script>
</body>

</html>
