<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- START Swiper css -->
    <link rel="stylesheet" href="{{ asset('tema/whitepre/assets/swiper/swiper-bundle.min.css') }}">
    <link href="{{ asset('tema/whitepre/src/css/output.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tema/whitepre/src/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/whitepre/src/css/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/whitepre/assets/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/whitepre/assets/aos/dist/aos.css') }}">
    @include('tema.whitepre.styles')
</head>

<body class="whitepre-page relative">

    <!-- cover mobile -->
    <style>
        #cover-mobile {
            isolation: isolate;
            overflow: hidden;
            background-color: #1f1820;
        }

        #cover-mobile::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(17, 14, 22, 0.18) 0%, rgba(17, 14, 22, 0.08) 28%, rgba(17, 14, 22, 0.42) 62%, rgba(17, 14, 22, 0.86) 100%);
            z-index: 1;
        }

        #cover-mobile::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 24%, rgba(255, 255, 255, 0.2), transparent 34%);
            z-index: 1;
            pointer-events: none;
        }

        #cover-mobile>.whitepre-cover-content {
            position: relative;
            z-index: 2;
            min-height: 100dvh;
            padding: clamp(2.5rem, 9vh, 5rem) 1.25rem 6.5rem;
            text-shadow: 0 3px 16px rgba(0, 0, 0, 0.58);
        }

        .whitepre-cover-content h3 {
            padding: 0.65rem 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.52);
            border-radius: 999px;
            background: rgba(20, 16, 24, 0.34);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.2), inset 0 1px rgba(255, 255, 255, 0.25);
            letter-spacing: 0.08em;
            font-size: clamp(1rem, 4.8vw, 1.5rem);
        }

        .whitepre-cover-title {
            max-width: 100%;
            color: #fffaf5;
            text-shadow: 0 4px 22px rgba(0, 0, 0, 0.72);
        }

        .whitepre-cover-date {
            margin-top: 0.75rem;
            padding: 0.35rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.55);
            border-bottom: 1px solid rgba(255, 255, 255, 0.55);
            letter-spacing: 0.18em;
            font-weight: 600;
        }

        #open-cover {
            position: absolute;
            left: 50%;
            bottom: clamp(2.5rem, 7vh, 4.5rem);
            min-width: 12rem;
            transform: translateX(-50%);
            padding: 0.85rem 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 999px;
            color: #2b1c1b;
            background: linear-gradient(135deg, #fffdf9 0%, #f4dfcb 100%);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.32), 0 0 0 5px rgba(255, 255, 255, 0.12);
            text-shadow: none;
            animation: whitepre-cover-breathe 2.4s ease-in-out infinite;
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        #open-cover:hover,
        #open-cover:focus-visible {
            transform: translateX(-50%) translateY(-3px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.36), 0 0 0 6px rgba(255, 255, 255, 0.18);
        }

        @keyframes whitepre-cover-breathe {

            0%,
            100% {
                transform: translateX(-50%) translateY(0);
            }

            50% {
                transform: translateX(-50%) translateY(-5px);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #open-cover {
                animation: none;
            }
        }
    </style>
    <div id="cover-mobile" class="h-full w-full font-poppins fixed lg:hidden block z-50 text-white"
        style="background-image: url('{{ asset('tema/whitepre/src/img/bg-kanan.jpg') }}'); background-size: cover; background-position: center;">
        <div class="whitepre-cover-content w-full flex justify-center items-center flex-col">
            <h3 class="text-center font-semibold text-2xl pt-10" data-aos="fade-down" data-aos-easing="linear"
                data-aos-duration="1500">The Wedding Of</h3>
            <h2 class="whitepre-cover-title mt-8 text-center text-[50px] font-light  font-great_vibes"
                data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
                Mekar <span class="font-poppins text-[25px]">&</span> Versa
            </h2>
            <p class="whitepre-cover-date text-center text-[20px]" data-aos="fade-zoom-in"
                data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">02 . 04 . 2025</p>

            <button id="open-cover" class="font-semibold">
                Buka Undangan
            </button>
        </div>
    </div>

    <!-- konten -->
    <div class="whitepre-shell flex flex-row z-10 relative">
        <!-- Bagian kiri  -->
        <aside class="whitepre-left-panel lg:w-3/5 md:h-screen lg:fixed z-20" aria-label="Panel foto undangan">
            <!-- opening  -->
            <div class="whitepre-left-image z-50 w-full h-full brightness-50 contrast-100 saturate-100"
                style="background-image: url('{{ asset('tema/whitepre/src/img/bg-kiri.jpg') }}'); background-size: cover; background-position: center;">
            </div>
            <h2
                class="whitepre-left-title absolute bottom-12 left-14 text-[50px] text-white font-great_vibes hidden lg:block">
                Mekar<span class="font-poppins text-[25px]"> & </span> Versa</h2>

            <!-- music -->
            <div id="youtube-player" class="hidden invisible z-10 absolute inset-0">
                <iframe id="videoFrame" width="240" height="240"
                    src="https://www.youtube.com/embed/sy0LqD9EA7A?si=59Ql_kVZl3TaSU3m&amp?enablejsapi=1"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>
            </div>
            <!-- Toggle Button -->
            <button id="musicToggle" type="button" aria-label="Putar atau jeda musik"
                class="whitepre-float-control whitepre-float-control--music fixed lg:absolute rounded-full w-10 h-10 top-10 right-2 z-50 flex items-center justify-center text-xl transition duration-300">
                <span id="audio-status" class="text-white">
                    <i class="fa-solid fa-play"></i>
                </span>
            </button>
            <!-- music -->

            <!-- sumbangan -->
            <button onclick="toggleModal()" type="button" aria-label="Buka informasi kado"
                class="whitepre-float-control whitepre-float-control--gift fixed lg:absolute rounded-full w-14 h-14 top-28 right-2 lg:right-5 z-50 flex items-center justify-center text-2xl transition duration-300">
                <i class="fa-solid fa-wallet text-white"></i>
            </button>

            <!-- Modal -->
            <div id="infoModal"
                class="invisible fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 font-poppins">
                <div class="bg-orange-50 rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Kado</h2>
                    <p class="text-gray-600 mb-4">Berikut adalah informasi untuk mengirimkan kado atau hadiah secara
                        online atau
                        melalui pengiriman fisik:</p>
                    <ul class="text-left text-gray-700 mb-6 flex flex-col items-center text-sm">
                        <li class="mb-2"><strong>Qris</strong></li>
                        <li class="mb-2 text-center"><img src="{{ asset('tema/whitepre/src/img/dana.png') }}"
                                alt="DANA" class="w-32"></li>
                        <li class="mb-2 "><strong>Nama Akun/Rekening:</strong> Eli</li>
                        <li><strong>Nomor Akun/Rekening:</strong> 085763561698</li>
                    </ul>
                    <button
                        class="whitepre-close-button bg-pink-800 text-white px-4 py-2 hover:bg-pink-900 transition duration-300"
                        onclick="toggleModal()">Tutup</button>
                </div>
            </div>
            <!-- sumbangan -->

            <!-- Navbar -->
            <nav class="whitepre-side-nav navbar hidden lg:block lg:absolute lg:right-8 lg:top-72 lg:w-9 h-auto bg-orange-50 rounded-full shadow-lg z-40"
                id="desktop-navbar">
                <div class=" py-3 relative">
                    <div class="flex flex-col justify-center items-center w-full text-pink-800 text-sm gap-3">
                        <a class="nav-link  couple flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#couple">
                            <i class="fa-regular fa-heart"></i>
                            <span class="ml-2 hidden">couple</span>
                        </a>
                        <a class="nav-link  gallery flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#gallery">
                            <i class="fa-regular fa-images"></i>
                            <span class="ml-2 hidden">gallery</span>
                        </a>
                        <a class="nav-link   date  flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#date">
                            <i class="fa-regular fa-calendar"></i>
                            <span class="ml-2 hidden">date</span>
                        </a>
                        <a class="nav-link  location flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#location">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span class="ml-2 hidden">location</span>
                        </a>

                        <a class="nav-link  wishes flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#wishes">
                            <i class="fa-regular fa-note-sticky"></i>
                            <span class="ml-2 hidden">wishes</span>
                        </a>
                    </div>
                </div>
            </nav>
            <!-- Navbar -->

        </aside>

        <!-- Bagian kanan -->
        <main class="whitepre-content-panel w-full lg:w-2/5 h-full relative items-center text-white ml-auto z-10">

            <!-- opening -->
            <section id="whitepre-hero" class="whitepre-hero" aria-label="Pembuka undangan">
                <div class="whitepre-hero-media"
                    style="background-image: url('{{ asset('tema/whitepre/src/img/bg-kanan.jpg') }}');"
                    aria-hidden="true"></div>
                <div class="whitepre-hero-content">
                    <p class="whitepre-hero-eyebrow" data-aos="fade-down">The Wedding Of</p>
                    <h1 class="whitepre-hero-title font-great_vibes" data-aos="fade-up" data-aos-delay="120">
                        Mekar <span class="font-poppins text-[25px]">&amp;</span> Versa
                    </h1>
                    <p class="whitepre-hero-date" data-aos="fade-up" data-aos-delay="220">02 . 04 . 2025</p>
                </div>
                <div class="whitepre-scroll-cue" aria-hidden="true">
                    <div class="whitepre-scroll-mouse"></div>
                    <span>Scroll ke bawah</span>
                </div>
                <svg class="whitepre-wave" viewBox="0 0 1440 320" preserveAspectRatio="none" aria-hidden="true">
                    <path fill="#fff8ef"
                        d="M0,64L60,80C120,96,240,128,360,122.7C480,117,600,75,720,80C840,85,960,139,1080,154.7C1200,171,1320,149,1380,138.7L1440,128L1440,320L0,320Z">
                    </path>
                </svg>
            </section>
            <!-- End opening -->

            <!-- pembatas -->
            <div class="whitepre-divider bg-orange-50 pt-10 section flex justify-center"><img
                    src="{{ asset('tema/whitepre/src/img/pembatas_bunga.png') }}" class="max-w-[350px] max-h-[200px]"
                    alt="" data-aos="fade-up" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
            </div>

            <!-- Kutipan Al-Qur'an -->
            <section class="whitepre-section bg-orange-50 w-full p-10" aria-label="Kutipan pernikahan">

                <div class="whitepre-quote-card rounded-md bg-pink-800 text-white font-poppins italic">
                    <p>Tidak ada solusi yang lebih baik bagi dua insan yang saling mencintai dibanding pernikahan
                        <span>-HR.Ibnu Majah</span>
                    </p>
                </div>
            </section>

            <!-- pembatas -->
            <div class="whitepre-divider bg-orange-50 flex justify-center"><img
                    src="{{ asset('tema/whitepre/src/img/pembatas_bunga.png') }}" class="max-w-[350px] max-h-[200px]"
                    alt="" data-aos="fade-down" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
            </div>

            <!-- pasangan -->
            <section id="couple"
                class="whitepre-section whitepre-couple-section bg-orange-50 relative font-great_vibes section"
                style="background-image: url('{{ asset('tema/whitepre/src/img/bg_1.png') }}');">
                <!-- card 1 -->
                <article class="whitepre-couple-card flex flex-col justify-center items-center"
                    style="background-image: url('{{ asset('tema/whitepre/src/img/bunga.png') }}'); background-position: center; background-size: contain;">
                    <div class="" data-aos="flip-left" data-aos-easing="ease-out-cubic"
                        data-aos-duration="2000"><img src="{{ asset('tema/whitepre/src/img/mekar.png') }}"
                            alt=""
                            class="object-cover object-center aspect-square rounded-full max-w-[350px] "
                            alt="Foto Mekar Saraswati">
                    </div>
                    <h3 class="whitepre-couple-name text-[40px] text-center text-pink-800 font-semibold pt-5">Mekar
                        Saraswati Dwiningtyas, A.Md.Keb.
                    </h3>
                    <div class="flex flex-col text-center items-center justify-center space-x-4 font-poppins">
                        <div class="whitepre-couple-bio text-pink-800">
                            <p class="font-semibold text-[13px] space-y-5">Putri dari <br> Bapak Akbar S.Kom <br> &amp;
                                Ibu Siti S.Pd</p>
                        </div>
                    </div>
                </article>

                <div
                    class="whitepre-couple-ampersand text-center text-4xl font-poppins text-pink-800 py-5 pb-8 font-semibold">
                    &amp;</div>

                <!-- card 2 -->
                <article class="whitepre-couple-card flex flex-col justify-center items-center">
                    <div class="" data-aos="flip-right" data-aos-easing="ease-out-cubic"
                        data-aos-duration="2000"><img src="{{ asset('tema/whitepre/src/img/versa.png') }}"
                            alt=""
                            class="object-cover object-center aspect-square rounded-full max-w-[350px] "
                            alt="Foto Andiky Versa">
                    </div>
                    <h3 class="whitepre-couple-name text-[40px] text-center text-pink-800 font-semibold pt-5">Andiky
                        Versa Djito Saputro, A.Md.Kep</h3>
                    <div class="flex flex-col text-center items-center justify-center  font-poppins">
                        <div class="whitepre-couple-bio text-pink-800">
                            <p class="font-semibold text-[13px] space-y-5">Putra dari <br> Bapak Akbar S.Kom <br> &amp;
                                Ibu Siti S.Pd</p>
                        </div>
                    </div>
                </article>

            </section>
            <!-- pasangan -->

            <!-- story -->
            <section
                class="whitepre-section whitepre-story-section w-full bg-orange-50 text-pink-800 font-poppins section overflow-x-hidden"
                style="background-image: url('{{ asset('tema/whitepre/src/img/bunga.png') }}'); background-position: center; background-size: contain; background-repeat: repeat-y;">
                <h2
                    class="whitepre-section-heading text-center text-[50px] font-great_vibes z-50 font-semibold mb-6 py-8">
                    Story</h2>
                <div class="swiper_2 swiperStory mt-8">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide whitepre-story-slide">
                            <img src="{{ asset('tema/whitepre/src/img/story-1.jpg') }}" alt="Cerita pertama"
                                class="object-cover object-center cursor-pointer" onclick="openModalImg(this)">
                            <div class="whitepre-story-line" aria-hidden="true"></div>
                            <p class="whitepre-story-copy">Pertama kita bertemu di tahun baru tahun 2014</p>
                        </div>

                        <div class="swiper-slide whitepre-story-slide"> <img
                                src="{{ asset('tema/whitepre/src/img/story-2.jpeg') }}" alt="Cerita kedua"
                                class="object-cover object-center cursor-pointer" onclick="openModalImg(this)">
                            <div class="whitepre-story-line" aria-hidden="true"></div>
                            <p class="whitepre-story-copy">15 November 2020</p>
                        </div>
                        <div class="swiper-slide whitepre-story-slide"> <img
                                src="{{ asset('tema/whitepre/src/img/story-3.jpeg') }}" alt="Cerita ketiga"
                                class="object-cover object-center cursor-pointer" onclick="openModalImg(this)">
                            <div class="whitepre-story-line" aria-hidden="true"></div>
                            <p class="whitepre-story-copy">29 November 2023</p>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>
            <!-- story -->

            <!-- Galery -->
            <section id="gallery" class="whitepre-section w-full bg-orange-50 text-pink-800 font-poppins section">
                <h2 class="whitepre-section-heading font-great_vibes" data-aos="fade-up">Momen Berharga</h2>
                <p class="whitepre-section-lead">Menciptakan kenangan adalah hadiah yang tak ternilai harganya.
                    Kenangan akan bertahan seumur hidup; benda-benda hanya dalam waktu singkat.</p>
                <div class="whitepre-gallery-grid">
                    <button type="button" class="text-left" onclick="openModalImg(this.querySelector('img'))"><img
                            src="{{ asset('tema/whitepre/src/img/story-1.jpg') }}" alt="Momen foto 1"
                            loading="lazy"></button>
                    <button type="button" class="text-left" onclick="openModalImg(this.querySelector('img'))"><img
                            src="{{ asset('tema/whitepre/src/img/story-3.jpeg') }}" alt="Momen foto 2"
                            loading="lazy"></button>
                    <button type="button" class="text-left" onclick="openModalImg(this.querySelector('img'))"><img
                            src="{{ asset('tema/whitepre/src/img/story-2.jpeg') }}" alt="Momen foto 3"
                            loading="lazy"></button>
                    <button type="button" class="text-left" onclick="openModalImg(this.querySelector('img'))"><img
                            src="{{ asset('tema/whitepre/src/img/story-2.jpeg') }}" alt="Momen foto 4"
                            loading="lazy"></button>
                    <button type="button" class="text-left" onclick="openModalImg(this.querySelector('img'))"><img
                            src="{{ asset('tema/whitepre/src/img/story-1.jpg') }}" alt="Momen foto 5"
                            loading="lazy"></button>
                    <button type="button" class="text-left" onclick="openModalImg(this.querySelector('img'))"><img
                            src="{{ asset('tema/whitepre/src/img/story-3.jpeg') }}" alt="Momen foto 6"
                            loading="lazy"></button>
                </div>
            </section>
            <!-- end gallery -->


            <!-- Akad -->
            <section class="whitepre-section bg-orange-50 relative pt-10 pb-16 text-pink-800 font-poppins section"
                id="date">
                <!-- Judul -->
                <h2
                    class="whitepre-section-heading text-center text-[40px] z-50 relative font-semibold mb-6 font-great_vibes">
                    Acara Akan Diselenggarakan
                </h2>
                <!-- Gambar Hiasan Kiri -->
                <div class="whitepre-countdown" aria-label="Hitung mundur">
                    <div class="whitepre-countdown-item" data-aos="zoom-in"><span id="days"
                            class="whitepre-countdown-value">00</span><span
                            class="whitepre-countdown-label">Hari</span></div>
                    <div class="whitepre-countdown-item" data-aos="zoom-in" data-aos-delay="100"><span
                            id="hours" class="whitepre-countdown-value">00</span><span
                            class="whitepre-countdown-label">Jam</span></div>
                    <div class="whitepre-countdown-item" data-aos="zoom-in" data-aos-delay="200"><span
                            id="minutes" class="whitepre-countdown-value">00</span><span
                            class="whitepre-countdown-label">Menit</span></div>
                    <div class="whitepre-countdown-item" data-aos="zoom-in" data-aos-delay="300"><span
                            id="seconds" class="whitepre-countdown-value">00</span><span
                            class="whitepre-countdown-label">Detik</span></div>
                </div>

                <!-- Tanggal -->
                <div class="whitepre-date-line text-center text-[12px] text-pink-800" id="countdown"
                    data-aos="zoom-in" data-aos-duration="2500">
                    Rabu, 2 April 2025
                </div>

                <!-- button -->
                <div class="text-center pt-5 ">
                    <a href="#"
                        class="whitepre-calendar-button rounded-full border border-orange-200 py-1 px-2 text-[13px]"><i
                            class="fa-solid fa-calendar-days mr-2"></i>Simpan acara ke kalender</a>
                </div>
            </section>
            <!-- end akad -->

            <!-- resepsi -->
            <section id="location" class="whitepre-section bg-orange-50 relative text-pink-800 w-full font-poppins"
                style="background-image: url('{{ asset('tema/whitepre/src/img/border.png') }}'); background-position: center; background-size: cover;">
                <h2 class="whitepre-section-heading font-great_vibes">Detail Acara</h2>
                <div class="whitepre-event-list">
                    <article class="whitepre-event-card">
                        <h2>Marriage Contract</h2>
                        <div class="whitepre-event-details">
                            <div>Jumat, 15 Oktober 2021</div>
                            <div>pukul 09.00 WIB - selesai</div>
                            <div>Jalan Kemuning Raya, di Masjid Al Barokah</div>
                        </div>
                        <a href="#" class="whitepre-map-button mt-5"><i
                                class="fa-solid fa-map-location-dot"></i>Lihat lokasi</a>
                    </article>
                    <article class="whitepre-event-card">
                        <h2>Resepsi</h2>
                        <div class="whitepre-event-details">
                            <div>Jumat, 15 Oktober 2021</div>
                            <div>pukul 09.00 WIB - selesai</div>
                            <div>Jalan Kemuning Raya, di Masjid Al Barokah</div>
                        </div>
                    </article>
                    <article class="whitepre-event-card">
                        <h2>Unduh Mantu</h2>
                        <div class="whitepre-event-details">
                            <div>Jumat, 15 Oktober 2021</div>
                            <div>pukul 09.00 WIB - selesai</div>
                            <div>Jalan Kemuning Raya, di Masjid Al Barokah</div>
                        </div>
                        <a href="#" class="whitepre-map-button mt-5"><i
                                class="fa-solid fa-map-location-dot"></i>Lihat lokasi</a>
                    </article>
                </div>
            </section>
            <!-- resepsi -->

            <!-- turut mengundang -->
            <section class="whitepre-section w-full text-center text-pink-800 bg-orange-50"
                style="background-image: url('{{ asset('tema/whitepre/src/img/bunga.png') }}'); background-position: center; background-size: contain;">
                <p class="whitepre-invitation-note text-center w-full pt-14 pb-10 font-light lg:text-sm text-[11px]">
                    Merupakan suatu kehormatan dan
                    kebahagiaan bagi
                    kami <br> apabila,
                    Saudara
                    / i. berkenan hadir untuk memberikan do'a <br> restunya kami ucapkan terimakasih.
                </p>

                <div class="whitepre-guest-list flex flex-col justify-center items-center space-y-3 text-sm">
                    <p class="text-xl font-semibold">Turut Mengundang:</p>
                    <p>Keluarga Besar Sujono</p>
                    <p>Keluarga Besar Emence</p>
                    <p>Teman SMK 1 Negeri</p>
                </div>
            </section>
            <!-- turut mengundang -->



            <!-- ucapan -->
            <section id="wishes"
                class="whitepre-section whitepre-wishes-section w-full bg-orange-50 text-pink-800 relative z-50">
                <h2 class="whitepre-section-heading text-center text-[50px] font-semibold mb-6 py-8 font-great_vibes">
                    Ucapan &amp; Doa</h2>
                <div class="flex justify-center left-0  absolute  z-10">
                    <img src="{{ asset('tema/whitepre/src/img/bunga.png') }}" alt="Hiasan Bunga"
                        class="w-20 lg:w-32 ">
                </div>

                <!-- Gambar Hiasan Tengah -->
                <div class="flex justify-center left-0 rotate-x-180  absolute  z-10">
                    <img src="{{ asset('tema/whitepre/src/img/bunga bawah.png') }}" alt="Hiasan Bunga"
                        class="w-20 lg:w-32  ">
                </div>


                <div
                    class="whitepre-message-list p-6 h-[300px] rounded-lg shadow-lg space-y-5 overflow-y-auto z-50 relative font-poppins">
                    <!-- AT -->
                    <div class="whitepre-message-card p-4 rounded-md h-auto shadow-md shadow-slate-200 bg-orange-50">
                        <h3 class="text-[14px] font-semibold">AT (Andy Tengil)</h3>
                        <p class="text-[12px] ">Thursday, 06 03 2025</p>
                        <p class="mt-2 text-[12px] italic">"Mantap antap"</p>
                    </div>

                    <!-- ST -->
                    <div class="whitepre-message-card p-4 rounded-md shadow-md shadow-slate-200 h-auto bg-orange-50">
                        <h3 class="text-[14px] font-semibold">ST (Selamat Tembak Dalam Coy)</h3>
                        <p class="text-[12px] ">Thursday, 06 03 2025</p>
                        <p class="mt-2  italic">"Selamat Ya"</p>
                    </div>

                    <!-- R -->
                    <div class="whitepre-message-card p-4 rounded-md shadow-md shadow-slate-200 h-auto bg-orange-50">
                        <h3 class="text-[14px] font-semibold">R (Ronald)</h3>
                        <p class="text-[12px] ">Thursday, 06 03 2025</p>
                        <p class="mt-2 text-[12px] italic">
                            "Selamat mengarungi kehidupan berumah tangga Bajuri & Ijah.. Langgeng terus sampai kapan
                            pun"
                        </p>
                    </div>
                </div>
            </section>


            <section
                class="whitepre-section whitepre-wishes-section w-full bg-orange-50 text-pink-800 p-6 shadow-lg relative section">
                <div class="whitepre-form-card">
                    <h4 class="whitepre-form-title text-2xl font-semibold mb-4 relative z-50 font-great_vibes">Kirim
                        Ucapan</h4>
                    <p class="whitepre-form-intro">Tinggalkan doa dan ucapan terbaik untuk kedua mempelai.</p>
                    <!-- Gambar Hiasan Tengah -->
                    <div class="whitepre-form-decoration flex justify-center right-0 -rotate-180 absolute z-10">
                        <img src="{{ asset('tema/whitepre/src/img/bunga bawah.png') }}" alt="Hiasan Bunga"
                            class="w-20 lg:w-32 ">
                    </div>
                    <form action="" class="whitepre-wish-form space-y-4 relative z-50">
                        <!-- Input Nama -->
                        <input type="text" name="nama" placeholder="Nama Lengkap"
                            class="whitepre-form-input w-full p-3 rounded-md bg-slate-300 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-black" />

                        <!-- Textarea Ucapan -->
                        <textarea name="pesan" placeholder="Ucapan & Doa" rows="4"
                            class="whitepre-form-input w-full p-3 rounded-md bg-slate-300 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-black"></textarea>

                        <!-- Select Konfirmasi Kehadiran -->
                        <select name="konfirmasi"
                            class="whitepre-form-input w-full p-3 rounded-md bg-slate-300 text-black focus:outline-none focus:ring-2 focus:ring-black">
                            <option value="">Konfirmasi Kehadiran</option>
                            <option value="datang">Datang Dong</option>
                            <option value="tidak_datang">Tidak Bisa Datang Nih</option>
                            <option value="diusahakan">Diusahakan Datang Ya</option>
                        </select>

                        <!-- Button Kirim -->
                        <button type="submit"
                            class="whitepre-submit-button w-full rounded-full bg-orange-200 text-black font-semibold p-3 hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                            Kirim Sekarang
                        </button>
                    </form>
                </div>
            </section>

            <footer
                class="whitepre-footer text-center text-pink-800 text-[10px] bg-orange-50 pt-6 lg:pt-12 pb-24 lg:pb-5">
                presented by <br> <span class="font-semibold">Wayae Nikah</span>
            </footer>
            <!-- ucapan -->

            <!-- Navbar mobile -->
            <nav class="whitepre-mobile-nav navbar block lg:hidden fixed bottom-3 ring-1 ring-offset-2 ring-white inset-x-0 w-auto h-auto mx-2 bg-orange-50 rounded-full shadow-lg z-50"
                id="mobile-navbar">
                <div class=" py-3 relative">
                    <div class="flex flex-row  justify-center items-center w-full text-pink-800 text-sm gap-3">
                        <a class="nav-link  couple flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#couple">
                            <i class="fa-regular fa-heart"></i>
                            <span class="ml-2 hidden">couple</span>
                        </a>

                        <a class="nav-link  gallery flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#gallery">
                            <i class="fa-regular fa-images"></i>
                            <span class="ml-2 hidden">gallery</span>
                        </a>
                        <a class="nav-link   date  flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#date">
                            <i class="fa-regular fa-calendar"></i>
                            <span class="ml-2 hidden">date</span>
                        </a>

                        <a class="nav-link  location flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#location">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span class="ml-2 hidden">location</span>
                        </a>
                        <a class="nav-link  wishes flex items-center justify-start text-pink-800 hover:bg-orange-50 hover:text-black px-2 py-1 rounded-full transition duration-200"
                            href="#wishes">
                            <i class="fa-regular fa-note-sticky"></i>
                            <span class="ml-2 hidden">wishes</span>
                        </a>
                    </div>
                </div>
            </nav>
            <!-- Navbar -->
        </main>

        <!-- Modal Image -->
        <div id="imageModal"
            class="fixed hidden inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center transition-all duration-300 ease-in-out">
            <div class="relative">
                <img id="modalImageContent" class="max-w-full max-h-screen rounded-lg shadow-xl py-11" src=""
                    alt="Modal Image" />
                <button onclick="closeModalImg()" aria-label="Tutup gambar"
                    class="absolute top-2 right-2 text-white bg-sky-500 hover:bg-slate-600 rounded-lg py-1 px-3 focus:outline-none">
                    &times;
                </button>
            </div>
        </div>

    </div>
    <!-- konten -->

    <!-- aos -->

    <!-- aos -->
    <script src="{{ asset('tema/whitepre/assets/aos/dist/aos.js') }}"></script>

    <!-- Swiper -->
    <script src="{{ asset('tema/whitepre/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/whitepre/assets/swiper/swiper-element-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/whitepre/src/js/swiper.js') }}"></script>

    <!-- nav -->
    <script src="{{ asset('tema/whitepre/src/js/nav.js') }}"></script>
    <!-- modal -->
    <script src="{{ asset('tema/whitepre/src/js/modal.js') }}"></script>
    <!-- audio -->
    <script src="{{ asset('tema/whitepre/src/js/audio.js') }}"></script>
    <script src="{{ asset('tema/whitepre/src/js/setDate.js') }}"></script>
    <script>
        AOS.init({
            duration: 850,
            easing: 'ease-out-cubic',
            once: true,
            offset: 70
        });
    </script>


</body>

</html>
