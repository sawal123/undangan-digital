<!-- Delete Confirmation Modal -->
@props(['id', 'deskripsi', 'wire'=>'','buttonId'=>''])
<div class="modal fade" id="{{ $id }}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    {{$deskripsi}}
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-sm btn-secondary" wire:click='close' data-bs-dismiss="modal"><i class="mdi mdi-close"></i> Batal</button>
                    <button type="button" class="btn btn-sm btn-danger" id="{{$buttonId}}" wire:click="{{$wire}}"><i class="mdi mdi-trash-can"></i> Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
