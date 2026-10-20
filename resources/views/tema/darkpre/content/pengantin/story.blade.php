@if ($data->kisah?->isNotEmpty())
    <section class="darkpre-section darkpre-story-section" aria-label="Cerita pasangan">
        <h2 class="darkpre-section-heading" data-aos="fade-up">Story</h2>
        <div class="swiper swiperStory">
            <div class="swiper-wrapper">
                @foreach ($data->kisah as $item)
                    <article class="swiper-slide darkpre-story-slide">
                        <img src="{{ asset('storage/' . ($item->image?->image ?? 'images/placeholder.jpg')) }}"
                            alt="{{ $item->title ?? 'Cerita pasangan' }}" onclick="openModalImg(this)">
                        <div class="darkpre-story-line" aria-hidden="true"></div>
                        <div class="darkpre-story-copy">
                            <h3 class="font-semibold">{{ $item->title }}</h3>
                            @if ($item->deskripsi)
                                <p class="mt-2 text-xs leading-relaxed">{{ $item->deskripsi }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
@endif
