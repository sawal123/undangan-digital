<section class="whitepre-section" aria-label="Kutipan pernikahan">
    <div class="whitepre-quote-card" data-aos="fade-up">
        @if ($data->qoute?->title)
            <p class="mb-3 font-semibold">{{ $data->qoute->title }}</p>
        @endif
        <p>{{ $data->qoute?->qoute ?? '' }}</p>
        @if ($data->qoute?->subtitle)
            <span>{{ $data->qoute->subtitle }}</span>
        @endif
    </div>
</section>
