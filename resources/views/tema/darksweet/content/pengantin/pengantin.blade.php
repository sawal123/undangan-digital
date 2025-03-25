<p class="text-center text-[12px] leading-[20px]" data-aos="fade-up" data-aos-duration="3000">Atas Rahmat
    {{ $data->teksUndangan->pembuka }}
</p>

<!-- Card 1 -->
<div class="mx-auto bg-white overflow-hidden my-3 px-3 font-italiana">
    <div class="flex justify-center" data-aos="zoom-in-up" data-aos-duration="3000">
        <img src="{{ asset('storage/' . $data->pria->image) }}" alt="Foto Siska"
        style="width: 256px; height: 256px; object-fit: cover; border-radius: 50%;" />
    

    </div>

    <div class="p-4 text-center" data-aos="fade-up" data-aos-duration="3000">
        <h2 class="text-xl font-semibold text-gray-800">{{ $data->pria->nama_lengkap }}</h2>
        <p class="mt-2 text-gray-600">{{ $data->pria->deskripsi }}</p>
    </div>
</div>
<!-- Card 1 -->

<!-- Card 2 -->
<div class="mx-auto bg-white overflow-hidden my-3 px-3 font-italiana">
    <div class="flex justify-center" data-aos="zoom-in-up" data-aos-duration="3000">
        <img src="{{ asset('storage/' . $data->wanita->image) }}" alt="Foto Siska"
        style="width: 256px; height: 256px; object-fit: cover; border-radius: 50%;" />
    

    </div>

    <div class="p-4 text-center" data-aos="fade-up" data-aos-duration="3000">
        <h2 class="text-xl font-semibold text-gray-800">{{ $data->wanita->nama_lengkap }}</h2>
        <p class="mt-2 text-gray-600">{{ $data->wanita->deskripsi }}</p>
    </div>
</div>
<!-- Card 2 -->
