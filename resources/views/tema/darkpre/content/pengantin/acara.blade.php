@foreach ($data->acara as $item)
    <div class="bg-neutral-950 relative text-orange-200 pb-10 font-poppins">

        <div class="flex flex-col items-center justify-center w-full space-y-6 text-sm">
            <!-- Judul Acara -->
            <h2 class=" text-[50px] font-light font-corinthia  z-50 text-center">
                {{ $item->nama_acara }}
            </h2>

            <!-- Detail Acara -->
            <div class="flex flex-col items-center justify-center w-full space-y-3 font-normal pt-8 pb-8">
                <div>
                    {{ date('d', strtotime($item->date)) }},
                    {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l') }}
                    {{ \Carbon\Carbon::parse($item->date)->translatedFormat('F Y') }}
                </div>
                <div>
                    pukul {{ $item->jam_start }} - {{ $item->jam_end }} {{ $item->zona_waktu }}
                </div>
                <div>
                    {{ $item->alamat }} {{ $item->vanue }}
                </div>
            </div>

            <!-- Tombol Lihat Lokasi -->
            <div class="text-center pt-8 ">
                <a href="{{ $item->maps }}"
                    class="rounded-full border border-orange-200 px-4  py-2 flex items-center justify-center space-x-2 hover:bg-orange-200 hover:text-white transition">
                    <i class="fa-solid fa-map-location-dot mr-2"></i>
                    <span>lihat lokasi</span>
                </a>
            </div>
        </div>

       

    </div>
@endforeach
<div class="bg-neutral-950 relative text-orange-200 pb-10 font-poppins">
    <p class="text-center w-full pt-14 pb-14 font-light lg:text-sm text-[11px]">Merupakan suatu
        kehormatan
        dan
        kebahagiaan bagi
        kami <br> apabila,
        Saudara
        / i. berkenan hadir untuk memberikan do'a <br> restunya kami ucapkan terimakasih.
    </p>
     {{-- Turut Mengundang --}}
        {{-- @if ($data->teksPenutup->mengundang)
    <div
        class="flex flex-col lg:absolute lg:inset-x-0 lg:-bottom-14 justify-center items-center space-y-3 pt-10 text-sm">
        <p class="text-xl font-semibold">Turut Mengundang:</p>
        <p>{!! nl2br(e($data->teksPenutup->mengundang)) !!}</p>
    
    </div>
    @endif --}}
        {{-- Turut Mengundang --}}
</div>
