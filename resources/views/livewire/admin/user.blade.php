<div>
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
    @if (session('success'))
        <div class="alert alert-danger">
            {{ session('success') }}
        </div>
    @endif
    <table class="table ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">WhatsApp</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $index => $item)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" wire:click='editUser({{ $item->id }})'>Edit</button>
                        <button class="btn btn-danger btn-sm"
                            wire:click='confirmDel({{ $item->id }})'>delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($isModalOpenUser)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title">Update User</h5>
                        <button type="button" class="close btn btn-light" wire:click="closeModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="updateUser">
                    <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" wire:model="name"
                                    placeholder="Masukkan nama">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" wire:model="email"
                                    placeholder="Masukkan Email">
                            </div>
                            <div class="form-group">
                                <label>WhatsApp</label>
                                <input type="text" class="form-control" wire:model="phone"
                                    placeholder="Masukkan Nomor Wa">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
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
                            <button class="btn btn-danger" wire:click='delUser({{ $idUser }})'>Hapus</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
