<div class=" lg:w-3/5 md:h-screen lg:fixed z-20">
    <!-- opening  -->
    <div class="z-50 w-full h-full brightness-50 contrast-100	saturate-100"
      style="background-image: url('{{ asset('storage/'. $thumbnailWa->thumbnail) }}'); background-size: cover; background-position: center;"></div>
    <h1 class="absolute bottom-12 left-14 text-[50px] text-white  font-great_vibes hidden lg:block">{{ $data->wanita->nama_panggilan }} <span
        class=" text-[25px]" > & </span> {{ $data->pria->nama_panggilan }}</h1>

    <!-- music -->
    @include('tema.whitepre.content.music')
    <!-- music -->

    <!-- kado -->
    @include('tema.whitepre.content.kado')
    <!-- kado -->

    <!-- Navbar -->
    <div
      class="navbar hidden lg:block lg:absolute lg:right-8 lg:top-72 lg:w-9 h-auto bg-orange-50 rounded-full shadow-lg z-40"
      id="navbar">
      <div class=" py-3 relative">
        <div class="flex flex-col justify-center items-center w-full text-pink-800 text-sm gap-3">
          <a class="nav-link  couple flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
            href="#couple">
            <i class="fa-regular fa-heart"></i>
            <span class="ml-2 hidden">couple</span>
          </a>
          <a class="nav-link  gallery flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
            href="#gallery">
            <i class="fa-regular fa-images"></i>
            <span class="ml-2 hidden">gallery</span>
          </a>
          <a class="nav-link   date  flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
            href="#date">
            <i class="fa-regular fa-calendar"></i>
            <span class="ml-2 hidden">date</span>
          </a>
          <a class="nav-link  location flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
            href="#location">
            <i class="fa-solid fa-map-location-dot"></i>
            <span class="ml-2 hidden">location</span>
          </a>

          <a class="nav-link  wishes flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
            href="#wishes">
            <i class="fa-regular fa-note-sticky"></i>
            <span class="ml-2 hidden">wishes</span>
          </a>
        </div>
      </div>
    </div>
    <!-- Navbar -->

  </div>
