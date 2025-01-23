<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('tema/standtheme/output.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('tema/standtheme/assets/aos/dist/aos.css') }}">
</head>

<body class="bg-white ">
    <!-- Main modal -->
    <div id="modal" class="fixed visible inset-0 bg-black bg-opacity-50 flex  justify-center items-center z-50">
        <div class="bg-white rounded-lg w-auto p-3 shadow-lg relative ">
            <div class="bg-[#755f4B] w-full text-white">
                <h4 class=" text-base md:text-lg  text-center pt-2">Undangan Pernikahan</h4>
                <p class="text-center text-lg md:text-2xl mb-4">The Wedding of Justins & Sisca</p>
                <div class="flex justify-center mb-6">

                    <img src="{{ asset('tema/standtheme/assets/img/cover.jpg') }}" alt=""
                        class="w-[466px] h-[466px]">
                </div>
            </div>
            <div class="flex justify-center mb-4">
                <p class="text-[11px] italic">*Mohon maaf bila ada kesalahan penulisan nama dan gelar</p>
            </div>
            <div class="flex justify-center">
                <button id="closeModal" class="px-4 py-2 bg-[#755f4B] text-white rounded-lg hover:bg-gray-500">
                    Buka Undangan
                </button>
            </div>

        </div>
    </div>

    <!-- content -->
    <div class=" md:w-[640px] w-full bg-[#F7F4EF] mx-auto">
        <!-- cover -->
        <div class="cover h-full  w-full  mx-auto ">

            <div class="w-full h-[500px] relative flex bg-no-repeat bg-cover bg-center"
                style="background-image: url('{{ asset('tema/standtheme/assets/img/cover.jpg') }}');">

                <div class="top-0 h-10 w-full justify-center py-2  flex text-center items-center bg-white rounded-b-lg">
                    <img src="{{ asset('tema/standtheme/assets/img/logo_akanikah.png') }}"
                        class="object-cover object-center h-8 my-2 " alt="">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="bottom-0 absolute " viewBox="0 0 1440 320">
                    <path fill="#F7F4EF" fill-opacity="1"
                        d="M0,192L480,256L960,128L1440,64L1440,320L960,320L480,320L0,320Z"></path>
                </svg>
            </div>

        </div>

        <!-- opening -->
        <div class="opening mt-20 h-auto w-full bg-[#F7F4EF] ">
            <div class="flex flex-col justify-center ">
                <div class="justify-center flex">
                    <img src="{{ asset('tema/standtheme/assets/img/bismillah.png') }}" data-aos="fade-up"
                        data-aos-duration="3000" class=" " alt="">
                </div>
                <div class="text-center max-w-2xl  p-8 text-[12px] md:text-lg text-[#755f4B]">
                    <h1 class="text-2xl font-bold mb-4" data-aos="fade-up" data-aos-duration="3000">Walimatul 'Urs</h1>
                    <p class="text-lg mb-2" data-aos="fade-up" data-aos-duration="1500">Muktarul Laili</p>
                    <p class="text-sm mb-4" data-aos="fade-up" data-aos-duration="1500">Anak pertama dari Bpk. Zaidun &
                        Ny</p>
                    <p class="text-lg mb-2" data-aos="fade-up" data-aos-duration="1500">&</p>
                    <p class="text-lg mb-2" data-aos="fade-up" data-aos-duration="1500">Nida Farida Rahim</p>
                    <p class="text-sm mb-4" data-aos="fade-up" data-aos-duration="1500">Anak ke 4 dari Bpk. Rahim Razaq
                        & Ny</p>
                    <p class="text-lg font-semibold my-6" data-aos="fade-up" data-aos-duration="1500">Save the Date <br>
                        17 Mei 2022</p>

                    <h3 class="text-lg font-semibold uppercase mb-2" data-aos="fade-up" data-aos-duration="1500">
                        Assalamu Alaikum Warahmatullahi Wabarakatuh</h3>
                    <p class="italic mb-6" data-aos="fade-up" data-aos-duration="1500">
                        Ya Allah Ar Rohman Ar Rohim. Sesungguhnya hati ini telah terhimpun dalam cinta dan bertemu dalam
                        taat kepada-Mu.
                        Eratkanlah ikatannya, kekalkanlah kasih sayangnya, berkahilah jalannya dan penuhilah hati ini
                        dengan cahaya-Mu yang tak pernah pudar.
                    </p>
                    <p class="mb-2" data-aos="fade-up" data-aos-duration="1500">
                        Rasa haru dan bahagia terukir di hati kami atas limpahan Rahmat Allah SWT. Kami bersimpuh
                        memohon ridho-Nya untuk melangsungkan resepsi pernikahan putra-putri kami, yang Insya Allah akan
                        dilaksanakan pada:
                    </p>
                    <p class="font-bold" data-aos="fade-up" data-aos-duration="1500">17 Mei 2022</p>
                </div>
            </div>
        </div>

        <!-- undangan -->
        <div class="undangan mt-10 flex flex-col justify-center">
            <h2 class="items-center text-center text-2xl uppercase my-7 text-[#755f4B]" data-aos="fade-up"
                data-aos-duration="1500">
                AKAD NIKAH</h2>
            <div class="grid grid-cols-3 gap-4 items-center mx-12 md:mx-28 text-[12px] md:text-lg" data-aos="fade-up">
                <!-- Kolom 1 -->
                <div class="flex flex-col items-center border-t border-gray-400">
                    <span class="text-gray-600 py-4">SELASA</span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>

                <!-- Kolom 2 -->
                <div class="text-center">
                    <span class="block text-sm text-gray-600">MEI</span>
                    <span class="block text-4xl font-bold text-gray-900">17</span>
                    <span class="block text-sm text-gray-600">2022</span>
                </div>

                <!-- Kolom 3 -->
                <div class="flex flex-col items-center text-center border-t border-gray-400">
                    <span class="text-gray-600 py-4">02:00 AM WIB - <br>SAMPAI 10:00 WITA </span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>
            </div>

            <p class="text-center  mt-8 text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">Jalan Sultan
                Alauddin
                No 47 Makassar</p>

            <h2 class="items-center text-center text-2xl uppercase my-7 text-[#755f4B]" data-aos="fade-up"
                data-aos-duration="1500">
                RESESPSI</h2>
            <div class="grid grid-cols-3 gap-4 items-center mx-12 md:mx-28 text-[12px] md:text-lg" data-aos="fade-up">
                <!-- Kolom 1 -->
                <div class="flex flex-col items-center border-t border-gray-400">
                    <span class="text-gray-600 py-4">SELASA</span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>

                <!-- Kolom 2 -->
                <div class="text-center">
                    <span class="block text-sm text-gray-600">MEI</span>
                    <span class="block text-4xl font-bold text-gray-900">17</span>
                    <span class="block text-sm text-gray-600">2022</span>
                </div>

                <!-- Kolom 3 -->
                <div class="flex flex-col items-center text-center border-t border-gray-400">
                    <span class="text-gray-600 py-4">02:00 AM WIB - <br>SAMPAI 10:00 WITA </span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>
            </div>

            <p class="text-center text-[#755f4B] mt-8" data-aos="fade-up" data-aos-duration="1500">Jalan Sultan
                Alauddin
                No 47 Makassar</p>

            <h2 class="items-center text-center text-2xl uppercase my-7 text-[#755f4B]" data-aos="fade-up"
                data-aos-duration="1500">
                Tundu Mantu</h2>
            <div class="grid grid-cols-3 gap-4 items-center mx-12 md:mx-28 text-[12px] md:text-lg" data-aos="fade-up"
                data-aos-duration="1500">
                <!-- Kolom 1 -->
                <div class="flex flex-col items-center border-t border-gray-400">
                    <span class="text-gray-600 py-4">SELASA</span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>

                <!-- Kolom 2 -->
                <div class="text-center">
                    <span class="block text-sm text-gray-600">MEI</span>
                    <span class="block text-4xl font-bold text-gray-900">17</span>
                    <span class="block text-sm text-gray-600">2022</span>
                </div>

                <!-- Kolom 3 -->
                <div class="flex flex-col items-center text-center border-t border-gray-400">
                    <span class="text-gray-600 py-4">02:00 AM WIB - <br>SAMPAI 10:00 WITA </span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>
            </div>

            <p class="text-center text-[#755f4B] mt-8" data-aos="fade-up" data-aos-duration="1500">Jalan Sultan
                Alauddin
                No 47 Makassar</p>

        </div>

        <!-- himbauan -->
        <div class="himbauan-1 mt-10 flex flex-col justify-center items-center ">
            <!-- Judul Turut Mengundang -->
            <h3 class="text-center text-xl mb-5 font-semibold text-[#755f4B]" data-aos="fade-up"
                data-aos-duration="1500">Turut Mengundang</h3>

            <!-- Daftar Nama -->
            <div class="text-center flex flex-col items-center text-sm md:text-lg space-y-2 text-[#755f4B]"
                data-aos="fade-up" data-aos-duration="1500">
                <p>Muktarul Laili, S.Kom</p>
                <p>Nida Faridah Rahim</p>
                <p>Nida Faridah Rahim</p>
                <p>Nida Faridah Rahim</p>
                <p>Nida Faridah Rahim</p>
            </div>

            <!-- Hitung Mundur -->
            <div class="mt-20">
                <!-- Judul -->
                <h2 class="text-center text-xl font-semibold  md:text-2xl uppercase mb-8 text-[#755f4B]"
                    data-aos="fade-up" data-aos-duration="1500">
                    Hitung Mundur</h2>

                <!-- Kotak Hitung Mundur -->
                <div class="flex flex-row gap-4 justify-center text-white items-center mx-auto" data-aos="fade-up"
                    data-aos-duration="1500">
                    <!-- Hari -->
                    <div class="bg-stone-500 rounded-lg p-5  w-auto flex flex-col justify-center items-center">
                        <h3 class="text-[12px] md:text-2xl font-bold" id="hari">-904</h3>
                        <span class="text-sm">Hari</span>
                    </div>

                    <!-- Jam -->
                    <div class="bg-stone-500 rounded-lg p-5 w-auto flex flex-col justify-center items-center">
                        <h3 class="text-[12px] md:text-2xl font-bold" id="jam">-904</h3>
                        <span class="text-sm">Jam</span>
                    </div>

                    <!-- Menit -->
                    <div class="bg-stone-500 rounded-lg p-5 w-auto flex flex-col justify-center items-center">
                        <h3 class="text-[12px] md:text-2xl font-bold" id="menit">-904</h3>
                        <span class="text-sm">Menit</span>
                    </div>

                    <!-- Detik -->
                    <div class="bg-stone-500 rounded-lg p-5 w-auto flex flex-col justify-center items-center">
                        <h3 class="text-[12px] md:text-2xl font-bold" id="detik">-904</h3>
                        <span class="text-sm">Detik</span>
                    </div>
                </div>

                <!-- Pemberitahuan -->
                <div class="bg-stone-500 rounded-lg mt-10 h-[93px] flex flex-inline items-center justify-center w-full px-8"
                    data-aos="fade-up" data-aos-duration="1500">
                    <p class="text-center text-white text-sm md:text-base">
                        Dimohon untuk para tamu undangan agar tetap mematuhi protokol <br> kesehatan yang berlaku.
                    </p>
                </div>
            </div>
        </div>

        <!-- denah -->
        <div class="denah mt-10">
            <h2 class="text-center text-xl md:text-2xl uppercase mb-8 font-semibold text-[#755f4B]" data-aos="fade-up"
                data-aos-duration="1500">Peta
                Lokasi</h2>
            <div class="relative w-auto h-96 mx-4" data-aos="fade-up" data-aos-duration="1500">
                <iframe class="absolute top-0 left-0 w-full h-full"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12080.73732861526!2d-74.0059418!3d40.7127847!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM40zMDA2JzEwLjAiTiA3NMKwMjUnMzcuNyJX!5e0!3m2!1sen!2sus!4v1648482801994!5m2!1sen!2sus"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                </iframe>
            </div>
        </div>

        <!-- himbauan -->
        <div class="himbauan-2 mt-10 text-[12px] md:text-lg ">
            <div class="bg-stone-500 rounded-lg  flex flex-col items-center justify-center mx-6 relative w-auto py-5"
                data-aos="fade-up" data-aos-duration="1500">
                <p class="text-center text-white ">
                    <strong>7 tamu undangan</strong> merespon akan Menghadiri Acara Pernikahan, Mari kirim konfirmasi
                    kehadiran anda sekarang.
                </p>
                <button type="button" class="bg-yellow-700 hover:bg-yellow-600 p-2 w-auto text-white mt-2">Konfirmasi
                    Kehadiran</button>
            </div>
        </div>

        <!-- album -->
        <div class="album mt-10">
            <h2 class="text-lg md:text-2xl font-semibold uppercase text-center mb-10 text-[#755f4B]"
                data-aos="fade-up" data-aos-duration="1500">Album Wedding</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4 mx-4" data-aos="fade-up" data-aos-duration="1500">
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/3.jpg') }}"
                            class="w-auto object-cover object-center" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/4.jpg') }}" alt=""
                            class="w-auto object-cover object-center">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mx-4">
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/3.jpg') }}"
                            class="w-auto object-cover object-center" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/4.jpg') }}" alt=""
                            class="w-auto object-cover object-center">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mx-4">
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/3.jpg') }}"
                            class="w-auto object-cover object-center" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/4.jpg') }}" alt=""
                            class="w-auto object-cover object-center">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mx-4">
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/3.jpg') }}"
                            class="w-auto object-cover object-center" alt="">
                    </div>
                    <div>
                        <img src="{{ asset('tema/standtheme/assets/img/4.jpg') }}" alt=""
                            class="w-auto object-cover object-center">
                    </div>
                </div>
            </div>
        </div>

        <!-- reveal -->
        <div class="reveal mt-10 mb-10">
            <div class="relative w-auto h-96 mx-4" data-aos="fade-up" data-aos-duration="1500">
                <iframe class="absolute top-0 left-0 w-full h-full"
                    src="https://www.youtube.com/embed/ojvJQK9cqr0?si=09AIIi_biQl4m5RO" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

            <div
                class="bg-stone-500 rounded-lg  flex flex-col items-center justify-center mx-6 relative w-auto py-5 mt-6">
                <p class="text-center text-white " data-aos="fade-up" data-aos-duration="1500">
                    Tanpa mengurangi rasa hormat, untuk melengkapi kebahagiaan pengantin, Anda dapat memberikan tanda
                    kasih dengan transfer ke rekening/emoney berikut :
                </p>
                <p class="mt-6 text-[12px] md:text-lg text-center font-bold text-white" data-aos="fade-up"
                    data-aos-duration="1500">BANK BCA <br>No.Rek/Emoney :
                    45454545343543 <br> a.n : Muktarul Laili</p>
            </div>
        </div>

        <!-- ucapan-->
        <div
            class="ucapan mt-10 pb-10 text-[12px] md:text-base bg-[#D7CEBE] justify-center flex flex-col items-center">

            <h2 class="text-center text-xl md:text-2xl pt-10 font-semibold text-[#755f4B]" data-aos="fade-up"
                data-aos-duration="1500">BERIKAN UCAPAN
            </h2>

            <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 mx-4 mt-10"
                data-aos="fade-up" data-aos-duration="1500">
                <form class="space-y-2" action="#">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    "
                            placeholder="Masukkan nama kamu" required />
                    </div>
                    <div>
                        <label for="ucapan" class="block mb-2 text-sm font-medium text-gray-900 ">Masukan
                            ucapanmu</label>
                        <input type="text" name="ucapan" id="ucapan"
                            placeholder="Berikan ucapan terbaik kamu"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            required />
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Kirim
                        Ucapan</button>

                </form>
            </div>

            <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 mx-4 mt-10 text-[12px] md:text-base mb-5"
                data-aos="fade-up" data-aos-duration="1500">
                <ul class="border-b border-black">
                    <li class="font-semibold">Maryam Altafunnisa </li>
                    <li class="mb-6">Selamat berbahagia semoga dilancarkan acaranya sampai hari H </li>
                </ul>
                <ul class="border-b border-black">
                    <li class="font-semibold">Maryam Altafunnisa </li>
                    <li class="mb-6">Selamat berbahagia semoga dilancarkan acaranya sampai hari H </li>
                </ul>

                <ul class="border-b border-black">
                    <li class="font-semibold">Maryam Altafunnisa </li>
                    <li class="mb-6">Selamat berbahagia semoga dilancarkan acaranya sampai hari H </li>
                </ul>
            </div>
        </div>

        <div class="footer bg-[#755F4B] pb-10 ">
            <p class="text-center text-white pt-10">© Nikah 2025</p>
            <div class="text-center flex flex-row justify-center items-center space-x-2">
                <p class="text-white">Full support by</p>
                <button type="button" class="w-auto p-2 bg-white hover:underline hover:text-red-500 rounded">Wayae
                    Nikah</button>
            </div>
        </div>

    </div>

     <!-- Music -->
    <!-- Sticky Button -->
    <div class="fixed bottom-4 right-0 z-50">
        <button id="bukaModal"
            class="bg-blue-600 text-white px-4 py-2 rounded-s-full shadow-lg hover:bg-blue-700 focus:outline-none">
            Music
        </button>
    </div>

    <!-- Modal -->
    <div id="mod" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <iframe id="videoFrame" width="100%" height="315"
                src="https://www.youtube.com/embed/VDbVXpJWA-k?si=HTH9oH1X5uoS-SUu&amp;start=1"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <button id="tutupModal"
                class="bg-red-600 mt-2 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none">
                Close
            </button>
        </div>
    </div>
    <script>
        const buka = document.getElementById('bukaModal');
        const tutup = document.getElementById('tutupModal');
        const mod = document.getElementById('mod');

        buka.addEventListener('click', () => {
            mod.classList.remove('hidden');
        });

        tutup.addEventListener('click', () => {
            mod.classList.add('hidden');
        });

        // Close modal when clicking outside
        mod.addEventListener('click', (e) => {
            if (e.target === mod) {
                mod.classList.add('hidden');
            }
        });
    </script>

    <script src="{{ asset('tema/standtheme/assets/aos/dist/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>
    <script src="{{ asset('tema/standtheme/js/modal.js') }}"></script>

</body>

</html>
