@props([
    'class' => 'w-4 h-4',
    'text' => null,
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }} role="status" aria-live="polite">
    <svg class="animate-spin {{ $class }}" style="animation: spin-anim 0.8s linear infinite; transform-origin: center;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
        <style>
            @keyframes spin-anim {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        </style>
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    @if($text)
        <span>{{ $text }}</span>
    @endif
    <span class="sr-only">Sedang memuat...</span>
</span>
