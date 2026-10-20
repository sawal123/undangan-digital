@if (!empty($poto))
    <section id="gallery" class="whitepre-section" aria-label="Galeri foto">
        <h2 class="whitepre-section-heading" data-aos="fade-up">Momen Berharga</h2>
        <p class="whitepre-section-lead">
            Menciptakan kenangan adalah hadiah yang tak ternilai harganya. Kenangan akan bertahan seumur hidup;
            benda-benda hanya dalam waktu singkat.
        </p>

        <div class="whitepre-gallery-grid">
            @foreach ($poto as $index => $item)
                <button type="button" class="text-left" onclick="openModalImg(this.querySelector('img'))"
                    data-aos="fade-up" data-aos-delay="{{ min($index * 60, 360) }}">
                    <img src="{{ asset('storage/' . $item) }}" alt="Momen foto {{ $index + 1 }}" loading="lazy">
                </button>
            @endforeach
        </div>
    </section>
@endif
