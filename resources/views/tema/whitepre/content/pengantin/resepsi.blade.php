<section id="location" class="whitepre-section" aria-label="Lokasi acara"
    style="background-image: url('{{ asset('tema/whitepre/src/img/border.png') }}'); background-position: center; background-size: cover;">
    <h2 class="whitepre-section-heading" data-aos="fade-up">Detail Acara</h2>

    <div class="whitepre-event-list">
        @foreach ($data->acara as $item)
            <article class="whitepre-event-card" data-aos="fade-up">
                <h2>{{ $item->nama_acara }}</h2>
                <div class="whitepre-event-details">
                    <div>
                        @if ($item->date)
                            {{ date('d', strtotime($item->date)) }},
                            {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l') }}
                            {{ \Carbon\Carbon::parse($item->date)->translatedFormat('F Y') }}
                        @else
                            Tanggal tidak tersedia
                        @endif
                    </div>
                    <div>pukul {{ $item->jam_start }} - {{ $item->jam_end }} {{ $item->zona_waktu }}</div>
                    @if ($item->alamat)
                        <div>{{ $item->alamat }}</div>
                    @endif
                    @if ($item->vanue)
                        <div>{{ $item->vanue }}</div>
                    @endif
                </div>

                @if ($item->maps)
                    <a href="{{ $item->maps }}" target="_blank" rel="noopener" class="whitepre-map-button mt-5">
                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                        Lihat lokasi
                    </a>
                @endif
            </article>
        @endforeach
    </div>
</section>
