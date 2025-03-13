<div>
    <h6><strong>Transaksi</strong></h6>
    <style>
        .responsive-input {
            width: 100%;
            /* Full width by default */
            max-width: none;
            /* Remove default max-width */
        }

        @media (min-width: 992px) {

            /* For devices larger than 992px (Desktop) */
            .responsive-input {
                max-width: 300px;
                /* Restrict width on desktop */
                width: 100%;
                /* Maintain responsive layout */
            }
        }
    </style>
    {{-- @include('livewire.admin.harga.transaksi') --}}
    <div class="form-input">
        <input type="text" class="form-control my-2 border border-danger responsive-input">
    </div>
    <div class="table-responsive"></div>
    <table class="table ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Invoice</th>
                <th scope="col">Title</th>
                <th scope="col">Email</th>
                <th scope="col">Kode</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col">Type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $index => $item)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $item->invoice }}</td>
                    <td>{{ $item->data->title }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->gross_amount }}</td>
                    <td><span class="badge text-bg-secondary">{{ $item->payment_status }}</span></td>
                    <td>{{ $item->payment_type }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                            wire:click='editTransaksi({{ $item->id }})'>Edit</button>
                        <button class="btn btn-danger btn-sm"
                            wire:click='confirmDel({{ $item->id }})'>delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($isModalOpenTrans)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title">Update Transksi</h5>
                        <button type="button" class="close btn btn-light" wire:click="closeModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateFlashSale">
                            <div class="form-group my-3">
                                <select class="form-select" aria-label="Default select example"
                                    wire:model.defer="statusTrans">
                                    <option selected>Type Nominal</option>
                                    <option value="SUCCESS">SUCCESS</option>
                                    <option value="PENDING">PENDING</option>
                                    <option value="CANCEL">CANCEL</option>
                                    <option value="FAILED">FAILED</option>
                                    <option value="EXPIRED">EXPIRED</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Type Transaksi</label>
                                <input type="text" class="form-control" wire:model="typeTrans"
                                    placeholder="Masukkan Type">
                                @error('typeTrans')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                        <button type="button" class="btn btn-primary"
                            wire:click="updateTrans({{ $idTrans }})">Update
                            Transaksi</button>

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($modalDelete)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-body p-5">
                        <p class="text-center">Apakah Anda Yakin Hapus Transaksi?</p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-light border" wire:click="closeModal">Batal</button>
                            <button class="btn btn-danger"
                                wire:click='delTransaksi({{ $idTrans }})'>Hapus</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
