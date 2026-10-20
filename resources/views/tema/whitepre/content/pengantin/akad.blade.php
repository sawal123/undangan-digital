@php
    $acaraAkad = $data->acara?->get(1) ?? $data->acara?->first();
    $acaraAkadDate = $acaraAkad?->date;
@endphp

<section id="date" class="whitepre-section" aria-label="Hitung mundur acara">
    <h2 class="whitepre-section-heading" data-aos="fade-up">Acara Akan Diselenggarakan</h2>
    <p class="whitepre-section-lead">{{ $data->teksUndangan?->pembuka ?? '' }}</p>

    <div class="whitepre-countdown" aria-label="Hitung mundur">
        <div class="whitepre-countdown-item" data-aos="zoom-in">
            <span id="days" class="whitepre-countdown-value">00</span>
            <span class="whitepre-countdown-label">Hari</span>
        </div>
        <div class="whitepre-countdown-item" data-aos="zoom-in" data-aos-delay="100">
            <span id="hours" class="whitepre-countdown-value">00</span>
            <span class="whitepre-countdown-label">Jam</span>
        </div>
        <div class="whitepre-countdown-item" data-aos="zoom-in" data-aos-delay="200">
            <span id="minutes" class="whitepre-countdown-value">00</span>
            <span class="whitepre-countdown-label">Menit</span>
        </div>
        <div class="whitepre-countdown-item" data-aos="zoom-in" data-aos-delay="300">
            <span id="seconds" class="whitepre-countdown-value">00</span>
            <span class="whitepre-countdown-label">Detik</span>
        </div>
    </div>

    <p id="countdown" class="whitepre-date-line" data-aos="fade-up">
        @if ($acaraAkadDate)
            {{ date('d', strtotime($acaraAkadDate)) }},
            {{ \Carbon\Carbon::parse($acaraAkadDate)->translatedFormat('l') }}
            {{ \Carbon\Carbon::parse($acaraAkadDate)->translatedFormat('F Y') }}
        @else
            Tanggal tidak tersedia
        @endif
    </p>

    <div class="mt-6 text-center">
        <a id="googleCalendarBtn" target="_blank" rel="noopener" class="whitepre-calendar-button">
            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
            Simpan acara ke kalender
        </a>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarButton = document.getElementById('googleCalendarBtn');
        const eventDateValue = @json($acaraAkadDate ? date('Y-m-d', strtotime($acaraAkadDate)) : null);

        if (calendarButton && eventDateValue) {
            const eventDateStart = eventDateValue.replaceAll('-', '') + 'T100000Z';
            const eventTitle = @json($acaraAkad?->nama_acara ?? 'Pernikahan Kami');
            const eventDetails = @json('Jangan lewatkan momen spesial kami!');
            const eventLocation = @json($acaraAkad?->alamat ?? '');
            calendarButton.href =
                `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${eventDateStart}&details=${encodeURIComponent(eventDetails)}&location=${encodeURIComponent(eventLocation)}&sf=true&output=xml`;
        }

        const eventDate = eventDateValue ? new Date(`${eventDateValue}T00:00:00`).getTime() : null;
        const elements = {
            days: document.getElementById('days'),
            hours: document.getElementById('hours'),
            minutes: document.getElementById('minutes'),
            seconds: document.getElementById('seconds'),
            message: document.getElementById('countdown'),
        };

        if (!eventDate || Object.values(elements).some((element) => !element)) return;

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
