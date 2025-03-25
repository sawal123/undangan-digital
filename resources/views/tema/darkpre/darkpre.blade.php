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
  wire:
    <!--  css -->
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/aos/dist/aos.css') }}">
    <link href="{{ asset('tema/darkpre/src/css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/src/css/style.css') }}">
    <link rel="stylesheet" href=" {{ asset('tema/darkpre/src/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/darkpre/assets/swiper/swiper-bundle.min.css') }}">
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set waktu acara (Format: YYYY-MM-DD HH:MM:SS)
            let eventDate = new Date(
                "{{ $data ? date('Y-m-d', strtotime($data->acara[1]->date ?? $data->acara[0]->date ?? '')) : '2024-10-10' }}").getTime();

            // Update countdown setiap detik
            let countdown = setInterval(function() {
                let now = new Date().getTime();
                let distance = eventDate - now;

                // Perhitungan waktu
                let hari = Math.floor(distance / (1000 * 60 * 60 * 24));
                let jam = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let menit = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let detik = Math.floor((distance % (1000 * 60)) / 1000);

                // Tampilkan hasil di elemen dengan id yang sesuai
                document.getElementById("days").innerText = hari.toString().padStart(2, '0');
                document.getElementById("hours").innerText = jam.toString().padStart(2, '0');
                document.getElementById("minutes").innerText = menit.toString().padStart(2, '0');
                document.getElementById("seconds").innerText = detik.toString().padStart(2, '0');

                // Jika waktu habis
                if (distance < 0) {
                    clearInterval(countdown);
                    document.getElementById("days").innerText = "00";
                    document.getElementById("hours").innerText = "00";
                    document.getElementById("minutes").innerText = "00";
                    document.getElementById("seconds").innerText = "00";
                }
            }, 1000);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let eventTitle = "Pernikahan Kami";
            let eventDateStart = "{{ date('Ymd', strtotime($acara->date)) }}T100000Z"; // Sesuaikan jam UTC

            let eventDetails = "Jangan lewatkan momen spesial kami!";
            let eventLocation = "{{ $acara->alamat }}";

            let googleCalendarUrl =
                `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${eventDateStart}&details=${encodeURIComponent(eventDetails)}&location=${encodeURIComponent(eventLocation)}&sf=true&output=xml`;

            document.getElementById("googleCalendarBtn").href = googleCalendarUrl;
        });
    </script>
</body>

</html>
