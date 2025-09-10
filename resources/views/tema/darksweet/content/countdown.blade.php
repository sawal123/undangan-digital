<p class="text-shadow date countdown text-center font-bold text-white" data-date="{{ $data ? date('Y-m-d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '2024-10-10' }}" data-aos="zoom-in-up"
    data-aos-duration="2000">
    <span class="text-lg text-shadow">{{ $data ? $hari[date('l', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? '')))] : 'Minggu' }}</span><br>
    <span class="text-2xl font-extrabold">{{ $data ? date('d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '10' }}</span>
    <span class="text-xl">•</span>
    <span class="text-2xl font-extrabold">{{ $data ? date('m', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '10' }}</span>
    <span class="text-xl">•</span>
    <span class="text-2xl font-extrabold">{{ $data ? date('Y', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '2024' }}</span>
</p>

<!-- Countdown Display -->
<div class="countdown flex justify-center gap-4 mt-4" id="countdown">
    <div class="countdown-item text-center bg-white border border-gray-300 shadow-md rounded-lg p-6" data-aos="zoom-in-up"
    data-aos-duration="3000">
        <span class="block text-3xl font-bold text-gray-900" id="days">0</span>
        <label class="block text-sm font-semibold text-gray-600" >Hari</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-300 shadow-md rounded-lg p-6" data-aos="zoom-in-up"
    data-aos-duration="3000">
        <span class="block text-3xl font-bold text-gray-900" id="hours">0</span>
        <label class="block text-sm font-semibold text-gray-600" >Jam</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-300 shadow-md rounded-lg p-6" data-aos="zoom-in-up"
    data-aos-duration="3000">
        <span class="block text-3xl font-bold text-gray-900" id="minutes">0</span>
        <label class="block text-sm font-semibold text-gray-600" >Menit</label>
    </div>
    <div class="countdown-item text-center bg-white border border-gray-300 shadow-md rounded-lg p-6" data-aos="zoom-in-up"
    data-aos-duration="3000">
        <span class="block text-3xl font-bold text-gray-900" id="seconds">0</span>
        <label class="block text-sm font-semibold text-gray-600" >Detik</label>
    </div>
</div>


