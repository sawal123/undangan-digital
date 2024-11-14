@props(['label', 'wire'=>null, 'place' => null, 'error', '$message', 'danger'=>null, 'type', 'class' => 'mb-3'])

<div class="{{$class}}">
    <small class="form-label">{{$label}} <span class="text-danger">{{$danger}}</span></small>
    <div class="form-icon position-relative">
        <input  wire:model="{{$wire}}" type="{{$type}}"
            class="form-control form-control-solid form-control-sm " placeholder="{{$place}}">
    </div>
    @error('{{$error}}')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
