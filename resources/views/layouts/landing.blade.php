<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Wayae Nikah" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta name="twitter:image" content="{{ asset('logo/logo.svg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Wayae Nikah">
    <meta name="description" content="Wayae Login dan buat undangan kamu" />
    <meta name="keywords" content="Undangan Digital, Undangan Digital Murah, Wayae Nikah, Wayae Kawin" />
    <meta name="author" content="Wayae Nikah" />
    <meta name="Version" content="v1.0.0" />

    <title>Wayae Nikah</title>

    <!-- Fonts & Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/tiny-slider/tiny-slider.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{ asset('logo/logo.svg') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-CczSUIEg.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/dist/css/lightbox.css') }}">

    @livewireStyles
    @vite([])
</head>

<body class="antialiased">
    <!-- Loader -->

    <livewire:part.header>

        <main>
            {{ $slot }}
        </main>


        @livewireScripts
        <script src="{{asset('assets/js/jquery.js')}}"></script>
        <script src="{{ asset('build/assets/app-I5mmpHKZ.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/tiny-slider/min/tiny-slider.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.init.js') }}"></script>
        <script src="{{ asset('assets/libs/dist/js/lightbox.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        

</body>

</html>
