<div class="card border border-info">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Flash Sale</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($harga as $item)
                    <tr>
                        <th scope="row">1</th>
                        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->flashsale, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" wire:click='editFlashSale({{ $item->id }})'>Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($isModalOpenFlash)
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
                        <form wire:submit.prevent="updateFlashSale"> 
                            <div class="form-group">
                                <label for="promoDiscount">Harga</label>
                                <input type="number" id="harga" class="form-control"
                                    wire:model.defer="hargaDasar" placeholder="Masukkan Harga">
                                @error('hargaDasar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="promoDiscount">Flash Sale</label>
                                <input type="number" id="flash" class="form-control"
                                    wire:model.defer="flashSale" placeholder="Masukkan FlashSale">
                                @error('flashSale')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                        <button type="button" class="btn btn-primary"
                                wire:click="updateFlashSale({{ $idFlash }})">Update
                                Harga</button>

                    </div>
                </div>
            </div>
        </div>
    @endif

   
</div>
