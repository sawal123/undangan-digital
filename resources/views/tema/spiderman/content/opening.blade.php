<div class="relative min-h-screen hidden transition-all" id="opening">
    <!-- Top Section -->
    @include('tema.ultah.top-section')
    <!-- End Top Section -->

    <!-- konten opening -->
    <div class="w-full flex flex-col items-center justify-center space-y-4">
      <div class="text-center text-[40px] font-bold text-white leading-tight pb-7 animate-bounce font-audiowide"
        data-aos="fade-down" data-aos-duration="2000" data-aos-easing="ease-in-sine">
        <span class="text-[#FFC300]">Happy</span> <br /> Birthday
      </div>
      <div class="text-center font-extrabold text-[20px] space-y-2" data-aos="zoom-in" data-aos-duration="2500"
        data-aos-easing="ease-in-sine">
        <h4 class="text-[20px]">JOIN US TO CELEBRATE</h4>
        <h1 class="text-[50px] leading-none font-audiowide"> {{ $data->pria->nama_panggilan }}</h1>
        <h4 class="text-[20px]">BIRTHDAY PARTY</h4>
      </div>
      <div class="text-center pt-6 space-y-2" data-aos="zoom-in" data-aos-duration="2500"
      data-aos-easing="ease-in-sine">
        <p class="text-[16px]">with Pleasure</p>
        <h3 class="text-[18px] font-semibold">{{ $tamu }}</h3>
      </div>
    </div>

    <!-- Bottom Section -->
    @include('tema.ultah.bottom-section')
    <!-- End Bottom Section -->
  </div>