<x-dashboard-layout>


    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-center">
                    <small>Buat Undangan Kamu</small>
                    <a href="dashboard/add-undangan/{{ base64_encode(Auth::user()->id) }}" wire:navigate
                        class="btn btn-danger"><i class="mdi mdi-plus-box"></i> Buat Undangan</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @if (session('message'))
        <div class="alert alert-danger alert-dismissible  fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col">
            {{-- <a href="/setup" class="btn btn-primary">Buat Baru</a> --}}
            @foreach (Auth::user()->data as $data)
                <div class="alert border border-info py-3">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                        <!-- Judul -->
                        <strong class="text-start">{{ $data->title }}</strong>
                        {{-- {{$data->transaction}} --}}
                        @php
                            $hasPending = collect($data->transaction)->contains('payment_status', 'PENDING');
                        @endphp

                        <!-- Tombol Aksi -->
                        <div class="d-flex gap-2 flex-wrap">
                            @if ($hasPending)
                                <a href="/dashboard/finishtunai/{{ Crypt::encryptString($data->id) }}"
                                    class="btn btn-sm btn-soft-dark border-1">Sedang DiProses</a>
                            @else
                                @if ($data->isActive)
                                    <button class="btn btn-sm btn-warning" disabled>Premium</button>
                                @else
                                    <a href="{{ route('dashboard.pay', Crypt::encryptString($data->id)) }}"
                                        class="btn btn-sm btn-light border border-info" wire:navigate>
                                        Aktifkan Sekarang
                                    </a>
                                @endif
                            @endif


                            <a href="{{ url('/u/') . '/' . $data->slug }}" class="btn btn-sm btn-secondary">
                                <i class="mdi mdi-web"></i> Lihat
                            </a>
                            <a href="{{ route('dashboard.undangan.kelola', Crypt::encryptString($data->id)) }}"
                                wire:navigate class="btn btn-sm btn-primary">
                                <i class="mdi mdi-cog"></i> Kelola
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



</x-dashboard-layout>
