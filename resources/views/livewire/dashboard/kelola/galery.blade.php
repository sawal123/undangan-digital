<div>
    <div class="row my-2">
        <div class="col">
            <div class="card border border-info">
                <div
                    class="card-body d-flex d-md-flex flex-column flex-md-row justify-content-between align-items-center">
                    @if ($data->count() < 10)
                        <small>Silahkan Tambah Galery Anda, <strong>Maksimal 10 Galery!</strong></small>
                    @else
                        <small><strong>Kapasitas Galery Anda Sudah Mencapai Batas!</strong></small>
                    @endif
                    <div class="d-flex gap-2">
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#AddPoto"><i
                                class="mdi mdi-image"></i> Tambah Poto</button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#AddVideo"><i
                                class="mdi mdi-video"></i> Tambah Video</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row">
        @php
            $lastItem = $data->last();
        @endphp
        @forelse ($data as $index => $item)
            <div class="col-lg-3 col mt-4 ">
                <div class="card border work-container work-classic rounded overflow-hidden hover-shadow ">
                    <div class="card-body p-0">

                        @if ($item->poto !== null)
                            <img src="{{ asset('storage/' . $item->poto) }}" loading="lazy"
                                style="object-fit: cover; height: 200px; " class="img-fluid w-100" alt="work-image">
                        @else
                            <iframe src="{{ $item->video }}" class="w-100" style="object-fit: cover; height: 200px;"
                                frameborder="0"></iframe>
                        @endif


                        <div class="content p-3">
                            <div class="row">
                                <div class="col-12 ">
                                    <ul class="pagination d-flex justify-content-center mb-0 ">
                                        <li class="page-item"
                                            @if ($index !== 0) wire:click='previous({{ $item->sort }})' @endif>
                                            <a class="page-link @if ($index === 0) bg-light text-dark border-0 @endif"
                                                href="javascript:void(0)" aria-label="Previous"><i
                                                    class="mdi mdi-arrow-left"></i></a>
                                        </li>
                                        <li class="page-item d-flex">
                                            <button class=" btn btn-sm btn-light text-center" style="line-height: 27px"
                                                data-bs-toggle="modal" data-bs-target="#previewModal"
                                                wire:click='pre({{ $item->id }})'>Preview</button>


                                            <button
                                                class="btn btn-sm btn-light border text-danger"
                                                data-bs-toggle="modal" data-bs-target="#hapusGalery"
                                                wire:click='confirmDelete({{ $item->id }})'>Hapus</button>
                                        </li>
                                        <li class="page-item"
                                            @if ($data->count() !== $index + 1) wire:click='next({{ $item->sort }})' @endif>
                                            <a class="page-link  @if ($data->count() === $index + 1) bg-light text-dark border-0 @endif"
                                                href="javascript:void(0)" aria-label="Next"><i
                                                    class="mdi mdi-arrow-right"></i></a>
                                        </li>
                                    </ul>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        @empty
            <div class="text-center">
                Belum Ada Galery.
            </div>
        @endforelse
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" wire:ignore.self tabindex="-1" aria-labelledby="previewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="previewModalLabel">Preview Media</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Tutup</button>
                </div>
                <div class="modal-body  ">
                    @if (!empty($preview) && $preview->poto)
                        <img src="{{ asset('storage/' . $preview->poto) }}" loading="lazy" style="object-fit: cover;"
                            class="img-fluid" alt="work-image">
                    @elseif (!empty($preview) && $preview->video)
                        <iframe src="{{ $preview->video }}" style="object-fit: cover; height: 100vh;" class="w-100"
                            frameborder="0"></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-modal-confirm id="hapusGalery" deskripsi="Apakah Anda yakin ingin menghapus galery ini?" wire="delete({{ $deleteId }})"
        buttonId="confirmDelete" />
    @include('user.kelola.galery.modalAddPoto')
    @include('user.kelola.galery.modalAddVideo')

    <style>
        .preview-full-width {
            width: 100%;
            max-height: 80vh;
            /* Atur batas tinggi jika diperlukan */
            object-fit: cover;
            /* Sesuaikan isi gambar */
        }
    </style>


</div>
