<div class="relative min-h-screen hidden" id="rspv">
    <!-- Top Section -->
    @include('tema.spiderman.top-section')
    <!-- End Top Section -->

    <!-- konten RSVP -->
    <div class="w-full flex flex-col items-center justify-center space-y-4 uppercase z-50">

      <div class="w-full flex justify-center items-center" data-aos="fade-down" data-aos-duration="2500"
        data-aos-easing="ease-in-sine">
        <img src="{{ $birthdayPhoto ? asset('storage/' . $birthdayPhoto) : asset('tema/spiderman/src/img/bayi.webp') }}" alt="bayi"
          class="max-w-[200px] max-h-[200px] object-cover object-center rounded-full aspect-square animate-bounce ease-in-out duration-300 border-4 border-red-500">
      </div>

      <div class="text-center" data-aos="fade-up" data-aos-duration="2000" data-aos-easing="ease-in-sine">
        <h3 class="leading-none text-[30px] font-extrabold">Kirim Ucapan dan <br>Konfirmasi <br>Kehadiran</h3>
      </div>

      <button type="button" onclick="toggleModalRspv()" data-aos="fade-up" data-aos-duration="2500"
        data-aos-easing="ease-in-sine"
        class="font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] rounded-full">
        Kirim Ucapan dan Kehadiran
      </button>

    </div>

    <!-- Bottom Section -->
    @include('tema.spiderman.bottom-section')
    <!-- End Bottom Section -->
  </div>
