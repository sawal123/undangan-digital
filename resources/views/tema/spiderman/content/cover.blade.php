<div id="cover"
    class="w-full lg:w-[430px] inset-0  absolute text-white z-50 mx-auto bg-red-500 lg:rounded-3xl min-h-screen rounded-3x overflow-hidden"
    style="background-image: url('{{ asset('tema/ultah/src/img/bg.webp') }} '); background-size: cover; background-position: center;">

    <!-- Top Section -->
    @include('tema.ultah.top-section')
    <!-- End Top Section -->

    <div class="w-full flex flex-col items-center justify-center space-y-4">
        <!-- Content -->
        <div class="w-full flex flex-col items-center justify-center space-y-4">
            <div class="text-center text-[40px] font-bold text-white leading-tight pb-7 animate-bounce font-audiowide"  data-aos="fade-down" data-aos-duration="2000" data-aos-easing="ease-in-sine">
                <span class="text-[#FFC300]">Happy</span> <br /> Birthday
            </div>
            <div class="text-center font-extrabold text-[20px] space-y-2" data-aos="zoom-in" data-aos-duration="2500"
            data-aos-easing="ease-in-sine">
                <h4 class="text-[20px]">JOIN US TO CELEBRATE</h4>
                <h1 class="text-[50px] leading-none font-audiowide">{{ $data->pria->nama_panggilan }}</h1>
                <h4 class="text-[20px]">BIRTHDAY PARTY</h4>
            </div>
            <div class="text-center pt-6 space-y-2" data-aos="zoom-in" data-aos-duration="2500"
            data-aos-easing="ease-in-sine">
                <p class="text-[16px]">with Pleasure</p>
                <h3 class="text-[20px] font-semibold">{{$tamu}}</h3>
            </div>
        </div>

        <!-- Open Cover Button -->
        <button id="open-cover"
            class="absolute button-cover bottom-36 px-4 text-black py-2 font-semibold rounded-lg bg-[#FFC300] border-2 z-50">
            Mari Selebrasi
        </button>
    </div>

    <!-- Bottom Section -->
    <div class="absolute bottom-0 w-full">
        <img src="{{ asset('tema/ultah/src/img/bm.webp') }}" alt="Bottom Middle" data-aos="fade-up" data-aos-easing="ease-in-sine" data-aos-duration="1500">
    </div>
    <div class="w-full flex absolute bottom-0">
        <div class="basis-1/2">
            <img src="{{ asset('tema/ultah/src/img/bl.webp') }}" alt="Bottom Left" data-aos="fade-up-right" data-aos-easing="ease-in-sine"
                data-aos-duration="2500">
        </div>
        <div class="basis-1/2">
            <img src="{{ asset('tema/ultah/src/img/br.webp') }}" alt="Bottom Right" data-aos="fade-up-left" data-aos-easing="ease-in-sine"
                data-aos-duration="2500">
        </div>
    </div>
    
    <!-- End Bottom Section -->
</div>
