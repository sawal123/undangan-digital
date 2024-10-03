@props(['active', 'link'])

@php
$classes = ($active ?? false)
            ? 'sub-menu-item active'
            : 'sub-menu-item';
@endphp

<li class="{{ $classes }}">
    <a href="{{ $link }}" wire:navigate
     class="sub-menu-item">
        {{ $slot }}
    </a>
</li>
