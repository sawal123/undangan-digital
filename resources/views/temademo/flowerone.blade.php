<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    

    <title>Flower One</title>

    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('tema/flowerone/assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Start Google Fonts -->
    <!-- ICONS -->
    <link rel="stylesheet" href="{{ asset('tema/flowerone/assets/fontawesome-free/css/all.min.css') }}">
    <!-- START Swiper css -->
    <link rel="stylesheet" href="{{ asset('tema/flowerone/assets/swiper/swiper-bundle.min.css') }}">
    <!-- End Swiper css -->
    <!-- AOS -->
    <link rel="stylesheet" href="{{ asset('tema/flowerone/assets/aos/dist/aos.css') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/cover.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/jumbotron.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/detail-pasangan.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/event.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/timeline.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/reservasi.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/message.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/flowerone/style/ending-section.css') }}">

    <!-- Custom Style Index-->
    <style>
        @font-face {
            font-family: 'Dancing Scriptt';
            src: url('{{ asset('tema/flowerone/assets/fonts/Dancing_Script/DancingScript-VariableFont_wght.ttf') }}') format('truetype');
            font-weight: 100 900;
            font-style: normal;
        }


        @font-face {
            font-family: 'Great Vibes';
            src: url('{{ asset('tema/flowerone/assets/fonts/Great_Vibes/GreatVibes-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Philosopher';
            src: url('{{ asset('tema/flowerone/assets/fonts/Philosopher/Philosopher-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            background-color: #FFD3E9;
            /* background: linear-gradient(135deg, #f8cdda 0%, #1d2b64 100%); */
            font-family: 'Philosopher';
            color: #333;
        }

        h3 {
            font-size: 30px;
            font-weight: 700;
            font-family: "Great Vibes", cursive;
            color: #9e0050;
            margin-bottom: 30px;
        }

        .container {
            margin-top: 1rem;
        }

        .rounded-card {
            background-color: white;
            padding: 1rem;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body class="position-relative ">
    <!-- COVER -->
    <div class="min-vh-100 position-fixed top-0 left-0 w-100 d-block align-content-center"
        style="background-color: pink; z-index: 9999;" id="cover">
        <div class="text-center mt-3">
            <img src="{{ asset('tema/flowerone/img/flower-top.png') }}" class="flower-img img-fluid"
                alt="Flower decoration">
        </div>
        <div data-aos="zoom-in" data-aos-duration="1500" class="text-center d-flex flex-column align-items-center">
            <div class="text-center mt-2">
                <h4 class="header-text">The Wedding Off</h4>
                <p class="main-text" style="font-size: 50px; font-family: Great Vibes, cursive;">Ajeng & Teddy</p>
            </div>

            <div class="row text-center d-flex justify-content-center align-items-center my-0"
                style="max-width: 500px;">
                <div class="col-4 text-end">
                    <p class="main-text ">Minggu</p>
                </div>
                <div class="col-4">
                    <p class="fs-1 fw-normal">| <small class="fs-6 fw-bold">11</small> |</p>
                </div>
                <div class="col-4 text-start main-text">
                    <p>November</p>
                </div>
                <div>
                    <p style="font-size: 30px;">2024</p>
                </div>
            </div>

            <div class="text-center my-0 py-0">
                <h4 class="header-text">Kepada:</h4>
                <p class="main-text">Yth. Bapak/Ibu/Saudara/i</p>
                <p class="main-text" style="font-size: 20px !important;">Melisa</p>
            </div>

            <div class="text-center my-0">
                <button type="button" class="btn text-white button-style" id="openCover">Buka Undangan</button>
            </div>
        </div>

        <div class="text-center mt-3">
            <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="flower-pembatas img-fluid"
                alt="Flower divider">
        </div>
    </div>
    <!-- COVER -->

    <!-- Modal -->
    <!-- Tombol vertikal di pojok kanan -->
    <div class="position-fixed d-flex flex-column z-3"
        style="right: -35px; top: 400px; gap: 70px; z-index: 1; height: 100px; ">
        <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#musicModal" id="link"
            style="transform: rotate(90deg); background-color: #9e0050;"><i class="fa-solid fa-music"></i>
            Music
        </button>
        <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#qrcodeModal"
            style="transform: rotate(90deg); background-color: #9e0050;"><i class="fa-solid fa-qrcode"></i>
            QR Code
        </button>
    </div>
    <!-- Tombol vertikal di pojok kanan -->

    <!-- Modal untuk Music -->
    <div class="modal fade" id="musicModal" tabindex="-1" aria-labelledby="musicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="musicModalLabel">Music</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <iframe id="videoFrame" width="100%" height="315"
                        src="https://www.youtube.com/embed/VDbVXpJWA-k?si=HTH9oH1X5uoS-SUu&amp;start=1"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                    <!-- Toggle Play/Pause button -->
                    <div class="mt-3 text-center d-flex justify-content-center">
                        <button id="toggleButton" class="btn custom-toggle-btn rounded-circle">
                            <i class="fa-solid fa-pause"></i>
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-5"><i
                            class="fa-brands fa-youtube mx-1"></i>Subscribe
                        Youtube</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk QR Code -->
    <div class="modal fade" id="qrcodeModal" tabindex="-1" aria-labelledby="qrcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="qrcodeModalLabel">QR Code Check-In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100 py-3 border border-info rounded-3 text-success text-center">
                        <p class="fs-6"><strong>Kamu Sudah Check In</strong></p>
                        <button type="button" class="btn btn-success text-white h-25" style="">
                            <small>Tampilkan QR Check-In</small>
                        </button>
                    </div>

                    <div class="w-100 text-center my-4">
                        <p class="fs-5">Gunakan QR untuk Check-In</p>
                        <img src="{{ asset('tema/flowerone/img/qr-1.jpg') }}" alt="QR Code"
                            class="img-fluid rounded ">
                    </div>

                    <div class="w-100 text-center">
                        <h5 class="text-primary">Melisa</h5>
                        <p class="text-muted">ID: 2345234</p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="background-color: #9e0050;">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- RSVP Modal -->
    <div class="modal fade" id="modalRSV1" tabindex="-1" aria-labelledby="modalRSVLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header" style="background-color: #9e0050;">
                    <h1 class="modal-title fs-5 text-white" id="modalRSVLabel1">Konfirmasi Kehadiran</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="guestCount1" class="form-label">Jumlah Orang (Maksimal 2):</label>
                    <input type="number" id="guestCount1" class="form-control" min="1" max="2"
                        placeholder="Masukkan jumlah orang">
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn text-white w-100 mx-2" data-bs-dismiss="modal"
                        style="background-color: #9e0050; ">
                        Tidak Hadir
                    </button>
                    <button type="button" class="btn text-white w-100 mx-2" style="background-color: #9e0050; ">
                        Konfirmasi Hadir
                    </button>
                    <button type="button" class="btn  w-100 mx-2" data-bs-dismiss="modal"
                        style="border-color: #9e0050; color: #9e0050;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- Navbar -->
    <nav class="navbar fixed-bottom mx-5 bg-white rounded-top-2 shadow-lg" id="navbar">
        <div class="container-fluid pt-2">
            <div class="d-flex justify-content-center w-100 gap-2">
                <a class="nav-link icon-container home" href="#home"><i class="fa-regular fa-file-lines"></i></a>
                <a class="nav-link icon-container detail" href="#detail"><i class="fa-regular fa-heart"></i></a>
                <a class="nav-link icon-container gallery" href="#gallery"><i class="fa-regular fa-images"></i></a>
                <a class="nav-link icon-container reservation" href="#reservation"><i
                        class="fa-solid fa-gifts"></i></a>
                <a class="nav-link icon-container message" href="#message"><i
                        class="fa-brands fa-rocketchat"></i></a>
            </div>
        </div>
    </nav>
    <!-- Navbar -->

    <!-- CONTENT -->
    <div class="container position-relative z-2" id="index">
        <div class="row d-flex justify-content-center">
            <!-- MAIN  -->
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="rounded-card w-100 position-relative">

                    <!-- Background Image -->
                    <div class="w-100 position-absolute" style="z-index: 1; top: 0; left: 0;  overflow: hidden;">
                        <img src="{{ asset('tema/flowerone/img/abstract.png') }}"
                            class="object-fit-cover w-100 h-100" alt="">
                    </div>

                    <!-- Image Section -->
                    <div class="row text-center mb-4 image-container mx-0 position-relative z-3" id="home">
                        <div class="col-6 col-sm-6">
                            <img src="{{ asset('tema/flowerone/img/flower-top.png') }}" alt="Flower"
                                class="bg-transparent object-fit-cover img-fluid float-start w-100">
                        </div>
                        <div class="col-6 col-sm-6">
                            <img src="{{ asset('tema/flowerone/img/flower-top.png') }}" alt="Flower"
                                class="object-fit-cover img-fluid float-end w-100">
                        </div>
                    </div>


                    <!-- Jumbotron -->
                    <section>
                        <div class="jumbotron text-center position-relative text-black z-3">
                            <h4>The Wedding Off</h4>
                            <p class="name-relationship countdown">Ajeng & Teddy</p>
                            <p class="date countdown">Minggu <br> 10 • 11 • 2025</p>

                            <!-- Countdown Display -->
                            <div class="countdown d-flex justify-content-center gap-3" id="countdown">
                                <div class="countdown-item">
                                    <span id="days">0</span>
                                    <label>Hari</label>
                                </div>
                                <div class="countdown-item">
                                    <span id="hours">0</span>
                                    <label>Jam</label>
                                </div>
                                <div class="countdown-item">
                                    <span id="minutes">0</span>
                                    <label>Menit</label>
                                </div>
                                <div class="countdown-item">
                                    <span id="seconds">0</span>
                                    <label>Detik</label>
                                </div>
                            </div>
                        </div>

                        <!-- Invitation -->
                        <div class="invitation position-relative z-3">
                            <h4 class="invitation-title">Kepada:</h4>
                            <p class="invitation-subtitle">Yth. Bapak/Ibu/Saudara/i</p>
                            <p class="invitation-name">Melisa</p>
                        </div>
                    </section>

                    <!-- Flower Pembatas -->
                    <div class="text-center pt-5 position-relative z-3" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" alt=""
                            class="img-fluid">
                    </div>

                    <section>
                        <!-- Quotation Section -->
                        <div class="quote-section text-center">
                            <div>
                                <h1 data-aos="fade-up" data-aos-duration="1000"><i
                                        class="fa-solid fa-quote-right quote-icon"></i></h1>
                            </div>
                            <div class="quote-text">
                                <p class="arabic-quote" data-aos="fade-up" data-aos-duration="1000">
                                    وَمِنْ اٰيٰتِهٖٓ اَنْ خَلَقَ لَكُمْ مِّنْ اَنْفُسِكُمْ اَزْوَاجًا لِّتَسْكُنُوْٓا
                                    اِلَيْهَا
                                    وَجَعَلَ بَيْنَكُمْ مَّوَدَّةً وَّرَحْمَةً ۗاِنَّ فِيْ ذٰلِكَ لَاٰيٰتٍ لِّقَوْمٍ
                                    يَّتَفَكَّرُوْنَ
                                </p>
                                <p class="translation" data-aos="fade-up" data-aos-duration="1000">
                                    Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri
                                    dari
                                    jenismu
                                    sendiri,
                                    supaya kamu merasa tenang dan tentram kepadanya, dan dijadikan-Nya diantaramu rasa
                                    kasih dan
                                    sayang.
                                    Sesungguhnya pada yang demikian itu benar-benar terdapat tanda-tanda bagi kaum yang
                                    berfikir.
                                </p>
                                <p class="source" data-aos="fade-up" data-aos-duration="1000">Ar Rum: 21</p>
                            </div>
                        </div>
                    </section>

                    <!-- Divider -->
                    <div class="flower-divider text-center pt-3" id="detail">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!-- Relationship Detail Section -->
                    <section class="relationship-section text-center">
                        <div class="relationship-text" data-aos="fade-up" data-aos-duration="1000">
                            <h5 class="bismillah">بسم الله الرحمن الرحيم</h5>
                            <p>Kami mohon do'a & restunya atas pernikahan kami</p>
                        </div>

                        <div class="relationship-couple d-flex flex-column">

                            <div class="relationship-photo" data-aos="fade-up" data-aos-duration="1000">
                                <img src="{{ asset('tema/flowerone/img/foto-prewed.webp') }}"
                                    class="rounded-circle img-thumbnail" alt="Pre-Wedding Photo">
                                <h3>Ajeng Febian</h3>
                                <p class="relationship-info">Putri ke-1 Bpk. Sumarni & Ibu Maryati</p>
                                <div class="social-icons" data-aos="fade-up" data-aos-duration="1000">
                                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div>

                            <h1 class="and-sign" data-aos="fade-up" data-aos-duration="1000">&</h1>

                            <div class="relationship-photo" data-aos="fade-up" data-aos-duration="1000">
                                <img src="{{ asset('tema/flowerone/img/foto-prewed.webp') }}"
                                    class="rounded-circle img-thumbnail" alt="Pre-Wedding Photo">
                                <h3>Teddy Prakarsa</h3>
                                <p class="relationship-info">Putra ke-2 Bpk. Samuel & Ibu Masuya</p>
                                <div class="social-icons" data-aos="fade-up" data-aos-duration="1000">
                                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!-- Acara -->
                    <section class="event-section text-center">
                        <h2 data-aos="fade-up" data-aos-duration="1000">Acara</h2>
                        <p data-aos="fade-up" data-aos-duration="1000">Kami bermaksud untuk mengundang saudara/i dalam
                            acara pernikahan kami pada:</p>

                        <!-- Akad Nikah Section -->
                        <div class="event-card" data-aos="fade-up" data-aos-duration="1000">
                            <h3>Akad Nikah</h3>
                            <p class="date">Minggu, 01 Desember 2024</p>
                            <p class="time">08:00 - 10:00 WIB</p>
                            <p class="location">Hotel X-More<br>Hotel eL Royale, Jl. Merdeka No.2, Braga, Kec. Sumur
                                Bandung,<br> Kota Bandung, Jawa Barat 40111</p>
                            <div class="d-flex flex-row justify-content-center gap-2">
                                <a href="#" class=" p-1 rounded-2 text-center text-white text-decoration-none">
                                    <i class="fa-solid fa-calendar-check mr-2"></i>Simpan Tanggal
                                </a>
                                <a href="#" class="p-1  rounded-2 text-white text-decoration-none "><i
                                        class="fa-solid fa-map-location-dot mr-2"></i>Navigasi Map</a>
                            </div>
                        </div>

                        <!-- Separator -->
                        <div class="separator" data-aos="fade-up" data-aos-duration="1000">&</div>

                        <!-- Resepsi Section -->
                        <div class="event-card" data-aos="fade-up" data-aos-duration="1000">
                            <h3>Resepsi</h3>
                            <p class="date">Minggu, 01 Desember 2024</p>
                            <p class="time">11:00 - 14:00 WIB</p>
                            <p class="location">Hotel X-More<br>Hotel eL Royale, Jl. Merdeka No.2, Braga, Kec. Sumur
                                Bandung,<br> Kota Bandung, Jawa Barat 40111</p>
                            <div class="d-flex flex-row justify-content-center gap-2">
                                <a href="#" class=" p-1 rounded-2 text-center text-white text-decoration-none">
                                    <i class="fa-solid fa-calendar-check mr-2"></i>Simpan Tanggal
                                </a>
                                <a href="#" class="p-1  rounded-2 text-white text-decoration-none "><i
                                        class="fa-solid fa-map-location-dot mr-2"></i>Navigasi Map</a>
                            </div>
                        </div>

                        <!-- Live Streaming Section -->
                        <div class="live-stream pb-5" data-aos="fade-up" data-aos-duration="1000">
                            <p data-aos="fade-up" data-aos-duration="1000">Acara ini akan disiarkan langsung melalui
                                media internet. Silakan klik tombol di bawah
                                ini untuk
                                membuka saluran live streaming.</p>
                            <a href="#" class="live-stream-button" data-aos="fade-up"
                                data-aos-duration="1000"><i class="fa-solid fa-play mr-2" data-aos="fade-up"
                                    data-aos-duration="1000"></i>
                                Tonton Live
                                Streaming</a>
                        </div>
                    </section>

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!--Start Timeline Pertemuan-->
                    <section>
                        <div class="card-container mt-5 pb-2 text-center">
                            <div class="row" data-aos="fade-up" data-aos-duration="1000">
                                <h3 class="my-3">Kisah Cinta</h3>
                                <div class="col-1">
                                    <div class="p-1 text-center d-flex justify-content-center align-content-center rounded-circle text-white"
                                        style="background-color: #9e0050; font-size:12px;"> <i
                                            class="fa-solid fa-heart p-1"></i>
                                    </div>
                                </div>
                                <div class="col-11 ">
                                    <div class="card-image pl-1">
                                        <img src="{{ asset('tema/flowerone/img/image-wide.jpeg') }}"
                                            class="rounded-3" alt="Card Image" width="100%">
                                        <div class="overlay">
                                            <div class="overlay-background"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-5" data-aos="fade-up" data-aos-duration="1000">
                                <div class="col">
                                    <p> <span class="fw-semibold">Pertemuan Pertama</span> <br>
                                        Kisah ini berawal ketika jumpa pandangan pertama di Kampus Perjuangan</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-container pb-2 text-center">
                            <div class="row" data-aos="fade-up" data-aos-duration="1000">
                                <div class="col-1">
                                    <div class="p-1 text-center d-flex justify-content-center align-content-center rounded-circle text-white"
                                        style="background-color: #9e0050; font-size:12px;"> <i
                                            class="fa-solid fa-heart p-1"></i>
                                    </div>
                                </div>
                                <div class="col-11 ">
                                    <div class="card-image pl-1">
                                        <img src="{{ asset('tema/flowerone/img/image-wide.jpeg') }}"
                                            class="rounded-3" alt="Card Image" width="100%">
                                        <div class="overlay">
                                            <div class="overlay-background"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-5" data-aos="fade-up" data-aos-duration="1000">
                                <div class="col">
                                    <p> <span class="fw-semibold">Lamaran</span> <br>
                                        Tak disangka, cerita ini semakin erat untuk memperkokoh niat beribadah. Sehingga
                                        prosesi
                                        lamaran ini dilaksanakan</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--END Timeline Pertemuan-->

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center" id="gallery">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!--START Gallery -->
                    <section class="gallery-section w-100 text-center mt-3">
                        <h3 data-aos="fade-up" data-aos-duration="1000">Gallery</h3>
                        <div class="row  text-center d-flex justify-content-center" data-aos="fade-up"
                            data-aos-duration="1000">
                            <div class="col-12" style="height: 250px;">
                                <iframe src="//www.youtube.com/embed/Yfx3FYxOc7I" class="w-100 h-100 rounded"
                                    frameborder="0"></iframe>
                            </div>
                        </div>

                        <!-- Slider main container -->
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                            class="swiper mySwiper2 p-1">
                            <!-- Thumbnail Swiper -->
                            <div thumbsSlider="" class="swiper mySwiper" data-aos="fade-up"
                                data-aos-duration="1000">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-1.jpg"
                                            class="object-fit-cover" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-2.jpg"
                                            class="object-fit-cover" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-3.jpg"
                                            class="object-fit-cover" />
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="swiper-button-next p-2 rounded-circle"></div>
                                <div class="swiper-button-prev p-2 rounded-circle"></div>

                            </div>

                            <!-- Main Image Swiper -->
                            <div class="swiper-wrapper" style="height: 300px;" data-aos="fade-up"
                                data-aos-duration="1000">
                                <div class="swiper-slide">
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- END Gallery -->

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center w-100" id="reservation">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!-- START Reservation -->
                    <section class="rsvp-gift-section text-center mt-5">
                        <h3 data-aos="fade-up" data-aos-duration="1000">RSVP & Kado</h3>

                        <!-- RSVP Card -->
                        <!-- Button trigger modal -->
                        <button type="button" class="btn konfirmasi-kehadiran text-white w-50"
                            data-bs-toggle="modal" data-bs-target="#modalRSV1" data-aos="fade-up"
                            data-aos-duration="1000">
                            <i class="fa-solid fa-user-check"></i> <br>
                            Konfirmasi Kehadiran
                        </button>




                        <div class="pt-5 mt-5">
                            <!-- Gift Options -->
                            <h3 data-aos="fade-up" data-aos-duration="1000">Kado</h3>
                            <p class="gift-info" data-aos="fade-up" data-aos-duration="1000">Berikut adalah informasi
                                untuk mengirimkan kado atau hadiah secara
                                online
                                atau melalui pengiriman fisik.</p>

                            <div class="bank-info" data-aos="fade-up" data-aos-duration="1000">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="30"
                                        viewBox="4.445 2.992 462.37 145.055">
                                        <path fill="#005FAF" stroke="#005FAF"
                                            d="M255.169 72.04c29.217-13.252 33.538-56.497-8.021-56.497H199.02l-17.786 34.875h8.37l-21.274 83.351h55.8c40.709.348 59.017-47.588 31.039-61.729zm-31.039 31.388h-13.95l5.231-18.832h13.252c15.694 3.138 5.93 19.529-4.533 18.832zm8.37-40.107h-11.857l3.487-16.391h13.252c12.805 3.139 1.745 17.089-4.882 16.391z" />
                                        <path fill="#005FAF" stroke="#005FAF"
                                            d="M369.418 60.083l18.271-32.254-24.723-12.896-3.225 3.98c-13.337-7.06-83.176 2.688-87.549 71.581 2.614 57.793 67.373 47.397 73.725 43.73l17.811-36.819c-17.444 11.49-53.162 17.006-54.673-17.509 3.133-28.462 36.737-39.091 60.363-19.813zM460.592 15.543h-56.169l-17.854 33.831h9.172l-42.33 84.395h40.973l8.412-20.356h25.151l.627 20.356h37.717l-5.699-118.226zm-46.401 70.463l13.755-32.833.627 32.833h-14.382z" />
                                        <g fill="#005FAF">
                                            <path
                                                d="M109.826 128.125l2.182-.633-2.393-3.307zM74.004 127.562l-.422 2.956c1.086-.106 2.423.83 2.956-1.267-.04-1.634-1.284-1.724-2.534-1.689zM91.388 127.492c-.181-.805-.853-1.398-2.534-.844l.563 3.025c1.381-.306 2.091-1.123 1.971-2.181zM52.117 125.016l-.672 2.688c1.08.045 2.345.921 3.062-.672.048-.998.089-1.992-2.39-2.016zM89.91 131.926l.493 3.097c1.153.029 2.205-.664 1.9-2.111-.294-1.392-1.463-1.172-2.393-.986z" />
                                            <path
                                                d="M135.678 17.137C98.411-1.848 53.904-1.32 18.396 16.309c-18.31 32.233-18.893 77.332 0 117.276 39.119 19.796 82.385 18.492 117.557.828 16.53-33.913 19.26-74.721-.275-117.276zm-62.94 96.248l-2.209.025c-.547-6.104-2.006-11.234-5.136-15.16C51.04 80.251 21.7 93.802 29.239 63.213c3.92-15.638 48.633-24.861 43.499 50.172zM29.292 83.173c3.134 6.379 22.769 7.424 29.585 12.307 10.812 7.745 9.26 17.933 9.26 17.933h-2.55c-5.02-15.387-19.109-3.204-30.394-7.348-7.085-2.52-12.229-13.443-5.901-22.892zm35.774 50.161l1.056-8.375 1.9.141-.845 9.219c-.852 4.061-6.907 3.518-7.671-.352l.985-9.571 2.252.353-.985 8.022c.125 2.655 2.788 2.496 3.308.563zm-10.111 2.287l-2.166-.523c.254-1.79 2.377-5.432-1.819-5.432l-1.168 4.76-2.39-.448 2.539-11.427c6.206.676 6.749 2.403 6.872 4.257-.245 1.438-.628 2.442-1.867 2.688 1.45 1.316.017 4.074-.001 6.125zm-13.757-12.799c-.597.792-1.792 3.559-1.965 5.764-.184 2.337 2.061 1.845 2.62 1.572.451-.219.786-2.096.786-2.096l-1.572-.524.524-1.571 3.538 1.179-1.703 5.896-1.441-.394.131-.917c-1.764.804-4.993.201-5.372-1.834-.379-1.635.769-6.592 2.62-8.908 1.799-2.252 6.182-.051 6.289 1.31.106 1.356-.429 2.882-.429 2.882l-1.65-.311s.101-.49.245-1.262c.152-.818-1.981-1.637-2.621-.786zm32.173 9.596l-.422 5.068-1.759-.07.633-12.035c4.393.091 6.911.699 6.827 3.801-.262 4.238-3.694 3.285-5.279 3.236zm4.379-19.006h-2.943c-.261-10.422 1.743-29.485-3.733-43.514-4.149-10.635-14.649-15.419-16.976-24.01-3.684-13.598 2.586-28.311 23.652-29.444 18.263 1.875 23.874 15.974 20.759 29.101-5.356 13.125-10.713 11.239-17.382 24.313-5.447 14.015-3.373 32.376-3.377 43.554zm32.639 19.288l-2.041.704-.634-12.105 2.393-.633 5.912 9.993-1.619 1.056-1.971-2.814-2.252.844.212 2.955zm-23.811-19.288h-2.354c1.94-26.766 35.575-20.951 38.649-30.239 5.316 9.208 3.405 16.972-2.146 20.952-13.794 9.894-27.021-7.322-34.149 9.287zm12.481 13.518l1.056 5.56c.657 1.281 1.103 1.044 2.111.915 1.169-.846.925-1.67.704-2.745l2.041-.281c.532 4.028-1.383 4.439-2.815 4.715-3.071.22-3.673-.378-4.504-4.363-.484-3.411-1.32-7.013 1.548-7.671 4.708-.719 4.43 1.4 4.856 2.885l-2.041.353c-.326-1.276-.795-1.782-1.83-1.688-.943.433-1.33 1.134-1.126 2.32zm-4.293 5.77c.098 1.753-.497 2.917-1.619 3.308l-4.786.985-1.9-11.612c.982-.16 5.797-1.924 6.967 1.268.577 1.949-.021 2.648-.704 3.518 1.295.416 1.732 1.424 2.042 2.533zm-12.29-58.273c10.662-30.02 35.059-24.715 40.47-11.213 7.413 27.093-16.457 19.663-31.747 30.773-5.779 5.026-8.82 10.792-8.865 19.533h-2.62c-.157-17.606-.442-30.073 2.762-39.093z" />
                                        </g>
                                    </svg>
                                </div>
                                <p style="font-size: 20px; font-weight: 800;">Bank BCA</p>
                                <p>Nama Rekening <br> <span>Ajeng</span></p>
                                <p>Nomor Rekening <br> <span> 123456</span></p>

                            </div>

                            <!-- Bank Details -->
                            <div class="bank-details d-flex flex-column align-items-center" data-aos="fade-up"
                                data-aos-duration="1000">
                                <p><strong>Transfer Pakai QRIS Bank BCA:</strong></p>
                                <div class="bank-card mb-3 text-center">
                                    <img src="{{ asset('tema/flowerone/img/QRIS.jpg') }}"
                                        class="object-fit-cover img-thumbnail" alt="QRIS Bank BCA"
                                        style="max-width: 75%; min-width: 50%;" />
                                </div>
                            </div>

                            <!-- Address for Sending Gifts -->
                            <div class="gift-address mt-4" data-aos="fade-up" data-aos-duration="1000">
                                <h5>Alamat Pengiriman Kado</h5>
                                <p>Anda dapat mengirimkan kado dengan alamat berikut:</p>
                                <address class="address-border p-3">Jalan Mawar No. 123, Kota Bandung, Jawa Barat,
                                    40123
                                </address>
                            </div>
                        </div>
                    </section>
                    <!-- END Reservation -->

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center" id="message">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!-- START message -->
                    <section class="message-section mt-5 mx-3">
                        <h5 class="text-center" data-aos="fade-up" data-aos-duration="1000">Ucapan & Doa</h5>

                        <form action="" data-aos="fade-up" data-aos-duration="1000">
                            <!-- Input field for messages -->
                            <div class="input-name mb-4">
                                <input type="text" id="messageInput" class="form-control custom-input-bg"
                                    placeholder="Nama Anda">
                            </div>

                            <!-- Input field for messages -->
                            <div class="input-message mb-4">
                                <textarea id="messageInput" class="form-control custom-input-bg" rows="5" placeholder="Tulis Ucapan dan Doa"></textarea>
                            </div>
                            <button type="submit" class="btn text-white mb-3">Kirim Ucapan</button>
                        </form>

                        <!-- Messages List -->
                        <div class="messages-list">
                            <!-- Message Card -->
                            <div class="card message-item mb-3" data-aos="fade-up" data-aos-duration="1000">
                                <div class="card-body">
                                    <strong>Ridho</strong>
                                    <p class="card-text" style="color: #9e0050;">
                                        <small>Minggu, 03 November 2024 20:42:49</small>
                                    </p>
                                    <p class="card-text">Semoga anak 50</p>
                                </div>
                            </div>
                        </div>

                        <!-- Message Card -->
                        <div class="card message-item mb-3" data-aos="fade-up" data-aos-duration="1000">
                            <div class="card-body">
                                <strong>Ridho</strong>
                                <p class="card-text" style=" color: #9e0050;"><small>Minggu, 03 November 2024
                                        20:42:49</small>
                                </p>
                                <p class="card-text">Semoga anak 50</p>
                            </div>
                        </div>
                    </section>

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid">
                    </div>

                    <!-- ENDING  -->
                    <section class="ending-section mt-5 mx-3">
                        <h5 class="title text-center" data-aos="fade-up" data-aos-duration="1000">Instagram Stories
                        </h5>
                        <p class="text-center" data-aos="fade-up" data-aos-duration="1000">Ayo bagikan momen bahagia
                            ini
                            ke Instagram Story kamu. Download template
                            IG Story dibawah ini
                            dan posting di Instagram kamu!</p>

                        <div class="d-flex row gap-2 justify-content-center w-100 mb-5">
                            <div class="card w-100 col-12" style="max-width: 600px;" data-aos="fade-up"
                                data-aos-duration="1000">
                                <div class="card-body d-flex align-items-center gap-3 text-white">
                                    <!-- Instagram Logo -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        style="min-width: 100px; max-height: 100px; margin-left: 15px;"
                                        viewBox="0 0 448 512">
                                        <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#ffffff"
                                            d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                                    </svg>
                                    <!-- Content -->
                                    <div class="d-flex flex-column">
                                        <!-- Instagram Story Template Preview -->
                                        <h5 class="card-title">Download</h5>
                                        <p class="card-text">Template IG Story</p>

                                    </div>
                                </div>
                            </div>

                            <div class="card w-100 col-12" style="max-width: 600px;" data-aos="fade-up"
                                data-aos-duration="1000">
                                <div class="card-body d-flex align-items-center gap-3 text-white">
                                    <!-- Instagram Logo -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        style="min-width: 100px; max-height: 100px; margin-left: 15px;"
                                        viewBox="0 0 448 512">
                                        <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path fill="#ffffff"
                                            d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                                    </svg>
                                    <!-- Content -->
                                    <div class="d-flex flex-column">
                                        <!-- Instagram Story Template Preview -->
                                        <h5 class="card-title">Download</h5>
                                        <p class="card-text">Template IG Story</p>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Flower Divider -->
                        <div class="flower-divider text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
                            <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid">
                        </div>

                        <h5 class="title text-center" data-aos="fade-up" data-aos-duration="1000">Protokol Kesehatan
                        </h5>
                        <p class="text-center" data-aos="fade-up" data-aos-duration="1000">Acara ini diselenggarakan
                            dengan mematuhi protokol kesehatan. Semua tamu
                            undangan diwajibkan mematuhi Protokol Kesehatan ini.
                        </p>

                        <div class="d-flex flex-row text-center justify-content-center gap-4" data-aos="fade-up"
                            data-aos-duration="1000">
                            <ul class="list-group list-group-flush no-border">
                                <li class="list-group-item compact-item">
                                    <div
                                        class="icon-circle text-white d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <i class="fa-solid fa-mask-face"></i>
                                    </div>
                                    <br>Menggunakan masker
                                </li>
                                <li class="list-group-item compact-item">
                                    <div
                                        class="icon-circle text-white d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <i class="fa-solid fa-hands-bubbles"></i>
                                    </div>
                                    <br>Mencuci Tangan
                                </li>
                                <li class="list-group-item compact-item">
                                    <div
                                        class="icon-circle text-white d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <i class="fa-solid fa-pump-soap"></i>
                                    </div>
                                    <br>Memakai Handsanitizer
                                </li>
                            </ul>

                            <ul class="list-group list-group-flush no-border">
                                <li class="list-group-item compact-item">
                                    <div
                                        class="icon-circle text-white d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <i class="fa-solid fa-people-arrows"></i>
                                    </div>
                                    <br>Menjaga Jarak
                                </li>
                                <li class="list-group-item compact-item">
                                    <div
                                        class="icon-circle text-white d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <i class="fa-solid fa-syringe"></i>
                                    </div>
                                    <br>Melakukan Vaksin
                                </li>
                                <li class="list-group-item compact-item">
                                    <div
                                        class="icon-circle text-white d-inline-flex align-items-center justify-content-center rounded-circle">
                                        <i class="fa-solid fa-people-group"></i>
                                    </div>
                                    <br>Menghindari Kerumunan
                                </li>
                            </ul>
                        </div>
                        <div class="thank-you-section mt-5 mb-5" data-aos="fade-up" data-aos-duration="1000">
                            <p class="text-center">Atas kehadiran saudara/(i) & Do'a restunya, kami ucapkan terimakasih
                            </p>
                            <h5 class="text-center">Hormat Kami</h5>
                            <p class="text-center">Ajeng & Teddy</p>

                            <!-- Additional text below -->
                            <p class="text-center mt-4">Turut Mengundang:</p>
                            <p class="text-center">Kel. Bpk Sumarni & Ibu Sukmana</p>
                        </div>

                        <!-- Flower Divider -->
                        <div class="flower-divider text-center" data-aos="fade-up" data-aos-duration="1000">
                            <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid">
                        </div>
                    </section>



                </div>
            </div>
            <!-- MAIN -->
            <!-- FOOTER -->
            <footer class="footer mt-5 text-center mb-5">
                <p style="margin: 0px">Ajeng & Teddy </p>
                <p style="margin: 0px">Made with ❤ somewhere in the world</p>
                <p style="margin-bottom: 5px">Powered by EraWedding</p>
            </footer>
            <!-- FOOTER -->
        </div>
    </div>
    <!-- CONTENT -->

    <!-- Swiper -->
    <script src="{{ asset('tema/flowerone/assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('tema/flowerone/assets/swiper/swiper-element-bundle.min.js') }}"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="{{ asset('tema/flowerone/assets/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('tema/flowerone/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('tema/flowerone/assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- AOS -->
    <script src="{{ asset('tema/flowerone/assets/aos/dist/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>

    <script src="{{ asset('tema/flowerone/js/cover.js') }}"></script>
    <script src="{{ asset('tema/flowerone/js/setDate.js') }}"></script>
    <script src="{{ asset('tema/flowerone/js/swiper.js') }}"></script>
    <script src="{{ asset('tema/flowerone/js/nav-link.js') }}"></script>
</body>

</html>
