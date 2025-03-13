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


    {{-- <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; script-src 'self' 'nonce-{{ $nonce }}'; style-src 'self' 'nonce-{{ $nonce }}';"> --}}


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

    <script src="https://cdn.jsdelivr.net/npm/heroicons-css@0.1.1/heroicons.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/heroicons-css@0.1.1/heroicons.min.css" rel="stylesheet">

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

    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eyeIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>
`;
            } else {
                passwordField.type = "password";
                eyeIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
</svg>`;
            }
        });
    </script>


</html>
