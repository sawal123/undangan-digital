<div class="bg-neutral-950 relative font-corinthia">
    <!-- card 1 -->
    <p class="text-center text-[12px] font-semibold font-poppins mb-5">{{ $data->teksUndangan->pembuka }}</p>
    <div class="  justify-center">

        <div class="flex flex-row pl-12 items-center justify-start space-x-4 font-poppins">
            <div class=""><img src="{{ asset('storage/' . $data->wanita->image) }}" alt=""
                    class="object-cover object-center aspect-square rounded-full w-[150px] lg:w-[180px]">
            </div>
            <div class="text-orange-200">
                <h2 class="text-[50px]  font-light font-corinthia text-orange-200 ">
                    {{ $data->wanita->nama_lengkap }}</h2>
                <p class="text-[13px] font-semibold">
                    {{ $data ? $data->wanita->nama_panggilan : 'Ajeng Febian' }} <span class="text-[12px]">(Nama
                        Panggilan)</p>
                <p class="font-semibold text-[13px] space-y-5">
                    {{ $data->wanita->deskripsi }}</p>
            </div>
        </div>
    </div>

    <!-- card 2 -->
    <div class=" justify-center pt-10">
        <div class="flex flex-row pr-12 px-2 items-center justify-end space-x-4">
            <div class="text-orange-200 font-poppins">
                <h2 class="text-[50px]  font-light font-corinthia text-orange-200 ">
                    {{ $data->pria->nama_lengkap }} </h2>
                <p class="text-[16px] font-semibold">
                    {{ $data ? $data->pria->nama_panggilan : 'Teddy Prakarsa' }} <span class="text-[12px]">(Nama
                        Panggilan)</span></p>
                <p class="font-semibold text-[13px] space-y-5">
                    {{ $data->pria->deskripsi }}</p>
            </div>
            <div class=""><img src="{{ asset('storage/' . $data->pria->image) }}" alt=""
                    class="object-cover object-center aspect-square rounded-full w-[150px] lg:w-[180px]">
            </div>
        </div>
        {{-- <h2 class="text-[50px] text-center lg:absolute lg:inset-x-0  lg:-bottom-10  font-light text-orange-200 ">
            {{ $data->pria->nama_panggilan }}</h2> --}}
    </div>
</div>
