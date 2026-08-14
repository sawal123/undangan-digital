<p class="date countdown" data-date="{{ ($data->acara?->first())?->date ? date('Y-m-d', strtotime($data->acara->first()->date)) : '' }}">
    {{ ($data->acara?->first())?->date ? ($hari[date('l', strtotime($data->acara->first()->date))] ?? date('l', strtotime($data->acara->first()->date))) : 'Minggu' }}
    <br>
    {{ ($data->acara?->first())?->date ? date('d', strtotime($data->acara->first()->date)) : '10' }} •
    {{ ($data->acara?->first())?->date ? date('m', strtotime($data->acara->first()->date)) : '10' }} •
    {{ ($data->acara?->first())?->date ? date('Y', strtotime($data->acara->first()->date)) : '2024' }}
</p>
 <!-- Countdown Display -->
 <div class="countdown d-flex justify-content-center gap-3" id="countdown">
    <div class="countdown-item border p-3">
        <span class="fw-bold fs-6" id="days">0</span>
        <label class="fw-bold mt-0" style="font-size: 11px !important">Hari</label>
    </div>
    <div class="countdown-item border p-3">
        <span class="fw-bold fs-6" id="hours">0</span>
        <label class="fw-bold mt-0" style="font-size: 11px !important">Jam</label>
    </div>
    <div class="countdown-item border p-3">
        <span class="fw-bold fs-6" id="minutes">0</span>
        <label class="fw-bold mt-0" style="font-size: 11px !important">Menit</label>
    </div>
    <div class="countdown-item border p-3">
        <span class="fw-bold fs-6" id="seconds">0</span>
        <label class="fw-bold mt-0" style="font-size: 11px !important">Detik</label>
    </div>
</div>