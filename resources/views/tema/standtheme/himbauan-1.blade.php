@php
    $standCountdownEvent = $data->acara?->first();
    $standCountdownDate = $standCountdownEvent?->date ? date('c', strtotime($standCountdownEvent->date)) : '';
@endphp

<section class="stand-section stand-section--brown" data-aos="fade-up">
    <div class="stand-section__header">
        <p class="stand-eyebrow" style="color:#f1d7b0;">Menuju hari bahagia</p>
        <h2 class="stand-section__title">Hitung Mundur</h2>
    </div>
    <div class="stand-countdown" data-stand-countdown data-date="{{ $standCountdownDate }}">
        <div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="days">00</span><span class="stand-countdown__label">Hari</span></div>
        <div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="hours">00</span><span class="stand-countdown__label">Jam</span></div>
        <div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="minutes">00</span><span class="stand-countdown__label">Menit</span></div>
        <div class="stand-countdown__item"><span class="stand-countdown__value" data-unit="seconds">00</span><span class="stand-countdown__label">Detik</span></div>
    </div>
    <p class="stand-countdown__note">Sampai bertemu di hari yang penuh kebahagiaan.</p>
</section>
