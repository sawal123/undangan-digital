<p class="text-shadow date countdown text-center font-bold text-white" data-date="{{ $data ? date('Y-m-d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '2024-10-10' }}" data-aos="zoom-in-up"
    data-aos-duration="2000">
    <span class="text-lg text-shadow">{{ $data ? $hari[date('l', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? '')))] : 'Minggu' }}</span><br>
    <span class="text-2xl font-extrabold">{{ $data ? date('d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '10' }}</span>
    <span class="text-xl">•</span>
    <span class="text-2xl font-extrabold">{{ $data ? date('m', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '10' }}</span>
    <span class="text-xl">•</span>
    <span class="text-2xl font-extrabold">{{ $data ? date('Y', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '2024' }}</span>
</p>

<!-- Countdown Display (Dijamin mutlak 4 kolom horizontal menggunakan flexbox murni, dengan batasan max-w-[320px] agar memiliki celah kosong yang lega di kanan dan kiri layar) -->
<div class="countdown mt-5 w-full max-w-[320px] mx-auto px-2" id="countdown" style="display: flex !important; flex-direction: row !important; justify-content: center !important; align-items: center !important;">
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-1" style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="days">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Hari</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-1" style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="hours">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Jam</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-1" style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="minutes">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Menit</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-200 shadow-xl rounded-xl p-1 mx-2" style="flex: 1 1 0% !important; min-width: 0 !important;" data-aos="zoom-in-up" data-aos-duration="3000">
        <span class="block text-xl font-extrabold text-gray-900 tracking-tight" id="seconds">0</span>
        <label class="block text-[10px] font-bold text-gray-600 mt-0.5 uppercase tracking-wider">Detik</label>
    </div>
</div>
