@if (!empty($poto))
    <section id="gallery" class="darkpre-section" aria-label="Galeri foto">
        <h2 class="darkpre-section-heading" data-aos="fade-up">Gallery Kami</h2>
        <p class="darkpre-section-lead">
            Pernikahan adalah kumpulan momen kecil yang tumbuh menjadi kisah cinta.
        </p>

        <div class="darkpre-gallery-grid">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($poto as $index => $item)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $item) }}" alt="Momen foto {{ $index + 1 }}"
                                loading="lazy" onclick="openModalImg(this)">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
@endif
