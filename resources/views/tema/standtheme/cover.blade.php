@php
    $standCoverImage = $thumbnailWa?->thumbnail
        ? asset('storage/' . $thumbnailWa->thumbnail)
        : asset('tema/standtheme/assets/img/cover.jpg');
    $standCoverDate = ($data->acara?->first())?->date;
@endphp

<section id="standCover" class="stand-cover" style="background-image: url('{{ $standCoverImage }}');">
    <div class="stand-cover__content" data-aos="fade-up">
        <p class="stand-cover__eyebrow">{{ $data->setting?->acara ?? 'The Wedding' }}</p>
        <h1 class="stand-cover__title">{{ $data->pria?->nama_panggilan ?? '' }} &amp; {{ $data->wanita?->nama_panggilan ?? '' }}</h1>
        @if ($standCoverDate)
            <p class="stand-cover__date">{{ \Carbon\Carbon::parse($standCoverDate)->translatedFormat('j F Y') }}</p>
        @endif
        <div class="stand-cover__hint"><i class="fa-solid fa-chevron-down"></i><span>Gulir untuk melihat undangan</span></div>
    </div>
</section>
