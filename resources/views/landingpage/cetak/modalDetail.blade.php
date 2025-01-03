<div class="modal fade show d-block" tabindex="-1" aria-labelledby="productview-title" aria-hidden="true"
    style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="productview-title">Detail Undangan</h5>
                <button type="button" class="btn btn-icon btn-close" wire:click="closeModal">
                    <i class="uil uil-times fs-4 text-dark"></i>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-lg-5">
                            <!-- Gambar Utama -->
                            <style>
                                .b {
                                    height: 250px !important;
                                    width: 100%;

                                    object-fit: cover;
                                    display: block;
                                    order: 1px solid #ddd;
                                }

                                /* Gambar Kecil dengan Scroll Horizontal */
                                .thumbnail-container {
                                    max-width: 100%;
                                    white-space: nowrap;
                                    overflow-x: auto;
                                    /* display: flex; */
                                    justify-content: start;
                                }

                                .thumbnail-container .thumbnail {
                                    display: inline-block;
                                    margin-right: 10px;
                                }

                                .thumbnail-container .thumbnail img {
                                    width: 80px !important;
                                    height: 80px !important;
                                    object-fit: cover;
                                    cursor: pointer;
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                }
                            </style>
                            <div class="container">
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $mainImage) }}" alt="Main Image"
                                        class="img-fluid border rounded b">
                                </div>

                                <div class="thumbnail-container">
                                    @foreach ($gambar as $image)
                                        <div class="thumbnail">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail"
                                                class="img-thumbnail cursor-pointer"
                                                wire:click="updateMainImage('{{ $image }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div><!--end col-->

                        <div class="col-lg-7 mt-4 mt-lg-0 pt-2 pt-lg-0">
                            <h4 class="title">{{ $undang->nama }}</h4>

                            <h5 class="text-muted">Rp{{ number_format($undang->promo > 0 ? $undang->promo : $undang->harga, 0, ',', '.') }}
                                @if ($undang->promo > 0)
                                    <del class="text-danger ms-2">Rp{{ number_format($undang->harga, 0, ',', '.') }}</del>
                                @endif
                            </h5>
                            {{-- <button class="btn btn-sm btn-primary">{{$undang->jenis}}</button> --}}

                            <h5 class="mt-4">Deskripsi :</h5>
                            <p class="text-muted">
                                @if ($isExpanded)
                                    <p>{!! $deskripsi !!}</p>
                                @else
                                    {!! Str::limit($deskripsi, 100) !!}
                                @endif
                            </p>

                            <!-- Tombol untuk toggling -->
                            @if ($isExpanded)
                                <button type="button" wire:click="toggleDownDescription({{ $undang->id }})"
                                    class="btn btn-sm btn-light border">
                                    Lihat Lebih Sedikit
                                </button>
                            @else
                                <button type="button" wire:click="toggleDescription({{ $undang->id }})"
                                    class="btn btn-sm btn-light border">
                                    Lihat Lebih Banyak
                                </button>
                            @endif



                            <div class="mt-4 pt-2">
                                <a href="https://wa.me/6282274677715?text=Saya+Pesan+Udangan+{{ $undang->nama }}"
                                    class="btn btn-primary">Pesan Sekarang</a>
                                    <button class="btn btn-secondary" wire:click='closeModal()'>Tutup</button>
                            </div>


                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end container-->
            </div>
        </div>
    </div>
</div>
