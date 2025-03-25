<div class="bg-orange-50 relative text-pink-800 w-full h-full lg:pt-5 pt-16 font-poppins"
    style="background-image: url('{{ asset('tema/whitepre/src/img/border.png') }}'); background-position: center; background-size:cover; ">

    @foreach ($data->acara as $item)
        <div class="flex flex-col items-center justify-center w-full space-y-3 font-normal text-[15px] lg:text-[10px] ">
            <h2 class="flex justify-center text-[50px] z-50 font-semibold pt-5  font-great_vibes">
                {{ $item->nama_acara }}</h2>
            <div>
                {{ date('d', strtotime($item->date)) }},
                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('l') }}
                {{ \Carbon\Carbon::parse($item->date)->translatedFormat('F Y') }}</div>
            <div>pukul {{ $item->jam_start }} - {{ $item->jam_end }} {{ $item->zona_waktu }}</div>
            <div>{{ $item->alamat }}</div>
            <div>{{ $item->vanue }}</div>
        </div>

        <!-- button -->
        <div class="text-center pt-5 ">
            <a href="{{ $item->maps }}"
                class="rounded-full w-11 border border-orange-200 text-[15px] lg:text-[10px]  p-2"><i
                    class="fa-solid fa-map-location-dot mr-2"></i>lihat lokasi</a>
        </div>
    @endforeach

</div>
