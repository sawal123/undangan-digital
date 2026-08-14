@if ($data->kisah?->isNotEmpty())
    <div class="mt-5 w-full py-16 flex flex-col relative mx-0 px-4 bg-zinc-800 shadow-inner shadow-black">
        <!-- Header Our Story -->
        <div class="text-center w-full mb-10 font-italiana z-10" data-aos="fade-up" data-aos-duration="3000">
            <h1 class="text-4xl font-bold text-white mb-3 tracking-wide">Our Story</h1>
            <p class="text-xs uppercase tracking-widest text-amber-400 font-bold block pb-2"
                style="color: #fbbf24 !important;">Momen indah kita berdua</p>
            <div class="w-12 h-0.5 bg-amber-400 mx-auto mt-2"></div>
        </div>

        <!-- Konten Cerita dengan penambahan margin & gap eksklusif -->
        <div class="w-full flex flex-col gap-10 z-10 mb-12 mt-4">
            @foreach ($data->kisah as $item)
                <div class="w-full bg-stone-900 rounded-3xl overflow-hidden shadow-2xl border border-stone-700 flex flex-col"
                    data-aos="fade-up" data-aos-duration="2000">
                    <!-- Bagian Gambar Atas -->
                    <div class="w-full h-64 relative overflow-hidden">
                        <img src="{{ asset('storage/' . ($item->image?->image ?? '')) }}"
                            class="object-cover object-center w-full h-full" alt="Wedding Potret">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-stone-900 via-transparent to-transparent opacity-60">
                        </div>
                    </div>

                    <!-- Bagian Deskripsi Bawah -->
                    <div class="w-full p-6 flex flex-col justify-start text-white bg-stone-900">
                        <h3 class="text-base font-bold mb-3 text-amber-300 tracking-wide text-start"
                            style="color: #fcd34d !important;">{{ $item->title }}</h3>
                        <p class="text-xs text-gray-300 text-start leading-relaxed break-words font-light">
                            {{ $item->deskripsi }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Garis & Gradient Pembatas -->
        <div class="absolute border-b border-stone-600 bottom-12 right-0 w-4/5 z-10"></div>
        <div class="absolute w-full bottom-0 h-24 bg-gradient-to-t from-black to-transparent z-0"></div>
    </div>
@endif
