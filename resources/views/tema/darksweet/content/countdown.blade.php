@php
    $countdownAcara = $data->acara?->get(1) ?? $data->acara?->first();
    $countdownDate = $countdownAcara?->date;
    $countdownTs = $countdownDate ? strtotime($countdownDate) : false;
    $countdownIso = $countdownTs ? date('c', $countdownTs) : '';
@endphp

<div class="darksweet-hero__countdown" data-aos="fade-up" data-aos-delay="100">
    <p class="darksweet-hero__date">
        {{ $countdownTs ? \Carbon\Carbon::parse($countdownDate)->translatedFormat('j F Y') : 'Segera hadir' }}
    </p>

    <div id="countdown" class="darksweet-countdown date countdown" data-date="{{ $countdownIso }}" aria-label="Hitung mundur acara">
        <div class="darksweet-countdown__item"><span id="days" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Hari</span></div>
        <div class="darksweet-countdown__item"><span id="hours" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Jam</span></div>
        <div class="darksweet-countdown__item"><span id="minutes" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Menit</span></div>
        <div class="darksweet-countdown__item"><span id="seconds" class="darksweet-countdown__value">00</span><span class="darksweet-countdown__label">Detik</span></div>
    </div>
</div>
