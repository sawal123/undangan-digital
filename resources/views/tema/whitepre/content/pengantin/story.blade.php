@if ($data->kisah?->isNotEmpty())
    <section class="whitepre-section whitepre-story-section" aria-label="Cerita pasangan"
        style="background-image: url('{{ asset('tema/whitepre/src/img/pembatas_bunga.png') }}'); background-position: center; background-size: contain; background-repeat: repeat-y;">
        <h2 class="whitepre-section-heading" data-aos="fade-up">Story</h2>
        <div class="swiper swiperStory">
            <div class="swiper-wrapper">
                @foreach ($data->kisah as $item)
                    <article class="swiper-slide whitepre-story-slide">
                        <img src="{{ asset('storage/' . ($item->image?->image ?? 'images/placeholder.jpg')) }}"
                            alt="{{ $item->title ?? 'Cerita pasangan' }}" onclick="openModalImg(this)">
                        <div class="whitepre-story-line" aria-hidden="true"></div>
                        <div class="whitepre-story-copy">
                            <h3 class="font-semibold">{{ $item->title }}</h3>
                            @if ($item->deskripsi)
                                <p class="mt-2 text-xs font-normal leading-relaxed">{{ $item->deskripsi }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
@endif
