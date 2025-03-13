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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set waktu acara (Format: YYYY-MM-DD HH:MM:SS)
        let eventDate = new Date("{{ $data ? date('Y-m-d', strtotime($data->acara[0]->date)) : '2024-10-10' }}").getTime();

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

{{-- <script>
    // Ambil waktu acara dari PHP
    const eventTimestamp = <?php echo $eventTimestamp; ?> * 1000; // Convert to milliseconds

    // Fungsi hitung mundur
    const countdown = setInterval(() => {
        const now = new Date().getTime();
        const distance = eventTimestamp - now;

        // Hitung waktu
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Tampilkan hasil
        document.getElementById("days").textContent = days;
        document.getElementById("hours").textContent = hours;
        document.getElementById("minutes").textContent = minutes;
        document.getElementById("second").textContent = seconds;

        // Jika hitung mundur selesai
        if (distance < 0) {
            clearInterval(countdown);
            document.getElementById("days").textContent = "0";
            document.getElementById("hours").textContent = "0";
            document.getElementById("minutes").textContent = "0";
            document.getElementById("seconds").textContent = "0";
        }
    }, 1000);

</script> --}}
