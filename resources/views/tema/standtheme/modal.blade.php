@php
    $standModalImage = $thumbnailWa?->thumbnail
        ? asset('storage/' . $thumbnailWa->thumbnail)
        : asset('tema/standtheme/assets/img/cover.jpg');
@endphp

<section id="modal" class="stand-modal" aria-label="Sampul undangan">
    <div class="stand-modal__panel">
        <div class="stand-modal__content">
            <p class="stand-modal__label">{{ $data->setting?->acara ?? 'Undangan Pernikahan' }}</p>
            <h1 class="stand-modal__title">{{ $coupleNames ?? $data->couple_name }}</h1>
            <div class="stand-modal__image"><img src="{{ $standModalImage }}" alt="Foto kedua mempelai"></div>
            <p class="stand-modal__guest">Kepada<strong>{{ $tamu ?: 'Tamu Undangan' }}</strong>Dengan hormat, kami mengundang Anda untuk hadir dan memberikan doa restu.</p>
            <button type="button" id="closeModal" class="stand-button stand-button--light"><i class="fa-solid fa-envelope-open-text"></i>Buka Undangan</button>
        </div>
    </div>
</section>
