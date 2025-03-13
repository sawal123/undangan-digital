<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="{{ $data->title }}" />
    <meta name="twitter:image" content="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}">
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- WhatsApp Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $data->title }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}">
    <title>{{ $data->title }}</title>

    <!--  css -->
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/aos/dist/aos.css') }}">
    <link href="{{ asset('tema/darkpre/src/css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/src/css/style.css') }}">
    <link rel="stylesheet" href=" {{ asset('tema/darkpre/src/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/undangan2/assets/swiper/swiper-bundle.min.css') }}">
    <script src="{{ asset('tema/darkpre/assets/swiper/swiper-bundle.min.js') }}"></script>
</head>

<body class="relative">

    <!-- cover mobile -->
    @include('tema.darkpre.cover-mobile')

    <!-- konten -->
    <div class="flex flex-row h-screen z-10 relative">
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
                <button onclick="closeModalImg()"
                    class="absolute top-2 right-2 text-white bg-sky-500 hover:bg-slate-600 rounded-lg py-1 px-3 focus:outline-none">
                    ✕
                </button>
            </div>
        </div>

    </div>
    <!-- konten -->
    <script src="{{ asset('tema/darkpre/assets/aos/dist/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>

    <!-- Swiper -->
    <script src="{{ asset('tema/darkpre/src/js/swiper.js') }}"></script>

    {{-- nav --}}
    <script src="{{ asset('tema/darkpre/src/js/nav.js') }}"></script>
    <!-- modal -->
    <script src="{{ asset('tema/darkpre/src/js/modal.js') }}"></script>
    <!-- audio -->
    <script src="{{ asset('tema/darkpre/src/js/audio.js') }}"></script>
    {{-- <script src="{{ asset('tema/darkpre/src/js/setDate.js') }}"></script> --}}
</body>

</html>
