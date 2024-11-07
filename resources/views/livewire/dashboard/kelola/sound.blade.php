<div>

    <div class="alert alert-info mt-2 d-flex justify-content-between align-items-center">
        <p class="m-0"> Aktifkan Fitur Backsound Untuk Undangan Kamu</p>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox"
                wire:change="switch({{ $dataId }}, $event.target.checked)" {{ $sound?->isActive ? 'checked' : '' }}
                role="switch">
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif
    <div class="row my-2">
        <div class="col-lg-5 col-md-12 my-2">
            <div class="card border border-info">
                <div class="card-body">

                    @if ($selectM || $sound || $youtube)
                        @php
                            $selectMusik = '';
                            if ($url) {
                                $selectMusik = $url;
                            } else {
                                if ($selectM) {
                                    $selectMusik = $selectM->link . '?start=' . $detik;
                                } elseif ($sound->sound) {
                                    $selectMusik = ($sound->sound ?? '') . '?start=' . ($sound->start ?? 0);
                                } else {
                                    if ($url) {
                                        $selectMusik = $url;
                                    }
                                }
                            }
                        @endphp
                        <iframe src=" {{ $selectMusik }}" frameborder="0" class="w-100 rounded-md"></iframe>

                        <form wire:submit.prevent='save'>
                            <input type="hidden" wire:model='link'
                                value="
                           {{ $url = $url ? $url : $selectM?->link }}
                            ">
                            <x-input-live type="number" label="Mulai Detik Ke :" danger="" wire="detik"
                                place="60 Detik" error="detik" message="$message" class="mb-0" />
                            <small class="text-danger">Musik akan di putar mulai pada detik ke
                                ({{ $detik }})</small>
                            <hr>
                            <button class="btn btn-primary w-100 my-1"><i class="mdi mdi-check-all"></i> Simpan</button>
                        </form>
                        <button class="btn btn-danger w-100 my-1" wire:click='delete({{ $sound ? $sound->id : '' }})'><i
                                class="mdi mdi-trash-can"></i> Hapus Musik</button>
                    @else
                        <small class="text-center text-danger border rounded-md p-3 text-bg-light fw-bold d-flex">Kamu
                            Belum
                            Memiliki Musik.</small>
                    @endif
                </div>
            </div>
        </div>


        <div class="col-lg-7 col-md-12 my-2">
            <div class="card border border-info p-0">
                <div class="card-header d-flex justify-content-center ">
                    <p class="fw-bold m-0">Daftar Kumpulan Musik</p>
                </div>
                <div class="card-body m-0 p-4">
                    <form wire:submit='convertUrl'>
                        <x-form-input type="url" label="Masukan Link Youtube:" wire="youtube"
                            place="https://www.youtube.com/watch?v=66lWBau" error="detik" message="$message"
                            class="mb-1" />
                        <button class="btn btn-sm btn-primary m-0">Masukan Musik</button>
                    </form>
                    <hr>
                    <p class="m-0">Pilih List Musik Dari Kami</p>
                    <x-input-live type="text" label="" wire="query" place="Cari Musik Disini :"
                        error="detik" message="$message" class="" />
                    <small class="text-danger">Cari Berdasarkan nama Artis, Judul, Kategory</small>

                    <ol class="list-group  mt-3">
                        @forelse ($musik as $item)
                            @php
                                $isSelected = $item->id === $selectM?->id || $item->link === ($sound->sound ?? '');
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-center {{ $isSelected ? 'active' : '' }}"
                                wire:click='selectMusic({{ $item->id }})' style="cursor: pointer">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $item->judul }}</div>
                                    {{ $item->artis }} - <span class="fs-6">{{ $item->category }}</span>
                                </div>
                                @if ($isSelected)
                                    <span class="badge text-bg-light rounded-pill"><i
                                            class="mdi mdi-check-all"></i></span>
                                @endif
                            </li>
                        @empty
                            <small class="text-center text-danger border rounded-md p-3 text-bg-light fw-bold">Music
                                Tidak Ditemukan!</small>
                        @endforelse
                        <div class="my-3">
                            {{ $musik->links(data: ['scrollTo' => false]) }}
                        </div>
                    </ol>
                </div>

            </div>
        </div>
    </div>
</div>
