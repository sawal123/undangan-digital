<div class="container px-0 fixed mx-auto w-full md:w-2/4 lg:w-1/3 h-screen justify-center items-center">
    <!-- Background Image -->
    <!-- Swiper -->
    <div class="absolute inset-0 swiper mySwiper h-full w-full">
        <div class="swiper-wrapper w-full h-full">
            <div class="swiper-slide bg-local bg-cover bg-center object-contain brightness-50 contrast-100"
                style="background-image: url('{{ asset('storage/' . $poto[0]) }}');"></div>
            <div class="swiper-slide bg-local bg-cover bg-origin-content bg-center object-cover brightness-50 contrast-100 "
                style="background-image: url('{{ asset('storage/' . $poto[1]) }}');"></div>
            <div class="swiper-slide bg-local bg-cover bg-center object-cover brightness-50 contrast-100 "
                style="background-image: url('{{ asset('storage/' . $poto[2]) }}');"></div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex flex-col items-center gap-4 md:gap-8 justify-center absolute inset-0 z-20 ">
        <!-- Main Content Row -->
        <div class="flex flex-row gap-4 items-center">
            <!-- List of Images -->
            <div class="flex flex-col gap-2">
                <ul class="flex flex-col gap-2">
                    <li>
                        <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}" alt="Image 1"
                            class="aspect-square object-cover w-[175px] h-[175px] md:w-[150px] md:h-[150px]"
                            lazy="load" />
                    </li>
                    <li>
                        <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}" alt="Image 2"
                            class="aspect-square object-cover w-[175px] h-[175px] md:w-[150px] md:h-[150px]" />
                    </li>
                    <li>
                        <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}" alt="Image 3"
                            class="aspect-square object-cover w-[175px] h-[175px] md:w-[150px] md:h-[150px]" />
                    </li>
                </ul>
            </div>

            <!-- Rotated Title -->
            <div class="w-10 flex justify-center">
                <h2 class="text-2xl text-white font-thin transform rotate-90 whitespace-nowrap font-italiana">
                    The Wedding of {{ $data->wanita->nama_panggilan }} &
                    {{ $data->pria->nama_panggilan }}
                </h2>
            </div>
        </div>

        <!-- Bottom Title -->
        <div class="">
            <h1 class="text-white text-3xl font-bold text-center font-italiana" data-aos="zoom-in-up"
                data-aos-duration="3000">{{ $data->wanita->nama_panggilan }} &
                {{ $data->pria->nama_panggilan }}</h1>
        </div>
    </div>

</div>
