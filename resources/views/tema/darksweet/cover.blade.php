@php
    $coverImage = $thumbnailWa?->thumbnail
        ? asset('storage/' . $thumbnailWa->thumbnail)
        : asset('tema/darksweet/img/pasangan.jpg');
    $coverDate = ($data->acara?->first())?->date;
@endphp

<section id="cover" class="darksweet-cover" aria-label="Sampul undangan">
    <div class="darksweet-cover__backdrop" style="background-image: url('{{ $coverImage }}');"></div>

    <div class="darksweet-cover__card">
        <div class="darksweet-cover__monogram" aria-hidden="true"><i class="fa-solid fa-heart"></i></div>
        <p class="darksweet-cover__eyebrow">{{ $data->setting?->acara ?? 'The Wedding' }}</p>
        <h1 class="darksweet-cover__title">
            {{ $coupleNames ?? $data->couple_name }}
        </h1>
        @if ($coverDate)
            <p class="darksweet-cover__date">{{ \Carbon\Carbon::parse($coverDate)->translatedFormat('j F Y') }}</p>
        @endif

        <div class="darksweet-cover__visual">
            <img src="{{ $coverImage }}" alt="Foto {{ $coupleNames ?? $data->couple_name }}">
        </div>

        <p class="darksweet-cover__guest">
            Kepada
            <strong>{{ $tamu ?: 'Tamu Undangan' }}</strong>
            Dengan penuh kebahagiaan, kami mengundang Anda untuk hadir di hari istimewa kami.
        </p>

        <button type="button" id="openCover" class="darksweet-button" style="margin-top: 1.35rem;">
            <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>
            Buka Undangan
        </button>
    </div>
</section>
