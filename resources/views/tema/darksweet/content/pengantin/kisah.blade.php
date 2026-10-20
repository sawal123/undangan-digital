<div class="darksweet-section__header" data-aos="fade-up">
    <p class="darksweet-eyebrow">Potongan perjalanan kami</p>
    <h2 class="darksweet-section__title">Our Story</h2>
    <p class="darksweet-section__subtitle">Momen-momen kecil yang membawa kami sampai di hari ini.</p>
</div>

<div class="darksweet-story-list">
    @foreach ($data->kisah as $item)
        <article class="darksweet-story-card" data-aos="fade-up">
            <div class="darksweet-story-card__image">
                <img src="{{ asset('storage/' . ($item->image?->image ?? '')) }}" alt="{{ $item->title }}" loading="lazy">
            </div>
            <div class="darksweet-story-card__body">
                <h3 class="darksweet-story-card__title">{{ $item->title }}</h3>
                <p class="darksweet-story-card__text">{{ $item->deskripsi }}</p>
            </div>
        </article>
    @endforeach
</div>
