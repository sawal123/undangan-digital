{{-- <!DOCTYPE html> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Shreethemes" />
    <meta name="email" content="support@shreethemes.in" />
    <meta name="website" content="https://shreethemes.in" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->



    <link rel="shortcut icon" href="{{ asset('assetDashboard/images/favicon.ico') }}" />
    <!-- Css -->
    <link href="{{ asset('assetDashboard/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assetDashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetDashboard/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assetDashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assetDashboard/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assetDashboard/userJs/css/dashboard.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Style Css-->
    <link href="{{ asset('assetDashboard/css/style.min.css') }}" class="theme-opt" rel="stylesheet" type="text/css" />
    @if (request()->routeIs('dashboard.undangan.kado'))
        <link href="{{ asset('assetDashboard/libs/select2/dist/css/select2.css') }}" rel="stylesheet" />
    @endif
    @vite([])
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
                </div>
            </div>
        </main>
    </div>


    <!-- javascript -->
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assetDashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assetDashboard/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assetDashboard/libs/simplebar/simplebar.min.js') }}"></script>
    {{-- <script src="assetDashboard/libs/apexcharts/apexcharts.min.js"></script> --}}
    <!-- Main Js -->
    {{-- Library Link --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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






</body>

</html>
