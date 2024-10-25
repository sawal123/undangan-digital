<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Landrick - Bootstrap 5 Multipurpose App, Saas & Software Landing & Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
    <meta name="keywords" content="Saas, Software, multi-uses, HTML, Clean, Modern" />
    <meta name="author" content="Shreethemes" />
    <meta name="email" content="support@shreethemes.in" />
    <meta name="website" content="https://shreethemes.in" />
    <meta name="Version" content="v4.8.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('assetDashboard/images/favicon.ico')}}" />
    <!-- Css -->
    <link href="{{asset('assetDashboard/libs/simplebar/simplebar.min.css')}}" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{asset('assetDashboard/css/bootstrap.min.css')}}" class="theme-opt" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assetDashboard/libs/@mdi/font/css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assetDashboard/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assetDashboard/libs/@iconscout/unicons/css/line.css')}}" type="text/css" rel="stylesheet" />
    <!-- Style Css-->
    <link href="{{asset('assetDashboard/css/style.min.css')}}" class="theme-opt" rel="stylesheet" type="text/css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    @vite([])
</head>

<body>

    <main>
        @yield('content')
    </main>


    <script src="{{asset('assetDashboard/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assetDashboard/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assetDashboard/libs/simplebar/simplebar.min.js')}}"></script>
    <!-- Main Js -->
    <script src="{{asset('assetDashboard/js/plugins.init.js')}}"></script>
    <script src="{{asset('assetDashboard/js/app.js')}}"></script>
    <script>
         var checkNameUrl = "{{ url('/check-name') }}"
    </script>
    <script src="{{ asset('assetDashboard/userJs/setup/checkName.js') }}"></script>

</body>

</html>
