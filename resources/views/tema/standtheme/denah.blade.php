@if ($acara->maps)
    <div class="denah mt-10">
        <h2 class="text-center text-xl md:text-2xl uppercase mb-8 text-[#755f4B]" data-aos="fade-up"
            data-aos-duration="1500">Peta
            Lokasi</h2>
        <div class="relative w-auto h-96 mx-4" data-aos="fade-up" data-aos-duration="1500">
            <iframe class="absolute top-0 left-0 w-full h-full" src="{{ $acara->maps }}" frameborder="0" style="border:0;"
                allowfullscreen="" aria-hidden="false" tabindex="0">
            </iframe>
        </div>
    </div>
@endif
