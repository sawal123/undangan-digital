<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
    @php
        use Carbon\Carbon;

        Carbon::setLocale('id');

        $wanita = $data->wanita;
        $pria = $data->pria;
        $firstEvent = $data->acara->first();
        $eventDate = $firstEvent?->date ? Carbon::parse($firstEvent->date) : null;
        $eventDateText = $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Tanggal acara';
        $eventTime = $firstEvent?->jam_start ?: '00:00';
        $countdownDate = $eventDate ? Carbon::parse($firstEvent->date . ' ' . $eventTime)->format('Y-m-d\TH:i:s') : now()->format('Y-m-d\TH:i:s');

        $storageUrl = fn ($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
        $coverImage = $storageUrl($data->coverUndangan?->cover_satu)
            ?? (count($poto ?? []) ? $storageUrl($poto[0]) : null)
            ?? 'https://images.pexels.com/photos/2253870/pexels-photo-2253870.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2';
        $footerImage = $storageUrl($data->coverUndangan?->cover_dua)
            ?? (count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null)
            ?? 'https://images.pexels.com/photos/3171837/pexels-photo-3171837.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2';
        $wanitaImage = $storageUrl($wanita?->image) ?? 'https://images.pexels.com/photos/1704488/pexels-photo-1704488.jpeg?auto=compress&cs=tinysrgb&w=600';
        $priaImage = $storageUrl($pria?->image) ?? 'https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=600';
        $title = ($data->setting?->acara ?? 'The Wedding Of') . ' ' . ($wanita?->nama_panggilan ?? 'Mempelai') . ' & ' . ($pria?->nama_panggilan ?? 'Mempelai');
    @endphp
    <title>{{ $title }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:site_name" content="Wayae Nikah">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:image" content="{{ url('storage/' . ($data->thumbnailWas?->thumbnail ?? '')) }}">
    <meta property="og:description" content="Acara akan dilaksanakan pada {{ $eventDateText }}.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f7efe5;
            font-family: 'Poppins', sans-serif;
            color: #3a2c24;
            line-height: 1.5;
            scroll-behavior: smooth;
        }

        .wedding-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fffef8;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow-x: hidden;
        }

        section {
            padding: 3rem 1.5rem;
            border-bottom: 1px solid rgba(210, 180, 140, 0.2);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 2rem;
            color: #b68b5c;
            letter-spacing: 1px;
            position: relative;
        }

        .section-title::after {
            content: "*";
            display: block;
            font-size: 1.2rem;
            color: #d9b68b;
            margin-top: 0.5rem;
        }

        .btn-primary {
            background: #c7a46b;
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.8rem 1.8rem;
            border-radius: 40px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: 0 8px 20px rgba(183, 132, 66, 0.2);
            width: fit-content;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #a87d48;
            transform: scale(1.02);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid #c7a46b;
            color: #9c7044;
            padding: 0.6rem 1.4rem;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .cover-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(20, 12, 8, 0.55), rgba(20, 12, 8, 0.6)), url('{{ $coverImage }}') center/cover no-repeat;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            backdrop-filter: blur(1px);
            transition: opacity 0.6s ease, visibility 0.6s;
            color: white;
        }

        .cover-content {
            max-width: 85%;
            animation: fadeUp 1s ease-out;
        }

        .cover-content h3 {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            letter-spacing: 3px;
            font-size: 1rem;
        }

        .couple-name-cover {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin: 1rem 0;
            font-weight: 600;
            line-height: 1.2;
        }

        .guest-card {
            background: rgba(255, 255, 245, 0.2);
            backdrop-filter: blur(8px);
            padding: 1rem;
            border-radius: 48px;
            margin: 1.5rem auto;
            width: 90%;
            border: 1px solid rgba(255, 215, 175, 0.6);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hidden-cover {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .music-btn {
            position: fixed;
            bottom: 85px;
            right: 18px;
            background: rgba(255, 250, 240, 0.9);
            backdrop-filter: blur(6px);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            z-index: 1200;
            color: #a47148;
            font-size: 1.6rem;
            border: 1px solid #e2cdb1;
        }

        .bottom-nav {
            position: fixed;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 248, 235, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 50px;
            padding: 0.6rem 1.4rem;
            display: flex;
            gap: 1.4rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            z-index: 1100;
            border: 1px solid #f1e3d4;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.68rem;
            color: #8b694a;
            cursor: pointer;
            transition: 0.2s;
            font-weight: 500;
        }

        .nav-item i {
            font-size: 1.25rem;
            margin-bottom: 3px;
        }

        .nav-item.active,
        .nav-item:active {
            color: #c29a6b;
        }

        .countdown-wrap {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 2rem 0;
        }

        .cd-card {
            background: #fef7ef;
            flex: 1;
            text-align: center;
            padding: 0.8rem 0;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1e2d2;
        }

        .cd-number {
            font-size: 1.7rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: #b57c48;
        }

        .couple-card {
            background: #fffcf7;
            border-radius: 32px;
            padding: 1.2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .couple-photo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 3px solid #eedbcb;
            box-shadow: 0 10px 15px -5px rgba(0, 0, 0, 0.1);
        }

        .ampersand {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            text-align: center;
            margin: -0.5rem 0 1rem;
            color: #dbb47a;
        }

        .event-card,
        .gift-card,
        .wish-card {
            background: #fff9f2;
            border-radius: 28px;
            padding: 1.3rem;
            margin-bottom: 1.2rem;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.02);
            border-left: 6px solid #e1c6a8;
        }

        .event-icon {
            margin-right: 0.5rem;
            color: #c7a46b;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.8rem;
            background: #fefaf5;
            padding: 1rem;
            border-radius: 20px;
        }

        .timeline-year {
            font-weight: 700;
            color: #c7a46b;
            min-width: 70px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .gallery-grid img {
            width: 100%;
            height: auto;
            border-radius: 18px;
            cursor: pointer;
            transition: 0.2s;
            object-fit: cover;
            aspect-ratio: 1/1;
        }

        .gallery-grid :first-child {
            grid-column: span 2;
            aspect-ratio: 16/10;
        }

        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
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
            border-radius: 20px;
        }

        .copy-btn {
            background: #e7d8ca;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.75rem;
            margin-top: 8px;
            cursor: pointer;
        }

        .badge-hadir {
            background: #d9e6c3;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            white-space: nowrap;
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 28px;
            border: 1px solid #ecdbba;
            background: white;
            font-family: 'Poppins', sans-serif;
        }

        .alert {
            padding: 0.85rem 1rem;
            border-radius: 18px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #e9f7dc;
            color: #44612a;
        }

        .alert-error {
            background: #fde7df;
            color: #8b3e2f;
        }

        footer {
            text-align: center;
            padding: 3rem 1.5rem 6rem;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.4)), url('{{ $footerImage }}') center/cover no-repeat;
            color: white;
        }

        .quote-text {
            font-style: italic;
            text-align: center;
            background: #fef1e4;
            padding: 1rem;
            border-radius: 30px;
            margin: 1rem 0;
        }

        .floral-divider {
            text-align: center;
            font-size: 1.2rem;
            letter-spacing: 6px;
            color: #debb95;
            margin: 1rem 0;
        }

        .error-text {
            color: #b42318;
            font-size: 0.8rem;
            margin: -6px 0 10px;
        }

        @media (min-width: 768px) {
            .wedding-container {
                max-width: 480px;
                border-radius: 32px;
                margin: 20px auto;
                overflow: hidden;
            }

            body {
                background: #e7dbcf;
            }

            .bottom-nav {
                padding: 0.5rem 1.8rem;
                gap: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="cover-screen" id="coverScreen">
        <div class="cover-content">
            <h3>{{ $data->setting?->acara ?? 'The Wedding Of' }}</h3>
            <div class="couple-name-cover">
                {{ $wanita?->nama_lengkap ?? 'Mempelai Wanita' }} <br> & <br>
                {{ $pria?->nama_lengkap ?? 'Mempelai Pria' }}
            </div>
            <p>{{ $eventDateText }}</p>
            <div class="guest-card">
                <i class="fas fa-envelope-open-text"></i> Kepada Yth.<br>
                <strong>Bapak/Ibu/Saudara/i</strong><br>
                <span style="font-size: 1.2rem;">{{ $tamu }}</span>
            </div>
            <button class="btn-primary" id="openInvitationBtn" style="background: #f1e0ce; color:#7a532e;">
                Buka Undangan
            </button>
            <div style="margin-top: 20px;"><i class="fas fa-chevron-down"></i></div>
        </div>
    </div>

    <div class="wedding-container" id="mainContent" style="display: none;">
        <section id="hero">
            <div style="text-align:center; padding-top: 1rem;">
                <h1 style="font-family:'Playfair Display'; font-size:2rem; color:#a27145;">
                    {{ $wanita?->nama_panggilan ?? 'Mempelai' }} & {{ $pria?->nama_panggilan ?? 'Mempelai' }}
                </h1>
                <p>{{ $eventDateText }}</p>
                <div class="floral-divider">* * *</div>
                <div class="quote-text">
                    @if ($data->qoute?->qoute)
                        {!! nl2br(e($data->qoute->qoute)) !!}
                        @if ($data->qoute?->subtitle)
                            <br><strong>{{ $data->qoute->subtitle }}</strong>
                        @endif
                    @else
                        Dan di antara tanda-tanda kekuasaan-Nya, Dia menciptakan pasangan hidup untukmu agar kamu merasa tenteram, dan menjadikan kasih sayang. (QS. Ar-Rum: 21)
                    @endif
                </div>
                <div class="countdown-wrap" id="countdownTimer" data-target="{{ $countdownDate }}">
                    <div class="cd-card">
                        <div class="cd-number" id="days">00</div>
                        <div>Hari</div>
                    </div>
                    <div class="cd-card">
                        <div class="cd-number" id="hours">00</div>
                        <div>Jam</div>
                    </div>
                    <div class="cd-card">
                        <div class="cd-number" id="minutes">00</div>
                        <div>Menit</div>
                    </div>
                    <div class="cd-card">
                        <div class="cd-number" id="seconds">00</div>
                        <div>Detik</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="couple">
            <div class="section-title">Mempelai</div>
            <p style="text-align:center; margin-bottom:2rem;">
                {!! nl2br(e($data->teksUndangan?->pembuka ?? 'Dengan memohon rahmat Allah, kami mengundang Bapak/Ibu/Saudara/i dalam bahagia pernikahan kami.')) !!}
            </p>
            <div class="couple-card">
                <img class="couple-photo" src="{{ $wanitaImage }}" alt="{{ $wanita?->nama_lengkap ?? 'Mempelai Wanita' }}">
                <h2 style="font-family:Playfair Display;">{{ $wanita?->nama_lengkap ?? 'Mempelai Wanita' }}</h2>
                <p>{!! nl2br(e($wanita?->deskripsi ?? '')) !!}</p>
            </div>
            <div class="ampersand">&</div>
            <div class="couple-card">
                <img class="couple-photo" src="{{ $priaImage }}" alt="{{ $pria?->nama_lengkap ?? 'Mempelai Pria' }}">
                <h2 style="font-family:Playfair Display;">{{ $pria?->nama_lengkap ?? 'Mempelai Pria' }}</h2>
                <p>{!! nl2br(e($pria?->deskripsi ?? '')) !!}</p>
            </div>
        </section>

        <section id="events">
            <div class="section-title">Save The Date</div>
            <p style="text-align:center; margin-bottom:1.5rem;">{!! nl2br(e($data->teksUndangan?->acara ?? 'Kami bermaksud mengundang saudara/i pada acara berikut.')) !!}</p>
            @forelse ($data->acara as $item)
                @php
                    $dateText = $item->date ? Carbon::parse($item->date)->translatedFormat('l, d F Y') : '-';
                    $mapUrl = $item->maps ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($item->alamat ?? $item->vanue ?? '');
                @endphp
                <div class="event-card">
                    <h3><i class="fas fa-ring event-icon"></i> {{ $item->nama_acara }}</h3>
                    <p><i class="far fa-calendar-alt"></i> {{ $dateText }}</p>
                    <p>
                        <i class="far fa-clock"></i>
                        {{ $item->jam_start }} {{ $item->zona_waktu }}
                        @if ($item->jam_end)
                            s/d {{ $item->jam_end === 'Selesai' ? 'Selesai' : $item->jam_end . ' ' . $item->zona_waktu }}
                        @endif
                    </p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $item->vanue }}</p>
                    <p style="font-size:0.8rem;">{{ $item->alamat }}</p>
                    <a class="btn-outline" href="{{ $mapUrl }}" target="_blank" rel="noopener">
                        <i class="fas fa-directions"></i> Petunjuk Lokasi
                    </a>
                </div>
            @empty
                <div class="event-card">Detail acara belum tersedia.</div>
            @endforelse
        </section>

        @if ($data->kisah->isNotEmpty())
            <section id="lovestory">
                <div class="section-title">Kisah Kami</div>
                @foreach ($data->kisah as $kisah)
                    <div class="timeline-item">
                        <div class="timeline-year">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <div>
                            <strong>{{ $kisah->title }}</strong><br>
                            {{ $kisah->deskripsi }}
                        </div>
                    </div>
                @endforeach
            </section>
        @endif

        @if ($poto || $video)
            <section id="gallery">
                <div class="section-title">Galeri</div>
                @if ($video)
                    <div style="height: 250px; margin-bottom: 1rem;">
                        <iframe src="{{ $video[0] }}" style="width:100%; height:100%; border:0; border-radius:18px;" allowfullscreen></iframe>
                    </div>
                @endif
                @if ($poto)
                    <div class="gallery-grid" id="galleryGrid">
                        @foreach ($poto as $image)
                            <img src="{{ $storageUrl($image) }}" alt="Galeri {{ $loop->iteration }}">
                        @endforeach
                    </div>
                @endif
            </section>
        @endif

        @if ($data->streaming?->isActive && $data->streaming?->link)
            <section id="liveStream">
                <div class="section-title">Live Streaming</div>
                <div style="background:#fcf5ea; border-radius: 32px; padding:1.5rem; text-align:center;">
                    <i class="fas fa-video" style="font-size:2rem; color:#b88552;"></i>
                    <p style="margin: 10px 0;">Turut hadir secara virtual melalui siaran langsung kami.</p>
                    <a class="btn-primary" href="{{ $data->streaming->link }}" target="_blank" rel="noopener">Tonton Streaming</a>
                </div>
            </section>
        @endif

        @if ($data->fiturKado?->isActive && $data->kado->isNotEmpty())
            <section id="gift">
                <div class="section-title">Wedding Gift</div>
                <p style="text-align:center;">Doa restu Anda merupakan hadiah terindah. Tanda kasih dapat disalurkan melalui:</p>
                @foreach ($data->kado as $gift)
                    <div class="gift-card">
                        <i class="fas fa-credit-card"></i>
                        <strong>{{ $gift->giftPay?->nama_pay ?? 'Hadiah Pernikahan' }}</strong>
                        <p>{{ $gift->nomorPay }}</p>
                        <p>a.n. {{ $gift->namaPay }}</p>
                        @if ($gift->qris)
                            <img src="{{ $storageUrl($gift->qris) }}" alt="QRIS" style="width: 180px; max-width: 100%; border-radius: 18px; margin-top: 8px;">
                        @endif
                        @if ($gift->nomorPay)
                            <button class="copy-btn" data-num="{{ $gift->nomorPay }}">Salin Nomor</button>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif

        @if ($data->FiturUcapan?->isActive)
            <section id="rsvp">
                <div class="section-title">Ucapan & Konfirmasi Kehadiran</div>

                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif
                <div id="wishAlert" style="display:none;"></div>

                @if ($data->FiturUcapan?->publicIsActive || $kode)
                    <form action="{{ route('savedoa') }}" method="post" id="mahligaiWishForm">
                        @csrf
                        <input type="hidden" name="dataId" value="{{ $data->id }}">
                        <input type="hidden" name="kode" value="{{ $kode }}">
                        <input type="text" name="nama" placeholder="Nama Anda" value="{{ old('nama', $tamu) }}" required>
                        @error('nama')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        <select name="status" required>
                            <option value="Datang Dong" @selected(old('status') === 'Datang Dong')>Hadir</option>
                            <option value="Ga bisa Datang Nih" @selected(old('status') === 'Ga bisa Datang Nih')>Tidak Dapat Hadir</option>
                            <option value="Diusahakan Datang Ya" @selected(old('status') === 'Diusahakan Datang Ya')>Diusahakan Hadir</option>
                        </select>
                        @error('status')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        <textarea rows="3" name="ucapan" placeholder="Ucapan & Doa untuk pasangan..." required>{{ old('ucapan') }}</textarea>
                        @error('ucapan')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn-primary" style="width:100%">Kirim Ucapan</button>
                    </form>
                @else
                    <div class="wish-card">Form ucapan hanya tersedia untuk tamu yang menerima tautan undangan.</div>
                @endif

                @if ($data->FiturUcapan?->viewIsActive)
                    <div style="margin-top: 2rem;" id="wishesList">
                        @forelse ($ucapan as $item)
                            <div class="wish-card">
                                <div style="display:flex; justify-content:space-between; gap:10px;">
                                    <strong>{{ $item->tamu?->nama ?? 'Tamu' }}</strong>
                                    <span class="badge-hadir">{{ $item->status }}</span>
                                </div>
                                <p style="margin:8px 0;">"{{ $item->ucapan }}"</p>
                                <small><i class="far fa-calendar"></i> {{ $item->created_at?->diffForHumans() }}</small>
                                @if ($item->balas)
                                    <div style="margin-top:10px; background:#fff; border-radius:16px; padding:10px;">
                                        <strong>Balasan:</strong> {{ $item->balas }}
                                    </div>
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
                <p style="text-align:center;">{!! nl2br(e($data->teksPenutup->mengundang)) !!}</p>
            </section>
        @endif

        <footer>
            <div style="font-family: 'Playfair Display'; font-size:2rem; margin-bottom: 0.5rem;">
                {{ $wanita?->nama_panggilan ?? 'Mempelai' }} & {{ $pria?->nama_panggilan ?? 'Mempelai' }}
            </div>
            <p>{!! nl2br(e($data->teksUndangan?->penutup ?? 'Terima kasih atas doa dan kehadiran Anda.')) !!}</p>
            <div class="floral-divider" style="color:#ffefdb;">* * *</div>
            <p style="font-size:0.8rem;">Merupakan suatu kehormatan bagi kami atas kehadiran Anda.</p>
        </footer>
    </div>

    @if ($data->sound?->isActive && $data->sound?->sound)
        <div class="music-btn" id="musicToggle"><i class="fas fa-music"></i></div>
        <audio id="bgAudio" loop src="{{ $storageUrl($data->sound->sound) }}" preload="auto"></audio>
    @endif

    <div class="bottom-nav">
        <div class="nav-item" data-section="hero"><i class="fas fa-home"></i><span>Home</span></div>
        <div class="nav-item" data-section="couple"><i class="fas fa-heart"></i><span>Mempelai</span></div>
        <div class="nav-item" data-section="events"><i class="fas fa-calendar-alt"></i><span>Acara</span></div>
        @if ($poto || $video)
            <div class="nav-item" data-section="gallery"><i class="fas fa-images"></i><span>Galeri</span></div>
        @endif
        @if ($data->FiturUcapan?->isActive)
            <div class="nav-item" data-section="rsvp"><i class="fas fa-comment-dots"></i><span>Ucapan</span></div>
        @endif
    </div>

    <div class="lightbox" id="lightbox">
        <img id="lightboxImg" src="" alt="Galeri">
        <span style="position:absolute; top:20px; right:30px; color:white; font-size:30px; cursor:pointer;" id="closeLightbox">&times;</span>
    </div>

    <script>
        (function() {
            const countdownTimer = document.getElementById("countdownTimer");
            const weddingDate = new Date(countdownTimer.getAttribute("data-target"));

            function setText(id, value) {
                const element = document.getElementById(id);
                if (element) element.innerText = value < 10 ? "0" + value : value;
            }

            function updateCountdown() {
                const diff = weddingDate.getTime() - new Date().getTime();
                if (diff <= 0) {
                    setText("days", 0);
                    setText("hours", 0);
                    setText("minutes", 0);
                    setText("seconds", 0);
                    return;
                }

                setText("days", Math.floor(diff / (1000 * 60 * 60 * 24)));
                setText("hours", Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
                setText("minutes", Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)));
                setText("seconds", Math.floor((diff % (1000 * 60)) / 1000));
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            const audio = document.getElementById("bgAudio");
            const musicBtn = document.getElementById("musicToggle");
            let isPlaying = false;
            if (audio && musicBtn) {
                musicBtn.addEventListener("click", () => {
                    if (isPlaying) {
                        audio.pause();
                        musicBtn.innerHTML = '<i class="fas fa-music"></i>';
                    } else {
                        audio.play().catch(() => {});
                        musicBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    }
                    isPlaying = !isPlaying;
                });
            }

            const cover = document.getElementById("coverScreen");
            const mainCont = document.getElementById("mainContent");
            document.getElementById("openInvitationBtn").addEventListener("click", () => {
                cover.classList.add("hidden-cover");
                setTimeout(() => {
                    cover.style.display = "none";
                    mainCont.style.display = "block";
                    document.body.style.overflow = "auto";
                    if (audio) {
                        audio.play().then(() => {
                            isPlaying = true;
                            if (musicBtn) musicBtn.innerHTML = '<i class="fas fa-pause"></i>';
                        }).catch(() => {});
                    }
                }, 600);
            });

            document.querySelectorAll(".nav-item").forEach(item => {
                item.addEventListener("click", () => {
                    const element = document.getElementById(item.getAttribute("data-section"));
                    if (element) element.scrollIntoView({ behavior: "smooth", block: "start" });
                });
            });

            document.querySelectorAll('#galleryGrid img').forEach(img => {
                img.addEventListener('click', (event) => {
                    const lightbox = document.getElementById('lightbox');
                    document.getElementById('lightboxImg').src = event.target.src;
                    lightbox.classList.add('active');
                });
            });

            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const text = btn.getAttribute('data-num');
                    navigator.clipboard.writeText(text);
                    btn.innerText = 'Tersalin';
                    setTimeout(() => btn.innerText = 'Salin Nomor', 1500);
                });
            });

            const wishForm = document.getElementById('mahligaiWishForm');
            const wishAlert = document.getElementById('wishAlert');

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[char]));
            }

            function showWishAlert(type, message) {
                if (!wishAlert) return;
                wishAlert.className = `alert ${type === 'success' ? 'alert-success' : 'alert-error'}`;
                wishAlert.textContent = message;
                wishAlert.style.display = 'block';
            }

            if (wishForm) {
                wishForm.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const submitButton = wishForm.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.textContent : '';
                    const formData = new FormData(wishForm);

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Mengirim...';
                    }

                    try {
                        const response = await fetch(wishForm.action, {
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
                        const textarea = wishForm.querySelector('textarea[name="ucapan"]');
                        if (textarea) textarea.value = '';

                        const wishesList = document.getElementById('wishesList');
                        if (wishesList && result.doa) {
                            const emptyCard = wishesList.querySelector('.wish-card:only-child');
                            if (emptyCard && emptyCard.textContent.includes('Belum ada ucapan')) {
                                emptyCard.remove();
                            }

                            wishesList.insertAdjacentHTML('afterbegin', `
                                <div class="wish-card">
                                    <div style="display:flex; justify-content:space-between; gap:10px;">
                                        <strong>${escapeHtml(result.doa.nama)}</strong>
                                        <span class="badge-hadir">${escapeHtml(result.doa.status)}</span>
                                    </div>
                                    <p style="margin:8px 0;">"${escapeHtml(result.doa.ucapan)}"</p>
                                    <small><i class="far fa-calendar"></i> ${escapeHtml(result.doa.created_at)}</small>
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

            document.getElementById("closeLightbox").addEventListener("click", () => {
                document.getElementById("lightbox").classList.remove("active");
            });
            document.getElementById("lightbox").addEventListener("click", (event) => {
                if (event.target === document.getElementById("lightbox")) {
                    document.getElementById("lightbox").classList.remove("active");
                }
            });
        })();
    </script>
</body>

</html>
