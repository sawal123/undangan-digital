<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- START Swiper css -->


    <link rel="stylesheet" href="{{ asset('tema/spiderman/src/css/output.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/spiderman/src/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('tema/spiderman/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/spiderman/assets/aos/dist/aos.css') }}">


    <link rel="stylesheet" href="{{ asset('tema/spiderman/assets/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/spiderman/src/css/gallery.css') }}?v=gallery-fit-20260529">

    <script src="{{ asset('tema/spiderman/assets/swiper/swiper-bundle.min.js') }}"></script>
</head>

<body class=" bg-red-900 font-quantico">
    @php
        $birthday = $data->birthdayProfile;
        $birthdayName = $birthday?->name ?? $data->title ?? 'Birthday';
        $birthdayNickname = $birthday?->nickname ?? $birthdayName;
        $birthdayAge = $birthday?->age;
        $birthdayPhoto = $birthday?->photo ?? $data->pria?->image;
    @endphp

    <!-- Cover -->
    @include('tema.spiderman.content.cover')

    <!-- konten -->
    <div class="">

        <!-- Konten undangan-->
        <div class="spiderman-stage w-full lg:w-[430px] relative flex flex-col text-white overflow-hidden justify-center z-10 mx-auto lg:rounded-3xl"
            style="background-image: url('{{ asset('tema/spiderman/src/img/bg.webp') }}'); background-size: cover; background-position: center;">

            <!-- opening -->
            @include('tema.spiderman.content.opening')
            <!-- opening -->

            <!-- acara -->
            @include('tema.spiderman.content.acara')
            <!-- acara -->

            <!-- gallery -->
            @include('tema.spiderman.content.gallery')
            <!-- gallery -->

            <!-- RSVP -->
            @include('tema.spiderman.content.rsvp')
            <!-- RSVP -->

            <!--gift -->
            @include('tema.spiderman.content.gift')
            <!-- gift -->

            <!-- Thanks -->
            @include('tema.spiderman.content.thanks')
            <!-- Thanks -->

            <!-- Navbar Mobile -->
            @include('tema.spiderman.navbar')
            <!-- End Navbar Mobile -->

            <!-- button kanan -->
            @include('tema.spiderman.button-kanan')

            <!-- button kanan -->
        </div>
        <!-- Konten undangan-->


        <!-- music -->
        @include('tema.spiderman.music')
        <!-- music -->


        <!-- Modal Image -->
        @include('tema.spiderman.modal-image')
        <!-- Modal Image -->



        <!-- Modal gift-->
        @include('tema.spiderman.modal-gift')
        <!-- Modal gift-->


        <!-- modal ucapan kehadiran -->
        @include('tema.spiderman.modal-kehadiran')
        <!-- modal ucapan kehadiran -->


    </div>
    <!-- konten -->

    <!-- Swiper -->

    <script src="{{ asset('tema/spiderman/src/js/swiper.js') }}?v=gallery-fit-20260529"></script>

    <!-- aos -->

    <script src="{{ asset('tema/spiderman/assets/aos/dist/aos.js') }}"></script>

    <script>
        AOS.init();
    </script>


    <!-- nav -->
    <script src="{{ asset('tema/spiderman/src/js/nav.js') }}"></script>
    <!-- modal -->
    <script src="{{ asset('tema/spiderman/src/js/modal.js') }}?v=wish-modal-fix-20260529"></script>
    <!-- audio -->
    <script src="{{ asset('tema/spiderman/src/js/audio.js') }}"></script>
    {{-- <script src="{{ asset('tema/spiderman/src/js/setDate.js') }}"></script> --}}


</body>

</html>
