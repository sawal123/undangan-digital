<!DOCTYPE html>
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
    <!-- Style Css-->
    <link href="{{ asset('assetDashboard/css/style.min.css') }}" class="theme-opt" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @vite([])
</head>

<body class="font-sans antialiased">
    <div class="page-wrapper toggled">
        <livewire:admin.layout.navigation />
        <!-- Page Content -->
        <main class="page-content bg-light">
            @include('layouts.app.top-header')
            <div class="container-fluid">
                <div class="layout-specing">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Welcome back, {{ Auth::user()->name }}</h6>
                            <h5 class="mb-0">{{ $halaman ?? 'Dashboard' }}</h5>
                        </div>
                    </div>
                    <div class="my-5">
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

    @if (request()->routeIs('admin.setting'))
        <script src="{{ asset('assetDashboard/main/setting/deleteCategory.js') }}"></script>
    @endif


    @if (request()->routeIs('admin.price.index'))
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>
        <script>
            var urlPrice = "{{ route('admin.price.store') }}"
        </script>
        <script src="{{ asset('assetDashboard/main/price/addPrice.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/price/deletePrice.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/price/modalUpdate.js') }}"></script>
        <script>
            $('#empty').html('<strong>harga Masih Kosong! </strong>');
        </script>
        <script>
            var input = document.querySelector('.deskripsi');
            var tagify = new Tagify(input);
            input.addEventListener('change', function() {
                var deskripsiArray = tagify.value.map(function(tag) {
                    return tag.value; // Ambil nilai dari setiap objek tag
                });
                console.log(deskripsiArray); // Akan menghasilkan array berisi string ["Ayam", "Anjing"]
            });
        </script>
       
    @endif

</body>

</html>
