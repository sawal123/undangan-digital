<div class="accordion" id="accordionExample">
    <!-- Section Qris / E-Wallet -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                Qris / E-Wallet
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                @foreach ($pay as $item)
                    @if ($item->category === 'ewallet')
                        <div class="border border-red rounded rad my-2">
                            <input type="radio" class="btn-check" id="pay{{ $item->id }}" name="channel"
                                value="{{ $item->slug }}" wire:model.lazy="channel">
                            <label for="pay{{ $item->id }}"
                                class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center p-3 mb-0">
                                <div class="symbol symbol-50px me-3 overflow-hidden">
                                    <img src="{{ asset('storage/' . $item->image) }}" width="50" class="h-auto"
                                        alt="Logo {{ $item->bank }}">
                                </div>
                                <div class="text-start">
                                    <span class="fw-bold text-dark fs-5">{{ $item->bank }}</span>
                                </div>
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section Transfer Bank (Virtual Account) -->
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Transfer Bank (Virtual Account)
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                @foreach ($pay as $item)
                    @if ($item->category === 'va')
                        <div class="border border-red rounded rad my-2">
                            <input type="radio" class="btn-check" id="pay{{ $item->id }}" name="channel"
                                value="{{ $item->slug }}" wire:model.lazy="channel">
                            <label for="pay{{ $item->id }}"
                                class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center p-3 mb-0">
                                <div class="symbol symbol-50px me-3 overflow-hidden">
                                    <img src="{{ asset('storage/' . $item->image) }}" width="50" class="h-auto"
                                        alt="Logo {{ $item->bank }}">
                                </div>
                                <div class="text-start">
                                    <span class="fw-bold text-dark fs-5">{{ $item->bank }}</span>
                                </div>
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
