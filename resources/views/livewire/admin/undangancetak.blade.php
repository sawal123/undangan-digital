<div>
    <div class="d-flex justify-content-end">
        <!-- Button to trigger the Offcanvas -->
        <button class="btn btn-secondary mb-5 w-100" wire:click="toggle">Jenis Undangan</button>

        <!-- Offcanvas itself -->
        <div class="offcanvas pe-2 offcanvas-end {{ $isOpen ? 'show' : '' }}" tabindex="-1" id="offcanvasRight"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header d-flex justify-content-between">
                <h5 id="offcanvasRightLabel">Jenis Undangan</h5>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas" aria-label="Close"
                    wire:click="toggle">Close</button>
            </div>
            <div class="offcanvas-body">
                <form wire:submit.prevent='createJenis'>
                    <div class="mb-3">
                        <input type="text" class="form-control" wire:model='jenisUndangan'
                            aria-describedby="emailHelp">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100">Simpan</button>
                </form>

                <ul class="list-group mt-5">
                    @foreach ($jenisUn as $item)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                {{ $item->jenis }}
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-primary"
                                        wire:click='editJenis({{ $item->id }})'>Edit</button>
                                    <button class="btn btn-sm btn-danger"
                                        wire:click='delJenis({{ $item->id }})'>Del</button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert bg-soft-primary fw-medium">
                    <i class="mdi mdi-check-circle"></i> {{ session('message') }}
                </div>
            @endif

            <div class="d-flex gap-2 flex-column flex-lg-row w-100 justify-content-between align-items-center">
                <!-- Input -->
                <div class="form-input w-40">
                    <input type="text" wire:model.live="search"
                        class="form-control my-2 border border-danger responsive-input w-100"
                        placeholder="Cari Undangan">
                </div>
                <!-- Button -->
                <button class="btn btn-primary mb-2 mb-lg-0" wire:click='openModal'>Tambah</button>
            </div>



            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Terjual</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Promo</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($u as $index => $item)
                            <tr>
                                <th scope="row">{{ ($u->currentPage() - 1) * $u->perPage() + $index + 1 }}</th>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @php
                                        // Mendecode gambar dari database
                                        $gambar = json_decode($item->gambar);
                                    @endphp @if (!empty($gambar) && isset($gambar[0]))
                                        <img src="{{ asset('storage/' . $gambar[0]) }}" alt="Thumbnail"
                                            class="img-thumbnail" width="40">
                                    @else
                                        <!-- Gambar default jika tidak ada gambar -->
                                        <img src="{{ asset('storage/default-thumbnail.jpg') }}" alt="Thumbnail"
                                            class="img-thumbnail" width="40">
                                    @endif
                                </td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ $item->terjual }}</td>
                                <td>{{ $item->harga }}</td>
                                <td>{{ $item->promo }}</td>

                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        wire:click='editUndangan({{ $item->id }})'>Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        wire:click='confirmDel({{ $item->id }})'>delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $u->links(data: ['scrollTo' => false]) }}
                </div>
            </div>

            @if ($isModalOpen)
                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog"
                    wire:ignore.self>
                    <div class="modal-dialog  modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title">{{ $judul }} Cetak Undangan</h5>
                                <button type="button" class="close btn btn-light" wire:click="closeModal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form wire:submit.prevent="{{ $judul === 'Tambah' ? 'saveUndangan' : 'upUndangan' }}">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group ">
                                                <label for="">Nama Undangan</label>
                                                <input type="text" class="form-control" wire:model='nama'>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group ">
                                                <label for="">Jenis</label>
                                                <select class="form-select" aria-label="Jeni Undangan"
                                                    wire:model='jenis'>
                                                    <option selected>Open this select Jenis</option>
                                                    @foreach ($jenisUn as $item)
                                                        <option value="{{ $item->jenis }}">{{ $item->jenis }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group my-3">
                                                <label>Stok</label>
                                                <input type="number" class="form-control" wire:model="stok"
                                                    placeholder="Masukkan Stok">
                                                @error('stok')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group my-3">
                                                <label>Terjual</label>
                                                <input type="number" class="form-control" wire:model="terjual"
                                                    placeholder="Terjual">
                                                @error('terjual')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group my-3">
                                                <label>Harga</label>
                                                <input type="number" class="form-control" wire:model="harga"
                                                    placeholder="Masukkan Harga">
                                                @error('Harga')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group my-3">
                                                <label>Promo</label>
                                                <input type="number" class="form-control" wire:model="promo"
                                                    placeholder="Promo">
                                                @error('promo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <x-forms.tinymce-editor /> --}}
                                    <x-editor.ckeditor />

                                    <div class="form-group my-3">
                                        <label>Thumbnail</label>
                                        <input type="file" class="form-control" wire:model="thumbnails" multiple>
                                        @error('thumbnails')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if ($judul === 'Edit')
                                        <div class="my-3" id="thumbnail-container" wire:poll wire:ignore.self>
                                            @php

                                                // Gabungkan gambar lama dan gambar baru (hindari duplikasi)
                                                $combinedThumbnails = array_merge(
                                                    $img ?? [], // Gambar lama dari database
                                                    $thumbnails ?? [], // Gambar sementara yang baru diupload
                                                );

                                                // Hapus duplikasi
                                                $combinedThumbnails = array_unique($combinedThumbnails);

                                            @endphp
                                            @foreach ($combinedThumbnails as $index => $thum)
                                                <div class="position-relative d-inline-block"
                                                    wire:key="thumbnails-{{ $index }}"
                                                    wire:dirty.class="bg-warning" wire:ignore>
                                                    <img src="{{ asset('storage/' . $thum) }}" alt="Thumbnail"
                                                        class="img-thumbnail" width="100">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                        style="z-index: 10"
                                                        wire:click="hapusGambar({{ $index }})">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        wire:click="closeModal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($modalDelete)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body p-5">
                        <p class="text-center">Apakah Anda Yakin Hapus Transaksi?</p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-light border" wire:click="closeModal">Batal</button>
                            <button class="btn btn-danger"
                                wire:click='delUndangan({{ $idTrans }})'>Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
