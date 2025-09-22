<div class="h-full w-full   relative">
    <div class="w-full h-full z-30 brightness-75"
      style="background-image: url('{{ asset('storage/' . $thumbnailWa->thumbnail) }}'); background-size: cover; background-position: center;"></div>

    <div class="w-full z-50 absolute top-3">
      <h3 class="text-center font-normal text-2xl pt-10 text-shadow">{{$data->setting->acara ?? 'The Wedding'}}</h3>
      <h1 class="mt-5 text-center text-[40px] font-light text-shadow">{{ $data->pria->nama_panggilan }} <span
          class=" text-[25px]">&</span> {{ $data->wanita->nama_panggilan }}</h1>
      <p class="text-center text-[20px] text-shadow">{{ $data ? date('d', strtotime($data->acara[0]->date)) : '10' }}
        {{ $data ? date('m', strtotime($data->acara[0]->date)) : '10' }}
        {{ $data ? date('Y', strtotime($data->acara[0]->date)) : '2024' }}</p>
    </div>
    <!-- svg -->
    <svg xmlns="http://www.w3.org/2000/svg" class="w-full absolute bottom-0 lg:hidden block" viewBox="0 0 1440 320"><path fill="#fff7ed" fill-opacity="1" d="M0,32L48,58.7C96,85,192,139,288,138.7C384,139,480,85,576,80C672,75,768,117,864,160C960,203,1056,245,1152,234.7C1248,224,1344,160,1392,128L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    <!-- svg -->

    <div class="absolute inset-x-0 flex flex-col items-center bottom-20">
      <!-- Mouse -->
      <div class="w-8 h-14 border-2 border-white rounded-full relative">
        <!-- Wheel -->
        <div
          class="w-2 h-3 bg-orange-50 rounded-full absolute top-3 left-1/2 transform -translate-x-1/2 animate-scroll">
        </div>
      </div>
      <!-- Arrow -->
      <div class="mt-4 text-sm text-white">Scroll Kebawah</div>
    </div>
  </div>
