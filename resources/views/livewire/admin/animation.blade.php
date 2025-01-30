<div>
    <div class="card">
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert bg-soft-primary fw-medium">
                    <i class="mdi mdi-check-circle"></i> {{ session('message') }}
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" wire:click='openModal'>Tambah Animasi</button>
                <div class="form-input">
                    <input type="text" class="form-control my-2 border border-danger responsive-input">
                </div>
            </div>
            <div class="table-responsive"></div>
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Link</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($animation as $index => $item)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->link }}</td>
                            <td>
                                {{ $item->thumbnail }}
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm"
                                    wire:click='editAnimasi({{ $item->id }})'>Edit</button>
                                <button class="btn btn-danger btn-sm"
                                    wire:click='confirmDel({{ $item->id }})'>delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($isModalOpen)
                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title">{{ $judul }} Video Animasi</h5>
                                <button type="button" class="close btn btn-light" wire:click="closeModal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form wire:submit.prevent="{{ $judul === 'Edit' ? 'updateAnimasi' : 'saveAnimation' }}">
                                <div class="modal-body">
                                    <div class="form-group ">
                                        <label for="">Nama Animasi</label>
                                        <input type="text" class="form-control" wire:model='nama'>
                                    </div>
                                    <div class="form-group my-3">
                                        <label>Link</label>
                                        <input type="text" class="form-control" wire:model="link"
                                            placeholder="Masukkan link">
                                        @error('link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" aria-label="Default select example" wire:model='thumbnail'>
                                            <option value="" selected disabled>Open this select menu</option>
                                            @foreach ($select as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('thumbanail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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

            @if ($delModalOpen)
                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-body p-5">
                                <p class="text-center">Apakah Anda Yakin Hapus Transaksi?</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-light border" wire:click="closeModal">Batal</button>
                                    <button class="btn btn-danger"
                                        wire:click='delAnimasi({{ $animasi->id }})'>Hapus</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
