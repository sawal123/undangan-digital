<div class="row row-cols-auto">
    @foreach ($pay as $item)
        @if ($item->category === 'manual')
            <div class="col-4 mb-2">
                <div class="border border-red rounded rad" wire:click='ifee({{ $item->id }})'>
                    <input type="radio" class="btn-check" id="pay{{ $item->id }}" name="channel"
                        value="{{ $item->slug }}_va" wire:model.lazy="channel">
                    <label for="pay{{ $item->id }}"
                        class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center p-3 mb-0">
                        <div class="symbol symbol-50px me-3 overflow-hidden">
                            <img src="{{ asset('storage/' . $item->image) }}" width="50" height="50"
                                style="object-fit: cover" alt="Logo {{ $item->bank }}">
                        </div>
                        <div class="text-start">
                            <span class="fw-bold text-dark fs-5">{{ $item->bank }}</span>
                        </div>
                    </label>
                </div>
            </div>
        @endif
    @endforeach
</div>
