<div class="relative min-h-screen hidden" id="thanks">
    <!-- Top Section -->
    @include('tema.spiderman.top-section')
    <!-- End Top Section -->

    <!-- konten thanks -->
    <div class="w-full flex flex-col items-center justify-center space-y-4 uppercase " data-aos="zoom-in"
      data-aos-duration="2500" data-aos-easing="ease-in-sine">


      <div class="text-center pt-32">
        <h3 class="leading-none text-[36px] font-extrabold uppercase ">Terima kasih<br>atas doa dan<br>kehadirannya</h3>
        <p class="max-w-[320px] mx-auto mt-5 text-sm normal-case px-6">
          {!! nl2br(e($data->teksUndangan?->penutup ?? 'Sampai jumpa di acara ulang tahun ' . $birthdayNickname . '.')) !!}
        </p>
      </div>


    </div>

    <!-- Bottom Section -->
    @include('tema.spiderman.bottom-section')
    <!-- End Bottom Section -->
  </div>
