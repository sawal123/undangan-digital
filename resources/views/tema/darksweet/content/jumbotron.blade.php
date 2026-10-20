@php
    $heroPhotos = collect($poto ?? [])->filter()->take(3)->values();
    if ($heroPhotos->isEmpty()) {
        $heroPhotos = collect([$thumbnailWa?->thumbnail])->filter()->values();
    }
    if ($heroPhotos->isEmpty()) {
        $heroPhotos = collect(['tema/darksweet/img/pasangan.jpg']);
    }
@endphp

<section id="hero" class="darksweet-hero">
    <div class="swiper mySwiper darksweet-hero__slider" aria-label="Foto pembuka undangan">
        <div class="swiper-wrapper">
            @foreach ($heroPhotos as $photo)
                <div class="swiper-slide" style="background-image: url('{{ str_starts_with($photo, 'tema/') ? asset($photo) : asset('storage/' . $photo) }}');"></div>
            @endforeach
        </div>
    </div>

    <div class="darksweet-hero__content">
        <p class="darksweet-hero__badge" data-aos="fade-down">
            <i class="fa-solid fa-sparkles" aria-hidden="true"></i>
            {{ $data->setting?->acara ?? 'The Wedding' }}
        </p>
        <h1 class="darksweet-hero__title" data-aos="fade-up">
            {{ $data->pria?->nama_panggilan ?? '' }} & {{ $data->wanita?->nama_panggilan ?? '' }}
        </h1>
        @include('tema.darksweet.content.countdown')
        <div class="darksweet-scroll-hint" data-aos="fade-up" data-aos-delay="250">
            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
            <span>Gulir untuk melihat cerita kami</span>
        </div>
    </div>
</section>
