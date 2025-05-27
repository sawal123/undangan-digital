

<div class="relative min-h-screen hidden " id="acara">
    <!-- Top Section -->
    @include('tema.ultah.top-section')
    <!-- End Top Section -->

    <!-- konten acara -->
    <div class="w-full flex flex-col items-center justify-center space-y-4 uppercase z-50">
      <div class="text-center text-[20px] font-bold text-white leading-none  text-ellipsis inline-block align-top"
        data-aos="fade-down" data-aos-duration="2000" data-aos-easing="ease-in-sine">
        Welcome To</div>
      <div class="text-center text-[40px] font-bold text-white leading-none  text-ellipsis inline-block align-top font-audiowide"
        data-aos="fade-down" data-aos-duration="2500" data-aos-easing="linear">
        1ST</div>
      <div
        class="text-center text-[18px] font-semibold text-white leading-none  text-ellipsis inline-block align-top"
        data-aos="fade-down" data-aos-duration="1700" data-aos-easing="linear">
        {{ $data->pria->nama_lengkap }}</div>

      <div class="flex flex-row justify-center items-center text-[#FFC300] space-x-1" data-aos="fade-down"
        data-aos-duration="2800" data-aos-easing="ease-in-sine">
        <div class="text-[50px] font-semibold  leading-none "> {{ $data ? date('d', strtotime($data->acara[0]->date)) : '10' }}</div>
        <div class=" text-[20px] font-semibold  leading-none text-start">{{ $data ? date('m', strtotime($data->acara[0]->date)) : '10' }}<br>{{ $data ? date('Y', strtotime($data->acara[0]->date)) : '2024' }}</div>

        <!-- Divider -->
        <div class="h-16 w-[2px] bg-[#FFC300]"></div>

        <div class=" text-[20px] font-semibold  leading-none text-end">17.00 WIT<br>S.D SELESAI</div>
      </div>

      <div class="text-center" data-aos="fade-down" data-aos-duration="2000" data-aos-easing="ease-in-sine">
        <div class="text-[12px] font-semibold text-white leading-none">lokasi acara</div>
        <div class="text-[15px] font-semibold text-white leading-none">Passo - kampung baru</div>
      </div>

      <div class="text-center pt-1 " data-aos="fade-down" data-aos-duration="2000" data-aos-easing="linear">
        <a href="#" class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px]"><i
            class="fa-solid fa-map-location-dot mr-2"></i>lihat lokasi</a>
      </div>

      <div class="flex flex-row justify-center items-center text-black font-semibold text-[15px] gap-2 pt-5 z-50"
        data-aos="fade-up" data-aos-duration="2500" data-aos-easing="ease-in-sine">
        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center" >
          <p id="hari">24</p>
          <p>Hari</p>
        </div>
        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center" >
          <p id="jam">24</p>
          <p>Jam</p>
        </div>
        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center" >
          <p id="menit">24</p>
          <p>Menit</p>
        </div>
        <div class="p-2 flex flex-col bg-[#FFC300] rounded-xl items-center">
          <p  id="detik">24</p>
          <p>Detik</p>
        </div>
      </div>

      <div class="text-center pt-1 z-50" data-aos="fade-up" data-aos-duration="2500" data-aos-easing="linear">
        <a id="googleCalendarBtn" target="_blank">
        <button type="button" class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] "><i
            class="fa-solid fa-calendar-days mr-2"></i>Simpan Kalender</button>
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

    </div>

    <!-- Bottom Section -->
    @include('tema.ultah.bottom-section')
    <!-- End Bottom Section -->
  </div>