<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="{{ $data->title }}" />
    <meta property="og:image" content="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- WhatsApp Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $data->title }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}">
    <title>{{ $data->title }}</title>

    <link rel="stylesheet" href="{{ asset('tema/whitepre/assets/aos/dist/aos.css') }}">
    <link href="{{ asset('tema/whitepre/src/css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tema/whitepre/src/css/style.css') }}">
    <link rel="stylesheet" href=" {{ asset('tema/whitepre/src/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/whitepre/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/whitepre/assets/swiper/swiper-bundle.min.css') }}">
    <script src="{{ asset('tema/whitepre/assets/swiper/swiper-bundle.min.js') }}"></script>

    <style>
        @if ($data->dataFont)
            @import url('{{ $data->dataFont->titleFont->link }}');
            @import url('{{ $data->dataFont->subFont->link }}');

        @else
            @import url('https://fonts.googleapis.com/css2?family=Capriola&family=Oleo+Script+Swash+Caps:wght@400;700&display=swap');
        @endif

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-family: "{{ $data->dataFont->titleFont->nama ?? 'Oleo Script Swash Caps' }}", system-ui;
            font-weight: 700;
            font-style: normal;
            font-size: {{ $data->dataFont->s_title }}px !important
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
            font-family: "{{ $data->dataFont->subFont->nama ?? 'Capriola' }}", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body class="relative">

    <!-- cover mobile -->
    @include('tema.whitepre.cover-mobile')


    <!-- konten -->
    <div class="flex flex-row h-screen z-10 relative">
        <!-- Bagian kiri  -->
        @include('tema.whitepre.bagian-kiri')

        <!-- Bagian kanan -->
        @include('tema.whitepre.bagian-kanan')

        <!-- Modal Image -->
        <div id="imageModal"
            class="fixed hidden inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center transition-all duration-300 ease-in-out">
            <div class="relative">
                <img id="modalImageContent" class="max-w-full max-h-screen rounded-lg shadow-xl py-11" src=""
                    alt="Modal Image" />
                <button onclick="closeModalImg()"
                    class="absolute top-2 right-2 text-white bg-sky-500 hover:bg-slate-600 rounded-lg py-1 px-3 focus:outline-none">
                    ✕
                </button>
            </div>
        </div>

    </div>
    <!-- konten -->



    <!-- konten -->
    <script src="{{ asset('tema/whitepre/assets/aos/dist/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>

    <!-- Swiper -->
    <script src="{{ asset('tema/whitepre/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/whitepre/assets/swiper/swiper-element-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/whitepre/src/js/swiper.js') }}"></script>


    {{-- nav --}}
    <script src="{{ asset('tema/whitepre/src/js/nav.js') }}"></script>
    <!-- modal -->
    <script src="{{ asset('tema/whitepre/src/js/modal.js') }}"></script>
    <!-- audio -->
    <script src="{{ asset('tema/whitepre/src/js/audio.js') }}"></script>

</body>

</html>
