<!-- opening -->
<div class="opening mt-20 h-auto w-full bg-[#F7F4EF] ">
    <div class="flex flex-col justify-center ">
        <div class="justify-center flex">
            <img src="{{ asset('tema/standtheme/assets/img/bismillah.png') }}" data-aos="fade-up" data-aos-duration="3000"
                class=" " alt="">
        </div>
        <h1 class="text-2xl font-bold mb-4 mt-2 text-center title" data-aos="fade-up" data-aos-duration="3000">Jamuan
            Syukuran</h1>
        <div class="text-center max-w-2xl  p-8 text-[12px] md:text-lg text-[#755f4B]">
            <p class="text-5xl mb-2 font-bold title" data-aos="fade-up" data-aos-duration="1500">
                {{ $data ? $data->pria->nama_lengkap : 'Teddy Prakarsa' }}</p>
            <p class="text-sm mb-4" data-aos="fade-up" data-aos-duration="1500">
                {{ $data ? $data->pria->deskripsi : 'Putra ke-2 Bpk. Samuel & Ibu Masuya' }}</p>
            <p class="text-lg mb-2" data-aos="fade-up" data-aos-duration="1500">&</p>
            <p class="text-5xl
title mb-2 font-bold " data-aos="fade-up" data-aos-duration="1500">
                {{ $data ? $data->wanita->nama_lengkap : 'Ajeng Febian' }}</p>
            <p class="text-sm mb-4" data-aos="fade-up" data-aos-duration="1500">
                {{ $data ? $data->wanita->deskripsi : 'Putri ke-2 Bpk. Samuel & Ibu Masuya' }}</p>
            @php
                use Carbon\Carbon;

                $tanggalAcara = Carbon::parse($data->acara[0]->date);
                $hari = $tanggalAcara->translatedFormat('l'); // 'l' = nama hari
                $tanggalFormatted = $tanggalAcara->translatedFormat('j M Y'); // 'j M Y' = 1 Sep 2025
            @endphp

            <p class="text-lg font-semibold my-6" data-aos="fade-up" data-aos-duration="1500">
                Save the Date <br> {{ $hari }}, {{ $tanggalFormatted }}
            </p>


            <a href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ $data->title }}&dates{{ $data->acara[0]->date }}&location={{ $data->acara[0]->alamat }}"
                target="_blank"
                class="inline-block px-4 py-2 bg-[#755f4B] text-white rounded hover:bg-[#68523e] transition"
                data-aos="fade-up" data-aos-delay="200">
                Tambah Pengingat
            </a>
            <hr class="my-6 border-t border-gray-300">

            <p class="text-lg mb-4" data-aos="fade-up" data-aos-duration="1500"></p>
            <h3 class="text-lg font-semibold uppercase mb-2 " data-aos="fade-up" data-aos-duration="1500">
                {{ $data->qoute->title }}</h3>
            <p class="italic mb-6" data-aos="fade-up" data-aos-duration="1500">
                {{ $data->qoute->qoute }}
            </p>
            <p class="mb-2" data-aos="fade-up" data-aos-duration="1500">
                {{ $data->qoute->subtitle }}
            </p>
            {{-- <p class="font-bold" data-aos="fade-up" data-aos-duration="1500">{{ $data ? date('d', strtotime($data->acara[0]->date)) : '11' }}</p> --}}
        </div>
    </div>
</div>
