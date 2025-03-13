<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- START Swiper css -->
  <link rel="stylesheet" href="{{asset('tema/darkpre/assets/swiper/swiper-bundle.min.css')}}">
  <link href="{{asset('tema/darkpre/src/css/output.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('tema/darkpre/src/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('tema/darkpre/src/css/gallery.css')}}">
  <link rel="stylesheet" href="{{asset('tema/darkpre/assets/fontawesome-free/css/all.css')}}">
  <link rel="stylesheet" href="{{asset('tema/darkpre/assets/aos/dist/aos.css')}}">
</head>

<body class="relative">

  <!-- cover mobile -->
  <div id="cover-mobile" class="h-full w-full font-poppins fixed lg:hidden block z-50 text-white"
    style="background-image: url('{{asset('tema/darkpre/src/img/bg-kanan.jpg')}}'); background-size: cover; background-position: center;">
    <div class="w-full flex justify-center items-center flex-col">
      <h3 class="text-center font-semibold text-2xl pt-10" data-aos="fade-down" data-aos-easing="linear"
        data-aos-duration="1500">The Wedding Of</h3>
      <h2 class="mt-8 text-center text-[50px] font-light font-corinthia" data-aos="fade-up"
        data-aos-anchor-placement="top-bottom">
        Izzah <span class="font-poppins text-[25px]">&</span> Rifki
      </h2>
      <p class="text-center text-[20px]" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">02 . 04 . 2025</p>

      <button id="open-cover"
        class="absolute bottom-20 px-4 py-2 font-semibold rounded-full border-white border-2 animate-bounce">
        Buka Undangan
      </button>
    </div>
  </div>

  <!-- konten -->
  <div class="flex flex-row h-screen z-10 relative">
    <!-- Bagian kiri  -->
    <div class=" lg:w-3/5 md:h-screen lg:fixed z-20">
      <!-- opening  -->
      <div class="z-50 w-full h-full brightness-50 contrast-100	saturate-100"
        style="background-image: url('{{asset('tema/darkpre/src/img/bg-kanan.jpg')}}'); background-size: cover; background-position: center;"></div>
      <h2 class="absolute bottom-12 left-14 text-[50px] text-white font-corinthia hidden lg:block">Izzah<span
          class="font-poppins text-[25px]"> & </span> Rifki</h2>
      <!-- music -->
      <div id="youtube-player" class="hidden">
        <iframe id="videoFrame" width="560" height="315"
          src="https://www.youtube.com/embed/sy0LqD9EA7A?si=59Ql_kVZl3TaSU3m&amp?enablejsapi=1"
          title="YouTube video player" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
        </iframe>
      </div>
      <!-- Toggle Button -->
      <button id="audio-toggle" type="button"
        class=" fixed lg:absolute rounded-full w-10 h-10 top-10 right-2 bg-slate-400 z-50 flex items-center justify-center text-xl shadow-lg hover:bg-slate-600 transition duration-300">
        <span id="audio-status" class="text-white">
          <i class="fa-solid fa-play"></i>
        </span>
      </button>
      <!-- music -->

      <!-- sumbangan -->
      <button onclick="toggleModal()" type="button"
        class="fixed lg:absolute rounded-full w-14 h-14 top-28 right-2 lg:right-5 bg-teal-400 z-50 flex items-center justify-center text-2xl shadow-lg hover:bg-teal-500 transition duration-300">
        <i class="fa-solid fa-wallet text-white"></i>
      </button>

      <!-- Modal -->
      <div id="infoModal"
        class="invisible fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 font-poppins">
        <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">
          <h2 class="text-lg font-bold text-gray-800 mb-4">Kado</h2>
          <p class="text-gray-600 mb-4">Berikut adalah informasi untuk mengirimkan kado atau hadiah secara online atau
            melalui pengiriman fisik:</p>
          <ul class="text-left text-gray-700 mb-6 flex flex-col items-center text-sm">
            <li class="mb-2"><strong>Qris</strong></li>
            <li class="mb-2 text-center"><img src="{{asset('tema/darkpre/src/img/bg-kanan.jpg')}}" alt="" class="w-32"></li>
            <li class="mb-2 "><strong>Nama Akun/Rekening:</strong> Eli</li>
            <li><strong>Nomor Akun/Rekening:</strong> 085763561698</li>
          </ul>
          <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
            onclick="toggleModal()">Tutup</button>
        </div>
      </div>
      <!-- sumbangan -->

      <!-- Navbar -->
      <div
        class="navbar hidden lg:block lg:absolute lg:right-8 lg:top-72 lg:w-9 h-auto bg-neutral-950 rounded-full shadow-lg z-40"
        id="navbar">
        <div class=" py-3 relative">
          <div class="flex flex-col justify-center items-center w-full text-orange-200 text-sm gap-3">
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
            <a class="nav-link  gallery flex items-center justify-start text-orange-200 hover:bg-orange-100 hover:text-black px-2 py-1 rounded-full transition duration-200"
              href="#gallery">
              <i class="fa-regular fa-images"></i>
              <span class="ml-2 hidden">gallery</span>
            </a>
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

    <!-- Bagian kanan -->
    <div class="w-full lg:w-2/5 h-full relative items-center text-white ml-auto z-10">

      <!-- opening -->
      <div class="h-full w-full font-poppins "
        style="background-image: url('{{asset('tema/darkpre/src/img/bg-kanan.jpg')}}'); background-size: cover; background-position: center;">

        <div class="w-full " data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
          <h3 class="text-center font-normal text-2xl pt-10 ">The Wedding Of</h3>
          <h2 class="mt-5 text-center text-[40px] font-light font-corinthia">Izzah <span
              class="font-poppins text-[25px]">&</span>Rifki</h2>
          <p class="text-center text-[20px]">02 . 04 . 2025</p>
                  
        </div>
        <!-- svg -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-full absolute bottom-0 lg:hidden block" viewBox="0 0 1440 320">
          <path fill="#0a0a0a" fill-opacity="1"
            d="M0,160L48,149.3C96,139,192,117,288,138.7C384,160,480,224,576,250.7C672,277,768,267,864,224C960,181,1056,107,1152,69.3C1248,32,1344,32,1392,32L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
          </path>
        </svg>
        <!-- svg -->

        <div class="absolute inset-x-0 flex flex-col items-center bottom-20">
          <!-- Mouse -->
          <div class="w-8 h-14 border-2 border-gray-500 rounded-full relative">
            <!-- Wheel -->
            <div
              class="w-2 h-3 bg-white rounded-full absolute top-3 left-1/2 transform -translate-x-1/2 animate-scroll">
            </div>
          </div>
          <!-- Arrow -->
          <div class="mt-4 text-sm text-white">Scroll Kebawah</div>
        </div>
      </div>
      <!-- End opening -->

      <!-- Kutipan Al-Qur'an -->
      <div class="bg-neutral-950 w-full p-10 ">

        <div class="border border-orange-200 border-dashed text-orange-200 font-poppins italic" data-aos="fade-down"
          data-aos-easing="linear" data-aos-duration="1500">
          <p class="text-center font-semibold p-10 space-y-3 lg:text-lg text-[13px]">"Dan Diantara tanda-tanda
            kebesaran-Nya ialah
            diciptakan-Nya
            untukmu pasangan hidup dari jenismu sendiri supaya kamu mendapatkan ketenangan hati dan dijadikan-Nya kasih
            sayang diantara kamu sesungguhnya yang demikian menjadi tanda-tanda kebesaran-Nya bagi orang-orang yang
            berfikir" <br> <br>
            <span>(Surat Ar-Ruum:21)</span>
          </p>
        </div>
      </div>

      <!-- pembatas -->
      <div class="bg-neutral-950 pt-10 section" id="couple"><img src="{{asset('tema/darkpre/src/img/pembatas.png')}}" class="w-full" alt=""></div>

      <!-- pasangan -->
      <div class="bg-neutral-950 relative font-corinthia">
        <!-- card 1 -->
        <div class="  justify-center">
          <h2 class="text-[50px] text-center font-light text-orange-200 " data-aos="fade-down" data-aos-easing="linear"
            data-aos-duration="1500">Izzah</h2>
          <div class="flex flex-row pl-12 items-center justify-start space-x-4 font-poppins" data-aos="fade-down"
            data-aos-easing="linear" data-aos-duration="2000">
            <div class=""><img src="{{asset('tema/darkpre/src/img/izzah.jpg')}}" alt=""
                class="object-cover object-center rounded-full w-[150px] lg:w-[180px]">
            </div>
            <div class="text-orange-200">
              <p class="text-[20px] font-semibold" data-aos="fade-down" data-aos-easing="linear"
                data-aos-duration="1500">Minhatul Izzah</p>
              <p class="font-semibold text-[13px] space-y-5" data-aos="fade-down" data-aos-easing="linear"
                data-aos-duration="1500">Putri dari <br> Bapak Akbar S.Kom <br> & Ibu Siti S.Pd</p>
            </div>
          </div>
        </div>

        <!-- card 2 -->
        <div class=" justify-center pt-10">
          <div class="flex flex-row pr-12 items-center justify-end space-x-4">
            <div class="text-orange-200 font-poppins">
              <p class="text-[20px] font-semibold" data-aos="fade-down"
              data-aos-easing="linear"
              data-aos-duration="1500">Minhatul Izzah</p>
              <p class="font-semibold text-[13px] space-y-5" data-aos="fade-down"
              data-aos-easing="linear"
              data-aos-duration="2000">Putri dari <br> Bapak Akbar S.Kom <br> & Ibu Siti S.Pd</p>
            </div>
            <div class="" ><img src="{{asset('tema/darkpre/src/img/rifki.jpg')}}" alt=""
                class="object-cover object-center rounded-full w-[150px] lg:w-[180px]" data-aos="fade-down"
                data-aos-easing="linear" data-aos-duration="2000">
            </div>
          </div>
          <h2 class="text-[50px] text-center lg:absolute lg:inset-x-0  lg:-bottom-10  font-light text-orange-200">Rifki
          </h2>
        </div>
      </div>
      <!-- pasangan -->

      <!-- pembatas -->
      <div class="bg-neutral-950  section" id="date"><img src="{{asset('tema/darkpre/src/img/pembatas.png')}}" class="w-full rotate-180" alt=""></div>

      <!-- Akad -->
      <div class="bg-neutral-950 relative pt-10 pb-16 text-orange-200  font-poppins">
        <!-- Judul -->
        <h2 class="text-center text-[50px] z-50 relative font-light mb-6 font-corinthia">
          Acara Akan <br> Diselenggarakan
        </h2>
        <!-- Gambar Hiasan Kiri -->
        <div class="left-0 absolute top-10 inset-x-0 z-10">
          <img src="{{asset('tema/darkpre/src/img/bunga.png')}}" alt="Hiasan Bunga" class="w-20 lg:w-24  object-center">
        </div>

        <!-- Hari -->
        <div class="text-center z-50 mt-4 relative ">
          <div class="text-[70px] font-bold" id="days">26</div>
          <div class="text-[30px] font-semibold">HARI</div>
        </div>

        <!-- Gambar Hiasan Tengah -->
        <div class="flex justify-center  absolute top-32 inset-x-0 z-10">
          <img src="{{asset('tema/darkpre/src/img/bunga.png')}}" alt="Hiasan Bunga" class="w-20 lg:w-24 rotate-180">
        </div>

        <!-- Timer -->
        <div class="flex relative justify-center z-50 items-center mt-10 space-x-8">
          <!-- Hours -->
          <div class="flex flex-col items-center">
            <h2 class="text-3xl font-bold" id="hours">21</h2>
            <span class="text-sm font-semibold uppercase">Hours</span>
          </div>

          <!-- Divider -->
          <div class="h-16 w-px bg-gray-400"></div>

          <!-- Minutes -->
          <div class="flex flex-col items-center">
            <h2 class="text-3xl font-bold" id="minutes">50</h2>
            <span class="text-sm font-semibold uppercase">Minutes</span>
          </div>

          <!-- Divider -->
          <div class="h-16 w-px bg-gray-400"></div>

          <!-- Seconds -->
          <div class="flex flex-col items-center">
            <h2 class="text-3xl font-bold" id="seconds">5</h2>
            <span class="text-sm font-semibold uppercase">Seconds</span>
          </div>
        </div>

        <!-- Tanggal -->
        <div class="text-center text-lg text-orange-200 pt-8" id="countdown">
          Rabu, 2 April 2025
        </div>

        <!-- button -->
        <div class="text-center pt-8 ">
          <a href="#" class="rounded-full w-11 border border-orange-200 p-2"><i
              class="fa-solid fa-calendar-days mr-2"></i>Simpan acara ke kalender</a>
        </div>
      </div>
      <!-- end akad -->

      <!-- pembatas -->
      <div class="bg-neutral-950  section" id="location"><img src="{{asset('tema/darkpre/src/img/pembatas.png')}}" class="w-full" alt=""></div>

      <!-- resepsi -->
      <div class="bg-neutral-950 relative text-orange-200 pb-10 font-poppins">
        <h2 class="flex justify-center inset-x-0 -top-14 text-[50px] z-50 absolute font-light mb-6 font-corinthia">
          Marriage contract</h2>

        <div class="flex flex-col items-center justify-center w-full space-y-3 font-normal text-sm pt-8">
          <div>Jumat, 15 Oktober 2021</div>
          <div>pukul 09.00 WIB - selesai</div>
          <div>Jalan Kemuning Raya, di Masjid Al Barokah</div>
        </div>

        <!-- button -->
        <div class="text-center pt-8 ">
          <a href="#" class="rounded-full w-11 border border-orange-200 p-2"><i
              class="fa-solid fa-map-location-dot mr-2"></i>lihat lokasi</a>
        </div>

        <!-- receptionis -->
        <div class="flex flex-col items-center justify-center w-full space-y-3  pt-10  text-sm">
          <h3 class="text-[50px] mb-5 font-corinthia ">Reception</h3>
          <div>Jumat, 15 Oktober 2021</div>
          <div>pukul 09.00 WIB - selesai</div>
        </div>

        <!-- unduh mantu -->
        <div class="flex flex-col items-center justify-center w-full space-y-3  pt-10  text-sm">
          <h3 class="text-[50px] mb-5 font-corinthia font-light">Unduh Mantu</h3>
          <div>Rabu, 21 April 2022</div>
          <div>pukul 09.00 WIB - selesai</div>
          <div>Jalan Kemuning Raya, di Masjid Al Barokah</div>
        </div>

        <!-- button -->
        <div class="text-center pt-8 ">
          <a href="#" class="rounded-full w-11 border border-orange-200 p-2 "><i
              class="fa-solid fa-map-location-dot mr-2"></i>lihat lokasi</a>
        </div>

        <div class="text-center w-full pt-14 pb-14 font-light lg:text-sm text-[11px]">Merupakan suatu kehormatan dan
          kebahagiaan bagi
          kami <br> apabila,
          Saudara
          / i. berkenan hadir untuk memberikan do'a <br> restunya kami ucapkan terimakasih.
        </div>

        <div
          class="flex flex-col lg:absolute lg:inset-x-0 lg:-bottom-14 justify-center items-center space-y-3 pt-10 text-sm">
          <p class="text-xl font-semibold">Turut Mengundang:</p>
          <p>Keluarga Besar Sujono</p>
          <p>Keluarga Besar Emence</p>
          <p>Teman SMK 1 Negeri</p>
        </div>

      </div>
      <!-- resepsi -->

      <!-- pembatas -->
      <div class="bg-neutral-950 "><img src="{{asset('tema/darkpre/src/img/pembatas.png')}}" class="w-full rotate-180" alt=""></div>

      <!-- story -->
      <div class="w-full bg-neutral-950 text-orange-200 font-poppins section overflow-x-hidden">
        <h2 class="text-center text-[50px] font-corinthia z-50  font-light mb-6 py-8 ">Story</h2>
        <div class="swiper_2 swiperStory mt-8 ">
          <div class="swiper-wrapper gap-3 font-semibold ">
            <div class="swiper-slide flex flex-col  text-sm space-y-5"><img src="{{asset('tema/darkpre/src/img/gambar-1.jpg')}}" alt=""
                class="object-cover object-center aspect-square  w-[300px] shadow-md cursor-pointer rounded-full"
                onclick="openModalImg(this)">
              <p>Pertama kita bertemu di tahun baru tahun 2014</p>
            </div>
            <div class="swiper-slide flex flex-col  text-sm space-y-5"><img src="{{asset('tema/darkpre/src/img/gambar-2.jpg')}}" alt=""
                class="object-cover object-center aspect-square  w-[300px] shadow-md cursor-pointer rounded-full"
                onclick="openModalImg(this)">
              <p>15 November 2020</p>
            </div>
            <div class="swiper-slide flex flex-col  text-sm space-y-5"><img src="{{asset('tema/darkpre/src/img/gambar-3.jpg')}}" alt=""
                class="object-cover object-center aspect-square  w-[300px] shadow-md cursor-pointer rounded-full"
                onclick="openModalImg(this)">
              <p>29 November 2023</p>
            </div>
          </div>
        </div>
      </div>
      <!-- story -->

      <!-- Galery -->
      <div class=" w-full bg-neutral-950 text-orange-200 font-poppins section" id="gallery">
        <h2 class="text-center text-[50px] font-corinthia z-50  font-light mb-6 py-8">Gallery Kami</h2>
        <div class="text-center text-sm mb-10">"Pernikahan seperti mozaik yang kita buat dengan <br> pasangan kita,
          jutaan momen kecil yang menjadi kisah <br> cinta."</div>
        <div class="swiper mySwiper text-black pt-10 ">
          <div class="swiper-wrapper ">
            <div class="swiper-slide">
              <img src="{{asset('tema/darkpre/src/img/gambar-1.jpg')}}" alt="Thumbnail" onclick="openModalImg(this)"
                class="object-cover object-center w-full h-full shadow-md cursor-pointer">
            </div>
            <div class="swiper-slide">
              <img src="{{asset('tema/darkpre/src/img/gambar-2.jpg')}}" alt="Thumbnail" onclick="openModalImg(this)"
                class="object-cover object-center w-full h-full shadow-md cursor-pointer">
            </div>
            <div class="swiper-slide">
              <img src="{{asset('tema/darkpre/src/img/gambar-3.jpg')}}" alt="Thumbnail" onclick="openModalImg(this)"
                class="object-cover object-center w-full h-full shadow-md cursor-pointer">
            </div>

          </div>
        </div>
      </div>
      <!-- end gallery -->

      <!-- ucapan -->
      <div class="w-full  bg-neutral-950 text-orange-200 relative z-50">
        <h2 class="text-center text-[50px] font-light mb-6 py-8 font-corinthia">Ucapan & Doa</h2>
        <div class="flex justify-center left-0  absolute  z-10">
          <img src="{{asset('tema/darkpre/src/img/bunga.png')}}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>

        <!-- Gambar Hiasan Tengah -->
        <div class="flex justify-center right-0  absolute  z-10">
          <img src="{{asset('tema/darkpre/src/img/bunga.png')}}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>


        <div class="p-6 h-[300px] rounded-lg shadow-lg space-y-5 overflow-y-auto z-50 relative font-poppins">
          <!-- AT -->
          <div class=" p-4 rounded-md   h-auto  shadow-md shadow-slate-200 bg-neutral-950">
            <h3 class="text-[14px] font-semibold">AT (Andy Tengil)</h3>
            <p class="text-[12px] ">Thursday, 06 03 2025</p>
            <p class="mt-2 text-[12px] italic">"Mantap antap"</p>
          </div>

          <!-- ST -->
          <div class=" p-4 rounded-md shadow-md shadow-slate-200 h-auto bg-neutral-950">
            <h3 class="text-[14px] font-semibold">ST (Selamat Tembak Dalam Coy)</h3>
            <p class="text-[12px] ">Thursday, 06 03 2025</p>
            <p class="mt-2  italic">"Selamat Ya"</p>
          </div>

          <!-- R -->
          <div class=" p-4 rounded-md shadow-md shadow-slate-200 h-auto bg-neutral-950">
            <h3 class="text-[14px] font-semibold">R (Ronald)</h3>
            <p class="text-[12px] ">Thursday, 06 03 2025</p>
            <p class="mt-2 text-[12px] italic">
              "Selamat mengarungi kehidupan berumah tangga Bajuri & Ijah.. Langgeng terus sampai kapan pun"
            </p>
          </div>
        </div>
      </div>


      <div class="w-full bg-neutral-950 text-orange-200 p-6 shadow-lg relative  section" id="wishes">
        <h4 class="text-2xl font-semibold mb-4 relative z-50 font-corinthia">Kirim Ucapan</h4>
        <!-- Gambar Hiasan Tengah -->
        <div class="flex justify-center right-14  absolute  z-10">
          <img src="{{asset('tema/darkpre/src/img/bunga.png')}}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>
        <form action="" class="space-y-4 relative z-50">
          <!-- Input Nama -->
          <input type="text" name="nama" placeholder="Nama Lengkap"
            class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 placeholder-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200" />

          <!-- Textarea Ucapan -->
          <textarea name="pesan" placeholder="Ucapan & Doa" rows="4"
            class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 placeholder-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200"></textarea>

          <!-- Select Konfirmasi Kehadiran -->
          <select name="konfirmasi"
            class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200">
            <option value="">Konfirmasi Kehadiran</option>
            <option value="datang">Datang Dong</option>
            <option value="tidak_datang">Tidak Bisa Datang Nih</option>
            <option value="diusahakan">Diusahakan Datang Ya</option>
          </select>

          <!-- Button Kirim -->
          <button type="submit"
            class="w-full rounded-full bg-orange-200 text-black font-semibold p-3 hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
            Kirim Sekarang
          </button>
        </form>
      </div>

      <div class="text-center pt-12 text-orange-200 text-[10px] bg-neutral-950 pb-5">
        presented by <br> <span class="font-semibold">Wayae Nikah</span>
      </div>
      <!-- ucapan -->

      <!-- Navbar mobile -->
      <div
        class="navbar block lg:hidden fixed bottom-3 ring-1 ring-offset-2 ring-white inset-x-0 w-auto h-auto mx-2 bg-neutral-950 rounded-full shadow-lg z-50"
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
            <a class="nav-link  gallery flex items-center justify-start text-orange-200 hover:bg-orange-100 hover:text-black px-2 py-1 rounded-full transition duration-200"
              href="#gallery">
              <i class="fa-regular fa-images"></i>
              <span class="ml-2 hidden">gallery</span>
            </a>
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

  </div>
  <!-- konten -->

  <!-- aos -->
  <script src="{{asset('tema/darkpre/assets/aos/dist/aos.js')}}"></script>

  <!-- Swiper -->
  <script src="{{asset('tema/darkpre/assets/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('tema/darkpre/assets/swiper/swiper-element-bundle.min.js')}}"></script>
  <script src="{{asset('tema/darkpre/src/js/swiper.js')}}"></script>

  <!-- nav -->
  <script src="{{asset('tema/darkpre/src/js/nav.js')}}"></script>
  <!-- modal -->
  <script src="{{asset('tema/darkpre/src/js/modal.js')}}"></script>
  <!-- audio -->
  <script src="{{asset('tema/darkpre/src/js/audio.js')}}"></script>
  <script src="{{asset('tema/darkpre/src/js/setDate.js')}}"></script>
  <script>
    AOS.init();
  </script>

</body>

</html>