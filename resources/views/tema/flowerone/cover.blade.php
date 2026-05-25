<div class="min-vh-100 position-fixed top-0 left-0 w-100 d-block align-content-center"
    style="background-color: pink; z-index: 9999;" id="cover">
    <div class="text-center mt-3">
        <img src="{{ asset('tema/flowerone/img/flower-top.png') }}" class="flower-img img-fluid" alt="Flower decoration">
    </div>
    <div data-aos="zoom-in" data-aos-duration="1500" class="text-center d-flex flex-column align-items-center">
        <div class="text-center mt-2">
            <h4 class="header-text">{{ $data->setting?->acara ?? 'The Wedding' }}</h4>
            <h1>
                {{ $data?->pria?->nama_panggilan ?? 'Teddy' }} &
                {{ $data?->wanita?->nama_panggilan ?? 'Ajeng' }}</h1>
        </div>
        @php
            $firstAcaraDate = ($data->acara[0] ?? null)?->date;
        @endphp
        <div class="row text-center d-flex justify-content-center align-items-center my-0" style="max-width: 500px;">
            <div class="col-4 text-end">
                <p>{{ $firstAcaraDate ? ($hari[date('l', strtotime($firstAcaraDate))] ?? date('l', strtotime($firstAcaraDate))) : 'Minggu' }}</p>
            </div>
            <div class="col-4">
                <p class="fs-1 fw-normal">| <small
                        class="fs-6 fw-bold">{{ $firstAcaraDate ? date('d', strtotime($firstAcaraDate)) : '11' }}</small> |
                </p>
            </div>
            <div class="col-4 text-start ">
                <p>{{ $firstAcaraDate ? ($bulan[date('M', strtotime($firstAcaraDate))] ?? date('M', strtotime($firstAcaraDate))) : 'November' }}</p>
            </div>
            <div>
                <p style="font-size: 30px;">{{ $firstAcaraDate ? date('Y', strtotime($firstAcaraDate)) : '2024' }}</p>
            </div>
        </div>

        <div class="text-center my-0 py-0">
            <h4 class="header-text">Kepada:</h4>
            <p>Yth. Bapak/Ibu/Saudara/i</p>
            <p style="font-size: 20px !important;">{{ $tamu }}</p>
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
