<div>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($dataId) }}" class="btn btn-secondary btn-sm"><i
            class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>
    @if ($data->isActive)
        <div class="alert bg-soft-primary mt-2 d-flex justify-content-between align-items-center">
            <p class="m-0 fw-bold">Kamu Sudah Menjadi Pelanggan Premium, Pilih Tema Sesuka mu!</p>
        </div>
        @if ($data->theme_id)
            <div class="alert bg-soft-primary  d-flex justify-content-between align-items-center">
                <p class="m-0 fw-bold">Lihat Theme Yang Kamu Pilih Dengan Data Kamu</p>
                <a href="{{ route('visit', $data->slug) }}" class="btn btn-sm btn-danger"
                   >Kunjungi Tema</a>
            </div>
        @endif
    @else
        <div class="alert alert-info mt-2 d-flex justify-content-between align-items-center">
            <p class="m-0">Aktifkan Fitur Tema Agar Kamu Bisa Bebas Pilih Tema Sesuka Kamu</p>

            <a href="{{ route('dashboard.pay', Crypt::encryptString($dataId)) }}" class="btn btn-sm btn-light"
                wire:navigate>Aktifkan</a>

        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert bg-soft-dark mt-2">
            {{ session('message') }}
        </div>
    @endif

    <div class="card border-info border mt-2">
        <div class="card-body">
            <div class="row">
                @foreach ($tema as $item)
                    <div class=" col-lg-2 col-md-6 mt-2 mx-1 border  rounded" style="padding: 0px !important">
                        <div class="card blog blog-primary  overflow-hidden">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top"
                                    alt="...">
                                <div class="overlay rounded-top"></div>
                            </div>
                            <div class="card-body content" style="padding: 15px">
                                <a href="javascript:void(0)" class="card-title title text-dark">{{ $item->nama }}</a>
                                <div class="post-meta d-flex justify-content-between mt-3 gap-2">
                                    @if ($data->isActive)
                                        @if ($data->theme_id == $item->id)
                                            <button class="btn btn-sm btn-success w-100">TERPILIH</button>
                                        @else
                                            <button class="btn btn-sm btn-primary w-100"
                                                wire:click='choose({{ $item->id }})'>Aktifkan</button>
                                        @endif
                                    @endif
                                    <a href="{{ route('dashboard.demo', [
                                        'demo' => Crypt::encryptString($item->demo),
                                        'id' => Crypt::encryptString($item->id),
                                    ]) }}"
                                        class="btn btn-sm btn-secondary w-100">Demo</a>
                                </div>
                            </div>

                        </div>
                    </div><!--end col-->
                @endforeach
            </div>
        </div>
    </div>
</div>
