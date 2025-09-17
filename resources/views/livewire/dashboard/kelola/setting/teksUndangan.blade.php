<form wire:submit='TeksUndangan'>
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="mb-3">
                <label for="basic-url" class="form-label">Teks Pembukaan</label>
                <textarea name="" id="" class="form-control" cols="30" rows="2" wire:model='pembuka'></textarea>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="mb-3">
                <label for="basic-url" class="form-label">Teks Acara</label>
                <textarea name="" id="" class="form-control" cols="30" rows="2" wire:model='acara'></textarea>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="mb-3">
                <label for="basic-url" class="form-label">Teks Penutup</label>
                <textarea name="" id="" class="form-control" cols="30" rows="2" wire:model='penutup'></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary btn-sm">Update</button>
        </div>
    </div>
</form>
