<x-dashboard-layout>

    <a href="/dashboard/undangan" class="btn btn-secondary btn-sm" wire:navigate><i class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>
        
        <div class="alert alert-info   d-lg-flex flex-lg-row flex-md-column  justify-content-between   align-items-center  my-2" role="alert">
            <div class="text-truncate" style="max-width: 100%;">Link Undangan Kamu: 
                <span id="copyText">https://erawedding.com/{{ $data->slug }}</span>
            </div>
            <div class="d-flex gap-2 mt-2 mt-lg-0">
                <button class="btn btn-sm btn-dark border" id="copyButton" onclick="copyToClipboard()">
                    <i class="mdi mdi-content-paste"></i> <span id="text">Salin</span>
                </button>
                <a href="https://erawedding.com/{{ $data->slug }}" class="btn btn-sm btn-primary border">
                    <i class="mdi mdi-link"></i> Kunjungi
                </a>
            </div>
        </div>
        
    <div class="alert alert-info d-lg-flex flex-lg-row flex-md-column justify-content-between align-items-center">
        <span>Kirim Undangan Ke Teman/Keluarga Kamu</span>
        <button class="btn btn-sm btn-secondary border"><i class="mdi mdi-send"></i> Kirim</button>

    </div>
    <div class="row my-5">
        @foreach ($objects as $item)
            <div class="col mx-2 my-2">
                <a href="{{url('/dashboard/kelola/'.Crypt::encryptString($data->id).'/'. $item->url)}}" wire:navigate 
                    class="features feature-primary d-flex justify-content-between align-items-center rounded border border-info  p-3 hover-shadow">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <img src="{{ asset('storage/iconKu/' . $item->icon) }}" width="30" alt=""
                                srcset="">
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">{{ $item->nama }}</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"></p>
                        </div>
                    </div>
                    {{-- <span class="text-danger"><i class="uil uil-chart-down"></i> 0.5%</span> --}}
                </a>
            </div>
        @endforeach
    </div>
    {{-- <hr> --}}



</x-dashboard-layout>
