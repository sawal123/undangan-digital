<div class="w-full lg:w-2/5 h-full relative items-center text-white ml-auto z-10">

    <!-- cover -->
    @include('tema.whitepre.content.pengantin.cover-kanan')
    <!-- End cover -->

    <!-- pembatas -->
    <div class="bg-orange-50 pt-10 section flex justify-center"><img src="{{ asset('tema/whitepre/src/img/pembatas_bunga.png') }} "
            class="max-w-[350px] max-h-[200px]" alt="" data-aos="fade-up" data-aos-easing="ease-out-cubic"
            data-aos-duration="2000">
    </div>

    <!-- Kutipan Al-Qur'an -->
    @include('tema.whitepre.content.pengantin.kutipan-al-quran')


    <!-- pembatas -->
    <div class="bg-orange-50   flex justify-center" id="couple"><img src="{{ asset('tema/whitepre/src/img/pembatas_bunga.png') }}"
            class="max-w-[350px] max-h-[200px]" alt="" data-aos="fade-down" data-aos-easing="ease-out-cubic"
            data-aos-duration="2000"></div>

    <!-- pasangan -->
    @include('tema.whitepre.content.pengantin.pasangan')
    <!-- pasangan -->

    <!-- story -->
    @include('tema.whitepre.content.pengantin.story')
    <!-- story -->

    <!-- Galery -->
    <div id="gallery"></div>
    @include('tema.whitepre.content.pengantin.gallery')
    <!-- end gallery -->


    <!-- Akad -->
    @include('tema.whitepre.content.pengantin.akad')
    <!-- end akad -->

    <!-- resepsi -->
    <div id="location"></div>
    @include('tema.whitepre.content.pengantin.resepsi')
    <!-- resepsi -->

    <!-- turut mengundang -->
    @include('tema.whitepre.content.pengantin.turut-mengundang')

    <!-- turut mengundang -->

    <!-- ucapan -->
    @include('tema.whitepre.content.pengantin.ucapan')
    
    <!-- end ucapan -->

    <div class="text-center text-pink-800 text-[10px] bg-orange-50  pt-6 lg:pt-12
    pb-24 lg:pb-5">
        presented by <br> <span class="font-semibold">Wayae Nikah</span>
    </div>

    <!-- Navbar mobile -->
    @include('tema.whitepre.content.navbar-mobile')
    
    <!-- Navbar -->
</div>
