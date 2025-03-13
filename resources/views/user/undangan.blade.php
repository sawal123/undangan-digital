<x-dashboard-layout>


    {{-- <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-center">
                    <small>Buat Undangan Kamu</small>
                    <button class="btn btn-danger" wire:click='add'><i class="mdi mdi-plus-box"></i> Buat Undangan</button>
                </div>
            </div>
        </div>
    </div> --}}
    <hr>

    <div class="row">
        <div class="col">
            @foreach (Auth::user()->data as $data)
            <div class="alert border border-info py-3">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3">
                    <!-- Judul -->
                    <strong class="text-start">{{ $data->title }}</strong>
            
                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-2 flex-wrap">
                        @if ($data->isActive)
                            <button class="btn btn-sm btn-warning" disabled>Premium</button>
                        @else
                            <a href="{{ route('dashboard.pay', Crypt::encryptString($data->id)) }}" 
                               class="btn btn-sm btn-light border border-info" wire:navigate>
                                Aktifkan Sekarang
                            </a>
                        @endif
            
                        <a href="{{url('/u/').'/'.$data->slug }}" class="btn btn-sm btn-secondary">
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
