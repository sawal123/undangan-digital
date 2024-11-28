<div>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($dataId) }}" class="btn btn-secondary btn-sm"  ><i
        class="mdi mdi-arrow-left-bold"></i>
    Kembali</a>

    <div class="alert alert-info mt-2 d-flex align-items-center gap-3">
        <i class="mdi mdi-security fs-1"></i>
        <div class="">
            <p class="m-0 fw-bold">Nomor WhatsApp Tamu Kamu Akan Tetap Aman Disini.</p>
            <small>Jika kamu ragu, harap tidak mengisi nomor whatsapp!</small>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif
    <div class="row mt-2">
        <div class="col">
            <div class="card border border-info">
                <div class="card-body">
                    <div
                        class="d-sm-flex flex-sm-column d-lg-flex flex-lg-row justify-content-between gap-5 align-items-center">
                        <x-input-live type="text" label="" class="mb-1 " danger="" wire="query"
                            place="Cari Tamu" error="query" message="$message" />
                        <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#AddTamu"><i class="mdi mdi-plus"></i> Tambah
                            Tamu</button>
                            @include('user.kelola.tamu.addTamu')

                    </div>
                    <div class="table-responsive">
                        <table class="table  caption-top">
                            <caption>Data Tamu</caption>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>WhatsApp</th>
                                    <th>Kode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tamu as $index=>$item)
                                    <tr>
                                        <th>{{ ($tamu->currentPage() - 1) * $tamu->perPage() + $index + 1 }}</th>
                                        <td><small>{{ $item->nama }}</small></td>
                                        <td><small>
                                                @if ($item->nomor)
                                                    {{ $item->nomor }}
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>Tidak
                                                        Tersedia</button>
                                                @endif
                                            </small></td>
                                        <td><small>{{ $item->kode }}</small></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-light border-info" data-bs-toggle="modal" data-bs-target="#shareTamu"
                                                    wire:click="shareTamu({{ $item->id }})">
                                                    <i class="mdi mdi-share-variant"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light border-info"
                                                    wire:click="shareWA({{ $item->id }})">
                                                    <i class="mdi mdi-whatsapp"></i>
                                                </button>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light border-info dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        <li><a class="dropdown-item"
                                                                href="{{ url('/') . '/' . $item->data->slug . '/' . $item->kode }}">Lihat
                                                                Undangan</a>
                                                        </li>
                                                        <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#EditTamu"
                                                                wire:click='EditTamu({{ $item->id }})'>Edit</button>
                                                        </li>
                                                        <li><button class="dropdown-item"
                                                                wire:click="delete({{ $item->kode }})">Hapus</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    {{-- <small>Belum Ada Tamu Yang Diundang</small> --}}
                                @endforelse

                            </tbody>
                        </table>
                        @if ($tamu->isEmpty())
                            <div class="text-center my-3">
                                <small>Belum Ada Tamu Yang Diundang</small>
                            </div>
                        @endif
                        <div class="my-3">
                            {{ $tamu->links(data: ['scrollTo' => false]) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('user.kelola.tamu.editTamu')
    <x-modal-slot id="shareTamu" title="Share Link" other="wire:ignore.self">
        <div class="p-3">
            <div class="d-flex gap-2">Nama: {{ $invite ? $invite[0] : 'Tidak tersedia' }}</div>
            <div class="d-flex gap-2">Kode: {{ $invite ? $invite[1] : 'Tidak tersedia' }}</div>
            <hr>
            <label for="">Link undangan</label>
            <input wire:model="slug" id="slugInput" type="url" class="form-control form-control-solid form-control-sm">
<button id="copyButton" class="btn btn-danger btn-sm w-100 mt-2" onclick="copyToClipboard()">Copy Link</button>
            
        </div>
    </x-modal-slot>

    

</div>
