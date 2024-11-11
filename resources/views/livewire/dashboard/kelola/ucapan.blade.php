<div>
    @php
        use Carbon\Carbon;

        $switches = [
            [
                'label' => 'Fitur Ucapan & Doa',
                'description' => null,
                'field' => 'isActive',
            ],
            [
                'label' => 'Semua Orang bisa kirim ucapan',
                'description' =>
                    'Orang lain yang memiliki link undanganmu akan bisa berkomentar. Mohon dipertimbangkan, bisa saja orang tak diundang dapat berkomentar tidak baik.',
                'field' => 'publicIsActive',
            ],
            [
                'label' => 'Tampilkan Hasil Ucapan',
                'description' => 'Hasil Ucapan & Doa akan ditampilkan di undangan',
                'field' => 'viewIsActive',
            ],
        ];
    @endphp

    @foreach ($switches as $switch)
        <div class="alert alert-info mt-2 mb-1 d-flex justify-content-between align-items-center">
            <div>
                <p class="m-0">{{ $switch['label'] }}</p>
                @if ($switch['description'])
                    <small class="fw-bold" style="font-size: 10px">{{ $switch['description'] }}</small>
                @endif
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                    wire:change="updateFiturUcapan({{ $dataId }}, $event.target.checked, '{{ $switch['field'] }}')"
                    {{ $fitUcapan?->{$switch['field']} ? 'checked' : '' }} role="switch">
            </div>
        </div>
    @endforeach

    <hr>
    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif

    <div class="row my-2">
        <div class="col-lg-12 col-md-12 my-2">
            <div class="card border border-info">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Ucapan & Doa</h5>
                        </div>
                        <div class="w-100 mb-2">
                            <x-input-live type="text" label="" class="mb-0 w-100" danger="" wire="query"
                                place="Cari Nama:" error="vanue" message="$message" />
                        </div>
                    </div>

                    <div class="list-group">
                        @forelse ($ucapan as $item)
                            <div class="list-group-item list-group-item-action" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                    <small class="mb-1"><strong>{{ $item->tamu->nama }}</strong> -
                                        {{ $item->status }}</small>
                                    <small style="font-size: 10px">{{ $item->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="d-flex flex-column">
                                    <small><i class="mdi mdi-comment-account-outline"></i> {{ $item->ucapan }}</small>
                                    @if ($item->balas)
                                        <small class="text-danger ms-2 fw-bold"><i
                                                class="mdi mdi-comment-arrow-right"></i>
                                            {{ $item->balas }}</small>
                                    @endif
                                </div>
                                <form wire:submit.prevent='tanggapi({{ $item->id }})'>
                                    <x-form-input type="text" label="" class="mb-1" danger=""   wire="balas.{{$item->id}}" 
                                        place="Tanggapi Ucapan & Doa Disini :" error="balas" message="$message" />
                                        
                                    <button class="btn btn-sm btn-light border text-danger" data-bs-toggle="modal"
                                    wire:click="confirmDelete({{ $item->id }})">Hapus</button>

                                    <button type="submit"
                                        class="btn btn-sm btn-primary ">{{ $item->balas ? 'Ubah Tanggapan' : 'Tanggapi' }}</button>
                                </form>
                            </div>
                        @empty
                            <small class="text-center mt-3">
                                <p>Tidak Ada Ucapan & Doa</p>
                            </small>
                        @endforelse

                    </div>
                    <div class="my-3">
                        {{ $ucapan->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal-confirm id="hapusUcapan" deskripsi="Apakah Anda yakin ingin hapus permanen Ucapan & Doa?" wire="delete"
        buttonId="confirmDelete" />
    {{-- onclick="@this.call('confirmDelete', {{ $item->id }} --}}
    {{-- wire="balas.{{ $item->id }}" --}}
</div>
