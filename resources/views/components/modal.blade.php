@props(['id' => null, 'name' => null, 'title' => '', 'wire' => null, 'textButton' => null, 'other' => null, 'show' => false, 'focusable' => false])

@php
    $modalId = $id ?? $name;
@endphp

<div class="modal fade" id="{{ $modalId }}" data-bs-backdrop="static" {{ $other }} tabindex="-1" aria-labelledby="{{ $modalId }}-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            @if ($wire)
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="{{ $modalId }}-title">{{ $title }}</h5>
                <button type="button" class="btn btn-icon btn-close" wire:click='close' data-bs-dismiss="modal" id="close-modal{{ $modalId }}" ><i
                        class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            <form wire:submit.prevent="{{ $wire }}" enctype="multipart/form-data">
                @csrf
               {{ $slot }}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='close' data-bs-dismiss="modal"  ><i
                        class="mdi mdi-close"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i class="mdi mdi-check-bold"></i> {{ $textButton }}</button>
                </div>
            </form>
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
</div>
