<div class="relative min-h-screen hidden" id="gallery">
    <!-- Top Section -->
    @include('tema.ultah.top-section')
    <!-- End Top Section -->

    <!-- konten gallery -->
    <div class="w-full flex flex-col items-center justify-center space-y-4 uppercase z-50 font-audiowide relative">

      <div class="text-center pt-10 pb-10">
        <h3 class="leading-none text-[30px] font-extrabold" data-aos="fade-down" data-aos-duration="2500"
          data-aos-easing="ease-in-sine">Gallery</h3>
      </div>

      <div class="swiper mySwiper  ">
        <div class="swiper-wrapper ">
          @foreach ($poto as $item)
          <div class="swiper-slide">
            <img src="{{ asset('storage/' . $item) }} " alt="Thumbnail" onclick="openModalImg(this)"
              class="object-cover object-center w-full h-full shadow-md cursor-pointer rounded-xl border-4 border-red-500">
          </div>
          @endforeach
        </div>
      </div>

    </div>

    <!-- Bottom Section -->
    @include('tema.ultah.bottom-section')
    <!-- End Bottom Section -->
  </div>