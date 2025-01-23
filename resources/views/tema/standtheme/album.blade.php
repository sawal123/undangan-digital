<div class="album mt-10">
    <h2 class="text-lg md:text-2xl font-semibold uppercase text-center mb-10 text-[#755f4B]" data-aos="fade-up"
        data-aos-duration="1500">
        Album Wedding</h2>
    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4 mx-4" data-aos="fade-up" data-aos-duration="1500">
            @foreach ($poto as $po)
                <div class="grid grid-cols-2 gap-4 mx-4" data-aos="fade-up" data-aos-duration="1500">
                    <img src="{{ asset('storage/' . $po) }}" class="w-auto object-cover object-center" />
                </div>
            @endforeach
            @foreach ($video as $po)
                <div class="grid grid-cols-2 gap-4 mx-4" data-aos="fade-up" data-aos-duration="1500">
                    <img src="{{ asset('storage/' . $po) }}" class="w-auto object-cover object-center" />
                </div>
            @endforeach
        </div>

    </div>
</div>
