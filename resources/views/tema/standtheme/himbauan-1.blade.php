<div class="himbauan-1 mt-10 flex flex-col justify-center items-center ">



    <!-- Hitung Mundur -->
    <div class="mt-8">
        <!-- Judul -->
        <h2 class="text-center text-xl font-semibold  md:text-2xl uppercase mb-8 text-[#755f4B]" data-aos="fade-up"
            data-aos-duration="1500">
            Hitung Mundur</h2>
        <?php
        // Ambil waktu acara dalam format Unix Timestamp
        $eventTimestamp = strtotime($data->acara[0]->date);
        ?>
        <!-- Kotak Hitung Mundur -->
        <div class="flex flex-row gap-4 justify-center text-white items-center mx-auto" data-aos="fade-up"
            data-aos-duration="1500">
            <!-- Hari -->
            <div class="bg-stone-500 rounded-lg p-5  w-auto flex flex-col justify-center items-center">
                <h3 class="text-[12px] md:text-2xl font-bold" id="hari">0</h3>
                <span class="text-sm">Hari</span>
            </div>

            <!-- Jam -->
            <div class="bg-stone-500 rounded-lg p-5 w-auto flex flex-col justify-center items-center">
                <h3 class="text-[12px] md:text-2xl font-bold" id="jam">0</h3>
                <span class="text-sm">Jam</span>
            </div>

            <!-- Menit -->
            <div class="bg-stone-500 rounded-lg p-5 w-auto flex flex-col justify-center items-center">
                <h3 class="text-[12px] md:text-2xl font-bold" id="menit">0</h3>
                <span class="text-sm">Menit</span>
            </div>

            <!-- Detik -->
            <div class="bg-stone-500 rounded-lg p-5 w-auto flex flex-col justify-center items-center">
                <h3 class="text-[12px] md:text-2xl font-bold" id="detik">0</h3>
                <span class="text-sm">Detik</span>
            </div>
        </div>

        <script>
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
                document.getElementById("hari").textContent = days;
                document.getElementById("jam").textContent = hours;
                document.getElementById("menit").textContent = minutes;
                document.getElementById("detik").textContent = seconds;

                // Jika hitung mundur selesai
                if (distance < 0) {
                    clearInterval(countdown);
                    document.getElementById("hari").textContent = "0";
                    document.getElementById("jam").textContent = "0";
                    document.getElementById("menit").textContent = "0";
                    document.getElementById("detik").textContent = "0";
                }
            }, 1000);
        </script>


    </div>
</div>
