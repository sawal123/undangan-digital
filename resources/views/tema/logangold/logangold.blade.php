<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
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
                'https://images.pexels.com/photos/2253870/pexels-photo-2253870.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
        $heroImage =
            $storageUrl($data->coverUndangan?->cover_dua) ??
            ((count($poto ?? []) > 1 ? $storageUrl($poto[1]) : null) ??
                'https://images.pexels.com/photos/3171837/pexels-photo-3171837.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
        $priaImage =
            $storageUrl($pria?->image) ??
            'https://images.pexels.com/photos/1043471/pexels-photo-1043471.jpeg?auto=compress&cs=tinysrgb&w=600';
        $wanitaImage =
            $storageUrl($wanita?->image) ??
            'https://images.pexels.com/photos/1704488/pexels-photo-1704488.jpeg?auto=compress&cs=tinysrgb&w=600';
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

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        body {
            background: linear-gradient(135deg, #1e1a14 0%, #2a241d 100%);
            overflow-x: hidden;
        }

        .glass-card {
            background: rgba(255, 255, 245, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .gold-text,
        .text-gold {
            color: #d4af37;
        }

        .gold-border,
        .border-gold {
            border-color: #d4af37;
        }

        .border-gold\/50 {
            border-color: rgba(212, 175, 55, 0.5);
        }

        .bg-gold\/20 {
            background: rgba(212, 175, 55, 0.2);
        }

        .btn-gold {
            background: linear-gradient(135deg, #d4af37 0%, #b8922a 100%);
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .timeline-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 20px;
            border: 2px solid #d4af37;
            flex: none;
        }

        .atm-card {
            background: linear-gradient(135deg, #1e1b16 0%, #0f0d0a 100%);
            border: 1px solid #d4af37;
            border-radius: 24px;
            padding: 1.2rem;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s;
        }

        .atm-card:hover {
            transform: translateY(-3px);
        }

        .chip-icon {
            background: #e6c27a;
            width: 45px;
            height: 35px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            color: #2c2c2c;
        }

        .floating-flower {
            position: fixed;
            pointer-events: none;
            z-index: 10;
            font-size: 1.5rem;
            opacity: 0.4;
            animation: floatFlower 12s infinite ease-in-out;
        }

        @keyframes floatFlower {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10%,
            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-20vh) rotate(360deg);
                opacity: 0;
            }
        }

        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        @media (max-width: 768px) {
            .parallax-bg {
                background-attachment: scroll;
            }
        }

        input,
        select,
        textarea {
            background: rgba(255, 255, 245, 0.1);
            border: 1px solid rgba(212, 175, 55, 0.5);
            border-radius: 24px;
            padding: 12px 18px;
            color: #f5e6c4;
            outline: none;
            transition: 0.2s;
        }

        select option {
            color: #2a241d;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #d4af37;
            box-shadow: 0 0 8px rgba(212, 175, 55, 0.4);
        }

        .guest-badge {
            background: rgba(212, 175, 55, 0.2);
            border-radius: 40px;
            padding: 4px 12px;
            font-size: 0.7rem;
        }

        .bottom-nav {
            background: rgba(30, 26, 20, 0.85);
            backdrop-filter: blur(16px);
            border-top: 1px solid rgba(212, 175, 55, 0.3);
        }

        .nav-item {
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-item.active {
            color: #d4af37;
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
            transition: 0.2s;
        }

        .lightbox.active {
            visibility: visible;
            opacity: 1;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 24px;
        }

        .wish-alert {
            border-radius: 18px;
            padding: 12px 14px;
            font-size: 0.85rem;
            display: none;
        }

        .wish-alert.success {
            background: rgba(34, 197, 94, 0.18);
            border: 1px solid rgba(34, 197, 94, 0.45);
        }

        .wish-alert.error {
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid rgba(239, 68, 68, 0.45);
        }
    </style>
</head>

<body class="text-[#f5e6c4]">
    <div id="flowerContainer"></div>

    <div id="coverScreen"
        class="fixed inset-0 z-[2000] flex items-center justify-center bg-cover bg-center transition-all duration-700"
        style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('{{ $coverImage }}');">
        <div class="glass-card rounded-[48px] p-6 w-11/12 max-w-sm text-center backdrop-blur-md">
            <i class="fas fa-crown gold-text text-3xl mb-2"></i>
            <p class="text-sm uppercase tracking-wider gold-text">{{ $data->setting?->acara ?? 'The Wedding Of' }}</p>
            <h1 class="font-serif text-3xl font-bold gold-text my-2">{{ $coupleNames }}</h1>
            <p class="text-sm">{{ $eventDateText }}</p>
            <div class="bg-white/10 rounded-full py-2 px-4 my-4 text-sm backdrop-blur-sm">
                <i class="fas fa-envelope-open-text mr-2"></i> Kepada Yth. Bapak/Ibu/Saudara/i<br>
                <span class="font-semibold">{{ $tamu }}</span>
            </div>
            <button id="openInvitationBtn"
                class="btn-gold text-black font-bold py-3 px-8 rounded-full shadow-lg w-full">Buka Undangan</button>
        </div>
    </div>

    <div id="mainContent" class="max-w-md mx-auto relative hidden pb-24">
        <div class="relative h-96 w-full rounded-b-3xl overflow-hidden shadow-xl scroll-reveal parallax-bg"
            id="hero" style="background-image: url('{{ $heroImage }}'); background-position: center 30%;">
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex flex-col justify-end p-6">
                <h1 class="font-serif text-4xl font-bold gold-text">{{ $coupleNames }}</h1>
                <p class="text-white/90">{{ $eventDateText }}</p>
                <div class="flex gap-2 mt-2">
                    <span
                        class="text-xs bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">{{ $data->setting?->acara ?? 'Pernikahan' }}</span>
                </div>
            </div>
        </div>

        <div class="px-5 py-8 scroll-reveal">
            <div class="glass-card rounded-2xl p-5 text-center">
                <i class="fas fa-quote-left gold-text text-2xl mb-2"></i>
                <p class="italic text-sm">
                    {{ $data->qoute?->qoute ?? 'Dan di antara tanda-tanda kekuasaan-Nya, Dia menciptakan pasangan hidup untukmu agar kamu merasa tenteram.' }}
                </p>
                @if ($data->qoute?->subtitle)
                    <p class="text-xs gold-text mt-2">{{ $data->qoute->subtitle }}</p>
                @endif
                <div class="grid grid-cols-4 gap-2 mt-5" id="countdownTimer" data-target="{{ $countdownDate }}">
                    <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text"
                            id="days">00</span>
                        <p class="text-[10px]">Hari</p>
                    </div>
                    <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text"
                            id="hours">00</span>
                        <p class="text-[10px]">Jam</p>
                    </div>
                    <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text"
                            id="minutes">00</span>
                        <p class="text-[10px]">Menit</p>
                    </div>
                    <div class="glass-card rounded-xl py-2"><span class="text-2xl font-bold gold-text"
                            id="seconds">00</span>
                        <p class="text-[10px]">Detik</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-5 py-4 scroll-reveal" id="couple">
            <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Mempelai</h2>
            <div class="glass-card rounded-3xl p-5 text-center mb-6">
                <img src="{{ $priaImage }}"
                    class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gold mb-3"
                    alt="{{ $pria?->nama_lengkap ?? 'Mempelai Pria' }}">
                <h3 class="font-serif text-xl font-semibold">
                    {{ $pria?->nama_lengkap ?? ($pria?->nama_panggilan ?? 'Mempelai Pria') }}</h3>
                <p class="text-sm opacity-80">{{ $pria?->deskripsi ?? 'Mempelai pria' }}</p>
                @if ($pria?->instagram)
                    <a href="https://instagram.com/{{ ltrim($pria->instagram, '@') }}" target="_blank"
                        class="text-gold text-sm inline-block mt-2"><i class="fab fa-instagram"></i>
                        {{ $pria->instagram }}</a>
                @endif
            </div>
            <div class="text-center gold-text text-2xl my-2">&amp;</div>
            <div class="glass-card rounded-3xl p-5 text-center mt-2">
                <img src="{{ $wanitaImage }}"
                    class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gold mb-3"
                    alt="{{ $wanita?->nama_lengkap ?? 'Mempelai Wanita' }}">
                <h3 class="font-serif text-xl font-semibold">
                    {{ $wanita?->nama_lengkap ?? ($wanita?->nama_panggilan ?? 'Mempelai Wanita') }}</h3>
                <p class="text-sm opacity-80">{{ $wanita?->deskripsi ?? 'Mempelai wanita' }}</p>
                @if ($wanita?->instagram)
                    <a href="https://instagram.com/{{ ltrim($wanita->instagram, '@') }}" target="_blank"
                        class="text-gold text-sm inline-block mt-2"><i class="fab fa-instagram"></i>
                        {{ $wanita->instagram }}</a>
                @endif
            </div>
        </div>

        <div class="px-5 py-4 scroll-reveal" id="events">
            <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Save The Date</h2>
            <div class="space-y-4">
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
                    <div class="glass-card rounded-2xl p-4 border-l-4 border-gold">
                        <h3 class="font-bold"><i class="fas fa-ring gold-text mr-2"></i>{{ $item->nama_acara }}</h3>
                        <p class="text-xs mt-1"><i
                                class="far fa-calendar-alt mr-1"></i>{{ $item->date ? Carbon::parse($item->date)->translatedFormat('l, d F Y') : 'Tanggal belum ditentukan' }}
                        </p>
                        <p class="text-xs"><i class="far fa-clock mr-1"></i>{{ $item->jam_start }}
                            {{ $item->zona_waktu }} @if ($item->jam_end === 'Selesai')
                                s/d Selesai
                            @else
                                s/d {{ $item->jam_end }} {{ $item->zona_waktu }}
                            @endif
                        </p>
                        <p class="text-xs"><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->vanue }}</p>
                        <p class="text-xs opacity-70">{{ $item->alamat }}</p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode($item->nama_acara) }}&dates={{ $startDateTime }}/{{ $endDateTime }}&details={{ urlencode('Jangan lewatkan acara ini') }}&location={{ urlencode($item->alamat) }}"
                                target="_blank"
                                class="text-gold border border-gold/50 px-3 py-1 rounded-full text-xs"><i
                                    class="fas fa-calendar-check"></i> Simpan Tanggal</a>
                            @if ($item->maps)
                                <a href="{{ $item->maps }}" target="_blank"
                                    class="text-gold border border-gold/50 px-3 py-1 rounded-full text-xs"><i
                                        class="fas fa-directions"></i> Petunjuk Lokasi</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if ($data->kisah?->count())
            <div class="px-5 py-4 scroll-reveal" id="lovestory">
                <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Kisah Kami</h2>
                <div class="space-y-4">
                    @foreach ($data->kisah as $kisah)
                        <div class="glass-card rounded-2xl p-3 flex gap-3 items-center">
                            <img src="{{ $storageUrl($kisah->image?->image) ?? $heroImage }}" class="timeline-img"
                                alt="{{ $kisah->title }}">
                            <div>
                                <div class="font-semibold text-sm gold-text">{{ $kisah->title }}</div>
                                <p class="text-xs opacity-80">{{ $kisah->deskripsi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($poto || $video)
            <div class="px-5 py-4 scroll-reveal" id="gallery">
                <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Galeri</h2>
                @if ($video)
                    <div class="glass-card rounded-2xl p-2 mb-3">
                        <iframe src="{{ $video[0] }}" class="w-full h-56 rounded-xl" frameborder="0"></iframe>
                    </div>
                @endif
                @if ($poto)
                    <div class="grid grid-cols-2 gap-3" id="galleryGrid">
                        @foreach ($poto as $po)
                            <img src="{{ $storageUrl($po) }}"
                                class="rounded-2xl aspect-square object-cover cursor-pointer transition hover:scale-[1.02]"
                                alt="Galeri">
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        @if ($data->streaming?->isActive && $data->streaming?->link)
            <div class="px-5 py-4 scroll-reveal">
                <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Live Streaming</h2>
                <div class="glass-card rounded-2xl p-6 text-center">
                    <i class="fas fa-video text-4xl gold-text mb-2"></i>
                    <p class="text-sm mb-4">Turut hadir secara virtual melalui siaran langsung kami.</p>
                    <a href="{{ $data->streaming->link }}" target="_blank"
                        class="btn-gold text-black font-semibold py-2 px-6 rounded-full inline-block">Tonton
                        Streaming</a>
                </div>
            </div>
        @endif

        @if ($data->fiturKado?->isActive && $data->kado?->isNotEmpty())
            <div class="px-5 py-4 scroll-reveal" id="gift">
                <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Wedding Gift</h2>
                <p class="text-center text-sm mb-4">Doa restu Anda merupakan hadiah terindah. Tanda kasih dapat
                    disalurkan melalui:</p>
                <div class="space-y-4">
                    @foreach ($data->kado as $gift)
                        <div class="atm-card">
                            <div class="flex justify-between items-center">
                                <div class="chip-icon"><i class="fas fa-credit-card"></i></div>
                                <span
                                    class="text-[10px] gold-text">{{ $gift->giftPay?->nama_pay ?? 'WEDDING CARD' }}</span>
                            </div>
                            <div class="font-mono text-center my-3 tracking-wider text-sm">{{ $gift->nomorPay }}</div>
                            <div class="flex justify-between text-[10px]">
                                <span>HOLDER</span>
                                <span>{{ $gift->namaPay }}</span>
                            </div>
                            <div class="flex justify-between text-[10px] mt-1">
                                <span>BANK</span>
                                <span>{{ $gift->giftPay?->nama_pay ?? '-' }}</span>
                            </div>
                            @if ($gift->qris)
                                <img src="{{ $storageUrl($gift->qris) }}"
                                    class="w-40 max-w-full mx-auto rounded-2xl mt-3" alt="QRIS">
                            @endif
                            @if ($gift->nomorPay)
                                <button class="copy-btn-atm w-full mt-3 bg-gold/20 text-gold py-2 rounded-full text-xs"
                                    data-num="{{ $gift->nomorPay }}">Salin Nomor Rekening</button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($data->FiturUcapan?->isActive)
            <div class="px-5 py-4 scroll-reveal" id="rsvp">
                <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Ucapan & Konfirmasi</h2>
                <div id="wishAlert" class="wish-alert mb-3"></div>

                @if ($data->FiturUcapan?->publicIsActive || $kode)
                    <form id="wishForm" action="{{ route('savedoa') }}" method="post" class="space-y-3">
                        @csrf
                        <input type="hidden" name="dataId" value="{{ $data->id }}">
                        <input type="hidden" name="kode" value="{{ $kode }}">
                        <input type="text" name="nama" placeholder="Nama Anda"
                            value="{{ old('nama', $tamu) }}" class="w-full" required>
                        <select name="status" class="w-full" required>
                            <option value="Datang Dong" @selected(old('status') === 'Datang Dong')>Hadir</option>
                            <option value="Ga bisa Datang Nih" @selected(old('status') === 'Ga bisa Datang Nih')>Tidak Dapat Hadir</option>
                            <option value="Diusahakan Datang Ya" @selected(old('status') === 'Diusahakan Datang Ya')>Diusahakan Hadir</option>
                        </select>
                        <textarea rows="3" name="ucapan" placeholder="Ucapan & Doa untuk pasangan..." class="w-full rounded-2xl"
                            required>{{ old('ucapan') }}</textarea>
                        <button type="submit" class="btn-gold text-black font-bold py-3 rounded-full w-full">Kirim
                            Ucapan</button>
                    </form>
                @else
                    <div class="glass-card rounded-2xl p-4 text-center text-sm">Form ucapan hanya tersedia untuk tamu
                        yang menerima tautan undangan.</div>
                @endif

                @if ($data->FiturUcapan?->viewIsActive)
                    <div id="wishesList" class="mt-6 space-y-3">
                        @forelse ($ucapan as $item)
                            <div class="glass-card rounded-2xl p-3 wish-card">
                                <div class="flex justify-between gap-3"><span
                                        class="font-semibold">{{ $item->tamu?->nama ?? 'Tamu' }}</span><span
                                        class="guest-badge">{{ $item->status }}</span></div>
                                <p class="text-sm mt-1 italic">"{{ $item->ucapan }}"</p>
                                <div class="text-[10px] mt-2 opacity-60"><i class="far fa-calendar"></i>
                                    {{ $item->created_at?->diffForHumans() }}</div>
                                @if ($item->balas)
                                    <div class="mt-3 bg-white/10 rounded-2xl p-3 text-xs"><strong>Balasan:</strong>
                                        {{ $item->balas }}</div>
                                @endif
                            </div>
                        @empty
                            <div class="glass-card rounded-2xl p-3 wish-card">Belum ada ucapan yang dikirim.</div>
                        @endforelse
                    </div>
                @endif
            </div>
        @endif

        @if ($data->teksPenutup?->mengundang)
            <div class="px-5 py-4 scroll-reveal">
                <h2 class="font-serif text-2xl font-bold text-center gold-text mb-6">Turut Mengundang</h2>
                <div class="glass-card rounded-2xl p-5 text-center text-sm">{!! nl2br(e($data->teksPenutup->mengundang)) !!}</div>
            </div>
        @endif

        <footer class="mt-8 mb-6 text-center px-5 py-8 rounded-t-3xl glass-card">
            <div class="font-serif text-2xl font-bold gold-text">{{ $coupleNames }}</div>
            <p class="text-sm mt-2">{!! nl2br(e($data->teksUndangan?->penutup ?? 'Terima kasih atas doa dan kehadiran Anda.')) !!}</p>
            <div class="text-gold text-2xl my-2">***</div>
            <p class="text-[10px] opacity-70">Merupakan suatu kehormatan bagi kami atas kehadiran Anda.</p>
        </footer>
    </div>

    @if ($data->sound?->isActive && $data->sound?->sound)
        <div id="musicToggle"
            class="fixed bottom-24 right-4 z-50 bg-black/40 backdrop-blur-md p-3 rounded-full border border-gold/50 cursor-pointer">
            <i class="fas fa-music gold-text text-xl"></i>
        </div>
        <audio id="bgAudio" loop src="{{ $storageUrl($data->sound->sound) }}" preload="auto"></audio>
    @endif

    <div
        class="bottom-nav fixed bottom-0 left-0 right-0 z-50 py-2 flex justify-around items-center max-w-md mx-auto rounded-t-2xl">
        <div class="nav-item flex flex-col items-center text-xs" data-section="hero"><i
                class="fas fa-home text-lg"></i><span>Home</span></div>
        <div class="nav-item flex flex-col items-center text-xs" data-section="couple"><i
                class="fas fa-heart text-lg"></i><span>Pasangan</span></div>
        <div class="nav-item flex flex-col items-center text-xs" data-section="events"><i
                class="fas fa-calendar text-lg"></i><span>Acara</span></div>
        @if ($poto || $video)
            <div class="nav-item flex flex-col items-center text-xs" data-section="gallery"><i
                    class="fas fa-images text-lg"></i><span>Galeri</span></div>
        @endif
        @if ($data->FiturUcapan?->isActive)
            <div class="nav-item flex flex-col items-center text-xs" data-section="rsvp"><i
                    class="fas fa-comment-dots text-lg"></i><span>Ucapan</span></div>
        @endif
    </div>

    <div id="lightbox" class="lightbox"><img id="lightboxImg" src="" alt="Galeri"><span
            class="absolute top-5 right-5 text-white text-3xl cursor-pointer" id="closeLightbox">&times;</span></div>

    <script>
        (function() {
            const countdownTimer = document.getElementById("countdownTimer");
            const weddingDate = new Date(countdownTimer.getAttribute("data-target"));

            function setText(id, value) {
                const element = document.getElementById(id);
                if (element) element.innerText = value.toString().padStart(2, '0');
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
            if (musicBtn && audio) {
                musicBtn.addEventListener("click", () => {
                    if (isPlaying) {
                        audio.pause();
                        musicBtn.innerHTML = '<i class="fas fa-music gold-text text-xl"></i>';
                    } else {
                        audio.play().catch(() => {});
                        musicBtn.innerHTML = '<i class="fas fa-pause gold-text text-xl"></i>';
                    }
                    isPlaying = !isPlaying;
                });
            }

            const cover = document.getElementById("coverScreen");
            const main = document.getElementById("mainContent");
            document.getElementById("openInvitationBtn").addEventListener("click", () => {
                cover.style.opacity = "0";
                setTimeout(() => {
                    cover.style.display = "none";
                    main.classList.remove("hidden");
                    document.body.style.overflow = "auto";
                    if (audio) {
                        audio.play().then(() => {
                            isPlaying = true;
                            if (musicBtn) musicBtn.innerHTML =
                                '<i class="fas fa-pause gold-text text-xl"></i>';
                        }).catch(() => {});
                    }
                }, 700);
            });

            document.querySelectorAll(".nav-item").forEach(item => {
                item.addEventListener("click", () => {
                    const el = document.getElementById(item.dataset.section);
                    if (el) el.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                });
            });

            document.querySelectorAll('#galleryGrid img').forEach(img => {
                img.addEventListener('click', () => {
                    document.getElementById('lightboxImg').src = img.src;
                    document.getElementById('lightbox').classList.add('active');
                });
            });

            document.querySelectorAll('.copy-btn-atm').forEach(btn => {
                btn.addEventListener('click', () => {
                    const text = btn.dataset.num;
                    navigator.clipboard.writeText(text);
                    btn.innerText = 'Tersalin';
                    setTimeout(() => btn.innerText = 'Salin Nomor Rekening', 1500);
                });
            });

            const wishForm = document.getElementById('wishForm');
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
                wishAlert.className = `wish-alert mb-3 ${type}`;
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
                                <div class="glass-card rounded-2xl p-3 wish-card">
                                    <div class="flex justify-between gap-3"><span class="font-semibold">${escapeHtml(result.doa.nama)}</span><span class="guest-badge">${escapeHtml(result.doa.status)}</span></div>
                                    <p class="text-sm mt-1 italic">"${escapeHtml(result.doa.ucapan)}"</p>
                                    <div class="text-[10px] mt-2 opacity-60"><i class="far fa-calendar"></i> ${escapeHtml(result.doa.created_at)}</div>
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

            document.getElementById("closeLightbox").addEventListener("click", () => document.getElementById("lightbox")
                .classList.remove("active"));
            document.getElementById("lightbox").addEventListener("click", (event) => {
                if (event.target === document.getElementById("lightbox")) {
                    document.getElementById("lightbox").classList.remove("active");
                }
            });

            const reveals = document.querySelectorAll('.scroll-reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('revealed');
                });
            }, {
                threshold: 0.15
            });
            reveals.forEach(reveal => observer.observe(reveal));

            function createFloatingFlowers() {
                const container = document.getElementById("flowerContainer");
                const flowers = ['*', '+', 'o'];
                for (let i = 0; i < 20; i++) {
                    const flower = document.createElement('div');
                    flower.className = 'floating-flower gold-text';
                    flower.innerHTML = flowers[Math.floor(Math.random() * flowers.length)];
                    flower.style.fontSize = (Math.random() * 20 + 16) + 'px';
                    flower.style.left = Math.random() * 100 + '%';
                    flower.style.animationDuration = (Math.random() * 10 + 8) + 's';
                    flower.style.animationDelay = Math.random() * 15 + 's';
                    flower.style.opacity = Math.random() * 0.4 + 0.2;
                    container.appendChild(flower);
                }
            }
            createFloatingFlowers();
        })();
    </script>
</body>

</html>
