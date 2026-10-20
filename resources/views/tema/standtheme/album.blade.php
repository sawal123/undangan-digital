<section id="standGallery" class="stand-section">
    <div class="stand-section__header" data-aos="fade-up">
        <p class="stand-eyebrow">Momen yang kami simpan</p>
        <h2 class="stand-section__title">Album Gallery</h2>
        <p class="stand-section__subtitle">Beberapa momen kecil dari perjalanan kami.</p>
    </div>

    @if (!empty($poto))
        <div class="stand-gallery" data-aos="fade-up">
            @foreach ($poto as $po)
                <button type="button" class="stand-gallery__item" onclick="openStandLightbox(this.querySelector('img'))" aria-label="Buka foto galeri"><img src="{{ asset('storage/' . $po) }}" alt="Foto momen pernikahan" loading="lazy"></button>
            @endforeach
        </div>
    @else
        <p class="stand-lead">Galeri foto akan segera diperbarui.</p>
    @endif
</section>
