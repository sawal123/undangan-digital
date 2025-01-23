<!doctype html>
<html class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--  -->
  <link href="{{ asset('tema/darksweet/css/output.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/fontawesome-free/css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.css') }}">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/assets/aos/dist/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('tema/darksweet/css/style.css') }}">


</head>

<body class="bg-neutral-300 text-slate-900 relative">

  <!-- Cover Section -->
  <div id="cover" class="z-50 bg-white flex inset-0 justify-center items-center min-w-screen min-h-screen fixed ">
    <!-- Background Image -->
    <img src="{{ asset('tema/darksweet/img/illustration.jpg') }}" class="absolute w-full md:w-1/3 h-full object-cover object-center z-0" alt="" />
    <div class="absolute inset-0 bg-black opacity-75 mx-auto w-full md:w-1/3"></div>
    <!-- Content Container -->
    <div class="relative z-10 w-full sm:w-1/3 flex flex-col justify-center items-center space-y-8 text-center">
      <!-- Title Section -->
      <div class="text-white font-italiana">
        <p class="text-sm uppercase tracking-wide font-semibold">Happy Wedding</p>
        <h1 class="text-3xl font-bold">Justin & Sisca</h1>
      </div>

      <!-- Image Section -->
      <div class="p-2 bg-white shadow-md rounded-lg">
        <img src="{{ asset('tema/darksweet/img/illustration.jpg') }}" class="w-[175px] h-[300px] object-cover rounded-lg"
          alt="Wedding Illustration" />
      </div>

      <!-- Invitation Section -->
      <div class="p-4 text-center text-white ">
        <p class="text-sm">Kepada</p>
        <h2 class="text-lg font-bold font-italiana">Bapa Budik</h2>
        <p class="text-sm mt-2 font-reemkufi">Tanpa Mengurangi Rasa Hormat, Kami Mengundang Bapak/Ibu/Saudara/i untuk
          Hadir di
          Acara Kami.</p>
      </div>
      <button type="button" id="openCover"
        class="w-[150px] py-2 px-4 bg-gradient-to-r from-black to-gray-500 text-white rounded-lg shadow-md hover:from-slate-800 hover:to-gray-600 hover:shadow-lg font-semibold text-xs ring-1 ring-white ">
        <i class="fa-regular fa-paper-plane mr-1"></i>Buka Sampul
      </button>
    </div>
  </div>
  <!-- End of Cover Section -->

  <!-- content -->
  <div id="content" class="relative">
    <!-- Jumbotron -->
    <section class="relative z-10 flex justify-center mx-auto inset-0">
      <div class="container px-0 fixed mx-auto w-full md:w-2/4 lg:w-1/3 h-screen justify-center items-center">
        <!-- Background Image -->
        <!-- Swiper -->
        <div class="absolute inset-0 swiper mySwiper h-full w-full">
          <div class="swiper-wrapper w-full h-full">
            <div class="swiper-slide bg-local bg-cover bg-center object-contain brightness-50 contrast-100"
              style="background-image: url('{{ asset('tema/darksweet/img/pasangan.jpg') }}');"></div>
            <div
              class="swiper-slide bg-local bg-cover bg-origin-content bg-center object-cover brightness-50 contrast-100 "
              style="background-image: url('{{ asset('tema/darksweet/img/wedding.jpg') }}');"></div>
            <div class="swiper-slide bg-local bg-cover bg-center object-cover brightness-50 contrast-100 "
              style="background-image: url('{{ asset('tema/darksweet/img/wedding-potret.jpg') }}');"></div>
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
                    class="aspect-square object-cover w-[175px] h-[175px] md:w-[150px] md:h-[150px]" lazy="load" />
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
                The Wedding of Justins & Sisca
              </h2>
            </div>
          </div>

          <!-- Bottom Title -->
          <div class="">
            <h1 class="text-white text-3xl font-bold text-center font-italiana" data-aos="zoom-in-up"
              data-aos-duration="3000">Justin
              dan Siska</h1>
          </div>
        </div>

      </div>
    </section>
    <!-- Jumbotron -->

    <div class="container relative px-0 mx-auto w-full min-h-screen invisible z-0" id="home"></div>

    <!-- Content -->
    <section class="z-10 relative w-full md:w-2/4 lg:w-1/3 flex flex-col justify-center  mx-auto ">
      <!--  -->

      <!--  -->
      <div class="container relative px-0 mx-auto flex flex-row w-full z-20 bg-transparent ">
        <div class=" border-white left-0 bg-transparent w-full h-0 border-b-[30px] border-l-[10px] border-r-[30px]
    border-r-transparent rounded-none">
        </div>
        <div
          class=" border-white left-0 bg-transparent w-full h-0 border-b-[30px] border-l-[30px] border-r-[10px] border-l-transparent rounded-none ">
        </div>
      </div>

      <div class="container relative z-30 px-0 mx-auto w-full bg-white pt-10">
        <div class="w-full h-full ">
          <div class="flex items-center min-w-[240px] px-3">
            <p class="text-center text-[12px] leading-[20px]" data-aos="fade-up" data-aos-duration="3000">Atas Rahmat
              Tuhan Yang Maha Esa, kami bermaksud mengundang
              Anda di acara Kami. Merupakan suatu kehormatan dan kebahagiaan bagi kami sekeluarga, apabila
              Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu pada
            </p>
          </div>

          <!-- Card 1 -->
          <div class="mx-auto bg-white overflow-hidden my-3 px-3 font-italiana">
            <div class="relative" data-aos="zoom-in-up" data-aos-duration="3000">
              <img src="{{ asset('tema/darksweet/img/wedding.jpg') }}" alt="Foto Justin"
                class="w-full h-64 object-cover object-center grayscale saturate-150	contrast-100 brightness-50" />
              <a href="" class="absolute top-4 left-6 text-white hover:text-blue-500">
                <i class="fab fa-instagram text-2xl"></i>
              </a>
              <div class="absolute bottom-4 left-4 text-white text-lg font-bold px-2 py-1 " data-aos="fade-up"
                data-aos-duration="3000">
                Justin
              </div>
            </div>

            <div class="p-4" data-aos="fade-up" data-aos-duration="3000">
              <h2 class="text-xl font-semibold text-gray-800">Tobias Justin</h2>
              <p class="mt-2 text-gray-600">Putra dari Pasangan</p>
              <p class="text-gray-600">Ayah Justin &</p>
              <p class="text-gray-600">Ibu Justin</p>
              <p class="mt-2 text-gray-600">Beralamat di Jakarta</p>
            </div>
          </div>
          <!-- Card 1 -->

          <!-- Card 2 -->
          <div class="mx-auto bg-white overflow-hidden my-3 px-3 font-italiana">
            <div class=" relative" data-aos="zoom-in-up" data-aos-duration="3000">
              <img src="{{ asset('tema/darksweet/img/wedding.jpg') }}" alt="Foto Siska"
                class="w-full h-64 object-cover object-center grayscale saturate-150	contrast-100 brightness-50" />
              <a href="" class="absolute top-4 right-6 text-white hover:text-blue-500">
                <i class="fab fa-instagram text-2xl"></i>
              </a>
              <div class="absolute bottom-4 right-4 text-white text-lg font-bold px-2 py-1 " data-aos="fade-up"
                data-aos-duration="3000">
                Siska Kohl
              </div>
            </div>

            <div class="p-4 text-end" data-aos="fade-up" data-aos-duration="3000">
              <h2 class="text-xl font-semibold text-gray-800">Siska Kohl</h2>
              <p class="mt-2 text-gray-600">Putra dari Pasangan</p>
              <p class="text-gray-600">Ayah Siska &</p>
              <p class="text-gray-600">Ibu Siska</p>
              <p class="mt-2 text-gray-600">Beralamat di Jakarta</p>
            </div>
          </div>
          <!-- Card 2 -->

          <!-- Date pick -->
          <div class="bg-white flex items-center justify-center h-[800px] mx-0 px-0 mt-12 ">
            <div class=" bg-fixed bg-cover bg-center bg-no-repeat h-full w-full "
              style="background-image: url('{{ asset('tema/darksweet/img/pasangan.jpg') }}');">

              <div
                class="relative bg-transparent  overflow-hidden w-full h-full flex flex-row items-start justify-center">
                <div class="absolute bg-black bg-opacity-80 inset-0 w-full h-full z-0 pointer-events-none "></div>

                <div class="basis-10/12 p-6 space-y-12  text-white flex flex-col justify-center z-10 font-reemkufi">
                  <h1 class="text-2xl font-bold" data-aos="fade-up" data-aos-duration="3000">Menghitung Hari</h1>
                  <p class="text-[14px]" data-aos="fade-up" data-aos-duration="3000">
                    وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُمْ مِنْ أَنْفُسِكُمْ أَزْوَاجًا لِتَسْكُنُوا إِلَيْهَا
                    وَجَعَلَ بَيْنَكُمْ مَوَدَّةً وَرَحْمَةً إِنَّ فِي ذَٰلِكَ لَآيَاتٍ لِقَوْمٍ يَتَفَكَّرُونَ
                  </p>
                  <div class="space-y-4">
                    <p class="text-[12px]" data-aos="fade-up" data-aos-duration="3000">
                      Di antara tanda-tanda (kebesaran)-Nya ialah bahwa Dia menciptakan pasangan-pasangan untukmu dari
                      (jenis)
                      dirimu sendiri agar kamu merasa tenteram kepadanya. Dia menjadikan di antaramu rasa cinta dan
                      kasih
                      sayang.
                    </p>
                    <p class="text-[12px]" data-aos="fade-up" data-aos-duration="3000">
                      Sesungguhnya pada yang demikian itu benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum
                      yang
                      berpikir.
                    </p>
                  </div>
                  <div class="mt-4">
                    <button
                      class="bg-white hover:bg-gray-600 text-slate-800  hover:text-white font-semibold py-2 px-4 rounded-lg"
                      data-aos="fade-up" data-aos-duration="3000">
                      Save To Calendar
                    </button>
                  </div>
                  <p class=" mt-4 text-sm" data-aos="fade-up" data-aos-duration="3000">- Ar-Rum • Ayat 21 -</p>
                </div>

                <div
                  class="basis-2/12 right-0 top-0 bg-gray-900  text-white text-center pt-7 pb-20 z-20 font-montserrat">
                  <div class="flex flex-col items-center gap-24 opacity-100" data-aos="fade-up"
                    data-aos-duration="3000">
                    <div class="flex flex-col items-center transform -rotate-90">
                      <h2 class="text-3xl font-bold " id="seconds">5</h2>
                      <span class="text-sm font-semibold uppercase ml-2">Seconds</span>
                    </div>
                    <div class="flex flex-col items-center transform -rotate-90 ">
                      <h2 class="text-3xl font-bold " id="minutes">50</h2>
                      <span class="text-sm font-semibold uppercase ml-2 ">Minutes</span>
                    </div>
                    <div class="flex flex-col items-center transform -rotate-90">
                      <h2 class="text-3xl font-bold " id="hours">21</h2>
                      <span class="text-sm font-semibold uppercase ml-2">Hours</span>
                    </div>
                    <div class="flex flex-col items-center transform -rotate-90">
                      <h2 class="text-3xl font-extrabold " id="days">106</h2>
                      <span class="text-sm font-semibold uppercase ml-2">Days</span>
                    </div>
                  </div>
                </div>

                <div
                  class="bottom-0 right-0 absolute bg-transparent w-0 h-0 border-b-[260px] border-l-[560px] border-l-transparent rounded-none z-20">
                </div>

                <div class="w-40 h-[218px] bottom-9 overflow-hidden bg-white mx-auto absolute z-30" data-aos="fade-up"
                  data-aos-duration="3000">
                  <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}" class="aspect-[2/3] object-cover object-center  w-full h-full"
                    alt="">
                </div>
                <div class="flex flex-row justify-center w-full bg-transparent absolute bottom-0 z-20 ">
                  <div
                    class="bottom-0 border-white left-0 bg-transparent w-full h-0 border-b-[25px] border-l-[5px] border-r-[25px] border-r-transparent rounded-none">
                  </div>
                  <div
                    class="bottom-0 border-white left-0 bg-transparent w-full h-0 border-b-[25px] border-l-[25px] border-r-[5px] border-l-transparent rounded-none ">
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- Date pick -->

          <!-- Save Date Acara -->
          <div class="w-full mt-5 flex flex-col justify-center items-center px-3 ">
            <h1 class="text-3xl font-bold font-italiana">Save The Date Acara</h1>

            <!-- CARD 1 -->
            <div class="relative w-full h-[300px] bg-white mt-4 font-reemkufi">
              <div
                class=" bg-center bg-fixed rounded-xl bg-origin-content overflow-hidden shadow-lg h-full w-full bg-cover "
                style="background-image: url('{{ asset('tema/darksweet/img/download (4).jpeg') }}');">
                <!-- Overlay Transparan -->
                <div class="bg-black bg-opacity-50 w-full h-full absolute rounded-xl inset-0"></div>

                <!-- Konten Kartu -->
                <div class="relative w-full h-full py-6 rounded-lg shadow-lg">
                  <!-- Judul -->
                  <h2 class="text-2xl pl-4 font-semibold text-start text-white" data-aos="fade-up"
                    data-aos-duration="3000">Resepsi Pernikahan</h2>
                  <!-- Tanggal dan Informasi -->
                  <div
                    class="flex items-center w-4/5 mt-6 bg-gradient-to-r from-white to-transparent h-[92px] gap-4 pl-4">
                    <div class="text-6xl font-bold items-center flex h-full text-center border-r border-black pr-4"
                      data-aos="fade-up" data-aos-duration="3000">04
                    </div>
                    <div class="text-left font-semibold">
                      <p class="" data-aos="fade-up" data-aos-duration="3000">Anggara</p>
                      <p class="" data-aos="fade-up" data-aos-duration="3000">Maret 2025</p>
                    </div>
                  </div>


                  <!-- Detail Acara -->
                  <div class="mt-4 pl-4 text-white p-4 rounded-lg flex justify-around">
                    <p class="text-[12px] font-semibold " data-aos="fade-up" data-aos-duration="3000">Jam Bebas</p>
                    <p class="text-[12px] whitespace-nowrap" data-aos="fade-up" data-aos-duration="3000"><i
                        class="fa-solid fa-location-dot mr-2"></i>Rumah Justin di
                      Jakarta</p>
                  </div>

                  <!-- Tombol -->
                  <div class="mt-4 flex justify-center  bg-white w-full absolute bottom-0 p-3">
                    <a href=""
                      class="text-sm font-bold  text-center underline hover:text-blue-800 w-full font-montserrat"
                      data-aos="fade-up" data-aos-duration="3000"><i class="fa-solid fa-location-dot mr-2"></i>Map
                      Lokasi
                      Acara</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- CARD 1 -->

            <!-- CARD 2 -->
            <div class="relative w-full h-[300px] bg-white mt-4 font-reemkufi">
              <div class="bg-cover bg-center bg-fixed rounded-xl overflow-hidden shadow-lg h-full w-full"
                style="background-image: url('{{ asset('tema/darksweet/img/wedding.jpg') }}'); background-size: cover; background-position: center;">

                <!-- Overlay Transparan -->
                <div class="bg-black bg-opacity-50 w-full h-full absolute rounded-xl inset-0"></div>

                <!-- Konten Kartu -->
                <div class="relative w-full h-full py-6 rounded-lg shadow-lg">
                  <!-- Judul -->
                  <h2 class="text-2xl pl-4 font-semibold text-start text-white" data-aos="fade-up"
                    data-aos-duration="3000">Akad Pernikahan</h2>
                  <!-- Tanggal dan Informasi -->
                  <div
                    class="flex items-center w-4/5 mt-6 bg-gradient-to-r from-white to-transparent h-[92px] gap-4 pl-4">
                    <div class="text-6xl font-bold items-center flex text-center border-r border-black pr-4 h-full"
                      data-aos="fade-up" data-aos-duration="3000">20
                    </div>
                    <div class="text-left font-semibold">
                      <p class="" data-aos="fade-up" data-aos-duration="3000">Sabtu</p>
                      <p class="" data-aos="fade-up" data-aos-duration="3000">Maret 2025</p>
                    </div>
                  </div>


                  <!-- Detail Acara -->
                  <div class="mt-4 pl-4 text-white p-4 rounded-lg flex justify-around">
                    <p class="text-[12px] font-semibold " data-aos="fade-up" data-aos-duration="3000">Pukul 02:39 WIB -
                      08:00 WIB
                    </p>
                    <p class="text-[12px] whitespace-nowrap" data-aos="fade-up" data-aos-duration="3000"><i
                        class=" fa-solid fa-location-dot mr-2"></i>Jalan gunung
                      batur, no 78, Denpasar, Bali
                    </p>
                  </div>

                  <!-- Tombol -->
                  <div class="mt-4 flex justify-center  bg-white w-full absolute bottom-0 p-3">
                    <a href="" class="text-sm font-bold  text-center underline hover:text-blue-800 w-full"
                      data-aos="fade-up" data-aos-duration="3000"><i class="fa-solid fa-location-dot mr-2"></i>Map
                      Lokasi
                      Acara</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- CARD 2 -->

            <!-- CARD 3 -->
            <div class="relative w-full h-[300px] bg-white mt-4 font-reemkufi">
              <div
                class="bg-cover bg-right bg-fixed rounded-xl bg-origin-content overflow-hidden shadow-lg h-full w-full"
                style="background-image: url('{{ asset('tema/darksweet/img/smiley-newlyweds-posing-together-outdoors.jpg') }}');">
                <!-- Overlay Transparan -->
                <div class="bg-black bg-opacity-50 w-full h-full absolute rounded-xl inset-0"></div>

                <!-- Konten Kartu -->
                <div class="relative w-full h-full py-6 rounded-lg shadow-lg">
                  <!-- Judul -->
                  <h2 class="text-2xl pl-4 font-semibold text-start text-white" data-aos="fade-up"
                    data-aos-duration="3000">Makan Malam</h2>
                  <!-- Tanggal dan Informasi -->
                  <div
                    class="flex items-center w-4/5 mt-6 bg-gradient-to-r from-white to-transparent h-[92px] gap-4 pl-4">
                    <div class="text-6xl font-bold text-center items-center flex border-r border-black pr-4 h-full"
                      data-aos="fade-up" data-aos-duration="3000">15
                    </div>
                    <div class="text-left font-semibold">
                      <p class="" data-aos="fade-up" data-aos-duration="3000">Kamis</p>
                      <p class="" data-aos="fade-up" data-aos-duration="3000">Maret 2025</p>
                    </div>
                  </div>


                  <!-- Detail Acara -->
                  <div class="mt-4 pl-4 text-white p-4 rounded-lg flex justify-around">
                    <p class="text-[12px] font-semibold " data-aos="fade-up" data-aos-duration="3000">Pukul 02:39 WIB -
                      08:00 WIB
                    </p>
                    <p class="text-[12px] whitespace-nowrap" data-aos="fade-up" data-aos-duration="3000"><i
                        class=" fa-solid fa-location-dot mr-2"></i>Jalan gunung
                      batur, no 78, Denpasar, Bali
                    </p>
                  </div>

                  <!-- Tombol -->
                  <div class="mt-4 flex justify-center  bg-white w-full absolute bottom-0 p-3">
                    <a href="" class="text-sm font-bold  text-center underline hover:text-blue-800 w-full"
                      data-aos="fade-up" data-aos-duration="3000"><i class="fa-solid fa-location-dot mr-2"></i>Map
                      Lokasi
                      Acara</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- CARD 3 -->
          </div>
          <!-- Save Date Acara -->

          <!-- Susunan Acara -->
          <div class="w-full mt-5 flex flex-col justify-center items-center relative overflow-hidden">
            <h1 class="text-3xl font-bold font-italiana">Susunan Acara</h1>

            <div class="w-full h-[660px] flex flex-row justify-center mt-4 px-0 relative" data-aos="fade-up"
              data-aos-duration="3000">
              <!-- Kolom Kiri -->
              <div class="w-1/2 flex flex-col border-r-2 border-black">
                <!-- Persiapan dan Kedatangan Tamu -->
                <div class="basis-1/4 w-full flex flex-col space-y-2 justify-center text-end px-3" data-aos="fade-right"
                  data-aos-duration="3000">
                  <h3 class="font-semibold text-[16px]">Persiapan dan Kedatangan Tamu</h3>
                  <div class="border border-dashed border-black"></div>
                  <p class="text-[12px]">Pengantin dan keluarga bersiap-siap</p>
                </div>

                <!-- Waktu 10 WIB -->
                <div class="basis-1/4 w-full flex flex-col space-y-2 justify-center items-center text-end px-3"
                  data-aos="fade-right" data-aos-duration="3000">
                  <h3 class="font-semibold text-[20px]">10 WIB</h3>
                </div>

                <!-- Resepsi Pernikahan -->
                <div class="basis-1/4 w-full flex flex-col space-y-2 justify-center text-end px-3" data-aos="fade-right"
                  data-aos-duration="3000">
                  <h3 class="font-semibold text-[16px]">Resepsi Pernikahan</h3>
                  <div class="border border-dashed border-black"></div>
                  <p class="text-[12px]">Sambutan dari keluarga kedua mempelai, Hiburan (musik, tarian tradisional, atau
                    penampilan lainnya)</p>
                </div>

                <!-- Penutupan -->
                <div class="basis-1/4 w-full flex flex-row gap-2 items-center space-y-2 justify-center text-end px-3"
                  data-aos="fade-right" data-aos-duration="3000">
                  <p class="text-[12px]">14.00 WIB Sampai Acara Selesai</p>
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white" viewBox="0 0 640 512">
                      <path
                        d="M155.6 17.3C163 3 179.9-3.6 195 1.9L320 47.5l125-45.6c15.1-5.5 32 1.1 39.4 15.4l78.8 152.9c28.8 55.8 10.3 122.3-38.5 156.6L556.1 413l41-15c16.6-6 35 2.5 41 19.1s-2.5 35-19.1 41l-71.1 25.9L476.8 510c-16.6 6.1-35-2.5-41-19.1s2.5-35 19.1-41l41-15-31.3-86.2c-59.4 5.2-116.2-34-130-95.2L320 188.8l-14.6 64.7c-13.8 61.3-70.6 100.4-130 95.2l-31.3 86.2 41 15c16.6 6 25.2 24.4 19.1 41s-24.4 25.2-41 19.1L92.2 484.1 21.1 458.2c-16.6-6.1-25.2-24.4-19.1-41s24.4-25.2 41-19.1l41 15 31.3-86.2C66.5 292.5 48.1 226 76.9 170.2L155.6 17.3zm44 54.4l-27.2 52.8L261.6 157l13.1-57.9L199.6 71.7zm240.9 0L365.4 99.1 378.5 157l89.2-32.5L440.5 71.7z" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Kolom Kanan -->
              <div class="w-1/2 flex flex-col ">
                <!-- Waktu 08 WIB -->
                <div class="basis-1/4 w-full flex flex-col space-y-2 text-start justify-center items-center px-3"
                  data-aos="fade-left" data-aos-duration="3000">
                  <h3 class="font-semibold text-[20px]">08 WIB</h3>
                </div>

                <!-- Akad Nikah -->
                <div class="basis-1/4 w-full flex flex-col space-y-2 text-start justify-center px-3"
                  data-aos="fade-left" data-aos-duration="3000">
                  <h3 class="font-semibold text-[16px]">Akad Nikah</h3>
                  <div class="border border-dashed border-black"></div>
                  <p class="text-[12px]">Pembukaan oleh MC, Pembacaan Ayat Suci Al-Qur'an, Khutbah Nikah oleh penghulu
                    atau
                    tokoh agama, Ijab Kabul, Doa</p>
                </div>

                <!-- Waktu 11 WIB -->
                <div class="basis-1/4 w-full flex flex-col space-y-2 text-start justify-center items-center px-3"
                  data-aos="fade-left" data-aos-duration="3000">
                  <h3 class="font-semibold text-[20px]">11 WIB</h3>
                </div>

                <!-- Acara Puncak -->
                <div class="basis-1/4 w-full flex flex-col space-y-2 text-start justify-center px-3"
                  data-aos="fade-left" data-aos-duration="3000">
                  <h3 class="font-semibold text-[16px]">Acara Puncak</h3>
                  <div class="border border-dashed border-black"></div>
                  <p class="text-[12px]">Hiburan dan makan siang</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Susunan Acara -->

          <!-- MAP -->
          <div class="relative w-full h-96 mt-5" id="map">
            <iframe class="absolute top-0 left-0 w-full h-full" data-aos="zoom-in" data-aos-duration="3000"
              src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12080.73732861526!2d-74.0059418!3d40.7127847!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40zMDA2JzEwLjAiTiA3NMKwMjUnMzcuNyJX!5e0!3m2!1sen!2sus!4v1648482801994!5m2!1sen!2sus"
              frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
            </iframe>
          </div>
          <!-- MAP -->
          <!-- KETERANGAN -->
          <div class="mt-5 w-full not-italic text-center space-y-3 ">
            <p data-aos="fade-down" data-aos-duration="3000">Acara ini di selenggarakan dengan mematuhi protokol
              pencegahan penyebaran COVID-19 dan bagi tamu undangan
              di
              harapkan dapat mengikutinya.</p>
            <p data-aos="fade-up" data-aos-duration="3000">Besar harapan kami jika Bapak/Ibu/Sahabat/Sdr/i berkenan
              hadir
              pada acara ini. Atas perhatiannya Terima
              kasih
            </p>
          </div>
          <!-- KETERANGAN -->

          <!-- Pertemuan -->
          <div class="mt-5 w-full h-[950px] flex flex-col relative mx-0 px-0 bg-zinc-800 shadow-inner shadow-black">
            <!-- Header Our Story -->
            <div class="text-center w-full py-16 font-italiana" data-aos="fade-up" data-aos-duration="3000">
              <h1 class="text-4xl font-bold text-white mb-2">Our Story</h1>
              <p class="text-lg text-white">Momen indah kita berdua</p>
            </div>

            <!-- Konten -->
            <div class="w-full flex flex-wrap items-center">
              <!-- Kolom Gambar Kiri -->
              <div class="basis-1/2 h-[300px]">
                <img src="{{ asset('tema/darksweet/img/wedding-potret.jpg') }}" class="object-cover object-center h-full w-full  shadow-md"
                  alt="Wedding Potret">
              </div>

              <!-- Kolom Deskripsi Kanan -->
              <div
                class="basis-1/2 h-[300px] flex flex-col justify-center text-white bg-stone-700 p-6  shadow-md overflow-hidden ">
                <h3 class="text-[14px] font-semibold mb-2 text-start">Lanjut Ke Pelaminan</h3>
                <p class="text-[12px] text-start break-words">
                  05 Januari 2024 <br>
                  Setelah itu, Ryan dan Aria terus berhubungan dan memulai sebuah hubungan yang manis. Mereka
                  mengunjungi
                  tempat-tempat yang indah dan menikmati setiap momen bersama. Perjalanan pertemuan di kereta api telah
                  membawa mereka pada sebuah cerita cinta perjalanan yang tak terlupakan.
                </p>
              </div>

              <!-- Kolom Deskripsi Kiri -->
              <div
                class="basis-1/2 h-[300px] flex flex-col justify-center text-white bg-black p-6  shadow-md overflow-hidden">
                <h3 class="text-[14px] font-semibold mb-2 text-end">Pertemuan Di Kereta Api
                </h3>
                <p class="text-[12px] text-end break-words">
                  Pertemuan tak terduga di sebuah kereta api membawa Aria dan Ryan dalam sebuah cerita cinta perjalanan
                  yang
                  tak terlupakan. Aria adalah seorang gadis yang bekerja sebagai penulis buku anak-anak, sedangkan Ryan
                  adalah seorang pengusaha muda yang sedang dalam perjalanan bisnis ke kota lain.
                </p>
              </div>


              <!-- Kolom Gambar Kanan -->
              <div class="basis-1/2 h-[300px]">
                <img src="{{ asset('tema/darksweet/img/wedding-potret.jpg') }}" class="object-cover object-center h-full w-full  shadow-md"
                  alt="Wedding Potret">
              </div>
            </div>
            <div class="absolute border-b-2 border-white bottom-16 right-0 w-4/5 z-10"></div>
            <!-- Gradient Background -->
            <div class="absolute w-full bottom-0 h-32 bg-gradient-to-t from-black to-transparent z-0"></div>
          </div>
          <!-- Pertemuan -->

          <!-- Gallery -->
          <div class="w-full pt-5 bg-red-800 h-auto" id="gallery">
            <h1 class="text-white text-center text-3xl font-bold font-italiana">Gallery</h1>
            <div class="aspect-video w-full text-center flex justify-center mt-4 mb-4 py-4 bg-black"
              data-aos="zoom-in-up" data-aos-duration="3000">
              <iframe class="w-full h-full" src="https://www.youtube.com/embed/7ztcdznpX9w?si=OM01zJr-M6_8_7TI"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

            <div class="w-full flex flex-row gap-2 px-3 items-center mt-3" data-aos="fade-up" data-aos-duration="3000">
              <div class="basis-1/2 w-full h-[255px]">
                <img src="{{ asset('tema/darksweet/img/wedding-potret.jpg') }}"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer" alt="Wedding Potret"
                  onclick="openModalImg(this)" />
              </div>
              <div class="basis-3/4 w-full h-[255px]">
                <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer " alt="Prewed Square"
                  onclick="openModalImg(this)" />
              </div>
            </div>

            <div class="w-full flex flex-row gap-2 px-3 items-center mt-3" data-aos="fade-up" data-aos-duration="3000">
              <div class="basis-1/2 w-full h-[255px]">
                <img src="{{ asset('tema/darksweet/img/wedding-potret.jpg') }}"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer" alt="Wedding Potret"
                  onclick="openModalImg(this)" />
              </div>
              <div class="basis-3/4 w-full h-[255px]">
                <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer" alt="Prewed Square"
                  onclick="openModalImg(this)" />
              </div>
            </div>

            <div class="w-full flex flex-row gap-2 px-3 items-center mt-3" data-aos="fade-up" data-aos-duration="3000">
              <div class="basis-6/12 w-full h-[158px]">
                <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer" alt="Prewed Square"
                  onclick="openModalImg(this)" />
              </div>
              <div class="basis-5/12 w-full h-[158px]">
                <img src="{{ asset('tema/darksweet/img/wedding-potret.jpg') }}"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer" alt="Wedding Potret"
                  onclick="openModalImg(this)" />
              </div>
              <div class="basis-6/12 w-full h-[158px]">
                <img src="{{ asset('tema/darksweet/img/prewed-square.jpg') }}"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer" alt="Prewed Square"
                  onclick="openModalImg(this)" />
              </div>
            </div>

          </div>
          <!-- Gallery -->

          <!--  GIFT  -->
          <div class="w-full flex flex-col justify-center items-center pt-5 bg-zinc-800 px-3">
            <h1 class="text-white text-center text-3xl font-bold font-italiana" data-aos="fade-up"
              data-aos-duration="3000">Titip Hadiah
            </h1>
            <p class="text-sm text-center break-words text-white mt-5" data-aos="fade-up" data-aos-duration="3000">
              Doa restu Bapak/Ibu sekalian merupakan karunia yang sangat berarti bagi kami. Dan jika memberi merupakan
              ungkapan tanda kasih, Bapak/Ibu dapat memberi kado secara cashless. Terima kasih
            </p>
            <p class="text-lg text-center break-words text-white mt-5" data-aos="fade-up" data-aos-duration="3000">
              Note: Terdapat pilihan untuk menyembunyikan daftar rekening, dan akan muncul ketika klik tombol
            </p>

            <!-- CARD -->
            <div class="w-full flex flex-col justify-center items-center mt-5 px-2 gap-3">

              <!-- CARD 1 -->
              <div
                class="w-full h-44 sm:h-52 md:h-56 bg-gray-50 shadow-lg rounded-2xl relative overflow-hidden bg-local bg-cover bg-center"
                data-aos="fade-up" data-aos-duration="3000" style="background-image: url('img/logo/abstrak.jpg');">

                <!-- Logo -->
                <div class="absolute top-4 right-4 flex items-center h-8 w-20">
                  <div class="relative w-full aspect-w-16 aspect-h-9">
                    <img src="{{ asset('tema/darksweet/img/logo/bca.png') }}" alt="" class="absolute inset-0 object-cover object-center">
                  </div>
                </div>

                <!-- Chip -->
                <div class="absolute top-10 sm:top-16 left-4 sm:left-3 w-12 sm:w-10">
                  <img src="{{ asset('tema/darksweet/img/logo/pin.png') }}" class="w-full h-full" alt="Chip">
                </div>

                <!-- Card Details -->
                <div class="absolute bottom-6 sm:bottom-10 left-4 sm:left-3 text-gray-800 tracking-wider">
                  <div class="text-xl  font-bold tracking-wide text-ellipsis">12345678</div>
                  <div class="text-lg font-semibold text-gray-600">Sisca Kohl</div>
                </div>

                <!-- Copy Button -->
                <div class="absolute bottom-8 sm:bottom-6 right-4 sm:right-3">
                  <button
                    class="px-4 sm:px-3 py-1 bg-gray-300 text-gray-700 text-sm sm:text-xs rounded-lg hover:bg-gray-400">
                    Copy
                  </button>
                </div>
              </div>
              <!-- CARD 1 -->


              <!-- CARD 2 -->
              <div
                class="w-full h-44 sm:h-52 md:h-56 bg-gray-50 shadow-lg rounded-2xl relative overflow-hidden bg-local bg-cover bg-center"
                data-aos="fade-up" data-aos-duration="3000" style="background-image: url('img/logo/abstrak.jpg');">

                <!-- Logo -->
                <div class="absolute top-4 right-4 flex items-center h-8  w-20 ">
                  <div class="relative w-full aspect-w-16 aspect-h-9">
                    <img src="{{ asset('tema/darksweet/img/logo/Bank Sinarmas (koleksilogo.com).png') }}" alt=""
                      class="absolute inset-0 object-cover object-center">
                  </div>
                </div>

                <!-- Chip -->
                <div class="absolute top-10 sm:top-16 left-4 sm:left-3 w-12 sm:w-10">
                  <img src="{{ asset('tema/darksweet/img/logo/pin.png') }}" class="w-full h-full" alt="Chip">
                </div>

                <!-- Card Details -->
                <div class="absolute bottom-6 sm:bottom-10 left-4 sm:left-3 text-gray-800 tracking-wider">
                  <div class="text-xl  font-bold tracking-wide text-ellipsis">0982309823 </div>
                  <div class="text-lg font-semibold text-gray-600">Tobias Justin</div>
                </div>

                <!-- Copy Button -->
                <div class="absolute bottom-8 sm:bottom-6 right-4 sm:right-3">
                  <button
                    class="px-4 sm:px-3 py-1 bg-gray-300 text-gray-700 text-sm sm:text-xs rounded-lg hover:bg-gray-400">
                    Copy
                  </button>
                </div>
              </div>
              <!-- CARD 2 -->

              <!-- CARD 3 -->
              <div
                class="w-full h-44 sm:h-52 md:h-56 bg-gray-50 shadow-lg rounded-2xl relative overflow-hidden bg-local bg-cover bg-center"
                data-aos="fade-up" data-aos-duration="3000" style="background-image: url('{{ asset('tema/darksweet/img/logo/abstrak.jpg') }}');">

                <!-- Logo -->
                <div class="absolute top-4 right-4 flex items-center h-8  w-20 ">
                  <div class="relative w-full aspect-w-16 aspect-h-9">
                    <img src="{{ asset('tema/darksweet/img/logo/Bank Mestika Dharma.png') }}" alt=""
                      class="absolute inset-0 object-cover object-center">
                  </div>
                </div>

                <!-- Chip -->
                <div class="absolute top-10 sm:top-16 left-4 sm:left-3 w-12 sm:w-10">
                  <img src="{{ asset('tema/darksweet/img/logo/pin.png') }}" class="w-full h-full" alt="Chip">
                </div>

                <!-- Card Details -->
                <div class="absolute bottom-6 sm:bottom-10 left-4 sm:left-3 text-gray-800 tracking-wider">
                  <div class="text-xl  font-bold tracking-wide text-ellipsis">99787238</div>
                  <div class="text-lg font-semibold text-gray-600">Papanya Sisca</div>
                </div>

                <!-- Copy Button -->
                <div class="absolute bottom-8 sm:bottom-6 right-4 sm:right-3">
                  <button
                    class="px-4 sm:px-3 py-1 bg-gray-300 text-gray-700 text-sm sm:text-xs rounded-lg hover:bg-gray-400">
                    Copy
                  </button>
                </div>
              </div>
              <!-- CARD 3 -->

              <!-- CARD 4 -->
              <div
                class="w-full h-44 sm:h-52 md:h-56 bg-gray-50 shadow-lg rounded-2xl relative overflow-hidden bg-local bg-cover bg-center"
                data-aos="fade-up" data-aos-duration="3000" style="background-image: url('img/logo/abstrak.jpg');">

                <!-- Logo -->
                <div class="absolute top-4 right-4 flex items-center h-8  w-20 ">
                  <div class="relative w-full aspect-w-16 aspect-h-9">
                    <img src="{{ asset('tema/darksweet/img/logo/BRI.png') }}" alt="" class="absolute inset-0 object-cover object-center">
                  </div>
                </div>

                <!-- Chip -->
                <div class="absolute top-10 sm:top-16 left-4 sm:left-3 w-12 sm:w-10">
                  <img src="{{ asset('tema/darksweet/img/logo/pin.png') }}" class="w-full h-full" alt="Chip">
                </div>

                <!-- Card Details -->
                <div class="absolute bottom-6 sm:bottom-10 left-4 sm:left-3 text-gray-800 tracking-wider">
                  <div class="text-xl  font-bold tracking-wide text-ellipsis">12345678</div>
                  <div class="text-lg font-semibold text-gray-600">Van</div>
                </div>

                <!-- Copy Button -->
                <div class="absolute bottom-8 sm:bottom-6 right-4 sm:right-3">
                  <button
                    class="px-4 sm:px-3 py-1 bg-gray-300 text-gray-700 text-sm sm:text-xs rounded-lg hover:bg-gray-400">
                    Copy
                  </button>
                </div>
              </div>
              <!-- CARD 4 -->

            </div>
            <!-- CARD -->

            <!-- kado -->
            <div
              class="max-w-[360px] flex flex-col justify-center items-center p-5 bg-white rounded-lg shadow-lg space-y-4  mt-7">
              <div class="text-center w-16 h-16 bg-red-100 rounded-full flex items-center justify-center shadow-md"
                data-aos="fade-up" data-aos-duration="3000">
                <i class="fa-solid fa-gift fa-bounce fa-2xl text-red-500"></i>
              </div>
              <p class="text-gray-700 text-center text-sm font-medium" data-aos="fade-up" data-aos-duration="3000">
                Klik tombol di bawah untuk titip kado fisik ke acara:
              </p>
              <button
                class="w-full py-2 px-4 bg-gradient-to-r from-sky-500 to-blue-500 text-white rounded-lg shadow-md font-semibold flex items-center justify-center space-x-2 hover:from-sky-600 hover:to-blue-600 hover:shadow-lg"
                data-aos="fade-up" data-aos-duration="3000">
                <i class="fa-solid fa-gift"></i>
                <span>Pilih Kado Fisik</span>
              </button>
            </div>
            <!-- kado -->

            <div class="w-full flex flex-col justify-center items-center mt-5 px-4 space-y-4 font-reemkufi">
              <form action="" class="w-full max-w-md text-white p-6 space-y-4 ">
                <!-- Input Nama -->
                <div class="flex flex-col space-y-1 " data-aos="fade-up" data-aos-duration="3000">
                  <label for="name" class=" font-medium ">Nama</label>
                  <input type="text" id="name" placeholder="Masukkan nama Anda"
                    class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-gray-800" />
                </div>

                <!-- Input Jumlah -->
                <div class="flex flex-col space-y-1 " data-aos="fade-up" data-aos-duration="3000">
                  <label for="jumlah" class=" font-medium">Jumlah</label>
                  <input type="number" id="jumlah" placeholder="Masukkan jumlah"
                    class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-gray-800" />
                </div>

                <!-- Pilihan Radio -->
                <div class="flex flex-col space-y-1 " data-aos="fade-up" data-aos-duration="3000">
                  <label class=" font-medium">Pilih Akun</label>
                  <div class="flex items-center space-x-2">
                    <input type="radio" id="sisca" name="account"
                      class="h-3 w-3 text-sky-500 focus:ring-sky-500 focus:outline-none" />
                    <label for="sisca" class="text-sm">Sisca Kohl | 12345678</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="radio" id="tobias" name="account"
                      class="h-3 w-3 text-sky-500 focus:ring-sky-500 focus:outline-none" />
                    <label for="tobias" class="text-sm">Tobias Justin | 0982309823</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="radio" id="Papanya" name="account"
                      class="h-3 w-3 text-sky-500 focus:ring-sky-500 focus:outline-none" />
                    <label for="Papanya" class="text-sm">Papanya Sisca | 99787238</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="radio" id="van" name="account"
                      class="h-3 w-3 text-sky-500 focus:ring-sky-500 focus:outline-none" />
                    <label for="van" class="text-sm">Van | 123456789123</label>
                  </div>
                </div>

                <!-- Tombol Kirim -->
                <div class="pt-2 text-center" data-aos="fade-up" data-aos-duration="3000">
                  <button type="submit"
                    class="w-[150px] py-2 px-4 bg-gradient-to-r from-black to-gray-500 text-white rounded-lg shadow-md hover:from-slate-800 hover:to-gray-600 hover:shadow-lg font-semibold text-xs ring-1 ring-white">
                    Konfirmasi via Whatsapp
                  </button>
                </div>
              </form>
            </div>
          </div>
          <!-- GIFT -->

          <!-- Kehadiran -->
          <div class="w-full pt-5 bg-zinc-800 h-auto" id="absen">
            <h1 class="text-white text-center text-3xl font-bold" data-aos="fade-up" data-aos-duration="3000">Kehadiran
            </h1>
            <form class="mt-5 p-5 space-y-4">
              <!-- Input Nama -->
              <div class="space-y-2" data-aos="fade-up" data-aos-duration="3000">
                <label for="nama" class="block text-white font-medium text-sm">Nama</label>
                <input type="text" id="nama" name="nama"
                  class="w-full p-2 bg-zinc-800 text-white ring-1 ring-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                  placeholder="Masukkan nama Anda" required />
              </div>
              <!-- Input Ucapan -->
              <div class="space-y-2" data-aos="fade-up" data-aos-duration="3000">
                <label for="ucapan" class="block text-white font-medium text-sm">Ucapan</label>
                <textarea id="ucapan" name="ucapan" rows="4"
                  class="w-full p-2 bg-zinc-800 text-white ring-1 ring-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                  placeholder="Tulis ucapan Anda di sini" required></textarea>
              </div>
              <!-- Input Kehadiran -->
              <div class="space-y-2" data-aos="fade-up" data-aos-duration="3000">
                <label for="kehadiran" class="block text-white font-medium text-sm">Kehadiran</label>
                <select id="kehadiran" name="kehadiran"
                  class="w-full p-2 bg-zinc-800 text-white ring-1 ring-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                  required>
                  <option value="" disabled selected>Pilih status kehadiran</option>
                  <option value="tidak hadir">Tidak Hadir</option>
                  <option value="hadir">Hadir</option>
                </select>
              </div>
              <!-- Input Datang Dengan Siapa -->
              <div class="space-y-2" data-aos="fade-up" data-aos-duration="3000">
                <label for="datang-dengan" class="block text-white font-medium text-sm">Datang Dengan Siapa</label>
                <input type="text" id="datang-dengan" name="datang-dengan"
                  class="w-full p-2 bg-zinc-800 text-white ring-1 ring-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                  placeholder="Contoh: Sendiri, Teman, Keluarga" required />
              </div>
              <!-- Input Menu Makan Malam -->
              <div class="space-y-2" data-aos="fade-up" data-aos-duration="3000">
                <label for="menu-makan" class="block text-white font-medium text-sm">Menu Makan Malam</label>
                <select id="menu-makan" name="menu-makan"
                  class="w-full p-2 bg-zinc-800 text-white ring-1 ring-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                  required>
                  <option value="" disabled selected>Pilih menu makan malam</option>
                  <option value="vegetarian">Vegetarian</option>
                  <option value="non-vegetarian">Non-Vegetarian</option>
                  <option value="vegan">Vegan</option>
                </select>
              </div>
              <div class="space-y-2" data-aos="fade-up" data-aos-duration="3000">
                <!-- Tombol Kirim -->
                <div class="text-start pt-2">
                  <button type="submit"
                    class="px-5 py-2 bg-black text-white ring-1 ring-white rounded-md hover:bg-white hover:text-black transition">
                    Kirim
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div class="w-full px-3 bg-zinc-800 pt-5 pb-10">
            <div class="w-full max-h-96 bg-white p-4 overflow-y-scroll mt-5" data-aos="fade-up"
              data-aos-duration="3000">
              <ul class="space-y-3">
                <!-- Item 1 -->
                <li class="flex flex-col items-start p-2  rounded-md text-xs shadow-lg">
                  <span>🔵 742 Total Ucapan</span>
                  <span>🟢 62076 Orang Menyatakan Hadir</span>
                </li>
                <!-- Item 2 -->
                <li class="flex flex-col items-start p-2  rounded-md ring-neutral-900 ring-1">
                  <span class="text-md font-bold">1. Mengirim Kado</span>
                  <span class="text-xs font-semibold italic">Waiting for Payment</span>
                  <span class="text-sm font-semibold">555'"</span>
                </li>
                <!-- Item 3 -->
                <!-- Item 2 -->
                <li class="flex flex-col items-start p-2  rounded-md ring-neutral-900 ring-1">
                  <span class="text-md font-bold">1. Mengirim Kado</span>
                  <span class="text-xs font-semibold italic">Waiting for Payment</span>
                  <span class="text-sm font-semibold">555'"</span>
                </li>
                <!-- Item 2 -->
                <li class="flex flex-col items-start p-2  rounded-md ring-neutral-900 ring-1">
                  <span class="text-md font-bold">1. Mengirim Kado</span>
                  <span class="text-xs font-semibold italic">Waiting for Payment</span>
                  <span class="text-sm font-semibold">555'"</span>
                </li>
                <!-- Item 2 -->
                <li class="flex flex-col items-start p-2  rounded-md ring-neutral-900 ring-1">
                  <span class="text-md font-bold">1. Mengirim Kado</span>
                  <span class="text-xs font-semibold italic">Waiting for Payment</span>
                  <span class="text-sm font-semibold">555'"</span>
                </li>
                <!-- Item 2 -->
                <li class="flex flex-col items-start p-2  rounded-md ring-neutral-900 ring-1">
                  <span class="text-md font-bold">1. Mengirim Kado</span>
                  <span class="text-xs font-semibold italic">Waiting for Payment</span>
                  <span class="text-sm font-semibold">555'"</span>
                </li>
                <!-- Item 2 -->
                <li class="flex flex-col items-start p-2  rounded-md ring-neutral-900 ring-1">
                  <span class="text-md font-bold">1. Mengirim Kado</span>
                  <span class="text-xs font-semibold italic">Waiting for Payment</span>
                  <span class="text-sm font-semibold">555'"</span>
                </li>
              </ul>
            </div>
          </div>
          <!-- Kehadiran -->

          <div class="w-full h-[750px] flex flex-col justify-center items-center bg-cover bg-center bg-local relative"
            id="bottom" style="background-image: url('{{ asset('tema/darksweet/img/illustration.jpg') }}');">
            <div class="absolute bg-black opacity-50 inset-0 w-full h-full z-0"></div>
            <div class="flex flex-col justify-center items-center p-2 bg-white shadow-md z-10">
              <div class="aspect-[5/7] w-44 h-auto">
                <img src="{{ asset('tema/darksweet/img/wedding-potret.jpg') }}" alt="" class="object-cover w-full h-full">
              </div>
            </div>
            <div class="w-full mx-auto mt-5 z-10">
              <h1 class="text-white text-center text-3xl font-bold font-italiana" data-aos="fade-down"
                data-aos-duration="3000">Justin &
                Sisca
              </h1>
            </div>
            <div class="w-full mx-auto mt-5 z-10">
              <p class="text-white text-center text-lg font-semibold font-italiana" data-aos="fade-up"
                data-aos-duration="3000">Terima
                Kasih</p>
            </div>
            <div class="absolute w-full bottom-0 h-48 bg-gradient-to-t from-black to-transparent"></div>
          </div>
          <div class="w-full h-[500px] bg-black"></div>
        </div>
      </div>


    </section>
    <!-- Content -->

    <nav
      class="fixed bottom-2 mb-1 md:mb-3 z-30 w-full md:w-2/4 lg:w-1/3 mx-auto max-h-[40px] flex justify-center inset-x-0">
      <div
        class="py-2 px-4 w-full h-full flex justify-evenly mx-6 space-x-6 items-center rounded-full bg-white shadow-2xl ring-1 ring-black backdrop-blur-lg bg-opacity-50">
        <!-- Icon 1 -->
        <a href="#home"
          class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200 scroll-smooth text-opacity-100">
          <i class="fa-solid fa-house text-lg md:text-2xl "></i>
        </a>
        <!-- Icon 2 -->
        <a href="#absen" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
          <i class="fa-solid fa-user-group text-lg md:text-2xl"></i>
        </a>
        <!-- Icon 3 -->
        <a href="#gallery" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
          <i class="fa-solid fa-images text-lg md:text-2xl"></i>
        </a>
        <!-- Icon 4 -->
        <a href="#map" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
          <i class="fa-solid fa-map-location-dot text-lg md:text-2xl"></i>
        </a>
        <!-- Icon 5 -->
        <button type="button" id="openModalQr"
          class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
          <i class="fa-solid fa-qrcode text-lg md:text-2xl"></i>
        </button>
        <!-- Icon 6 -->
        <button type="button" id="scrollButton"
          class="flex items-center text-gray-600 hover:text-sky-600 p-1  rounded-lg ">
          <i class="fa-solid fa-circle-down text-lg md:text-2xl"></i>
        </button>
        <!-- Icon 7 -->
        <button type="button" id="toggleButton"
          class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
          <i class="fa-solid fa-music text-lg md:text-2xl"></i>
        </button>

      </div>
    </nav>

    <!-- Youtube -->
    <div class="hidden fixed z-0 bottom-0">
      <iframe id="videoFrame" width="0" height="0" src="https://www.youtube.com/embed/VDbVXpJWA-k?enablejsapi=1"
        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
      </iframe>
    </div>

    
  </div>
  <!-- content -->
<!-- Modal Qr -->
<div id="modal" class="fixed invisible inset-0 bg-black bg-opacity-50 flex  justify-center items-center z-50">
  <div class="bg-white rounded-lg w-80 p-6 shadow-lg relative">

    <h2 class="text-lg font-bold text-center mb-4">QRCode Buku Tamu</h2>
    <p class="text-center text-sm mb-4">The Wedding of Justins & Sisca</p>
    <p class="text-center text-sm mb-6">Tunjukkan QRCode di bawah ini ke panitia penyelenggara</p>
    <div class="flex justify-center mb-6">

      <img src="img/qr-1.jpg" alt="QR Code" class="w-40 h-40">
    </div>
    <div class="flex justify-center mb-4">
      <button id="downloadBtn" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
        Download
      </button>
    </div>
    <div class="flex justify-center">
      <button id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
        Close
      </button>
    </div>
  </div>
</div>


 <!-- Modal Image -->
 <div id="imageModal"
 class="fixed invisible inset-0 z-50  bg-black bg-opacity-75 flex items-center justify-center transition-all duration-300 ease-in-out">
 <div class="relative">
   <img id="modalImage" class="max-w-full max-h-screen rounded-lg shadow-xl py-11" src="" alt="Modal Image" />
   <button onclick=" closeModalImg()"
     class="absolute top-2 right-2 text-white bg-sky-500 hover:bg-slate-600 rounded-lg py-1 px-3 focus:outline-none">
     ✕
   </button>
 </div>
</div>
  <!-- datePick -->
  <script src="{{ asset('tema/darksweet/js/setDate.js') }}"></script>

  <!-- aos -->
  <script src="{{ asset('tema/darksweet/assets/aos/dist/aos.js') }}"></script>
  <script>
    AOS.init();
  </script>
  <!-- swiper -->
  <script src="{{ asset('tema/darksweet/assets/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/swiper.js') }}"></script>

  <script src="{{ asset('tema/darksweet/js/autoScroll.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/openCover.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/modal.js') }}"></script>
  <script src="{{ asset('tema/darksweet/js/modalImage.js') }}"></script>
</body>

</html>