<div class="album mt-10">
     @if (!$poto)
        <div class=""></div>
        @else
        <p class="text-4xl title text-center mb-10 text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">
        Album Gallery
    </p>
     @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mx-4" data-aos="fade-up" data-aos-duration="1500">
        @foreach ($poto as $po)
            <div class="relative overflow-hidden rounded-lg shadow-lg">
                <img src="{{ asset('storage/' . $po) }}" class="w-full h-full object-cover object-center transform transition duration-500 hover:scale-105" />
            </div>
        @endforeach
        @foreach ($video as $po)
            <div class="relative overflow-hidden rounded-lg shadow-lg">
                <img src="{{ asset('storage/' . $po) }}" class="w-full h-full object-cover object-center transform transition duration-500 hover:scale-105" />
            </div>
        @endforeach
    </div>

</div>
