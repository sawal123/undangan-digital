@php
    $calendarEvent = $data->acara?->first();
    $quoteTitle = $data->qoute?->title ?? '';
    $quoteText = $data->qoute?->qoute ?? '';
    $quoteSubtitle = $data->qoute?->subtitle ?? '';
@endphp

<section id="hitunghari" class="darksweet-section darksweet-section--accent">
    <div class="darksweet-section__header" data-aos="fade-up">
        <p class="darksweet-eyebrow">Menuju hari bahagia</p>
        <h2 class="darksweet-section__title">Menghitung Hari</h2>
        @if ($quoteTitle)
            <p class="darksweet-section__subtitle" dir="auto">{{ $quoteTitle }}</p>
        @endif
    </div>

    @if ($quoteText)
        <p class="darksweet-quote" data-aos="fade-up" dir="auto">{!! nl2br(e($quoteText)) !!}</p>
    @endif

    @if ($quoteSubtitle)
        <p class="darksweet-section__subtitle" style="text-align: center; margin-bottom: 1.5rem;">{{ $quoteSubtitle }}</p>
    @endif

    @if ($calendarEvent?->date)
        <div style="text-align: center;" data-aos="fade-up">
            <a id="googleCalendarBtn" class="darksweet-button darksweet-button--ghost" target="_blank" rel="noopener">
                <i class="fa-regular fa-calendar-plus" aria-hidden="true"></i>
                Simpan ke Kalender
            </a>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const event = @json([
                    'title' => $data->title ?? 'Pernikahan Kami',
                    'date' => date('Ymd', strtotime($calendarEvent->date)),
                    'location' => $calendarEvent->alamat ?? '',
                ]);
                const button = document.getElementById('googleCalendarBtn');
                if (!button) return;
                const dates = `${event.date}T100000Z/${event.date}T120000Z`;
                button.href = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(event.title)}&dates=${dates}&location=${encodeURIComponent(event.location)}&sf=true&output=xml`;
            });
        </script>
    @endif
</section>
