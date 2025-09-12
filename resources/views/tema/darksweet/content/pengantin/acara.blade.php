<div class="w-full mt-5 flex flex-col justify-center items-center px-3 ">
    <h1 class="text-3xl font-bold ">Save The Date Acara</h1>
    <p class="text-center">{{ $data->teksUndangan->acara }}</p>

    <!-- CARD 1 -->
    @foreach ($data->acara as $item)
        <div class="relative w-full h-[300px] bg-white mt-2 mb-2 font-reemkufi">
            <div class=" bg-center bg-fixed rounded-xl bg-origin-content overflow-hidden shadow-lg h-full w-full bg-cover "
                style="background-image: url('{{ asset('tema/darksweet/img/download (4).jpg') }}');">
                <!-- Overlay Transparan -->
                <div class="bg-black bg-opacity-50 w-full h-full absolute rounded-xl inset-0"></div>

                <!-- Konten Kartu -->
                <div class="relative w-full h-full py-6 rounded-lg shadow-lg">
                    <!-- Judul -->
                    <h2 class="text-2xl pl-4 font-semibold text-start text-white" data-aos="fade-up"
                        data-aos-duration="3000">{{ $item->nama_acara }}</h2>
                    <!-- Tanggal dan Informasi -->
                    <div
                        class="flex items-center w-4/5 mt-6 bg-gradient-to-r from-white to-transparent h-[92px] gap-4 pl-4">
                        <div class="text-6xl font-bold items-center flex h-full text-center border-r border-black pr-4"
                            data-aos="fade-up" data-aos-duration="3000">
                            {{ date('d', strtotime($item->date)) }} {{-- Tanggal (04) --}}
                        </div>
                        <div class="text-left font-semibold">
                            <p class="" data-aos="fade-up" data-aos-duration="3000">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l') }} {{-- Nama Hari (Kami/Kamis) --}}
                            </p>
                            <p class="" data-aos="fade-up" data-aos-duration="3000">
                                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('F Y') }} {{-- Bulan & Tahun (Maret 2025) --}}
                            </p>
                        </div>
                    </div>



                    <!-- Detail Acara -->
                    <div class="mt-4 pl-4 text-white p-4 rounded-lg flex justify-around">
                        <p class="text-[12px] font-semibold " data-aos="fade-up" data-aos-duration="3000">{{ $item->vanue }}</p>

                        <p class="text-[12px] whitespace-nowrap" data-aos="fade-up" data-aos-duration="3000"><i
                                class="fa-solid fa-location-dot mr-2"></i>{{ $item->alamat }}</p>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-4 flex justify-center  bg-white w-full absolute bottom-0 p-3">
                        <a href="{{$item->maps}}"
                            class="text-sm font-bold  text-center underline hover:text-blue-800 w-full font-montserrat"
                            data-aos="fade-up" data-aos-duration="3000"><i class="fa-solid fa-location-dot mr-2"></i>Map
                            Lokasi
                            Acara</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- CARD 1 -->




</div>
