@props(['id', 'title', 'wire', 'other' => null])

<div class="modal fade" id="{{ $id }}" data-bs-backdrop="static" {{ $other }} tabindex="-1"
    aria-labelledby="{{ $id }}-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="{{ $id }}-title">{{ $title }}</h5>
                <button type="button" class="btn btn-icon btn-close" wire:click='close' data-bs-dismiss="modal"
                    id="close-modal{{ $id }}"><i class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
