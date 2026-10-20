<section id="whitepre-hero" class="whitepre-hero" aria-label="Pembuka undangan">
    <div class="whitepre-hero-media"
        style="background-image: url('{{ asset('storage/' . ($thumbnailWa?->thumbnail ?? 'images/placeholder.jpg')) }}');"
        aria-hidden="true"></div>

    <div class="whitepre-hero-content">
        <p class="whitepre-hero-eyebrow" data-aos="fade-down">{{ $data->setting?->acara ?? 'The Wedding' }}</p>
        <h1 class="whitepre-hero-title" data-aos="fade-up" data-aos-delay="120">
            {{ $data->pria?->nama_panggilan ?? '' }}
            <span class="text-[25px]">&amp;</span>
            {{ $data->wanita?->nama_panggilan ?? '' }}
        </h1>

        @php
            $firstAcaraDate = ($data->acara[0] ?? null)?->date;
        @endphp
        <p class="whitepre-hero-date" data-aos="fade-up" data-aos-delay="220">
            {{ $firstAcaraDate ? date('d', strtotime($firstAcaraDate)) : '10' }}
            . {{ $firstAcaraDate ? date('m', strtotime($firstAcaraDate)) : '10' }}
            . {{ $firstAcaraDate ? date('Y', strtotime($firstAcaraDate)) : '2024' }}
        </p>
    </div>

    <div class="whitepre-scroll-cue" aria-hidden="true">
        <div class="whitepre-scroll-mouse"></div>
        <span>Scroll ke bawah</span>
    </div>

    <svg class="whitepre-wave" viewBox="0 0 1440 320" preserveAspectRatio="none" aria-hidden="true">
        <path fill="#fff8ef" d="M0,64L60,80C120,96,240,128,360,122.7C480,117,600,75,720,80C840,85,960,139,1080,154.7C1200,171,1320,149,1380,138.7L1440,128L1440,320L0,320Z"></path>
    </svg>
</section>
