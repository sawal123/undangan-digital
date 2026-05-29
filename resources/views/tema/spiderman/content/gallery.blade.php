<div class="relative min-h-screen overflow-hidden hidden spiderman-gallery-section" id="gallery">
    <!-- Top Section -->
    @include('tema.spiderman.top-section')
    <!-- End Top Section -->

    <!-- konten gallery -->
    <div class="w-full flex flex-col items-center justify-start space-y-4 uppercase z-20 font-audiowide relative spiderman-gallery-content">

      <div class="text-center pt-10 pb-10 spiderman-gallery-title">
        <h3 class="leading-none text-[30px] font-extrabold" data-aos="fade-down" data-aos-duration="2500"
          data-aos-easing="ease-in-sine">Gallery</h3>
      </div>

      <div class="swiper mySwiper spiderman-gallery-swiper" style="overflow: hidden;">
        <div class="swiper-wrapper ">
          @forelse ($poto as $item)
            <div class="swiper-slide spiderman-gallery-slide">
              <img src="{{ asset('storage/' . $item) }} " alt="Thumbnail" onclick="openModalImg(this)"
                class="spiderman-gallery-image shadow-md cursor-pointer rounded-xl border-4 border-red-500" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </div>
          @empty
            <div class="swiper-slide spiderman-gallery-slide">
              <img src="{{ $birthdayPhoto ? asset('storage/' . $birthdayPhoto) : asset('tema/spiderman/src/img/bayi.webp') }}" alt="Birthday"
                class="spiderman-gallery-image shadow-md rounded-xl border-4 border-red-500" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </div>
          @endforelse
        </div>
      </div>

    </div>

    <!-- Bottom Section -->
    @include('tema.spiderman.bottom-section')
    <!-- End Bottom Section -->
  </div>
