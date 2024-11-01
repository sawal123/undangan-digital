<x-dashboard-layout>


    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <small>Buat Undangan Kamu</small>
                    <button class="btn btn-danger"><i class="mdi mdi-plus-box"></i> Buat Undangan</button>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col">
            @foreach (Auth::user()->data as $data)
                <div class="alert shadow-sm">
                    <div class=" d-flex justify-content-between align-items-center">
                        <small>{{$data->slug}}</small>
                        <div class="d-flex gap-2">
                            <a href="{{url('/'. Crypt::encryptString($data->id))}}" class="btn btn-sm btn-secondary"><i class="mdi mdi-web"></i> Lihat</a>
                            <a  href="{{route('dashboard.undangan.kelola', Crypt::encryptString($data->id))}}" wire:navigate class="btn btn-sm btn-primary"><i class="mdi mdi-cog"></i> Kelola</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



</x-dashboard-layout>
