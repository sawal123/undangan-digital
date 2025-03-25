<div class="bg-neutral-950 relative pt-10 pb-16 text-orange-200  font-poppins">
    <!-- Judul -->
    <h2 class="text-center text-[50px] z-50 relative font-light mb-6 font-corinthia">
        Acara Akan <br> Diselenggarakan
    </h2>
    <!-- Gambar Hiasan Kiri -->
    <div class="left-0 absolute top-10 inset-x-0 z-10">
        <img src="{{ asset('tema/darkpre/src/img/bunga.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-24  object-center">
    </div>

    <!-- Hari -->
    <div class="text-center z-50 mt-4 relative ">
        <div class="text-[70px] font-bold" id="days">26</div>
        <div class="text-[30px] font-semibold">HARI</div>
    </div>

    <!-- Gambar Hiasan Tengah -->
    <div class="flex justify-center  absolute top-32 inset-x-0 z-10">
        <img src="{{ asset('tema/darkpre/src/img/bunga.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-24 rotate-180">
    </div>

    <!-- Timer -->
    <div class="flex relative justify-center z-50 items-center mt-10 space-x-8">
        <!-- Hours -->
        <div class="flex flex-col items-center">
            <h2 class="text-3xl font-bold" id="hours">21</h2>
            <span class="text-sm font-semibold uppercase">Hours</span>
        </div>

        <!-- Divider -->
        <div class="h-16 w-px bg-gray-400"></div>

        <!-- Minutes -->
        <div class="flex flex-col items-center">
            <h2 class="text-3xl font-bold" id="minutes">50</h2>
            <span class="text-sm font-semibold uppercase">Minutes</span>
        </div>

        <!-- Divider -->
        <div class="h-16 w-px bg-gray-400"></div>

        <!-- Seconds -->
        <div class="flex flex-col items-center">
            <h2 class="text-3xl font-bold" id="seconds">5</h2>
            <span class="text-sm font-semibold uppercase">Seconds</span>
        </div>
    </div>

    <!-- Tanggal -->
    <div class="text-center text-lg text-orange-200 pt-8" id="countdown">
        <div>
            {{ date('d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? 'Tanggal tidak tersedia'))) }},
            {{ \Carbon\Carbon::parse($data->acara[1]->date ?? ($data->acara[0]->date ?? 'Tanggal tidak tersedia'))->translatedFormat('l') }}
            {{ \Carbon\Carbon::parse($data->acara[1]->date ?? ($data->acara[0]->date ?? 'Tanggal tidak tersedia'))->translatedFormat('F Y') }}
        </div>
        <?php // Ambil waktu acara dalam format Unix Timestamp
        $eventTimestamp = strtotime($data->acara[0]->date); ?>
    </div>

    <!-- button -->
    <div class="text-center pt-8 ">
        <a id="googleCalendarBtn" target="_blank">
            <button class="rounded-full w-auto border border-orange-200 p-2"><i
                    class="fa-solid fa-calendar-days mr-2"></i>Simpan acara ke
                kalender</button>
        </a>
    </div>

</div>
