<div class="container px-0 fixed mx-auto w-full md:w-2/4 lg:w-1/3 h-screen justify-center items-center">
    <!-- Background Image -->
    <!-- Swiper -->
    <div class="absolute inset-0 swiper mySwiper h-full w-full">
        @if ($poto == null)
            <div class="swiper-slide bg-local bg-cover bg-center object-cover brightness-50 contrast-100 "
                style="background-image: url('{{ asset('storage/' . $thumbnailWa->thumbnail) }}');"></div>
        @else
            <div class="swiper-wrapper w-full h-full">
                <div class="swiper-slide bg-local bg-cover bg-center object-contain brightness-50 contrast-100"
                    style="background-image: url('{{ asset('storage/' . $poto[0]) }}');"></div>
                <div class="swiper-slide bg-local bg-cover bg-origin-content bg-center object-cover brightness-50 contrast-100 "
                    style="background-image: url('{{ asset('storage/' . $poto[1]) }}');"></div>
                <div class="swiper-slide bg-local bg-cover bg-center object-cover brightness-50 contrast-100 "
                    style="background-image: url('{{ asset('storage/' . $poto[2]) }}');"></div>
            </div>
        @endif

    </div>

    <!-- Content -->
    <div class="flex flex-col items-center gap-4 md:gap-8 justify-center absolute inset-0 z-20 ">


        <!-- Bottom Title -->
        <div class="">
            <p class=" text-shadow text-center text-white " data-aos="zoom-in-up" data-aos-duration="2000">
                Invitation From</p>
            <h1 class=" text-shadow text-white text-4xl font-bold text-center " data-aos="zoom-in-up"
                data-aos-duration="3000">{{ $data->pria->nama_panggilan }} &
                {{ $data->wanita->nama_panggilan }}</h1>
        </div>
        @include('tema.darksweet.content.countdown')
    </div>

</div>
