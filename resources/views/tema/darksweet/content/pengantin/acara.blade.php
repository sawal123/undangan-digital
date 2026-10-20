<div class="darksweet-section__header" data-aos="fade-up">
    <p class="darksweet-eyebrow">Catat tanggalnya</p>
    <h2 class="darksweet-section__title">Acara Kami</h2>
    @if ($data->teksUndangan?->acara)
        <p class="darksweet-section__subtitle">{{ $data->teksUndangan->acara }}</p>
    @endif
</div>

<div class="darksweet-event-list">
    @foreach ($data->acara as $item)
        @php
            $eventDate = $item->date ? \Carbon\Carbon::parse($item->date) : null;
        @endphp
        <article class="darksweet-event-card" data-aos="fade-up" style="background-image: url('{{ asset('tema/darksweet/img/download (4).jpg') }}');">
            <h3 class="darksweet-event-card__title">{{ $item->nama_acara }}</h3>
            @if ($eventDate)
                <div class="darksweet-event-card__date">
                    <span class="darksweet-event-card__day">{{ $eventDate->format('d') }}</span>
                    <span class="darksweet-event-card__meta">{{ $eventDate->translatedFormat('l') }}<br>{{ $eventDate->translatedFormat('F Y') }}</span>
                </div>
            @endif
            <p class="darksweet-event-card__location">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                {{ $item->vanue }}<br>{{ $item->alamat }}
            </p>
            @if ($item->maps)
                <a class="darksweet-event-card__link" href="{{ $item->maps }}" target="_blank" rel="noopener">
                    Lihat lokasi <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                </a>
            @endif
        </article>
    @endforeach
</div>
