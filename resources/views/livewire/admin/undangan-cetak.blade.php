<div>
    <div class="card">
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert bg-soft-primary fw-medium">
                    <i class="mdi mdi-check-circle"></i> {{ session('message') }}
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" wire:click='openModal'>Tambah Undangan</button>
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
                    @foreach ($undangan as $index => $item)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>{{ $item->terjual }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>{{ $item->promo }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="" width="40">
                            </td>
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

            @if ($isModalOpen)
                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
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
                                                <select class="form-select" aria-label="Jeni Undangan">
                                                    <option selected>Open this select Jenis</option>
                                                    <option value="Maliq">Maliq</option>
                                                    <option value="Invinity">Invinity</option>
                                                    <option value="Erba">Erba</option>
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
                                    <x-forms.tinymce-editor/>
                                    <div class="form-group">
                                        <label>Thumbnail (Optional)</label>
                                        <input type="file" class="form-control" wire:model="thumbnail">
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
        </div>
    </div>
</div>
