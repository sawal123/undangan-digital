{{-- <!DOCTYPE html> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Wayae Login dan buat undangan kamu" />
    <meta name="keywords" content="Undangan Digital, Undangan Digital Murah, Wayae Nikah, Wayae Kawin" />
    <meta name="author" content="Wayae Nikah" />
    <meta name="website" content="https://wayaenikah.com" />
    <meta name="Version" content="v1.0.0" />
    {{-- @php
        $nonce = bin2hex(random_bytes(16));
    @endphp
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'nonce-{{ $nonce }}' {{url('/')}}; style-src 'self' 'nonce-{{ $nonce }}';"> --}}
    <title>Dashoard {{ Auth::user()->name }}</title>

    <!-- Fonts -->



    <link rel="shortcut icon" href="{{ asset('logo/logo.svg') }}" />
    <!-- Css -->
    <link href="{{ asset('assetDashboard/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assetDashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetDashboard/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assetDashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assetDashboard/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('assetDashboard/tagify/tagify.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assetDashboard/userJs/css/dashboard.css') }}">
   
    <!-- Style Css-->
    <link href="{{ asset('assetDashboard/css/st.min.css') }}" class="theme-opt" rel="stylesheet" type="text/css" />
    @if (request()->routeIs('dashboard.undangan.kado'))
        <link href="{{ asset('assetDashboard/libs/select2/dist/css/select2.css') }}" rel="stylesheet" />
    @endif

    <link rel="stylesheet" href="{{asset('build/assets/app-CczSUIEg.css')}}">
   
    

    @vite([])
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="page-wrapper toggled">
        @if (!request()->routeIs('dashboard.setup'))
            <livewire:dashboard.sidebar />
        @endif
        <!-- Page Content -->
        <main class="page-content bg-light">
            @if (!request()->routeIs('dashboard.setup'))
                @include('layouts.app.top-header')
            @endif

            <div class="container-fluid">
                <div class="layout-specing">
                    <div class="d-flex align-items-center justify-content-between">
                        @if (request()->routeIs('dashboard.dashboard'))
                            <div>
                                <h6 class="text-muted mb-1">Welcome back, {{ Auth::user()->name }}</h6>
                            </div>
                        @endif
                    </div>
                    <div class="">
                        {{ $slot }}
                    </div>
                    {{-- @livewire('your-component') --}}
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assetDashboard/js/jquery.js') }}"></script>
    <!-- javascript -->
    <!-- JAVASCRIPT -->
    <script src="{{asset('build/assets/app-I5mmpHKZ.js')}}"></script>

    <script src="{{ asset('assetDashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetDashboard/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assetDashboard/libs/simplebar/simplebar.min.js') }}"></script>


    <script src="{{asset('assetDashboard/libs/sweetalert/sweetAlert.js')}}"></script>

    <script src="{{ asset('assetDashboard/js/plugins.init.js') }}"></script>
    <script src="{{ asset('assetDashboard/js/app.js') }}"></script>

    @if (request()->routeIs('dashboard.undangan.kelola'))
        <script src="{{ asset('assetDashboard/userJs/dashboard/copyLink.js') }}"></script>
    @endif


    @if (request()->routeIs('dashboard.undangan.acara'))
        <script src="{{ asset('assetDashboard/userJs/kelola-undangan/acara.js') }}"></script>
    @endif

    @if (request()->routeIs('dashboard.undangan.galery'))
        <script src="{{ asset('assetDashboard/userJs/kelola-undangan/galery.js') }}"></script>
    @endif
    @if (request()->routeIs('dashboard.undangan.ucapan'))
        <script src="{{ asset('assetDashboard/userJs/kelola-undangan/ucapan.js') }}"></script>
    @endif
    @if (request()->routeIs('dashboard.undangan.tamu'))
        <script src="{{ asset('assetDashboard/userJs/kelola-undangan/tamu.js') }}"></script>
        <script></script>
    @endif
    @if (request()->routeIs('dashboard.undangan.kado'))
        <script src="{{ asset('assetDashboard/userJs/kelola-undangan/kado.js') }}"></script>
    @endif
    @if (request()->routeIs('dashboard.undangan.kisah'))
        <script src="{{ asset('assetDashboard/userJs/kelola-undangan/kisah.js') }}"></script>
    @endif


    <script>
       
        // const removeBackdrop = () => {
        //     const backdrop = document.querySelector(".modal-backdrop");
        //     if (backdrop) {
        //         backdrop.remove();
        //     }
        //     document.body.classList.remove("modal-open"); // Menghilangkan class `modal-open` dari body
        //     document.body.style.overflow = "auto";
        // };
    </script>
    @livewireScripts





</body>

</html>
