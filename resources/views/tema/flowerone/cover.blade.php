<div class="min-vh-100 position-fixed top-0 left-0 w-100 d-block align-content-center"
    style="background-color: pink; z-index: 9999;" id="cover">
    <div class="text-center mt-3">
        <img src="{{ asset('tema/flowerone/img/flower-top.png') }}" class="flower-img img-fluid" alt="Flower decoration">
    </div>
    <div data-aos="zoom-in" data-aos-duration="1500" class="text-center d-flex flex-column align-items-center">
        <div class="text-center mt-2">
            <h4 class="header-text">The Wedding Off</h4>
            <p class="main-text" style="font-size: 50px; font-family: Great Vibes, cursive;">
                {{ $data ? $data->wanita->nama_panggilan : 'Ajeng' }} &
                {{ $data ? $data->pria->nama_panggilan : 'Teddy' }}</p>
        </div>

        <div class="row text-center d-flex justify-content-center align-items-center my-0" style="max-width: 500px;">
            <div class="col-4 text-end">
                <p class="main-text ">{{ $data ? $hari[date('l', strtotime($data->acara[0]->date))] : 'Minggu' }}</p>
            </div>
            <div class="col-4">
                <p class="fs-1 fw-normal">| <small class="fs-6 fw-bold">{{ $data ? date('d', strtotime($data->acara[0]->date)) : '11' }}</small> |</p>
            </div>
            <div class="col-4 text-start main-text">
                <p>{{ $data ? $bulan[date('M', strtotime($data->acara[0]->date))] : 'November' }}</p>
            </div>
            <div>
                <p style="font-size: 30px;">{{ $data ? date('Y', strtotime($data->acara[0]->date)) : '2024' }}</p>
            </div>
        </div>

        <div class="text-center my-0 py-0">
            <h4 class="header-text">Kepada:</h4>
            <p class="main-text">Yth. Bapak/Ibu/Saudara/i</p>
            <p class="main-text" style="font-size: 20px !important;">{{$tamu}}</p>
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
