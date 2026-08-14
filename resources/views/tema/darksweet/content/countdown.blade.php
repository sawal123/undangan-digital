@php
    $countdownAcara = $data->acara?->get(1) ?? $data->acara?->first();
    $countdownDate = $countdownAcara?->date;
    $countdownTs = $countdownDate ? strtotime($countdownDate) : false;
@endphp
<p class="text-shadow date countdown text-center font-bold text-white"
    data-date="{{ $countdownTs ? date('Y-m-d', $countdownTs) : '' }}" data-aos="zoom-in-up" data-aos-duration="2000">
    <span
        class="text-lg text-shadow">{{ $countdownTs ? $hari[date('l', $countdownTs)] ?? date('l', $countdownTs) : 'Minggu' }}</span><br>
    <span class="text-2xl font-extrabold">{{ $countdownTs ? date('d', $countdownTs) : '10' }}</span>
    <span class="text-xl">•</span>
    <span class="text-2xl font-extrabold">{{ $countdownTs ? date('m', $countdownTs) : '10' }}</span>
    <span class="text-xl">•</span>
    <span class="text-2xl font-extrabold">{{ $countdownTs ? date('Y', $countdownTs) : '2024' }}</span>
</p>

<!-- Countdown Display (Dijamin mutlak 4 kolom horizontal menggunakan flexbox murni, dengan batasan max-w-[320px] agar memiliki celah kosong yang lega di kanan dan kiri layar) -->
<div class="countdown mt-5 flex gap-2 max-w-[320px] mx-auto px-2" id="countdown"
    style="display: flex !important; flex-direction: row !important; justify-content: center !important; align-items: center !important;">
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-4"
        style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="days">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Hari</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-4"
        style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="hours">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Jam</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-4"
        style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="minutes">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Menit</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-4 mx-2"
        style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="seconds">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Detik</label>
    </div>
</div>
