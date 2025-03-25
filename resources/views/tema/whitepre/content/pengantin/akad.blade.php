<div class="bg-orange-50 relative pt-10 pb-16 text-pink-800  font-poppins section" id="date">
    <!-- Judul -->
    <h2 class="text-center text-[40px] z-50 relative font-semibold mb-6  font-great_vibes">
        Acara Akan Diselenggarakan
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
    <!-- Timer -->
    <div class="flex relative justify-center text-center z-50 items-center mt-10 space-x-4">
        <!-- Hours -->
        <div class="flex flex-col items-center" data-aos="zoom-in-right" data-aos-duration="2000">
            <h2 class="text-[20px] font-bold" id="hours">21</h2>
            <span class="text-[15px] font-semibold uppercase">Hours</span>
        </div>

        <!-- Divider -->
        <div class="h-16 w-px bg-pink-800"></div>

        <!-- Minutes -->
        <div class="flex flex-col items-center" data-aos="zoom-in" data-aos-duration="2000">
            <h2 class="text-[20px]  font-bold" id="minutes">50</h2>
            <span class=" text-[15px] font-semibold uppercase">Minutes</span>
        </div>

        <!-- Divider -->
        <div class="h-16 w-px bg-pink-800"></div>

        <!-- Seconds -->
        <div class="flex flex-col items-center" data-aos="zoom-in-left" data-aos-duration="2000">
            <h2 class="text-[20px]  font-bold" id="seconds">5</h2>
            <span class=" text-[15px] font-semibold uppercase">Seconds</span>
        </div>
    </div>

    <!-- Tanggal -->
    <div class="text-center text-[12px] text-pink-800 " id="countdown" data-aos="zoom-in" data-aos-duration="2500">
        <div>
            {{ date('d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? 'Tanggal tidak tersedia'))) }},
            {{ \Carbon\Carbon::parse($data->acara[1]->date ?? ($data->acara[0]->date ?? 'Tanggal tidak tersedia'))->translatedFormat('l') }}
            {{ \Carbon\Carbon::parse($data->acara[1]->date ?? ($data->acara[0]->date ?? 'Tanggal tidak tersedia'))->translatedFormat('F Y') }}
        </div>
    </div>

    <!-- button -->
    <div class="text-center pt-5 ">
        <a id="googleCalendarBtn" target="_blank">
            <button class="rounded-full w-auto border border-orange-200 py-1 px-2 text-[13px]"><i
                    class="fa-solid fa-calendar-days mr-2"></i>Simpan acara ke
                kalender</button>
        </a>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let eventTitle = "Pernikahan Kami";
                let eventDateStart = "{{ date('Ymd', strtotime($acara->date)) }}T100000Z"; // Sesuaikan jam UTC

                let eventDetails = "Jangan lewatkan momen spesial kami!";
                let eventLocation = "{{ $acara->alamat }}";

                let googleCalendarUrl =
                    `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${eventDateStart}&details=${encodeURIComponent(eventDetails)}&location=${encodeURIComponent(eventLocation)}&sf=true&output=xml`;

                document.getElementById("googleCalendarBtn").href = googleCalendarUrl;
            });
        </script>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set waktu acara (Format: YYYY-MM-DD HH:MM:SS)
        let eventDate = new Date(
                "{{ $data ? date('Y-m-d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '2024-10-10' }}"
                )
            .getTime();

        // Update countdown setiap detik
        let countdown = setInterval(function() {
            let now = new Date().getTime();
            let distance = eventDate - now;

            // Perhitungan waktu
            let hari = Math.floor(distance / (1000 * 60 * 60 * 24));
            let jam = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let menit = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let detik = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan hasil di elemen dengan id yang sesuai
            document.getElementById("days").innerText = hari.toString().padStart(2, '0');
            document.getElementById("hours").innerText = jam.toString().padStart(2, '0');
            document.getElementById("minutes").innerText = menit.toString().padStart(2, '0');
            document.getElementById("seconds").innerText = detik.toString().padStart(2, '0');

            // Jika waktu habis
            if (distance < 0) {
                clearInterval(countdown);
                document.getElementById("days").innerText = "00";
                document.getElementById("hours").innerText = "00";
                document.getElementById("minutes").innerText = "00";
                document.getElementById("seconds").innerText = "00";
            }
        }, 1000);
    });
</script>
