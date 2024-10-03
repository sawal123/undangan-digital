<x-landing-layout>
    <div class="h-20" style="padding-top: 50px">
        <h4 class="text-center mt-5">Kategori</h4>
    </div>
    <x-kategory>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
        <a href="" class="btn btn-light">Nikah</a>
    </x-kategory>

    <div class="container mb-5">
        <div class="row">
            @for ($j = 0; $j <= 7; $j++)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-4 pt-2">
                    <div class="card nft nft-item nft-primary rounded shadow overflow-hidden">
                        <div class="nft-image position-relative overflow-hidden">
                            <img src="{{ asset('assets/images/digital/invitation4.webp') }}" class="img-fluid item-img"
                                alt="">
                            <div class="overlay"></div>
                            <div class="bid-btn p-3 text-center">
                                <a href="nft-item-detail.html" class="btn btn-pills"><i
                                        class="mdi mdi-gavel fs-6 me-2"></i>
                                    Pesan</a>
                            </div>
                            {{-- <div class="position-absolute top-0 start-0 m-2">
                          <a href=""><img src="assets/images/client/01.jpg"
                                  class="avatar avatar-sm-sm rounded-pill shadow-md" alt=""></a>
                      </div> --}}
                            <div class="position-absolute top-0 end-0 m-2">
                                <a href="" class="badge rounded-md bg-light shadow"><i
                                        class="mdi mdi-heart align-middle text-danger"></i> <span
                                        class="text-dark">{{ rand(100, 1000) }}</span></a>
                            </div>
                        </div>

                        <div class="card-body p-3">
                            <a href="nft-item-detail.html" class="h5 title text-dark">#01 nft title</a>

                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <button class="btn btn-secondary">Lihat</button>
                                <span class="text-dark">Price: <span class="link">2.333ETH</span></span>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            @endfor
        </div>
        <div class="mt-5"></div>

</x-landing-layout>
