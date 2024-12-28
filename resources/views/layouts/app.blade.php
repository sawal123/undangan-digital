<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Shreethemes" />
    <meta name="email" content="support@shreethemes.in" />
    <meta name="website" content="https://shreethemes.in" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->



    <link rel="shortcut icon" href="{{ asset('logo/logo.svg') }}" />
    <!-- Css -->
    {{-- <link href="{{ asset('assetDashboard/libs/simplebar/simplebar.min.css') }}" rel="stylesheet"> --}}
    <!-- Bootstrap Css -->
    <link href="{{ asset('assetDashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assetDashboard/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assetDashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assetDashboard/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet" />
    <!-- Style Css-->
    <link href="{{ asset('assetDashboard/css/st.min.css') }}" class="theme-opt" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

    
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{asset('build/assets/app-CczSUIEg.css')}}">

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
                            {{-- <h6 class="text-muted mb-1">Welcome back, {{ Auth::user()->name }}</h6> --}}
                            {{-- <h5 class="mb-0">{{ $halaman ?? 'Dashboard' }}</h5> --}}
                        </div>
                    </div>
                    <div class="my-5">
                        {{ $slot }}
                    </div>
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
    {{-- <script src="assetDashboard/libs/apexcharts/apexcharts.min.js"></script> --}}
    <!-- Main Js -->
    {{-- Library Link --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assetDashboard/js/plugins.init.js') }}"></script>
    <script src="{{ asset('assetDashboard/js/app.js') }}"></script>

    @if (request()->routeIs('admin.setting'))
        <script src="{{ asset('assetDashboard/main/setting/deleteCategory.js') }}"></script>
        <script src="{{asset('assetDashboard/main/setting/deleteGiftPay.js')}}"></script>
    @endif


    @if (request()->routeIs('admin.price.index'))
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>
        <script>
            var urlPrice = "{{ route('admin.price.store') }}"
            var updatePrice = "{{ route('admin.price.update') }}"
        </script>
        <script src="{{ asset('assetDashboard/main/price/addPrice.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/price/deletePrice.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/price/modalUpdate.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/price/updatePrice.js') }}"></script>

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


            var des = document.querySelector(".deskripsiUp");
            var tag = new Tagify(des);
            des.addEventListener("change", function() {
                var deskripsiArray = tag.value.map(function(tag) {
                    return tag.value; // Ambil nilai dari setiap objek tag
                });
                console.log(deskripsiArray); // Akan menghasilkan array berisi string ["Ayam", "Anjing"]
            });
        </script>
    @endif

    @if (request()->routeIs('admin.theme.index'))
        <script>
            var urlAddTheme = "{{ route('admin.theme.store') }}"
            var urlUpdateTheme = "{{ url('admin/theme/') }}"
        </script>
        <script src="{{ asset('assetDashboard/main/theme/addTheme.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/theme/deleteTheme.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/theme/modalTheme.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/theme/thumbnailChanges.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/theme/modalThumbnail.js') }}"></script>
        <script src="{{ asset('assetDashboard/main/theme/updateTheme.js') }}"></script>
    @endif


</body>

</html>
