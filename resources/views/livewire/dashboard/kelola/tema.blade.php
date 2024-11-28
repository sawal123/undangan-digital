<div>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($dataId) }}" class="btn btn-secondary btn-sm"><i
            class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>

    <div class="alert alert-info mt-2 d-flex justify-content-between align-items-center">
        <p class="m-0">Aktifkan Fitur Tema Agar Kamu Bisa Bebas Pilih Tema Sesuka Kamu</p>
        <a href="{{ route('dashboard.pay', Crypt::encryptString($dataId)) }}" class="btn btn-sm btn-light" wire:navigate>Aktifkan</a>
    </div>

    <div class="card border-info border mt-2">
        <div class="card-body">
            <div class="row">
                @foreach ($tema as $item)
                    <div class="col-xl- col-lg-3 col-md-6 mt-4">
                        <div class="card blog blog-primary rounded border-0 shadow overflow-hidden">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top"
                                    alt="...">
                                <div class="overlay rounded-top"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="javascript:void(0)"
                                        class="card-title title text-dark">{{ $item->nama }}</a></h5>
                                <div class="post-meta d-flex justify-content-between mt-3 gap-2">
                                    <button class="btn btn-sm btn-primary w-100">Aktifkan</button>
                                    {{-- Crypt::encryptString($dataId)  --}}
                                    <a href="{{ route('dashboard.demo', Crypt::encryptString($item->path)) }}"
                                        class="btn btn-sm btn-secondary w-100">Demo</a>
                                </div>
                            </div>
                            {{-- <div class="author">
                                <small class="text-white user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>
                                <small class="text-white date"><i class="uil uil-calendar-alt"></i> 25th June
                                    2021</small>
                            </div> --}}
                        </div>
                    </div><!--end col-->
                @endforeach
            </div>
        </div>
    </div>
</div>
