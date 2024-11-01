@props(['label', 'wire', 'place' => '', 'error', '$message', 'danger'=>'', 'type'])

<div class="mb-3">
    <label class="form-label">{{$label}} <span class="text-danger">{{$danger}}</span></label>
    <div class="form-icon position-relative">
        <input  wire:model="{{$wire}}" type="{{$type}}"
            class="form-control form-control-solid form-control-sm " placeholder="{{$place}}">
    </div>
    @error('{{$error}}')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
