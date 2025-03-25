@if ($data->kisah->isNotEmpty())
<div class="mt-5 w-full h-[950px] flex flex-col relative mx-0 px-0 bg-zinc-800 shadow-inner shadow-black">
    <!-- Header Our Story -->
        <div class="text-center w-full py-16 font-italiana" data-aos="fade-up" data-aos-duration="3000">
            <h1 class="text-4xl font-bold text-white mb-2">Our Story</h1>
            <p class="text-lg text-white">Momen indah kita berdua</p>
        </div>
 


    <!-- Konten -->
    <div class="w-full flex flex-wrap items-center">
        @foreach ($data->kisah as $item)
            <!-- Kolom Gambar Kiri -->
            <div class="basis-1/2 h-[300px]">
                <img src="{{ asset('storage/' . $item->image->image) }}"
                    class="object-cover object-center h-full w-full  shadow-md" alt="Wedding Potret">
            </div>

            <!-- Kolom Deskripsi Kanan -->
            <div
                class="basis-1/2 h-[300px] flex flex-col justify-center text-white bg-stone-700 p-6  shadow-md overflow-hidden ">
                <h3 class="text-[14px] font-semibold mb-2 text-start">{{ $item->title }}</h3>
                <p class="text-[12px] text-start break-words">
                    {{ $item->deskripsi }}
                </p>
            </div>
        @endforeach


    </div>
    <div class="absolute border-b-2 border-white bottom-16 right-0 w-4/5 z-10"></div>
    <!-- Gradient Background -->
    <div class="absolute w-full bottom-0 h-32 bg-gradient-to-t from-black to-transparent z-0"></div>
</div>
@endif