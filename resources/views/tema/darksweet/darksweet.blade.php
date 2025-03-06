<!doctype html>
<html class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--  -->
  <link href="{{ asset('tema/darksweet/css/output.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/fontawesome-free/css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.css') }}">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/aos/dist/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/css/style.css') }}">


</head>

<body class="bg-neutral-300 text-slate-900 relative">

  <!-- Cover Section -->
 @include('tema.darksweet.cover')
  <!-- End of Cover Section -->

  <!-- content -->
 @include('tema.darksweet.content')
  <!-- content -->
<!-- Modal Qr -->



 <!-- Modal Image -->
 <div id="imageModal"
 class="fixed invisible inset-0 z-50  bg-black bg-opacity-75 flex items-center justify-center transition-all duration-300 ease-in-out">
 <div class="relative">
   <img id="modalImage" class="max-w-full max-h-screen rounded-lg shadow-xl py-11" src="" alt="Modal Image" />
   <button onclick=" closeModalImg()"
     class="absolute top-2 right-2 text-white bg-sky-500 hover:bg-slate-600 rounded-lg py-1 px-3 focus:outline-none">
     ✕
   </button>
 </div>
</div>
  <!-- datePick -->
  <script src="{{ asset('tema/darksweet/js/setDate.js') }}"></script>

  <!-- aos -->
  <script src="{{ asset('tema/darksweet/assets/aos/dist/aos.js') }}"></script>
  <script>
    AOS.init();
  </script>
  <!-- swiper -->
  <script src="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/swiper.js') }}"></script>

  <script src="{{ asset('tema/darksweet/js/autoScroll.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/openCover.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/modal.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/modalImage.js') }}"></script>
</body>

</html>