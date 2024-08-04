<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Era Nikah</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" class="theme-opt" rel="stylesheet" type="text/css">

        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <link href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('assets/libs/tiny-slider/tiny-slider.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.min.css') }}" id="color-opt" class="theme-opt" rel="stylesheet" type="text/css">
        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        @vite([])
    </head>
    <body class="antialiased">
     <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div> 
        <!-- Loader -->
        
        <main>
            {{ $slot }}
        </main>

        
        <!-- Cookies Start -->
        {{-- <div class="card cookie-popup shadow rounded py-3 px-4">
            <p class="text-muted mb-0">This website uses cookies to provide you with a great user experience. By using it, you accept our <a href="https://shreethemes.in" target="_blank" class="text-success h6">use of cookies</a></p>
            <div class="cookie-popup-actions text-end">
                <button><i class="uil uil-times text-dark fs-4"></i></button>
            </div>
        </div> --}}
        <!--Note: Cookies Js including in plugins.init.js (path like; js/plugins.init.js) and Cookies css including in _helper.scss (path like; scss/_helper.scss)-->
        <!-- Cookies End -->
        

       

        <!-- Javascript -->
        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- SLIDER -->
        <script src="{{ asset('assets/libs/tiny-slider/min/tiny-slider.js') }}"></script>
        <!-- Main Js -->
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.init.js') }}"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
        <script src="{{ asset('assets/js/app.js') }}"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
    </body>
</html>
