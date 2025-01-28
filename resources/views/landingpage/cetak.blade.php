<div>
    <style>
        .a {
            height: 250px !important;
            width: 100%;

            object-fit: cover;
            display: block;
        }

        .cursor {
            cursor: pointer;
        }
    </style>
    <x-landing-layout>
      


        <section id="section">
            <div class="container">
                <div class="row mt-100">
                    <div class="col-12">
                        {{-- <h5 class="mb-0">Most Viewed Products</h5> --}}
                        <small class="text-sm text-danger fst-italic">Cari Berdasarkan Nama, Harga, Jenis</small>

                        <input type="search" class="form-control" placeholder="Cari Undangan Kamu.."
                            wire:model.live="search">
                            {{-- {{$search}} --}}
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    @foreach ($undangan as $index => $item)
                        <div class="col-lg-3 col-md-6 col-6 mt-4 pt-2 mb-4">
                            <div class="card shop-list border-1 border  position-relative ">
                                <ul class="label list-unstyled mb-0">
                                    <li><a href="javascript:void(0)"
                                            class="badge badge-link rounded-pill bg-primary">{{ $item->jenis }}</a>
                                    </li>
                                    <li>
                                </ul>

                                <div class="shop-image position-relative overflow-hidden rounded shadow cursor"
                                    wire:click='openModal({{ $item->id }})'>

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
                                <div class="card-body content pt-2 p-2">
                                    <div class="text-dark product-name h6">{{ $item->nama }}</div>

                                    <div class="d-flex flex-column flex-md-row flex-row justify-content-between ">
                                        <h6 class="text-dark small  mb-0 mt-0">
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
                    <!-- Tombol Load More -->
                    @if (count($undangan) >= $perPage)
                        <div class="text-center mt-4">
                            <button class="btn btn-secondary" wire:click="loadMore" wire:loading.attr="disabled">
                                <span wire:loading.remove>Load More</span>
                                <span wire:loading>Loading...</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            @if ($isOpenModal)
                @php
                    // dd($gambar)
                @endphp
                @include('landingpage.cetak.modalDetail')
            @endif
        </section>
        <section class="section mt-5" style="background: url('{{asset("assets/images/nft/bg.jpg")}}') top center;">
            @include('landingpage.welcome.start2')
        </section>
    </x-landing-layout>
</div>
