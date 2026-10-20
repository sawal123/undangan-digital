@php
    $navItems = 5 + ($data->kisah?->isNotEmpty() ? 1 : 0) + (!empty($poto) ? 1 : 0);
@endphp
<nav class="darksweet-nav" style="--ds-nav-items: {{ $navItems }};" aria-label="Navigasi undangan">
    <div class="darksweet-nav__inner">
        <a class="darksweet-nav__link" href="#hero"><i class="fa-solid fa-house" aria-hidden="true"></i><span>Home</span></a>
        <a class="darksweet-nav__link" href="#pengantin"><i class="fa-solid fa-heart" aria-hidden="true"></i><span>Pasangan</span></a>
        <a class="darksweet-nav__link" href="#savethedate"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span>Acara</span></a>
        @if ($data->kisah?->isNotEmpty())
            <a class="darksweet-nav__link" href="#story"><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i><span>Cerita</span></a>
        @endif
        @if (!empty($poto))
            <a class="darksweet-nav__link" href="#gallery"><i class="fa-solid fa-images" aria-hidden="true"></i><span>Galeri</span></a>
        @endif
        <a class="darksweet-nav__link" href="#absen"><i class="fa-solid fa-comment-dots" aria-hidden="true"></i><span>Ucapan</span></a>
        <button type="button" id="toggleButton" class="darksweet-nav__link" aria-label="Putar atau jeda musik">
            <i class="fa-solid fa-music" aria-hidden="true"></i><span>Musik</span>
        </button>
    </div>
</nav>

@include('tema.partials.music', ['data' => $data])
