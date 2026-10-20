<div class="darksweet-section__header" data-aos="fade-up">
    <p class="darksweet-eyebrow">Momen yang kami simpan</p>
    <h2 class="darksweet-section__title">Galeri</h2>
    @if ($data->teksUndangan?->penutup)
        <p class="darksweet-section__subtitle">{{ $data->teksUndangan->penutup }}</p>
    @endif
</div>

@if (!empty($video[0]))
    <div class="darksweet-video" data-aos="fade-up">
        <iframe src="{{ $video[0] }}" title="Video pernikahan" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
@endif

<div class="darksweet-gallery" data-aos="fade-up">
    @foreach ($poto as $item)
        <button type="button" class="darksweet-gallery__item" onclick="openModalImg(this.querySelector('img'))" aria-label="Buka foto galeri">
            <img src="{{ asset('storage/' . $item) }}" alt="Foto momen pernikahan" loading="lazy">
        </button>
    @endforeach
</div>
