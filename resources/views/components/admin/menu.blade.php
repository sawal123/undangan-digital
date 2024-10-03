@props(['active', 'link', 'icon'])

@php
$classes = ($active ?? false)
            ? 'active'
            : '';
@endphp

<li class="{{ $classes }}">
    <a href="{{ $link }}" wire:navigate
     >
     <i class="{{$icon}} me-2"></i>
        {{ $slot }}
    </a>
</li>
