<div class="undangan mt-10 flex flex-col justify-center py-2">
    {{-- AKAD --}}
    @foreach ($data->acara as $item)
        <div class="border my-2 py-2 rounded-lg ">
            <p class="items-center text-center text-4xl title italic  my-7 text-[#755f4B]" data-aos="fade-up"
                data-aos-duration="1500">
                {{ $item->nama_acara }}</p>
            <div class="grid grid-cols-3 gap-4 items-center mx-12 md:mx-28 text-[12px] md:text-lg" data-aos="fade-up">
                <!-- Kolom 1 -->
                <div class="flex flex-col items-center border-t border-gray-400">
                    <span
                        class="text-gray-600 py-4 text-sm">{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('l') }}
                    </span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>

                <!-- Kolom 2 -->
                <div class="text-center">
                    <span
                        class="block text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('F') }}
                    </span>
                    <span
                        class="block text-4xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('d') }}
                    </span>
                    <span
                        class="block text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('Y') }}
                    </span>
                </div>

                <!-- Kolom 3 -->
                <div class="flex flex-col items-center text-center border-t border-gray-400">
                    <span class="text-gray-600 py-4 text-sm">{{ $item->jam_start }} s/d {{ $item->jam_end }}
                        {{ $item->zona_waktu }} </span>
                    <span class="border-t border-gray-400 w-full mt-1"></span>
                </div>
            </div>
            <div class="mt-8">
                <p class="text-center  text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">
                    {{ $item->alamat }}</p>
                <p class="text-center  text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">{{ $item->vanue }}
                </p>
            </div>
            <div class="flex justify-center mt-2">
                <a href="{{ $item->maps }}" class=" px-4 py-2 bg-[#755f4B] text-white rounded-lg hover:bg-gray-500"
                    data-aos="fade-up" data-aos-duration="1800">
                    Lihat Lokasi
                </a>
            </div>

        </div>
    @endforeach





</div>
