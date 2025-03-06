<div class="bg-white flex items-center justify-center h-[800px] mx-0 px-0 mt-12 ">
    <div class=" bg-fixed bg-cover bg-center bg-no-repeat h-full w-full "
        style="background-image: url('{{ asset('tema/darksweet/img/pasangan.jpg') }}');">

        <div class="relative bg-transparent  overflow-hidden w-full h-full flex flex-row items-start justify-center">
            <div class="absolute bg-black bg-opacity-80 inset-0 w-full h-full z-0 pointer-events-none "></div>

            <div class="basis-10/12 p-6 space-y-12  text-white flex flex-col justify-center z-10 font-reemkufi">
                <h1 class="text-2xl font-bold" data-aos="fade-up" data-aos-duration="3000">Menghitung Hari</h1>
                <p class="text-[14px]" data-aos="fade-up" data-aos-duration="3000">
                    {{ $data->qoute->title }}
                </p>
                <div class="space-y-4">
                    <p class="text-[12px]" data-aos="fade-up" data-aos-duration="3000">
                        {{ $data->qoute->qoute }}
                    </p>

                </div>
                <div class="mt-4">
                    <a id="googleCalendarBtn" target="_blank">
                        <button
                            class="bg-white hover:bg-gray-600 text-slate-800 hover:text-white font-semibold py-2 px-4 rounded-lg"
                            data-aos="fade-up" data-aos-duration="3000">
                            Save To Calendar
                        </button>
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
                <p class=" mt-4 text-sm" data-aos="fade-up" data-aos-duration="3000">- {{ $data->qoute->subtitle }} -
                </p>
            </div>

            <div class="basis-2/12 right-0 top-0 bg-gray-900 text-white text-center pt-7 pb-20 z-20 font-montserrat">
                <div class="flex flex-col items-center gap-24 opacity-100" data-aos="fade-up" data-aos-duration="3000">
                    <div class="flex flex-col items-center transform -rotate-90">
                        <h2 class="text-3xl font-bold" id="detik">00</h2>
                        <span class="text-sm font-semibold uppercase ml-2">Detik</span>
                    </div>
                    <div class="flex flex-col items-center transform -rotate-90">
                        <h2 class="text-3xl font-bold" id="menit">00</h2>
                        <span class="text-sm font-semibold uppercase ml-2">Menit</span>
                    </div>
                    <div class="flex flex-col items-center transform -rotate-90">
                        <h2 class="text-3xl font-bold" id="jam">00</h2>
                        <span class="text-sm font-semibold uppercase ml-2">Jam</span>
                    </div>
                    <div class="flex flex-col items-center transform -rotate-90">
                        <h2 class="text-3xl font-extrabold" id="hari">00</h2>
                        <span class="text-sm font-semibold uppercase ml-2">Hari</span>
                    </div>
                </div>
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
                        document.getElementById("hari").innerText = hari.toString().padStart(2, '0');
                        document.getElementById("jam").innerText = jam.toString().padStart(2, '0');
                        document.getElementById("menit").innerText = menit.toString().padStart(2, '0');
                        document.getElementById("detik").innerText = detik.toString().padStart(2, '0');

                        // Jika waktu habis
                        if (distance < 0) {
                            clearInterval(countdown);
                            document.getElementById("hari").innerText = "00";
                            document.getElementById("jam").innerText = "00";
                            document.getElementById("menit").innerText = "00";
                            document.getElementById("detik").innerText = "00";
                        }
                    }, 1000);
                });
            </script>


            <div
                class="bottom-0 right-0 absolute bg-transparent w-0 h-0 border-b-[260px] border-l-[560px] border-l-transparent rounded-none z-20">
            </div>

            <div class="w-40 h-[218px] bottom-9 overflow-hidden bg-white mx-auto absolute z-30" data-aos="fade-up"
                data-aos-duration="3000">
                <img src="{{ asset('storage/'. $thumbnailWa->thumbnail) }}  "
                    class="aspect-[2/3] object-cover object-center  w-full h-full" alt="">
            </div>
            <div class="flex flex-row justify-center w-full bg-transparent absolute bottom-0 z-20 ">
                <div
                    class="bottom-0 border-white left-0 bg-transparent w-full h-0 border-b-[25px] border-l-[5px] border-r-[25px] border-r-transparent rounded-none">
                </div>
                <div
                    class="bottom-0 border-white left-0 bg-transparent w-full h-0 border-b-[25px] border-l-[25px] border-r-[5px] border-l-transparent rounded-none ">
                </div>
            </div>
        </div>

    </div>
</div>
