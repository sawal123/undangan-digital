<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="{{ $data->title }}" />
    <meta property="og:description" content="Deskripsi singkat undangan." />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    @include('components.social-preview-meta', ['data' => $data, 'title' => $data->title])
    <title>{{ $data->title }}</title>
    <!--  css -->
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/aos/dist/aos.css') }}">
    <link href="{{ asset('tema/darkpre/src/css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/src/css/style.css') }}">
    <link rel="stylesheet" href=" {{ asset('tema/darkpre/src/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/swiper/swiper-bundle.min.css') }}">
    <script src="{{ asset('tema/darkpre/assets/swiper/swiper-bundle.min.js') }}"></script>


    <style>
        @if ($data->dataFont)
            @import url('{{ $data->dataFont?->titleFont?->link ?? '' }}');
            @import url('{{ $data->dataFont?->subFont?->link ?? '' }}');

        @else
            @import url('https://fonts.googleapis.com/css2?family=Capriola&family=Oleo+Script+Swash+Caps:wght@400;700&display=swap');
        @endif

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-family: "{{ $data->dataFont?->titleFont?->nama ?? 'Oleo Script Swash Caps' }}", system-ui;
            font-weight: 700;
            font-style: normal;
            font-size: {{ $data->dataFont?->s_title ?? 40 }}px !important
        }

        html,
        p,
        span,
        a,
        li,
        div,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "{{ $data->dataFont?->subFont?->nama ?? 'Capriola' }}", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>
    @include('tema.darkpre.styles')

</head>

<body class="darkpre-page relative">

    <!-- cover mobile -->
    @include('tema.darkpre.cover-mobile')

    <!-- konten -->
    <div class="darkpre-shell flex flex-row z-10 relative">
        <!-- Bagian kiri  -->
        @include('tema.darkpre.bagian-kiri-pc')

        <!-- Bagian kanan -->
        @include('tema.darkpre.bagian-kanan')

        <!-- Modal Image -->
        <div id="imageModal"
            class="fixed hidden inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center transition-all duration-300 ease-in-out">
            <div class="relative">
                <img id="modalImageContent" class="max-w-full max-h-screen rounded-lg shadow-xl py-11" src=""
                    alt="Modal Image" />
                <button onclick="closeModalImg()" aria-label="Tutup gambar"
                    class="absolute top-2 right-2 text-white bg-sky-500 hover:bg-slate-600 rounded-lg py-1 px-3 focus:outline-none">
                    &times;
                </button>
            </div>
        </div>

    </div>
    <!-- konten -->
    <script src="{{ asset('tema/darkpre/assets/aos/dist/aos.js') }}"></script>
    <script>
        AOS.init({
            duration: 850,
            easing: 'ease-out-cubic',
            once: true,
            offset: 70
        });
    </script>

    <!-- Swiper -->
    <script src="{{ asset('tema/darkpre/src/js/swiper.js') }}"></script>

    {{-- nav --}}
    <script src="{{ asset('tema/darkpre/src/js/nav.js') }}"></script>
    <!-- modal -->
    <script src="{{ asset('tema/darkpre/src/js/modal.js') }}"></script>
    <!-- audio -->
    <script src="{{ asset('tema/darkpre/src/js/audio.js') }}"></script>
</body>

</html>
