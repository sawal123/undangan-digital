<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Wayae Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Wayae Login dan buat undangan kamu" />
    <meta name="keywords" content="Undangan Digital, Undangan Digital Murah, Wayae Nikah, Wayae Kawin" />
    <meta name="author" content="Wayae Nikah" />
    <meta name="website" content="https://wayaenikah.com" />
    <meta name="Version" content="v1.0.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; script-src 'self' 'nonce-{{ $nonce }}'; style-src 'self' 'nonce-{{ $nonce }}';">


    <link rel="shortcut icon" href="{{ asset('logo/logo.svg') }}" />
    <!-- Css -->
    <link href="{{ asset('assetDashboard/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assetDashboard/css/bootstrap.min.css') }}" class="theme-opt" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetDashboard/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assetDashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assetDashboard/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet" />
    <!-- Style Css-->
    <link href="{{ asset('assetDashboard/css/st.min.css') }}" class="theme-opt" rel="stylesheet" type="text/css" />



    <link rel="stylesheet" href="{{ asset('build/assets/app-CczSUIEg.css') }}">

    @vite([])
</head>

<body>

    <main>
        @yield('content')
    </main>
    <script nonce="{{ $nonce }}">
        var checkNameUrl = "{{ url('/check-name') }}"
    </script>
    <script src="{{ asset('assetDashboard/js/jquery.js') }}"></script>
    <script src="{{ asset('build/assets/app-I5mmpHKZ.js') }}"></script>
    <script src="{{ asset('assetDashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetDashboard/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assetDashboard/libs/simplebar/simplebar.min.js') }}"></script>
    <!-- Main Js -->
    <script src="{{ asset('assetDashboard/js/plugins.init.js') }}"></script>
    <script src="{{ asset('assetDashboard/js/app.js') }}"></script>

    <script src="{{ asset('assetDashboard/userJs/setup/checkName.js') }}"></script>

</body>

</html>
