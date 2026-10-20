<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:description" content="Undangan {{ $data->title }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title])
    <title>{{ $data->title }}</title>

    <link rel="stylesheet" href="{{ asset('tema/standtheme/assets/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/standtheme/css/style.css') }}">
    <style>
        @if ($data->dataFont)
            @import url('{{ $data->dataFont?->titleFont?->link ?? '' }}');
            @import url('{{ $data->dataFont?->subFont?->link ?? '' }}');
        @else
            @import url('https://fonts.googleapis.com/css2?family=Capriola&family=Dancing+Script:wght@400..700&display=swap');
        @endif

        :root {
            --stand-title-font: "{{ $data->dataFont?->titleFont?->nama ?? 'Dancing Script' }}", cursive;
            --stand-body-font: "{{ $data->dataFont?->subFont?->nama ?? 'Capriola' }}", system-ui, sans-serif;
        }

        .stand-body { font-family: var(--stand-body-font); }
        .stand-title, .stand-script, .stand-modal__title, .stand-cover__title, .stand-opening__names, .stand-event-card__title, .stand-footer__title, .stand-music-modal__panel h2 { font-family: var(--stand-title-font); }
    </style>
</head>

<body class="stand-body is-locked">
    <div class="stand-shell">
        @include('tema.standtheme.modal')

        <main id="standContent" class="stand-main">
            @include('tema.standtheme.cover')
            @include('tema.standtheme.opening')
            @include('tema.standtheme.undangan')
            @include('tema.standtheme.himbauan-1')
            @include('tema.standtheme.reveal')
            @include('tema.standtheme.album')
            @include('tema.standtheme.denah')
            @include('tema.standtheme.himbauan-2')
            @include('tema.standtheme.ucapan')

            <footer class="stand-footer">
                <h2 class="stand-footer__title">Terima Kasih</h2>
                <p class="stand-footer__text">Dengan penuh kasih, {{ $data->pria?->nama_panggilan ?? '' }} &amp; {{ $data->wanita?->nama_panggilan ?? '' }}</p>
            </footer>
        </main>

        <nav class="stand-nav" aria-label="Navigasi undangan">
            <div class="stand-nav__inner">
                <a class="stand-nav__link" href="#standCover"><i class="fa-solid fa-house"></i><span>Home</span></a>
                <a class="stand-nav__link" href="#standAcara"><i class="fa-solid fa-calendar-days"></i><span>Acara</span></a>
                <a class="stand-nav__link" href="#standGallery"><i class="fa-solid fa-images"></i><span>Galeri</span></a>
                <a class="stand-nav__link" href="#standMap"><i class="fa-solid fa-location-dot"></i><span>Lokasi</span></a>
                <a class="stand-nav__link" href="#standUcapan"><i class="fa-solid fa-comment-dots"></i><span>Ucapan</span></a>
            </div>
        </nav>
    </div>

    @include('tema.standtheme.music')

    <div id="standLightbox" class="stand-lightbox is-hidden" role="dialog" aria-modal="true" aria-label="Pratinjau foto">
        <div class="stand-lightbox__panel">
            <button type="button" class="stand-lightbox__close" onclick="closeStandLightbox()" aria-label="Tutup foto">&times;</button>
            <img id="standLightboxImage" src="" alt="Pratinjau foto">
        </div>
    </div>

    <script src="{{ asset('tema/standtheme/assets/aos/dist/aos.js') }}"></script>
    <script>window.addEventListener('load', () => window.AOS?.init({ once: true, duration: 750, offset: 70 }));</script>
    <script src="{{ asset('tema/standtheme/js/modal.js') }}"></script>
</body>

</html>
