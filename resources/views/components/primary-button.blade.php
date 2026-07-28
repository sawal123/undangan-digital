@props([
    'loadingTarget' => null,
    'loadingText' => null,
])

<button
    @if($loadingTarget) wire:loading.attr="disabled" wire:target="{{ $loadingTarget }}" @endif
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50']) }}>
    @if($loadingTarget)
        <span wire:loading.remove wire:target="{{ $loadingTarget }}">{{ $slot }}</span>
        <span wire:loading.inline-flex wire:target="{{ $loadingTarget }}" class="hidden items-center gap-2">
            <x-loading-spinner class="w-3.5 h-3.5" />
            <span>{{ $loadingText ?? $slot }}</span>
        </span>
    @else
        {{ $slot }}
    @endif
</button>
