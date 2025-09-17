<div class="w-full lg:w-2/5 h-full relative items-center text-white ml-auto z-10">

    <!-- cover-kiri -->
    @include('tema.darkpre.content.cover-kanan')
    <!-- End cover-kiri -->

    <!-- Kutipan Al-Qur'an -->
    <div class="bg-neutral-950 w-full p-2 ">

        <div class="border border-orange-200 rounded-lg border-dashed text-orange-200 p-2 italic">
            <p class="text-center font-semibold p-10 space-y-3 lg:text-lg text-[13px]">{{ $data->qoute->title }}</p>
            <p class="text-center font-semibold  space-y-3 lg:text-lg text-[13px]">"{{ $data->qoute->qoute }}" <br>
                <br>
                <span class="italic">{{ $data->qoute->subtitle }}</span>
            </p>
        </div>
    </div>

    <!-- pembatas -->
    <div class="bg-neutral-950 pt-10 section" id="couple"><img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}"
            class="w-full" alt=""></div>

    <!-- opening -->
    @include('tema.darkpre.content.pengantin.opening')
    <!-- opening -->

    <!-- pembatas -->
    <div class="bg-neutral-950  section" id="date"><img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}"
            class="w-full rotate-180" alt=""></div>

    <!-- himbauan 1 -->
    @include('tema.darkpre.content.pengantin.himbauan-1')
    <!-- end himbauan 1 -->

    <!-- pembatas -->
    <div class="bg-neutral-950  section" id="location"><img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}"
            class="w-full" alt=""></div>

    <!-- acara -->
    @include('tema.darkpre.content.pengantin.acara')
    <!-- acara -->

    <!-- pembatas -->
    <div class="bg-neutral-950 "><img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" class="w-full rotate-180"
            alt=""></div>

    {{-- story --}}
    @include('tema.darkpre.content.pengantin.story')
    {{-- story --}}

    <!-- album -->
    @include('tema.darkpre.content.pengantin.album')
    <!-- end album -->

    <!-- ucapan -->
    @include('tema.darkpre.content.pengantin.ucapan')
    <!-- ucapan -->

    <div class="text-center pt-6 lg:pt-12 text-orange-200 text-[10px] bg-neutral-950 pb-24 lg:pb-5">
        presented by <br> <span class="font-semibold">Wayae Nikah</span>
    </div>


    <!-- Navbar mobile -->
    <div class="navbar block lg:hidden fixed bottom-3 ring-1 ring-offset-2 ring-white inset-x-0 w-auto h-auto mx-2 bg-neutral-950 rounded-full shadow-lg z-50"
        id="navbar">
        <div class=" py-3 relative">
            <div class="flex flex-row  justify-center items-center w-full text-orange-200 text-sm gap-3">
                <a class="nav-link  couple flex items-center justify-start text-orange-200 hover:bg-orange-100 hover:text-black px-2 py-1 rounded-full transition duration-200"
                    href="#couple">
                    <i class="fa-regular fa-heart"></i>
                    <span class="ml-2 hidden">couple</span>
                </a>
                <a class="nav-link   date  flex items-center justify-start text-orange-200 hover:bg-orange-100 hover:text-black px-2 py-1 rounded-full transition duration-200"
                    href="#date">
                    <i class="fa-regular fa-calendar"></i>
                    <span class="ml-2 hidden">date</span>
                </a>
                <a class="nav-link  location flex items-center justify-start text-orange-200 hover:bg-orange-100 hover:text-black px-2 py-1 rounded-full transition duration-200"
                    href="#location">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span class="ml-2 hidden">location</span>
                </a>
                @if ($poto)
                    <a class="nav-link  gallery flex items-center justify-start text-orange-200 hover:bg-orange-100 hover:text-black px-2 py-1 rounded-full transition duration-200"
                        href="#gallery">
                        <i class="fa-regular fa-images"></i>
                        <span class="ml-2 hidden">gallery</span>
                    </a>
                @endif
                <a class="nav-link  wishes flex items-center justify-start text-orange-200 hover:bg-orange-100 hover:text-black px-2 py-1 rounded-full transition duration-200"
                    href="#wishes">
                    <i class="fa-regular fa-note-sticky"></i>
                    <span class="ml-2 hidden">wishes</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Navbar -->
</div>
