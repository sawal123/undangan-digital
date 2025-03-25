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
    <link href="{{ asset('tema/standtheme/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tema/standtheme/assets/aos/dist/aos.css') }}">
</head>

<body class="bg-white ">
    <!-- Main modal -->
    @include('tema.standtheme.modal')
    <!--  end modal -->

    <!-- content -->
    <div class=" md:w-[640px] w-full bg-[#F7F4EF] mx-auto">
        <!-- cover -->
        @include('tema.standtheme.cover')
        {{-- end cover --}}

        <!-- opening -->
        @include('tema.standtheme.opening')
        {{-- end opening --}}

        <!-- undangan -->
        @include('tema.standtheme.undangan')
        {{-- end undangan --}}

        <!-- himbauan 1 -->
        @include('tema.standtheme.himbauan-1')
        <!-- end himbauan 1 -->

        <!-- denah -->
        @include('tema.standtheme.denah')
        <!-- end denah -->

        <!-- himbauan 2 -->
        {{-- @include('tema.standtheme.himbauan-2') --}}
        <!--end himbauan 2 -->

        <!-- album -->
        @include('tema.standtheme.album')
        <!-- end album -->

        <!-- reveal -->
        @include('tema.standtheme.reveal')
        <!-- end reveal -->

        <!-- ucapan-->
        @include('tema.standtheme.ucapan')
        <!-- end ucapan-->

        <div class="footer bg-[#755F4B] pb-10 ">
            <p class="text-center text-white pt-10">© Nikah 2025</p>
           
        </div>

    </div>

    <!-- Music -->
    @include('tema.standtheme.music')
   {{-- end music --}}
   <script>
    const buka = document.getElementById('bukaModal');
    const tutup = document.getElementById('tutupModal');
    const mod = document.getElementById('mod');

    buka.addEventListener('click', () => {
        mod.classList.remove('hidden');
    });

    tutup.addEventListener('click', () => {
        mod.classList.add('hidden');
    });

    // Close modal when clicking outside
    mod.addEventListener('click', (e) => {
        if (e.target === mod) {
            mod.classList.add('hidden');
        }
    });
</script>

<script src="{{ asset('tema/standtheme/assets/aos/dist/aos.js') }}"></script>
<script>
    AOS.init();
</script>
<script src="{{ asset('tema/standtheme/js/modal.js') }}"></script>

</body>

</html>
