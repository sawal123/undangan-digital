@props(['label'=> null, 'wire' => null, 'place' => null, 'error', '$message', 'danger' => null, 'type', 'class' => 'mb-3'])

<div class="{{ $class }}">
    @if ($label)
        <label class="form-label">{{ $label }} <span class="text-danger">{{ $danger }}</span></label>
    @endif
    <div class="form-icon position-relative">
        <input wire:model.live="{{ $wire }}" type="{{ $type }}"
            class="form-control form-control-solid form-control-sm " placeholder="{{ $place }}">
    </div>
    @error('{{ $error }}')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>