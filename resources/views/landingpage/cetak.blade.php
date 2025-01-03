<div>
    <style>
        .a {
            height: 250px !important;
            width: 100%;

            object-fit: cover;
            display: block;
        }
        .cursor{
            cursor: pointer;
        }
    </style>
    <x-landing-layout>
        <section class="section">
            <!-- Start CTA -->
            <div class="container-fluid mt-100 mt-5">
                <div class="rounded py-5" style="background: url('assets/images/shop/cta.jpg') fixed;">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-title">
                                    <h2 class="fw-bold text-black mb-4">Cetak Undangan Untuk Hari Special Kamu <br> Dan Dapatkan Gratis Undangan Digital</h2>
                                    <p class="para-desc text-black mb-0">Rayakan momen spesialmu dengan undangan yang elegan dan memukau. Cetak undangan fisik untuk acara pernikahan, ulang tahun, atau acara penting lainnya, dan nikmati keuntungan undangan digital gratis yang dapat diakses dengan mudah oleh tamu undanganmu.
                                    </p>
                                    <div class="mt-4">
                                        <a href="https://wa.me/6282274677715?text=Saya+Ingin+Tanya+Tentang+Undangan" class="btn btn-primary">Tanya Tanya Dulu</a>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end container-->
                </div>
            </div><!--end container-->
        </section>


        <section id="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-0">Most Viewed Products</h5>
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    @foreach ($undangan as $index => $item)
                        <div class="col-lg-3 col-md-6 col-12 mt-4 pt-2 mb-4">
                            <div class="card shop-list border-1 border  position-relative ">
                                <ul class="label list-unstyled mb-0">
                                    <li><a href="javascript:void(0)"
                                            class="badge badge-link rounded-pill bg-primary">{{ $item->jenis }}</a>
                                    </li>
                                    <li>
                                </ul>
                              
                                <div class="shop-image position-relative overflow-hidden rounded shadow cursor"
                                    wire:click='openModal({{ $item->id }})' >

                                    @php
                                        // Mendecode gambar dari database
                                        $gambar = json_decode($item->gambar);
                                    @endphp @if (!empty($gambar) && isset($gambar[0]))
                                        <img src="{{ asset('storage/' . $gambar[0]) }}" alt="Thumbnail"
                                            class="img-fluid a">
                                    @else
                                        <img src="{{ asset('storage/default-thumbnail.jpg') }}" alt="Thumbnail"
                                            class="img-fluid  a ">
                                    @endif

                                </div>
                                <div class="card-body content pt-4 p-2">
                                    <div class="text-dark product-name h6">{{ $item->nama }}</div>

                                    <div class="d-flex justify-content-between mt-1">
                                        <h6 class="text-dark small fst-italic mb-0 mt-1">
                                            Rp{{ number_format($item->promo > 0 ? $item->promo : $item->harga, 0, ',', '.') }}
                                            @if ($item->promo > 0)
                                                <del
                                                    class="text-danger ms-2">Rp{{ number_format($item->harga, 0, ',', '.') }}</del>
                                            @endif
                                        </h6>
                                        <button class="btn btn-sm btn-light border border-1"
                                            wire:click='openModal({{ $item->id }})'>Lihat Detail</button>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    @endforeach
                </div>
            </div>
            {{-- <div class="col-lg-5">
                <div class="tiny-single-item">
                    <div class="tiny-slide"><img src="assets/images/shop/product/single-2.jpg" class="img-fluid rounded" alt=""></div>
                    <div class="tiny-slide"><img src="assets/images/shop/product/single-3.jpg" class="img-fluid rounded" alt=""></div>
                    <div class="tiny-slide"><img src="assets/images/shop/product/single-4.jpg" class="img-fluid rounded" alt=""></div>
                    <div class="tiny-slide"><img src="assets/images/shop/product/single-5.jpg" class="img-fluid rounded" alt=""></div>
                    <div class="tiny-slide"><img src="assets/images/shop/product/single-6.jpg" class="img-fluid rounded" alt=""></div>
                </div>
            </div><!--end col--> --}}
            @if ($isOpenModal)
                @include('landingpage.cetak.modalDetail')
            @endif
        </section>
        <section class="section" style="background: url('assets/images/nft/bg.jpg') top center;">
            @include('landingpage.welcome.start2')
        </section>
    </x-landing-layout>
</div>
