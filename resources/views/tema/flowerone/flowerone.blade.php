<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Open Graph Meta Tags -->
    <title>{{ $data->setting->acara }} {{ $data->pria->nama_panggilan }} & {{ $data->wanita->nama_panggilan }}</title>
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
        $tanggalAcara = Carbon::parse($data->acara[0]->date)->translatedFormat('l, j F Y');
    @endphp
    
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:site_name" content="Wayae Nikah">
    <meta property="og:title" content="{{ $data->title }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image" content="{{ url('storage/' . $data->thumbnailWas->thumbnail) }}">
    <meta property="og:image:secure_url" content="{{ url('storage/' . $data->thumbnailWas->thumbnail) }}">
    <meta property="og:description" content="Acara akan dilaksanakan pada {{ $tanggalAcara }}." />
    <meta property="og:image:width" content="664">
    <meta property="og:image:height" content="664">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    

    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <meta itemprop="url" content="{{ url('storage/' . $data->thumbnailWas->thumbnail) }}">
    </div>
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

    <style>
        @if ($data->dataFont)
            @import url('{{ $data->dataFont->titleFont->link }}');
            @import url('{{ $data->dataFont->subFont->link }}');

        @else
            @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Capriola&family=Epunda+Slab:ital,wght@0,300..900;1,300..900&display=swap');
        @endif


        h1 {
            font-family: "{{ $data->dataFont->titleFont->nama ?? 'Dancing Script' }}", system-ui;
            font-weight: <weight>;
            font-style: normal;
            font-size: {{ $data->dataFont->s_title }}px;
            color: #9e0050;
        }

        h3 {
            font-family: "{{ $data->dataFont->titleFont->nama ?? 'Dancing Script' }}", system-ui;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
            color: #9e0050
        }



        body {
            background-color: #FFD3E9;
            /* background: linear-gradient(135deg, #f8cdda 0%, #1d2b64 100%); */
            font-family: "{{ $data->dataFont->subFont->nama ?? 'Capriola' }}" !important;
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
                <a class="nav-link icon-container acara" href="#acara"><i class="fa-regular fa-note-sticky"></i></a>
                @if ($poto)
                    <a class="nav-link icon-container gallery" href="#gallery"><i
                            class="fa-regular fa-images"></i></a>
                @endif
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
                            <p>{{ $data->setting->acara ?? 'The Wedding' }}</p>
                            <h1 class="countdown">
                                {{ $data ? $data->pria->nama_panggilan : 'Teddy' }} &
                                {{ $data ? $data->wanita->nama_panggilan : 'Ajeng' }}
                            </h1>
                            {{-- <p class="date countdown">Minggu <br> 10 • 11 • 2024</p> --}}
                            @include('tema.flowerone.flower.countdown')


                        </div>

                        <!-- Invitation -->
                        <div class="invitation position-relative z-3">
                            <p class="invitation-title">Kepada:</p>
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
                            <p>{!! nl2br(e($data->teksUndangan->pembuka)) !!}</p>
                        </div>

                        <div class="relationship-couple d-flex flex-column">

                            @include('tema.flowerone.mempelai')
                        </div>
                    </section>

                    <!-- Flower Divider -->
                    <div class="flower-divider text-center" id="acara">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!-- Acara -->
                    <section class="event-section text-center">
                        <h3 data-aos="fade-up" data-aos-duration="1000">Acara</h3>
                        <p data-aos="fade-up" data-aos-duration="1000">{!! nl2br(e($data->teksUndangan->acara)) !!}</p>

                        <!-- Akad Nikah Section -->

                        @forelse ($data->acara as $item)
                            <div class="event-card" data-aos="fade-up" data-aos-duration="1000">
                                <h3>{{ $item->nama_acara }}</h3>
                                <p class="date">
                                    {{ \Carbon\Carbon::parse($item->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                                @php
                                    $zonaWaktuStart = $item->jam_end == 'Selesai' ? $item->zona_waktu : '';
                                    $zonaWaktuEnd = $item->jam_end != 'Selesai' ? $item->zona_waktu : '';
                                @endphp
                                <p class="time"> {{ $item->jam_start }} {{ $zonaWaktuStart }} s/d
                                    {{ $item->jam_end }} {{ $zonaWaktuEnd }}</p>
                                <p class="location">{{ $item->vanue }}<br>{{ $item->alamat }}</p>
                                <div class="d-flex flex-row justify-content-center gap-2">
                                    <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Acara+Penting&dates={{ date('Ymd', strtotime($item->date)) }}T090000Z/{{ date('Ymd', strtotime($item->date)) }}T120000Z&details=Jangan+lewatkan+acara+ini&location={{ $item->alamat }}"
                                        target="_blank"
                                        class="p-1 rounded-2 text-center text-white text-decoration-none">
                                        <i class="fa-solid fa-calendar-check mr-2"></i>Simpan Tanggal
                                    </a>
                                    @if ($item->maps)
                                        <a href="{{ $item->maps }}"
                                            class="p-1  rounded-2 text-white text-decoration-none "><i
                                                class="fa-solid fa-map-location-dot mr-2"></i>Navigasi Map</a>
                                    @endif

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
                            @include('tema.flowerone.streaming')
                        @endif


                    </section>


                    <!--Start Timeline Pertemuan-->
                    <section>

                        @foreach ($data->kisah as $kisah)
                            <!-- Flower Divider -->
                            <div class="flower-divider text-center">
                                <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                                    data-aos="fade-up" data-aos-duration="1000">
                            </div>

                            <h3 class="my-3 mt-4 text-center" data-aos="fade-up" data-aos-duration="1200">Kisah Cinta
                            </h3>
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

                    </section>
                    <!--END Timeline Pertemuan-->

                    <!-- Flower Divider -->

                    @if ($poto || $video)
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
                            @endif

                        </section>
                        <!-- END Gallery -->
                    @endif
                    <!-- Flower Divider -->
                    <div class="flower-divider text-center w-100" id="reservation">
                        <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid"
                            data-aos="fade-up" data-aos-duration="1000">
                    </div>

                    <!-- START Reservation -->

                    <section class="rsvp-gift-section text-center mt-5">
                        @if ($data->fiturKado)
                            @include('tema.flowerone.kado')
                        @endif
                    </section>
                    <!-- END Reservation -->



                    <!-- START message -->
                    @include('tema.flowerone.ucapan')



                    @if ($data->teksPenutup->mengundang)
                        <!-- Flower Divider -->
                        <div class="flower-divider text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
                            <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid">
                        </div>
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

            <footer class="footer mt-5 text-center mb-5">
                <p style="margin: 0px">{{ $data->wanita->nama_panggilan }} & {{ $data->pria->nama_panggilan }} </p>
                <p style="margin: 0px">Made with ❤ somewhere in the world</p>
                <p style="margin-bottom: 5px">Powered by Wayae Nikah</p>
            </footer>
            <!-- FOOTER -->
        </div>
    </div>
    <!-- CONTENT -->
    <script src="{{ asset('build/assets/app-I5mmpHKZ.js') }}"></script>
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
