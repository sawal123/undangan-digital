<x-dashboard-layout>
    @php
        // Card Top
        $nameCard = ['Visitor', 'Doa', 'Undangan'];
        $icon = ['uil-user-circle', 'uil-star', 'uil-envelope-open'];
    @endphp
    <div class="row my-5 ">
        @foreach ($nameCard as $index=>$item)
            <div class="col">
                <a href="#!"
                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil {{$icon[$index]}} fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">{{$item}}</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span class="counter-value"
                                    data-target="4589">2100</span></p>
                        </div>
                    </div>
                    {{-- <span class="text-danger"><i class="uil uil-chart-down"></i> 0.5%</span> --}}
                </a>
            </div>
        @endforeach
    </div>

    {{-- <div class="alert alert-info d-flex justify-content-between align-items-center" role="alert">
        <div class="">Link Undangan Kamu: <span id="copyText">https://erawedding.com/{{Auth::user()->data->slug}}</span></div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-dark" id="copyButton" onclick="copyToClipboard()"><i class="mdi mdi-content-paste" ></i> <span id="text">Salin</span></button>
            <a href="https://erawedding.com/{{Auth::user()->data->slug}}" class="btn btn-sm btn-primary"><i class="mdi mdi-link"></i> Kunjungi</a>
        </div>
    </div> --}}

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <small>Buat Undangan Kamu</small>
                    <a wire:navigate href="dashboard/undangan" class="btn btn-danger"><i class="mdi mdi-plus-box"></i> Buat Undangan</a>
                </div>
            </div>
        </div>
    </div> 

    
</x-dashboard-layout>
