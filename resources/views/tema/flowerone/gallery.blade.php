<div class="flowerone-gallery" data-aos="fade-up" data-aos-duration="800">
    <div class="swiper mySwiper2" aria-label="Galeri utama">
        <div class="swiper-wrapper">
            @foreach ($poto as $po)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $po) }}" alt="Foto galeri undangan" loading="lazy">
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next" aria-label="Foto berikutnya"></div>
        <div class="swiper-button-prev" aria-label="Foto sebelumnya"></div>
    </div>

    <div thumbsSlider class="swiper mySwiper" aria-label="Pilih foto galeri">
        <div class="swiper-wrapper">
            @foreach ($poto as $po)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $po) }}" alt="Thumbnail foto galeri" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</div>
