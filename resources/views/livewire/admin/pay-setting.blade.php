<div>
    @if (session()->has('message'))
        <div class="alert bg-soft-primary fw-medium">
            <i class="mdi mdi-check-circle"></i> {{ session('message') }}
        </div>
    @endif
    <div class="row ">
        <div class="col-lg-4 col-md-12 mb-2">
            <div class="card border border-info">
                <div class="card-body">
                    @include('livewire.admin.paysetting.form')
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 mb-2">
            <div class="card border border-info">
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($paySet as $item)
                            <li class="list-group-item  d-lg-flex justify-content-between align-items-center "
                                aria-disabled="true">
                                <div class="d-flex justify-content-start align-items-center gap-5"> <img width="50"
                                        src="{{ asset('storage/' . $item->image) }}" alt="" srcset="">
                                    <span>{{ $item->bank }}</span>
                                </div>
                                <div class="my-2">
                                    <button class="btn {{ $item->isActive === 0 ? 'btn-light' : 'btn-success' }} btn-sm" wire:click='isActive({{ $item->id }})'>{{ $item->isActive === 0 ? 'DeActive' : 'Active' }} </button>
                                    <button class="btn btn-secondary btn-sm" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight{{ $item->id }}"
                                        aria-controls="offcanvasRight">Deskripsi</button>
                                    <button class="btn btn-primary btn-sm"
                                        wire:click='edit({{ $item->id }})'>Edit</button>
                                    <button class="btn btn-danger btn-sm" wire:click='delete({{ $item->id }})'>Hapus</button>
                                    
                                </div>

                            </li>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight{{ $item->id }}"
                                aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasRightLabel">Deskripsi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    {!! nl2br(e($item->deskripsi)) !!}
                                </div>
                            </div>
                        @empty
                            <p>Belum Ada Metode Payment</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
