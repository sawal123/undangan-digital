<form wire:submit.prevent='{{ $submit }}'>
    <input type="hidden" class="form-control" wire:model='id' id="bank" aria-describedby="emailHelp">
    <div class="mb-3">
        <label for="bank" class="form-label">Nama Bank*</label>
        <input type="text" class="form-control" wire:model='bank' id="bank" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your bank with anyone else.</div>
    </div>
    <select class="form-select mb-3" aria-label="Default  select example" wire:model='category'>
        <option selected>Pilih Kategori</option>
        <option value="credit_card">Credit Card</option>
        <option value="manual">Manual</option>
        <option value="cash">Cash</option>
        <option value="cash">Transfer</option>
        <option value="ewallet">Qris / E-Wallet</option>
        <option value="va">Virtual Account</option>
        <option value="cstore">Gerai</option>
        <option value="shopeepay">Shoope Pay</option>
        <option value="echannel">Echannel</option>
        <option value="cardless_credit">Cardless Credit</option>
    </select>
    <div class="mb-3">
        <label for="fee" class="form-label">Fee Admin*</label>
        <input type="text" class="form-control" wire:model='fee' id="fee" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your bank with anyone else.</div>
    </div>
    {{-- <div class="mb-3">
        <div class="form-floating">
            <textarea class="form-control" wire:model='deskripsi' placeholder="Leave a comment here" id="floatingTextarea2"
                style="height: 100px"></textarea>
            <label for="floatingTextarea2">Deskripsi</label>
        </div>
    </div> --}}
    <select class="form-select mb-3" aria-label="Default  select example" wire:model='deskripsi' >
        <option value="persen">Persen (%)</option>
        <option value="rupiah">Rupiah (Rp)</option>

    </select>
    <div class="mb-3 ">
        <label for="exampleInputEmail1" class="form-label">Icon Bank*</label>
        <div class="d-flex gap-2">
            @if ($noTempo)
                <img src="{{ asset('storage/' . $noTempo) }}" width="50" class="" alt=""
                    srcset="">
            @elseif ($image)
                <img src="{{ $image->temporaryUrl() }}" width="50" class="" alt="" srcset="">
            @endif
            <input type="file" class="form-control w-100" wire:model='image' id="exampleInputEmail1"
                aria-describedby="emailHelp">
        </div>
    </div>
    <button class="btn  btn-primary w-100">{{ $teks }}</button>
</form>
