<section id="standAcara" class="stand-section stand-section--soft">
    <div class="stand-section__header" data-aos="fade-up">
        <p class="stand-eyebrow">Catat tanggalnya</p>
        <h2 class="stand-section__title">Acara Kami</h2>
        <p class="stand-section__subtitle">Kami menantikan kehadiran dan doa restu Anda di hari istimewa kami.</p>
    </div>

    <div class="stand-event-list">
        @foreach ($data->acara as $item)
            @php $standEventDate = $item->date ? \Carbon\Carbon::parse($item->date) : null; @endphp
            <article class="stand-event-card" data-aos="fade-up">
                <h3 class="stand-event-card__title">{{ $item->nama_acara }}</h3>
                @if ($standEventDate)
                    <div class="stand-event-card__date">
                        <div class="stand-event-card__date-group"><span class="stand-event-card__date-label">Hari</span><span>{{ $standEventDate->translatedFormat('l') }}</span></div>
                        <div class="stand-event-card__date-main"><strong class="stand-event-card__day">{{ $standEventDate->format('d') }}</strong><span class="stand-event-card__meta">{{ $standEventDate->translatedFormat('F Y') }}</span></div>
                        <div class="stand-event-card__date-group"><span class="stand-event-card__date-label">Waktu</span><span>{{ $item->jam_start }}{{ $item->jam_end ? ' – ' . $item->jam_end : '' }}<br>{{ $item->zona_waktu }}</span></div>
                    </div>
                @endif
                <p class="stand-event-card__location"><i class="fa-solid fa-location-dot"></i><br>{{ $item->vanue }}<br>{{ $item->alamat }}</p>
                @if ($item->maps)
                    <div class="stand-event-card__actions"><a class="stand-button" href="{{ $item->maps }}" target="_blank" rel="noopener"><i class="fa-solid fa-location-dot"></i>Lihat Lokasi</a></div>
                @endif
            </article>
        @endforeach
    </div>
</section>
