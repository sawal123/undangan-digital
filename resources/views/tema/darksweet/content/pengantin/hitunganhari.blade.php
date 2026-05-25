<style>
    .sidebar-text {
      writing-mode: vertical-rl;
      text-orientation: mixed;
    }
</style>

<!-- BEGIN: Hero Section (Struktur Flexbox 2-Kolom Horizontal Murni untuk Mengisolasi Konten Kiri dan Sidebar Kanan) -->
<section class="relative min-h-screen flex flex-row items-stretch justify-between bg-cover bg-center overflow-hidden w-full mt-5" id="hero" style="background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('{{ asset('tema/darksweet/img/pasangan.jpg') }}'); border-bottom: 1px solid rgba(255,255,255,0.1);">
    
    <!-- KOLOM KIRI: Zona Konten Utama (Mengambil 100% sisa ruang di kiri, terisolasi penuh sehingga MUSTAHIL menabrak atau berada di belakang sidebar) -->
    <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-3 py-12 text-center overflow-hidden my-auto">
        <!-- Judul Utama -->
        <h1 class="text-4xl md:text-5xl mb-5 font-normal tracking-wide" style="font-family: 'Great Vibes', Italiana, cursive; color: #ffffff !important; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
            Menghitung Hari
        </h1>
        
        @php
            $arTitle = $data->qoute?->title ?? '';
            if (str_contains($arTitle, 'Ù') || str_contains($arTitle, 'Ø') || str_contains($arTitle, 'Ã') || str_contains($arTitle, 'Â')) {
                $arTitle = "بِسْمِ اللهِ الرَّحْمٰنِ الرَّحِيْمِ";
            }
        @endphp

        <!-- Arabic Text -->
        <p class="text-xl md:text-2xl mb-5 font-bold tracking-wide" dir="auto" style="font-family: 'Noto Naskh Arabic', 'Amiri', serif; color: #d4af37 !important; text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
            {{ $arTitle }}
        </p>
        
        <!-- Quranic Verse -->
        <p class="text-xs leading-relaxed font-light italic opacity-95 mb-6 max-w-[220px] mx-auto break-words" style="color: #ffffff !important;">
            {!! nl2br(e($data->qoute?->qoute ?? '')) !!}
        </p>
        
        <!-- Main Couple Image Portrait -->
        <div class="relative mx-auto w-48 h-64 rounded-2xl overflow-hidden border-3 border-white/20 shadow-2xl mb-6 flex-shrink-0" data-purpose="couple-portrait" style="border-width: 3px;">
            <img alt="Couple Portrait" class="w-full h-full object-cover object-center" src="{{ asset('storage/'. ($thumbnailWa?->thumbnail ?? '')) }}"/>
            <!-- Overlay to match image composition -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#1a202c]/50 via-transparent to-transparent"></div>
        </div>

        <!-- Tombol Save To Calendar -->
        <div class="text-center mb-3">
            <a id="googleCalendarBtn" target="_blank" class="inline-block">
                <button type="button" class="px-5 py-2.5 bg-white hover:bg-gray-200 font-bold rounded-xl shadow-xl text-xs tracking-wider uppercase transition-all" style="color: #1a202c !important;">
                    Save To Calendar
                </button>
            </a>
        </div>

        <!-- Subtitle Referensi -->
        <p class="mt-1 text-[10px] italic opacity-75" style="color: #ffffff !important;">
            - {{ $data->qoute?->subtitle ?? '' }} -
        </p>
    </div>
    <!-- END: Kolom Kiri -->

    <!-- KOLOM KANAN: Countdown Sidebar (Diberi lebar tetap w-16 di sisi paling kanan layar) -->
    <aside class="w-16 flex-shrink-0 backdrop-blur-sm flex flex-col items-center justify-center space-y-12 py-10 z-30 border-l border-white/5" style="background-color: rgba(26, 32, 44, 0.85);" data-purpose="countdown-sidebar">
        <div class="flex flex-col items-center">
            <span class="text-2xl font-bold tracking-widest" id="hari" style="color: #ffffff !important;">00</span>
            <span class="sidebar-text text-[10px] font-semibold tracking-widest uppercase mt-2" style="color: #d4af37 !important;">HARI</span>
        </div>
        <div class="flex flex-col items-center">
            <span class="text-2xl font-bold tracking-widest" id="jam" style="color: #ffffff !important;">00</span>
            <span class="sidebar-text text-[10px] font-semibold tracking-widest uppercase mt-2" style="color: #d4af37 !important;">JAM</span>
        </div>
        <div class="flex flex-col items-center">
            <span class="text-2xl font-bold tracking-widest" id="menit" style="color: #ffffff !important;">00</span>
            <span class="sidebar-text text-[10px] font-semibold tracking-widest uppercase mt-2" style="color: #d4af37 !important;">MENIT</span>
        </div>
        <div class="flex flex-col items-center">
            <span class="text-2xl font-bold tracking-widest" id="detik" style="color: #ffffff !important;">00</span>
            <span class="sidebar-text text-[10px] font-semibold tracking-widest uppercase mt-2" style="color: #d4af37 !important;">DETIK</span>
        </div>
    </aside>
    <!-- END: Kolom Kanan -->

    <!-- Integrasi Logika Live Countdown & Link Kalender -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(isset($acara) && $acara)
                let eventTitle = "Pernikahan Kami";
                let eventDateStart = "{{ date('Ymd', strtotime($acara->date)) }}T100000Z";
                let eventDetails = "Jangan lewatkan momen spesial kami!";
                let eventLocation = "{{ $acara->alamat ?? '' }}";
                let googleCalendarUrl = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventTitle)}&dates=${eventDateStart}&details=${encodeURIComponent(eventDetails)}&location=${encodeURIComponent(eventLocation)}&sf=true&output=xml`;
                let btn = document.getElementById("googleCalendarBtn");
                if(btn) btn.href = googleCalendarUrl;
            @endif

            let eventDateStr = "{{ $data ? date('Y-m-d', strtotime($data->acara[1]->date ?? ($data->acara[0]->date ?? ''))) : '2024-10-10' }}";
            let eventDate = new Date(eventDateStr).getTime();
            let countdown = setInterval(function() {
                let now = new Date().getTime();
                let distance = eventDate - now;

                let hari = Math.floor(distance / (1000 * 60 * 60 * 24));
                let jam = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let menit = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let detik = Math.floor((distance % (1000 * 60)) / 1000);

                let elHari = document.getElementById("hari");
                let elJam = document.getElementById("jam");
                let elMenit = document.getElementById("menit");
                let elDetik = document.getElementById("detik");

                if(elHari) elHari.innerText = hari.toString().padStart(2, '0');
                if(elJam) elJam.innerText = jam.toString().padStart(2, '0');
                if(elMenit) elMenit.innerText = menit.toString().padStart(2, '0');
                if(elDetik) elDetik.innerText = detik.toString().padStart(2, '0');

                if (distance < 0) {
                    clearInterval(countdown);
                    if(elHari) elHari.innerText = "00";
                    if(elJam) elJam.innerText = "00";
                    if(elMenit) elMenit.innerText = "00";
                    if(elDetik) elDetik.innerText = "00";
                }
            }, 1000);
        });
    </script>
</section>
