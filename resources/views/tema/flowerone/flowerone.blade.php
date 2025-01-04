<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $data->title }}" />
    <meta name="twitter:image" content="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}">
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    <!-- WhatsApp Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $data->title }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}">
    <title>{{$data->title}}</title>

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
    <link rel="stylesheet" href="asset('build/assets/app-CczSUIEg.css')">
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
    @include('tema.flowerone.cover')
    <!-- COVER -->

    <!-- Modal -->
    <!-- Tombol vertikal di pojok kanan -->

    @include('tema.flowerone.settingbar')
    {{-- {{ $data->sound->isActive }} sdadsasdsdsd --}}
    <!-- Tombol vertikal di pojok kanan -->

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
                            <p class="name-relationship countdown">
                                {{ $data ? $data->wanita->nama_panggilan : 'Ajeng' }} &
                                {{ $data ? $data->pria->nama_panggilan : 'Teddy' }}
                            </p>
                            {{-- <p class="date countdown">Minggu <br> 10 • 11 • 2024</p> --}}
                            <p class="date countdown"
                                data-date="{{ $data ? date('Y-m-d', strtotime($data->acara[0]->date)) : '2024-10-10' }}">
                                {{ $data ? $hari[date('l', strtotime($data->acara[0]->date))] : 'Minggu' }}
                                <br>
                                {{ $data ? date('d', strtotime($data->acara[0]->date)) : '10' }} •
                                {{ $data ? date('m', strtotime($data->acara[0]->date)) : '10' }} •
                                {{ $data ? date('Y', strtotime($data->acara[0]->date)) : '2024' }}
                            </p>

                            <!-- Countdown Display -->
                            <div class="countdown d-flex justify-content-center gap-3" id="countdown">
                                <div class="countdown-item border p-3">
                                    <span class="fw-bold fs-6" id="days">0</span>
                                    <label class="fw-bold mt-0" style="font-size: 11px !important">Hari</label>
                                </div>
                                <div class="countdown-item border p-3">
                                    <span class="fw-bold fs-6" id="hours">0</span>
                                    <label class="fw-bold mt-0" style="font-size: 11px !important">Jam</label>
                                </div>
                                <div class="countdown-item border p-3">
                                    <span class="fw-bold fs-6" id="minutes">0</span>
                                    <label class="fw-bold mt-0" style="font-size: 11px !important">Menit</label>
                                </div>
                                <div class="countdown-item border p-3">
                                    <span class="fw-bold fs-6" id="seconds">0</span>
                                    <label class="fw-bold mt-0" style="font-size: 11px !important">Detik</label>
                                </div>
                            </div>
                        </div>

                        <!-- Invitation -->
                        <div class="invitation position-relative z-3">
                            <h4 class="invitation-title">Kepada:</h4>
                            <p class="invitation-subtitle">Yth. Bapak/Ibu/Saudara/i</p>
                            <p class="invitation-name">{{ $tamu }}</p>
                        </div>
                    </section>

                    <!-- Flower Pembatas -->
                    <div class="text-center pt-5 position-relative z-3" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('tema/flowerone/img/flower-top.png') }}" alt=""
                            class="img-fluid">
                    </div>

                    <section>
                        <!-- Quotation Section -->
                        <div class="quote-section text-center">
                            <div>
                                <h1 data-aos="fade-up" data-aos-duration="1000"><i
                                        class="fa-solid fa-quote-right quote-icon"></i></h1>
                            </div> 
                            {{-- Qoute --}}
                            @include('tema.flowerone.qoute')
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
                            {{-- <h5 class="bismillah">بسم الله الرحمن الرحيم</h5> --}}
                            <p>{!! nl2br(e($data->teksUndangan->pembuka)) !!}</p>
                        </div>

                        <div class="relationship-couple d-flex flex-column">

                            @include('tema.flowerone.mempelai')
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
                        <p data-aos="fade-up" data-aos-duration="1000">{!! nl2br(e($data->teksUndangan->acara)) !!}</p>

                        <!-- Akad Nikah Section -->

                        @forelse ($data->acara as $item)
                            <div class="event-card" data-aos="fade-up" data-aos-duration="1000">
                                <h3>{{ $item->nama_acara }}</h3>
                                <p class="date">{{ $item->date }}</p>
                                <p class="time">{{ $item->jam_start }} s/d {{ $item->jam_end }}
                                    {{ $item->zona_waktu }}</p>
                                <p class="location">{{ $item->vanue }}<br>{{ $item->alamat }}</p>
                                <div class="d-flex flex-row justify-content-center gap-2">
                                    <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Acara+Penting&dates={{ date('Ymd', strtotime($item->date)) }}T090000Z/{{ date('Ymd', strtotime($item->date)) }}T120000Z&details=Jangan+lewatkan+acara+ini&location={{ $item->alamat }}"
                                        target="_blank"
                                        class="p-1 rounded-2 text-center text-white text-decoration-none">
                                        <i class="fa-solid fa-calendar-check mr-2"></i>Simpan Tanggal
                                    </a>
                                    <a href="{{ $item->maps }}"
                                        class="p-1  rounded-2 text-white text-decoration-none "><i
                                            class="fa-solid fa-map-location-dot mr-2"></i>Navigasi Map</a>
                                </div>
                            </div>
                        @empty
                            <!-- Separator -->
                            <div class="separator" data-aos="fade-up" data-aos-duration="1000">&</div> --}}

                            <!-- Resepsi Section -->
                            <div class="event-card" data-aos="fade-up" data-aos-duration="1000">
                                <h3>Resepsi</h3>
                                <p class="date">Minggu, 01 Desember 2024</p>
                                <p class="time">11:00 - 14:00 WIB</p>
                                <p class="location">Hotel X-More<br>Hotel eL Royale, Jl. Merdeka No.2, Braga, Kec.
                                    Sumur
                                    Bandung,<br> Kota Bandung, Jawa Barat 40111</p>
                                <div class="d-flex flex-row justify-content-center gap-2">
                                    <a href="#"
                                        class=" p-1 rounded-2 text-center text-white text-decoration-none">
                                        <i class="fa-solid fa-calendar-check mr-2"></i>Simpan Tanggal
                                    </a>
                                    <a href="#" class="p-1  rounded-2 text-white text-decoration-none "><i
                                            class="fa-solid fa-map-location-dot mr-2"></i>Navigasi Map</a>
                                </div>
                            </div>
                        @endforelse



                        @if ($data->streaming)
                            @include('user.kelola.streaming')
                        @endif


                    </section>

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!--Start Timeline Pertemuan-->
                    <section>
                        <h3 class="my-3 mt-4 text-center" data-aos="fade-up" data-aos-duration="1200">Kisah Cinta
                        </h3>
                        @foreach ($data->kisah as $kisah)
                            <div class="card-container mt-5 pb-2 text-center">
                                <div class="row" data-aos="fade-up" data-aos-duration="1000">

                                    <div class="col-1">
                                        <div class="p-1 text-center d-flex justify-content-center align-content-center rounded-circle text-white"
                                            style="background-color: #9e0050; font-size:12px; width: 30px; height: 30px;">
                                            <i class="fa-solid fa-heart p-1"></i>
                                        </div>
                                    </div>
                                    <div class="col-11 ">
                                        <div class="card-image pl-1 ">
                                            <img src="{{ asset('storage/' . $kisah->image->image) }}"
                                                class="rounded-3 object-fit-cover" alt="Card Image" width="100%">
                                            <div class="overlay">
                                                <div class="overlay-background"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-5" data-aos="fade-up" data-aos-duration="1000">
                                    <div class="col">
                                        <p> <span class="fw-semibold">{{ $kisah->title }}</span> <br>
                                            {{ $kisah->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- 
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
                                        <img src="img/image-wide.jpeg" class="rounded-3" alt="Card Image"
                                            width="100%">
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
                        </div> --}}
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
                        @if ($video)
                            <div class="row  text-center d-flex justify-content-center" data-aos="fade-up"
                                data-aos-duration="1000">
                                <div class="col-12" style="height: 250px;">
                                    <iframe src="{{ $video[0] }}" class="w-100 h-100 rounded"
                                        frameborder="0"></iframe>
                                </div>
                            </div>
                        @endif

                        <!-- Slider main container -->
                        @if ($data)
                            @include('tema.flowerone.gallery')
                        @else
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
                        @endif
                    </section>
                    <!-- END Gallery -->

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center w-100" id="reservation">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!-- START Reservation -->

                    <section class="rsvp-gift-section text-center mt-5">
                        @if ($data->fiturKado)
                            @include('tema.flowerone.kado')
                        @else
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
                                    <img src="img/QRIS.jpg" class="object-fit-cover img-thumbnail"
                                        alt="QRIS Bank BCA" style="max-width: 75%; min-width: 50%;" />
                                </div>
                            </div>
                        @endif
                    </section>
                    <!-- END Reservation -->



                    <!-- START message -->
                    @include('tema.flowerone.ucapan')

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid">
                    </div>

                    @if ($data->teksPenutup->mengundang)
                        <div class="my-3 text-center" data-aos="fade-up " data-aos-duration="1000">
                            <h3>Turut Mengundang</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">{!! nl2br(e($data->teksPenutup->mengundang)) !!}</li>
                            </ul>

                        </div>
                        <div class="flower-divider text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
                            <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid">
                        </div>
                    @endif

                    <p class="text-center" data-aos="fade-up" data-aos-duration="1000"> {!! $data->teksUndangan->penutup !!}</p>







                </div>
            </div>
            <!-- MAIN -->
            <!-- FOOTER -->
            <footer class="footer mt-5 text-center mb-5">
                <p style="margin: 0px">{{ $data->wanita->nama_panggilan }} & {{ $data->pria->nama_panggilan }} </p>
                <p style="margin: 0px">Made with ❤ somewhere in the world</p>
                <p style="margin-bottom: 5px">Powered by EraWedding</p>
            </footer>
            <!-- FOOTER -->
        </div>
    </div>
    <!-- CONTENT -->
    <script src="{{asset('build/assets/app-I5mmpHKZ.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('scrollPosition')) {
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
                localStorage.removeItem('scrollPosition'); // Hapus setelah digunakan
            }
        });

        window.addEventListener('beforeunload', function() {
            localStorage.setItem('scrollPosition', window.scrollY); // Simpan posisi scroll
        });
    </script>

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

    <script src="{{ asset('tema/flowerone/js/openCover.js') }}"></script>
    <script src="{{ asset('tema/flowerone/js/setDate.js') }}"></script>
    <script src="{{ asset('tema/flowerone/js/swiper.js') }}"></script>
    <script src="{{ asset('tema/flowerone/js/nav-link.js') }}"></script>
</body>

</html>
