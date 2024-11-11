<div class="modal-footer">
    <button type="button" class="btn btn-secondary" wire:click='close' data-bs-dismiss="modal"><i
            class="mdi mdi-close"></i> Tutup</button>
    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i class="mdi mdi-check-bold"></i>
        {{$textButton}}</button>
</div>