<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- START Swiper css -->

    <link rel="stylesheet" href="{{ asset('tema/spiderman/src/css/output.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/spiderman/src/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('tema/spiderman/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/spiderman/assets/aos/dist/aos.css') }}">


    <link rel="stylesheet" href="{{ asset('tema/spiderman/assets/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/spiderman/src/css/gallery.css') }}">

    <script src="{{ asset('tema/spiderman/assets/swiper/swiper-bundle.min.js') }}"></script>
</head>

<body class=" bg-red-900 font-quantico">

    <!-- Cover -->
    <div id="cover"
        class="w-full lg:w-[430px] inset-0 absolute text-white z-50 mx-auto bg-red-500 lg:rounded-3xl min-h-screen rounded-3xl"
        style="background-image: url('{{ asset('tema/spiderman/src/img/bg.webp') }}'); background-size: cover; background-position: center;">

        <!-- Top Section -->
        <div>
           <img src="{{ asset('tema/spiderman/src/img/tm.webp') }}" alt="Top Middle">

        </div>

        <div class="w-full absolute top-0 flex">
            <div class="basis-1/2">
                <img src="{{asset('tema/spiderman/src/img/tl.webp')}}" alt="Top Left">
            </div>
            <div class="basis-1/2">
                <img src="{{asset('tema/spiderman/src/img/tr.webp')}}" alt="Top Right">
            </div>
        </div>
        <!-- End Top Section -->

        <div class="w-full flex flex-col items-center justify-center space-y-4">
            <!-- Content -->
            <div class="w-full flex flex-col items-center justify-center space-y-4">
                <div
                    class="text-center text-[40px] font-bold text-white leading-tight pb-7 animate-bounce font-audiowide">
                    <span class="text-[#FFC300]">Happy</span> <br /> Birthday
                </div>
                <div class="text-center font-extrabold text-[20px] space-y-2">
                    <h4 class="text-[20px]">JOIN US TO CELEBRATE</h4>
                    <h1 class="text-[50px] leading-none font-audiowide">DAVA'S</h1>
                    <h4 class="text-[20px]">BIRTHDAY PARTY</h4>
                </div>
                <div class="text-center pt-6 space-y-2">
                    <p class="text-[16px]">with Pleasure</p>
                    <h3 class="text-[20px] font-semibold">Nama Tamu</h3>
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
            <img src="{{asset('tema/spiderman/src/img/bm.webp')}}" alt="Bottom Middle">
        </div>
        <div class="w-full flex absolute bottom-0">
            <div class="basis-1/2">
                <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Bottom Left">
            </div>
            <div class="basis-1/2">
                <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Bottom Right">
            </div>
        </div>
        <!-- End Bottom Section -->
    </div>

    <!-- konten -->
    <div class="">

        <!-- Konten undangan-->
        <div class="w-full lg:w-[430px]  relative flex flex-col text-white overflow-hidden justify-center z-10 mx-auto lg:rounded-3xl"
            style="background-image: url('img/bg.webp'); background-size: cover; background-position: center;">

            <!-- opening -->
            <div class="relative min-h-screen hidden transition-all" id="opening">
                <!-- Top Section -->
                <div>
                    <img src="{{asset('tema/spiderman/src/img/tm.webp')}}" alt="Top Middle" data-aos="fade-down" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>

                <div class="w-full absolute top-0 flex">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tl.webp')}}" alt="Top Left" data-aos="fade-down-right" data-aos-easing="ease-in-sine"
                            data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tr.webp')}}" alt="Top Right" data-aos="fade-down-left" data-aos-easing="ease-in-sine"
                            data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Top Section -->

                <!-- konten opening -->
                <div class="w-full flex flex-col items-center justify-center space-y-4">
                    <div class="text-center text-[40px] font-bold text-white leading-tight pb-7 animate-bounce font-audiowide"
                        data-aos="fade-down" data-aos-duration="2000" data-aos-easing="ease-in-sine">
                        <span class="text-[#FFC300]">Happy</span> <br /> Birthday
                    </div>
                    <div class="text-center font-extrabold text-[20px] space-y-2" data-aos="zoom-in"
                        data-aos-duration="2500" data-aos-easing="ease-in-sine">
                        <h4 class="text-[20px]">JOIN US TO CELEBRATE</h4>
                        <h1 class="text-[50px] leading-none font-audiowide">DAVA'S</h1>
                        <h4 class="text-[20px]">BIRTHDAY PARTY</h4>
                    </div>
                    <div class="text-center pt-6 space-y-2" data-aos="zoom-in" data-aos="zoom-out"
                        data-aos-duration="1500" data-aos-easing="ease-in-sine">
                        <p class="text-[16px]">with Pleasure</p>
                        <h3 class="text-[18px] font-semibold">Nama Tamu</h3>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="absolute bottom-14 w-full">
                    <img src="{{asset('tema/spiderman/src/img/bm.webp')}}" alt="Bottom Middle" data-aos="fade-up" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full flex absolute bottom-14">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Bottom Left" data-aos="fade-up-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Bottom Right" data-aos="fade-up-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Bottom Section -->
            </div>
            <!-- opening -->

            <!-- acara -->
            <div class="relative min-h-screen hidden  " id="acara">
                <!-- Top Section -->
                <div class="z-10">
                    <img src="{{asset('tema/spiderman/src/img/tm.webp')}}" alt="Top Middle" data-aos="fade-down" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500" data-aos-delay="1000">
                </div>
                <div class="w-full absolute top-0 flex z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tl.webp')}}" alt="Top Left" data-aos="fade-down-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tr.webp')}}" alt="Top Right" data-aos="fade-down-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Top Section -->

                <!-- konten acara -->
                <div class="w-full flex flex-col items-center justify-center space-y-4 uppercase z-50">
                    <div class="text-center text-[20px] font-bold text-white leading-none  text-ellipsis inline-block align-top"
                        data-aos="fade-down" data-aos-duration="2000" data-aos-easing="ease-in-sine">
                        Welcome To</div>
                    <div class="text-center text-[40px] font-bold text-white leading-none  text-ellipsis inline-block align-top font-audiowide"
                        data-aos="fade-down" data-aos-duration="2500" data-aos-easing="linear">
                        1ST</div>
                    <div class="text-center text-[18px] font-semibold text-white leading-none  text-ellipsis inline-block align-top"
                        data-aos="fade-down" data-aos-duration="1700" data-aos-easing="linear">
                        KAIVAN SATYA DAVANKA KOLATLENA</div>

                    <div class="flex flex-row justify-center items-center text-[#FFC300] space-x-1"
                        data-aos="fade-down" data-aos-duration="2800" data-aos-easing="ease-in-sine">
                        <div class="text-[50px] font-semibold  leading-none ">6</div>
                        <div class=" text-[20px] font-semibold  leading-none text-start">Sabtu<br>April 2024</div>

                        <!-- Divider -->
                        <div class="h-16 w-[2px] bg-[#FFC300]"></div>

                        <div class=" text-[20px] font-semibold  leading-none text-end">17.00 WIT<br>S.D SELESAI</div>
                    </div>

                    <div class="text-center" data-aos="fade-down" data-aos-duration="2000"
                        data-aos-easing="ease-in-sine">
                        <div class="text-[12px] font-semibold text-white leading-none">lokasi acara</div>
                        <div class="text-[15px] font-semibold text-white leading-none">Passo - kampung baru</div>
                    </div>

                    <div class="text-center pt-1 " data-aos="fade-down" data-aos-duration="2000"
                        data-aos-easing="linear">
                        <a href="#"
                            class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px]"><i
                                class="fa-solid fa-map-location-dot mr-2"></i>lihat lokasi</a>
                    </div>

                    <div class="flex flex-row justify-center items-center text-black font-semibold text-[15px] gap-2 pt-5 z-50"
                        data-aos="fade-up" data-aos-duration="2500" data-aos-easing="ease-in-sine">
                        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center">
                            <p>24</p>
                            <p>Hari</p>
                        </div>
                        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center">
                            <p>24</p>
                            <p>Hari</p>
                        </div>
                        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center">
                            <p>24</p>
                            <p>Hari</p>
                        </div>
                        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center">
                            <p>24</p>
                            <p>Hari</p>
                        </div>
                    </div>

                    <div class="text-center pt-1 z-50" data-aos="fade-up" data-aos-duration="2500"
                        data-aos-easing="linear">
                        <a href="#"
                            class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] "><i
                                class="fa-solid fa-calendar-days mr-2"></i>Simpan Kalender</a>
                    </div>

                </div>

                <!-- Bottom Section -->
                <div class="absolute bottom-14 w-full z-10">
                    <img src="{{asset('tema/spiderman/src/img/bm.webp')}}" alt="Bottom Middle" data-aos="fade-up" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full flex absolute bottom-14 z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Bottom Left" data-aos="fade-up-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Bottom Right" data-aos="fade-up-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Bottom Section -->
            </div>
            <!-- acara -->

            <!-- gallery -->
            <div class="relative min-h-screen hidden  " id="gallery">
                <!-- Top Section -->
                <div class="z-10">
                    <img src="{{asset('tema/spiderman/src/img/tm.webp')}}" alt="Top Middle" data-aos="fade-down" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full absolute top-0 flex z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tl.webp')}}" alt="Top Left" data-aos="fade-down-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tr.webp')}}" alt="Top Right" data-aos="fade-down-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Top Section -->

                <!-- konten gallery -->
                <div
                    class="w-full flex flex-col items-center justify-center space-y-4 uppercase z-50 font-audiowide relative">

                    <div class="text-center pt-10 pb-10">
                        <h3 class="leading-none text-[30px] font-extrabold" data-aos="fade-down"
                            data-aos-duration="2500" data-aos-easing="ease-in-sine">Gallery</h3>
                    </div>

                    <div class="swiper mySwiper  ">
                        <div class="swiper-wrapper ">
                            <div class="swiper-slide">
                                <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Thumbnail" onclick="openModalImg(this)"
                                    class="object-cover object-center w-full h-full shadow-md cursor-pointer ">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{asset('tema/spiderman/src/img/bayi.webp')}}" alt="Thumbnail" onclick="openModalImg(this)"
                                    class="object-cover object-center w-full h-full shadow-md cursor-pointer">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Thumbnail" onclick="openModalImg(this)"
                                    class="object-cover object-center w-full h-full shadow-md cursor-pointer">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Bottom Section -->
                <div class="absolute bottom-14 w-full z-10">
                    <img src="{{asset('tema/spiderman/src/img/bm.webp')}}" alt="Bottom Middle" data-aos="fade-up" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full flex absolute bottom-14 z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Bottom Left" data-aos="fade-up-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Bottom Right" data-aos="fade-up-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Bottom Section -->
            </div>
            <!-- gallery -->

            <!-- RSVP -->
            <div class="relative min-h-screen hidden  " id="rspv">
                <!-- Top Section -->
                <div class="z-10">
                    <img src="{{asset('tema/spiderman/src/img/tm.webp')}}" alt="Top Middle" data-aos="fade-down" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full absolute top-0 flex z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tl.webp')}}" alt="Top Left" data-aos="fade-down-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tr.webp')}}" alt="Top Right" data-aos="fade-down-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Top Section -->

                <!-- konten RSVP -->
                <div class="w-full flex flex-col items-center justify-center space-y-4 uppercase z-50">

                    <div class="w-full flex justify-center items-center" data-aos="fade-down"
                        data-aos-duration="2500" data-aos-easing="ease-in-sine">
                        <img src="{{asset('tema/spiderman/src/img/bayi.webp')}}" alt="bayi"
                            class="max-w-[200px] max-h-[200px] object-cover object-center rounded-full aspect-square animate-bounce ease-in-out duration-300 border-4 border-red-500">
                    </div>

                    <div class="text-center" data-aos="fade-up" data-aos-duration="2000"
                        data-aos-easing="ease-in-sine">
                        <h3 class="leading-none text-[30px] font-extrabold">Kirim Ucapan dan <br>Konfirmasi
                            <br>Kehadiran</h3>
                    </div>

                    <button type="button" onclick="toggleModalRspv()" data-aos="fade-up" data-aos-duration="2500"
                        data-aos-easing="ease-in-sine"
                        class=" font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] rounded-full"></i>Kirim
                        Ucapan dan Kehadiran</a>

                </div>

                <!-- Bottom Section -->
                <div class="absolute bottom-14 w-full z-10">
                    <img src="{{asset('tema/spiderman/src/img/bm.webp')}}" alt="Bottom Middle" data-aos="fade-up" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full flex absolute bottom-14 z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Bottom Left" data-aos="fade-up-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Bottom Right" data-aos="fade-up-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Bottom Section -->
            </div>
            <!-- RSVP -->

            <!--gift -->
            <div class="relative min-h-screen hidden " id="gift">
                <!-- Top Section -->
                <div class="z-10">
                    <img src="{{asset('tema/spiderman/src/img/tm.webp')}}" alt="Top Middle" data-aos="fade-down" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full absolute top-0 flex z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tl.webp')}}" alt="Top Left" data-aos="fade-down-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tr.webp')}}" alt="Top Right" data-aos="fade-down-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Top Section -->

                <!-- konten gallery -->
                <div class="w-full flex flex-col items-center justify-center  uppercase z-50">

                    <div class="text-center pt-12" data-aos="fade-down" data-aos-duration="2500"
                        data-aos-easing="ease-in-sine">
                        <h3 class="leading-none text-[30px] font-extrabold pb-10 font-audiowide">Tanda Kasih</h3>
                        <p class="text-[12px] mx-6">Terima kasih telah menambah semangat <br> kegembiraan ulang tahun
                            anak kami
                            dengan <br> kehadiran dan hadiah indah Anda</p>
                    </div>

                    <div class="flex flex-row justify-center items-center pt-4 gap-12" data-aos="fade-up"
                        data-aos-duration="2000" data-aos-easing="ease-in-sine">
                        <button
                            class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] cashless-btn"
                            onclick="toggleSection('cashless')">
                            <i class="fa-solid fa-map-location-dot mr-2"></i>Cashless
                        </button>
                        <button
                            class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] kado-btn"
                            onclick="toggleSection('kirimKado')">
                            <i class="fa-solid fa-map-location-dot mr-2"></i>Kirim Kado
                        </button>
                    </div>

                    <!-- cashless -->
                    <div class="flex flex-col  justify-center items-center pt-5 z-50 hidden" id="cashless"
                        data-aos="fade-up" data-aos-duration="2500" data-aos-easing="ease-in-sine">
                        <!-- card 1 -->
                        <div class="flex flex-row gap-2 items-center">
                            <div class="px-2 py-1 w-[80px] h-[58px] bg-white rounded-lg flex items-center">
                                <img src="img/dana.png" alt="pembayaran"
                                    class="w-full h-full object-center object-contain">
                            </div>
                            <div class="flex flex-col justify-center items-start text-white text-start">
                                <p class="font-extrabold text-[20px]">123456777</p>
                                <button
                                    class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px]">
                                    Salin Rekening
                                </button>
                                <p class="font-extrabold text-[15px]">nama rekening</p>
                            </div>
                        </div>
                    </div>

                    <!-- kirim kado -->
                    <div class="flex flex-col justify-center items-center pt-5 z-50 hidden" id="kirimKado"
                        data-aos="zoom-in" data-aos-duration="2500" data-aos-easing="ease-in-sine">
                        <div class="flex flex-col justify-center items-center text-white">
                            <p class="font-extrabold text-[20px] text-[#FFC300]">Kirim Kado</p>
                            <p class="font-extrabold text-[15px] text-center">
                                Anda dapat mengirim kado ke: <br>
                                Jl Wildan Sari No 11 Banjarmasin Barat 703222
                            </p>
                        </div>
                    </div>



                </div>

                <!-- Bottom Section -->
                <div class="absolute bottom-14 w-full z-10">
                    <img src="{{asset('tema/spiderman/src/img/bm.webp')}}" alt="Bottom Middle" data-aos="fade-up" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full flex absolute bottom-14 z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Bottom Left" data-aos="fade-up-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Bottom Right" data-aos="fade-up-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Bottom Section -->
            </div>
            <!-- gift -->

            <!-- Thanks -->
            <div class="relative min-h-screen hidden  " id="thanks">
                <!-- Top Section -->
                <div class="z-10">
                    <img src="{{asset('tema/spiderman/src/img/tm.webp')}}" alt="Top Middle" data-aos="fade-down" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full absolute top-0 flex z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tl.webp')}}" alt="Top Left" data-aos="fade-down-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/tr.webp')}}" alt="Top Right" data-aos="fade-down-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Top Section -->

                <!-- konten thanks -->
                <div class="w-full flex flex-col items-center justify-center space-y-4 uppercase " data-aos="zoom-in"
                    data-aos-duration="2500" data-aos-easing="ease-in-sine">


                    <div class="text-center pt-32">
                        <h3 class="leading-none text-[40px] font-extrabold uppercase ">Thank you for <br>Your Atention
                            <br>Hope To
                            See You <br>At The Event</h3>
                    </div>


                </div>

                <!-- Bottom Section -->
                <div class="absolute bottom-14 w-full z-10">
                    <img src="{{asset('tema/spiderman/src/img/bm.webp')}}" alt="Bottom Middle" data-aos="fade-up" data-aos-easing="ease-in-sine"
                        data-aos-duration="1500">
                </div>
                <div class="w-full flex absolute bottom-14 z-10">
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/bl.webp')}}" alt="Bottom Left" data-aos="fade-up-right"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                    <div class="basis-1/2">
                        <img src="{{asset('tema/spiderman/src/img/br.webp')}}" alt="Bottom Right" data-aos="fade-up-left"
                            data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    </div>
                </div>
                <!-- End Bottom Section -->
            </div>
            <!-- Thanks -->

            <!-- Navbar Mobile -->
            <div class="navbar absolute bottom-3 w-full z-10" id="navbar">
                <div
                    class="py-3 relative flex justify-center ring-1 ring-offset-2 ring-white text-white w-full h-auto bg-blue-700 shadow-lg">
                    <div class="flex flex-row justify-center items-center w-full text-sm gap-3 text-white">
                        <button
                            class="nav-link opening flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
                            onclick="showSection('opening', this)">
                            <i class="fa-solid fa-house"></i>
                            <span class="ml-2 hidden">Opening</span>
                        </button>
                        <button
                            class="nav-link acara flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
                            onclick="showSection('acara', this)">
                            <i class="fa-solid fa-calendar"></i>
                            <span class="ml-2 hidden">Acara</span>
                        </button>
                        <button
                            class="nav-link gallery flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
                            onclick="showSection('gallery', this)">
                            <i class="fa-solid fa-images"></i>
                            <span class="ml-2 hidden">Gallery</span>
                        </button>
                        <button
                            class="nav-link rspv flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
                            onclick="showSection('rspv', this)">
                            <i class="fa-solid fa-comment"></i>
                            <span class="ml-2 hidden">Rspv</span>
                        </button>
                        <button
                            class="nav-link gift flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
                            onclick="showSection('gift', this)">
                            <i class="fa-solid fa-gift"></i>
                            <span class="ml-2 hidden">Gift</span>
                        </button>
                        <button
                            class="nav-link thanks flex items-center hover:bg-red-700 p-2 rounded-lg transition duration-200"
                            onclick="showSection('thanks', this)">
                            <i class="fa-solid fa-square-check"></i>
                            <span class="ml-2 hidden">Thanks</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- End Navbar Mobile -->

            <!-- button kanan -->
            <div class="absolute right-5 bottom-28 flex flex-col space-y-3 z-50">
                <button class="bg-green-500 hover:opacity-50 text-white font-bold p-2 w-10 rounded-full aspect-square">
                    <i class="fa-brands fa-whatsapp"></i>
                </button>
                <button class="bg-[#FFC300] hover:opacity-50 text-black font-bold p-2 w-10 rounded-full aspect-square"
                    onclick="toggleModalQr()" type="button">
                    <i class="fa-solid fa-qrcode"></i></button>
                <button class="bg-[#FFC300] hover:opacity-50 text-black font-bold p-2 w-10 rounded-full aspect-square"
                    id="audio-toggle" type="button">
                    <i class="fa-solid fa-play"></i>
                </button>
            </div>
        </div>
        <!-- Konten undangan-->


        <!-- music -->
        <div id="youtube-player" class="hidden invisible z-10 absolute inset-0">
            <iframe id="videoFrame" width="240" height="240"
                src="https://www.youtube.com/embed/sy0LqD9EA7A?si=59Ql_kVZl3TaSU3m&amp?enablejsapi=1"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
            </iframe>
        </div>

        <!-- Modal Image -->
        <div id="imageModal"
            class="fixed hidden inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center transition-all duration-300 ease-in-out">
            <div class="relative">
                <img id="modalImageContent" class="max-w-full max-h-screen rounded-lg shadow-xl py-11" src=""
                    alt="Modal Image" />
                <button onclick="closeModalImg()"
                    class="absolute top-2 right-2 text-white bg-sky-500 hover:bg-slate-600 rounded-lg py-1 px-3 focus:outline-none">
                    ✕
                </button>
            </div>
        </div>

        <!-- Modal gift-->
        <div id="infoModal"
            class="invisible fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 font-poppins">
            <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">
                <ul class="text-left text-gray-700 mb-6 flex flex-col items-center text-sm">
                    <li class="mb-2 text-center"><img src="img/qr.png" alt="" class="w-32"></li>
                    <li class="mb-2 "><strong>Nama</strong></li>
                </ul>
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
                    onclick="toggleModalQr()">Tutup</button>
            </div>
        </div>

        <!-- modal ucapan kehadiran -->
        <div id="ModalRspv"
            class="invisible fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 font-poppins overflow-auto ">
            <div class=" max-w-xl w-full text-center my-3 py-4 relative">
                <div class="absolute w-full h-full inset-0 bg-white z-10 brightness-75 rounded-2xl shadow-xl"></div>
                <ul class="text-left  flex flex-col items-center text-sm text-black py-2 z-50">
                    <!-- ucapan -->
                    <li class="w-full  relative z-50 ">
                        <h2 class="text-center text-[30px] font-semibold pb-5 font-audiowide">Ucapan & Doa</h2>

                        <div
                            class="p-6 h-[250px] rounded-lg shadow-lg space-y-2 overflow-y-auto z-50 relative font-poppins">
                            <!-- AT -->
                            <div class=" p-4 rounded-md   h-auto  shadow-md shadow-slate-200 bg-[#FFC300]">
                                <h3 class="text-[12px] font-semibold">AT (Andy Tengil)</h3>
                                <p class="text-[10px] ">Thursday, 06 03 2025</p>
                                <p class="mt-2 text-[10px] italic">"Mantap antap"</p>
                            </div>

                            <!-- AT -->
                            <div class=" p-4 rounded-md   h-auto  shadow-md shadow-slate-200 bg-[#FFC300]">
                                <h3 class="text-[12px] font-semibold">AT (Andy Tengil)</h3>
                                <p class="text-[10px] ">Thursday, 06 03 2025</p>
                                <p class="mt-2 text-[10px] italic">"Mantap antap"</p>
                            </div>

                            <!-- AT -->
                            <div class=" p-4 rounded-md   h-auto  shadow-md shadow-slate-200 bg-[#FFC300]">
                                <h3 class="text-[12px] font-semibold">AT (Andy Tengil)</h3>
                                <p class="text-[10px] ">Thursday, 06 03 2025</p>
                                <p class="mt-2 text-[10px] italic">"Mantap antap"</p>
                            </div>
                        </div>
                    </li>

                    <li class="w-full    p-6 relative  section">
                        <h4 class="text-xl font-semibold mb-4 relative z-50 font-audiowide">Kirim Ucapan</h4>

                        <form action="" class="space-y-4 relative z-50">
                            <!-- Input Nama -->
                            <input type="text" name="nama" placeholder="Nama Lengkap"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black placeholder-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800" />

                            <!-- Textarea Ucapan -->
                            <textarea name="pesan" placeholder="Ucapan & Doa" rows="4"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black placeholder-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800"></textarea>

                            <!-- Select Konfirmasi Kehadiran -->
                            <select name="konfirmasi"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black focus:outline-none focus:ring-2 focus:ring-slate-800">
                                <option value="">Konfirmasi Kehadiran</option>
                                <option value="datang">Datang Dong</option>
                                <option value="tidak_datang">Tidak Bisa Datang Nih</option>
                                <option value="diusahakan">Diusahakan Datang Ya</option>
                            </select>

                            <!-- Button Kirim -->
                            <button type="submit"
                                class="w-full z-50 rounded-full bg-[#FFC300] text-black font-semibold p-3 hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-slate-800">
                                Kirim Sekarang
                            </button>
                        </form>
                    </li>
                    <!-- ucapan -->

                    <button
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 z-50"
                        onclick="toggleModalRspv()">Tutup</button>
                </ul>

            </div>
        </div>

    </div>
    <!-- konten -->

    <!-- Swiper -->


    <!-- Swiper -->

    <script src="{{ asset('tema/spiderman/src/js/swiper.js') }}"></script>

    <!-- aos -->

    <script src="{{ asset('tema/spiderman/assets/aos/dist/aos.js') }}"></script>

    <script>
        AOS.init();
    </script>


    <!-- nav -->
    <script src="{{ asset('tema/spiderman/src/js/nav.js') }}"></script>
    <!-- modal -->
    <script src="{{ asset('tema/spiderman/src/js/modal.js') }}"></script>
    <!-- audio -->
    <script src="{{ asset('tema/spiderman/src/js/audio.js') }}"></script>
    {{-- <script src="{{ asset('tema/spiderman/src/js/setDate.js') }}"></script> --}}


</body>

</html>
