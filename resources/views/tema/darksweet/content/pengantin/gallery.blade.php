@if ($poto)
    <div class=" pt-5 bg-red-800 h-auto" id="gallery">
        <h1 class="text-white text-center text-3xl font-bold font-italiana">Gallery</h1>

        <!-- Video -->
        @if (!empty($video[0]))
            <div class="aspect-video w-full text-center flex justify-center mt-4 mb-4 py-4 bg-black" data-aos="zoom-in-up"
                data-aos-duration="3000">
                <iframe class="w-full h-full" src="{{ $video[0] }}" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        @endif


        <!-- Gallery -->
        <div class="gallery-container" data-aos="fade-up" data-aos-duration="3000">
            @foreach ($poto as $item)
                <div class="w-full">
                    <img src="{{ asset('storage/' . $item) }}"
                        class="object-cover object-center gallery-item w-full h-[200px] md:h-[180px] lg:h-[160px] rounded-lg shadow-md cursor-pointer"
                        alt="Wedding Potret" onclick="openModalImg(this)" />
                </div>
            @endforeach
        </div>
        <p class="text-sm text-center break-words text-white mt-5" data-aos="fade-up" data-aos-duration="3000">
            {{ $data->teksUndangan->penutup }}
        </p>
    </div>

@endif
