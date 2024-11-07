<x-modal id="AddPoto" title="Tambah Poto" wire="save" textButton="Simpan" other="wire:ignore">
    <div class="modal-body">

        <label class="form-label">Gambar <span class="text-danger">*</span></label>
        <div class="form-icon position-relative">
            <input id="poto" wire:model.defer="poto" type="file" class="form-control"
                onchange="previewImage(event)">
                <p class="text-danger fs-6" style="font-size: 0.7rem!important">Photo Maks 1Mb</p>
        </div>
        <!-- Preview Gambar -->
        <div class="mt-3" id="preview-container" style="display: none;">
            <p>Photo Preview:</p>
            <img id="preview-image" class="img-thumbnail" width="150">
        </div>
    </div>
    
</x-modal>
