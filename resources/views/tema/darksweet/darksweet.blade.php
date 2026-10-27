<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        
         use Carbon\Carbon;
        Carbon::setLocale('id');
        $firstAcaraDate = ($data->acara[0] ?? null)?->date;
        $tanggalAcara = $firstAcaraDate ? Carbon::parse($firstAcaraDate)->translatedFormat('l, j F Y') : '';
    @endphp
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:site_name" content="Wayae Nikah">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:description" content="Acara akan dilaksanakan pada {{ $tanggalAcara }}.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title])
    <title>{{ $data->setting?->acara ?? 'The Wedding' }} {{ $coupleNames ?? $data->couple_name }}</title>

    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darksweet/css/style.css') }}?v={{ filemtime(public_path('tema/darksweet/css/style.css')) }}">
    <style>
        @if ($data->dataFont)
            @import url('{{ $data->dataFont?->titleFont?->link ?? '' }}');
            @import url('{{ $data->dataFont?->subFont?->link ?? '' }}');
        @else
            @import url('https://fonts.googleapis.com/css2?family=Capriola&family=Oleo+Script+Swash+Caps:wght@400;700&display=swap');
        @endif

        :root {
            --ds-title-font: "{{ $data->dataFont?->titleFont?->nama ?? 'Oleo Script Swash Caps' }}", Georgia, serif;
            --ds-body-font: "{{ $data->dataFont?->subFont?->nama ?? 'Capriola' }}", system-ui, sans-serif;
        }

        .darksweet-body { font-family: var(--ds-body-font); }
        .darksweet-cover__title, .darksweet-script, .darksweet-section__title, .darksweet-hero__title, .darksweet-ending__title { font-family: var(--ds-title-font); }
    </style>
</head>

<body class="darksweet-body darksweet-locked">
    <div class="darksweet-shell">
        @include('tema.darksweet.cover')

        <main id="content" class="darksweet-content is-locked">
            @include('tema.darksweet.content')
        </main>
    </div>

    <div id="imageModal" class="darksweet-modal is-hidden" role="dialog" aria-modal="true" aria-label="Pratinjau foto">
        <div class="darksweet-modal__panel">
            <button type="button" class="darksweet-modal__close" onclick="closeModalImg()" aria-label="Tutup foto">&times;</button>
            <img id="modalImage" class="darksweet-modal__image" src="" alt="Pratinjau foto">
        </div>
    </div>

    <script src="{{ asset('tema/darksweet/assets/aos/dist/aos.js') }}"></script>
    <script>window.addEventListener('load', () => window.AOS?.init({ once: true, duration: 750, offset: 70 }));</script>
    <script src="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/setDate.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/swiper.js') }}?v={{ filemtime(public_path('tema/darksweet/js/swiper.js')) }}"></script>
    <script src="{{ asset('tema/darksweet/js/autoScroll.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/openCover.js') }}"></script>
    <script src="{{ asset('tema/darksweet/js/modalImage.js') }}"></script>
</body>

</html>
