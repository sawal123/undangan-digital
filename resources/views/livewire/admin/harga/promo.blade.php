<div class="card border border-info my-2">

    <div class="card-body">
        <div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-sm btn-primary" wire:click="openModal">Buat Promo</button>
            </div>
            @if ($isModalOpen)
                <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between">
                                <h5 class="modal-title">Buat Promo</h5>
                                <button type="button" class="close btn btn-light" wire:click="closeModal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form wire:submit.prevent="savePromo">
                                    <div class="form-group">
                                        <label for="promoName">Nama Promo</label>
                                        <input type="text" id="promoName" class="form-control"
                                            wire:model.live="promoName" placeholder="Masukkan nama promo">
                                        @error('promoName')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group my-3">
                                        <select class="form-select" aria-label="Default select example"
                                            wire:model.defer="promoType">
                                            <option selected>Type Nominal</option>
                                            <option value="rupiah">Rupiah</option>
                                            <option value="persen">Persen</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="promoDiscount">Diskon (%)</label>
                                        <input type="number" id="promoDiscount" class="form-control"
                                            wire:model.defer="promoDiscount" placeholder="Masukkan diskon">
                                        @error('promoDiscount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                                @if ($checkUpdate)
                                    <button type="button" class="btn btn-primary"
                                        wire:click="updatePromo({{ $idPromo }})">Update
                                        Promo</button>
                                @else
                                    <button type="button" class="btn btn-primary" wire:click="savePromo">Simpan
                                        Promo</button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Promo</th>
                    <th scope="col">Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promo as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $item->kode }}</td>
                        <td>Rp{{ number_format($item->promo, 0, ',', '.') }}</td>
                        <td>{{ $item->type }}</td>
                        <td>

                            <button class="btn btn-primary btn-sm"
                                wire:click='editPromo({{ $item->id }})'>Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
