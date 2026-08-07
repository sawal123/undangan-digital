<div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
    @forelse ($pay as $item)
        @if ($item->category !== 'manual')
            <label for="pay{{ $item->id }}"
                class="relative flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all
                       {{ $paymentGatewayId == $item->id ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-slate-200 dark:border-slate-600 hover:border-slate-400 dark:hover:border-slate-500' }}"
                wire:click="ifee({{ $item->id }})">
                <input type="radio" id="pay{{ $item->id }}" name="channel" value="{{ $item->midtrans_code }}"
                    wire:model.lazy="channel" class="sr-only">
                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-white dark:bg-slate-600">
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover" alt="{{ $item->bank }}">
                </div>
                <div class="text-left min-w-0">
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate">{{ $item->bank }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">Otomatis</p>
                </div>
            </label>
        @endif
    @empty
        <p class="text-sm text-slate-400 col-span-full py-4 text-center">Tidak ada metode pembayaran otomatis.</p>
    @endforelse
</div>
