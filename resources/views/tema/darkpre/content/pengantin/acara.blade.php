@php
    $acaraUtama = $data->acara?->get(1) ?? $data->acara?->first();
    $acaraUtamaDate = $acaraUtama?->date;
@endphp

<section id="date" class="darkpre-section darkpre-event-section" aria-label="Jadwal acara">
    <h2 class="darkpre-section-heading" data-aos="fade-up">Acara Akan Diselenggarakan</h2>
    <p class="darkpre-section-lead">{{ $data->teksUndangan?->pembuka ?? '' }}</p>

    <div class="darkpre-countdown" aria-label="Hitung mundur acara">
        <div class="darkpre-countdown-item" data-aos="zoom-in">
            <span id="days" class="darkpre-countdown-value">00</span>
            <span class="darkpre-countdown-label">Hari</span>
        </div>
        <div class="darkpre-countdown-item" data-aos="zoom-in" data-aos-delay="100">
            <span id="hours" class="darkpre-countdown-value">00</span>
            <span class="darkpre-countdown-label">Jam</span>
        </div>
        <div class="darkpre-countdown-item" data-aos="zoom-in" data-aos-delay="200">
            <span id="minutes" class="darkpre-countdown-value">00</span>
            <span class="darkpre-countdown-label">Menit</span>
        </div>
        <div class="darkpre-countdown-item" data-aos="zoom-in" data-aos-delay="300">
            <span id="seconds" class="darkpre-countdown-value">00</span>
            <span class="darkpre-countdown-label">Detik</span>
        </div>
    </div>

    <p id="countdown" class="darkpre-date-line" data-aos="fade-up">
        @if ($acaraUtamaDate)
            {{ \Carbon\Carbon::parse($acaraUtamaDate)->translatedFormat('l, d F Y') }}
        @else
            Tanggal acara belum tersedia
        @endif
    </p>

    <div class="mt-6 text-center">
        <a id="googleCalendarBtn" target="_blank" rel="noopener" class="darkpre-calendar-button">
            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
            Simpan acara ke kalender
        </a>
    </div>
</section>

<section id="location" class="darkpre-section" aria-label="Detail lokasi acara">
    <h2 class="darkpre-section-heading" data-aos="fade-up">Detail Acara</h2>
    <div class="darkpre-event-list">
        @forelse ($data->acara as $item)
            <article class="darkpre-event-card" data-aos="fade-up">
                <h3>{{ $item->nama_acara ?? 'Acara Pernikahan' }}</h3>
                <div class="darkpre-event-details">
                    <div>
                        @if ($item->date)
                            {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}
                        @else
                            Tanggal acara belum tersedia
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
                    <a href="{{ $item->maps }}" target="_blank" rel="noopener" class="darkpre-map-button mt-5">
                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                        Lihat lokasi
                    </a>
                @endif
            </article>
        @empty
            <p class="darkpre-section-lead">Detail acara belum tersedia.</p>
        @endforelse
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventDateValue = @json($acaraUtamaDate ? date('Y-m-d', strtotime($acaraUtamaDate)) : null);
        const calendarButton = document.getElementById('googleCalendarBtn');
        const elements = {
            days: document.getElementById('days'),
            hours: document.getElementById('hours'),
            minutes: document.getElementById('minutes'),
            seconds: document.getElementById('seconds'),
            message: document.getElementById('countdown'),
        };

        if (calendarButton && eventDateValue) {
            const eventDateStart = eventDateValue.replaceAll('-', '') + 'T100000Z';
            const eventTitle = @json($acaraUtama?->nama_acara ?? 'Pernikahan Kami');
            const eventLocation = @json($acaraUtama?->alamat ?? '');
            calendarButton.href =
                `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${eventDateStart}&details=${encodeURIComponent('Jangan lewatkan momen spesial kami!')}&location=${encodeURIComponent(eventLocation)}&sf=true&output=xml`;
        }

        if (!eventDateValue || Object.values(elements).some((element) => !element)) return;

        const eventDate = new Date(`${eventDateValue}T00:00:00`).getTime();
        let countdownInterval;
        const updateCountdown = () => {
            const distance = eventDate - Date.now();
            const values = {
                days: Math.max(0, Math.floor(distance / (1000 * 60 * 60 * 24))),
                hours: Math.max(0, Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))),
                minutes: Math.max(0, Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))),
                seconds: Math.max(0, Math.floor((distance % (1000 * 60)) / 1000)),
            };

            Object.entries(values).forEach(([key, value]) => {
                elements[key].textContent = String(value).padStart(2, '0');
            });

            if (distance <= 0) {
                elements.message.textContent = 'Hari bahagia telah tiba.';
                clearInterval(countdownInterval);
            }
        };

        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    });
</script>
