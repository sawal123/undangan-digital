<div>
    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div
                    class="card-body d-flex d-md-flex flex-column flex-md-row justify-content-between align-items-center">
                    <small>Silahkan Tambah Acara Anda!</small>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#AddAcara"><i
                            class="mdi mdi-plus-box"></i> Tambah Acara</button>
                </div>
            </div>
        </div>
    </div>
   


    <h5>Jadwal Acara</h5>
    <hr>
    @if (session()->has('message'))
        <div class="alert alert-success my-2">
            {{ session('message') }}
        </div>
    @endif
    <div class="row">
        @forelse ($dataAcara as $item)
            <div class="col col-sm-3 mb-3">
                <div class="card  hover-shadow border border-info">
                    <div class="card-body flex-column d-flex">
                        <p class=" m-0"><strong>{{ $item->nama_acara }}</strong></p>
                        <small class="text-danger"> <i
                                class="mdi mdi-calendar"></i>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</small>
                        <small class="text-danger"> <i class="mdi mdi-clock"></i>{{ $item->jam_start }} s/d
                            {{ $item->jam_end }} Wib</small>
                        <small class="text-danger"> <i class="mdi mdi-map"></i>{{ $item->alamat }}</small>
                        <small class="text-danger text-truncate"
                            style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"> <i
                                class="mdi mdi-office-building"></i>{{ $item->vanue }}</small>
                        <div class="d-flex gap-2">
                            <button data-bs-toggle="modal"
                            data-bs-target="#hapusAcara"   onclick="@this.call('confirmDelete', {{ $item->id }})"  class="btn btn-sm btn-danger">
                                <i class="mdi mdi-trash-can"></i> Hapus
                            </button>
                            
                            <button wire:click="edit({{$item->id}})" data-bs-toggle="modal"
                                data-bs-target="#EditAcara" class="btn btn-sm btn-info"><i class="mdi mdi-book-edit"></i> Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">Tidak Ada Acara</div>
        @endforelse
    </div>
    <x-modal-confirm id="hapusAcara" deskripsi="Apakah Anda yakin ingin menghapus acara ini?" wire="delete" buttonId="confirmDelete" />
    @include('user.kelola.acara.modalAdd')
    @include('user.kelola.acara.modalEdit')
    

    
</div>
