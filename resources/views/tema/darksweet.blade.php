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
<div id="modal" class="fixed invisible inset-0 bg-black bg-opacity-50 flex  justify-center items-center z-50">
  <div class="bg-white rounded-lg w-80 p-6 shadow-lg relative">

    <h2 class="text-lg font-bold text-center mb-4">QRCode Buku Tamu</h2>
    <p class="text-center text-sm mb-4">The Wedding of Justins & Sisca</p>
    <p class="text-center text-sm mb-6">Tunjukkan QRCode di bawah ini ke panitia penyelenggara</p>
    <div class="flex justify-center mb-6">

      <img src="img/qr-1.jpg" alt="QR Code" class="w-40 h-40">
    </div>
    <div class="flex justify-center mb-4">
      <button id="downloadBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
        Download
      </button>
    </div>
    <div class="flex justify-center">
      <button id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
        Close
      </button>
    </div>
  </div>
</div>


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