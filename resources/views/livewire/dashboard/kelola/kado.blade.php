<div>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($dataId) }}" class="btn btn-secondary btn-sm"><i
            class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>
    <div class="alert alert-info mt-2 d-flex justify-content-between align-items-center">
        <p class="m-0"> Aktifkan Fitur Kado, Agar Teman Bisa Kasih Hadiah</p>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox"
                wire:change="switch({{ $dataId }}, $event.target.checked)" {{ $fitur?->isActive ? 'checked' : '' }}
                role="switch">
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif



    <div class="row my-2">
        <div class="col-lg-12 col-md-12 my-2">
            <div class="card border border-info">
                <div class="card-body">
                    <div class="alert alert-primary d-flex justify-content-between align-items-center ">
                        <p class="m-0">Buat Metode Pengiriman Hadiah.</p>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#AddKado"
                            {{ $fitur === null || $fitur->isActive === 0 ? 'disabled' : '' }}>
                            <i class="mdi mdi-plus-box"></i>Tambah
                        </button>
                        @include('user.kelola.kado.addKado')
                    </div>
                    <hr>
                    <ul class="list-group">
                        @forelse ($kado as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="">
                                    <p class="m-0">{{ $item->giftPay->nama_pay }}</p>
                                    <small>{{ $item->namaPay }}</small> |
                                    <small>{{ $item->nomorPay }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#openModalCode"
                                        wire:click='barcodePreview({{ $item->id }})'><i
                                            class="mdi mdi-barcode-scan"></i></button>
                                    <button class="btn btn-sm btn-danger" wire:click='delete({{ $item->id }})'><i
                                            class="mdi mdi-close"></i></button>
                                </div>
                            </li>
                        @empty
                            <p>Tidak Ada Metode Kado</p>
                        @endforelse


                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('user.kelola.kado.addKado') --}}

    <div class="modal fade" id="openModalCode" wire:ignore.self tabindex="-1" aria-labelledby="openModalCodeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="openModalCodeLabel">Preview Qris</h5>
                    <button type="button" class="btn btn-secondary" wire:click='close' data-bs-dismiss="modal"
                        aria-label="Close">Tutup</button>
                </div>
                <div class="modal-body text-center">
                    @if ($barcode)
                        <img src="{{ asset('storage/' . $barcode) }}" alt="QRIS Barcode" class="img-fluid">
                    @else
                        <p>Gambar tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
