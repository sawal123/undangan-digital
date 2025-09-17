<div class="bg-neutral-950 relative ">
    <!-- card 1 -->

    <p class="text-center text-[12px] text-orange-200 font-semibold  mb-5">{{ $data->teksUndangan->pembuka }}</p>
    <div class="  justify-center">
        <!-- card 2 -->
        <div class="bg-neutral-950 pt-10 section" id="couple"><img
                src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" class="w-full" alt=""></div>
        <div class=" justify-center pt-10">
            <div class="flex flex-row pr-12 px-4 items-center justify-end space-x-4">
                <div class="text-orange-200 ">
                    <h1 class="text-[50px]  font-light  text-orange-200 ">
                        {{ $data->pria->nama_lengkap }} </h1>
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

        </div>

        <div class="bg-neutral-950 pt-10 section" id="couple"><img
                src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" class="w-full" alt=""></div>
        <div class="flex flex-row pl-12 items-center justify-start space-x-4 ">
            <div class=""><img src="{{ asset('storage/' . $data->wanita->image) }}" alt=""
                    class="object-cover object-center aspect-square rounded-full w-[150px] lg:w-[180px]">
            </div>
            <div class="text-orange-200">
                <h1 class="text-[50px]  font-light  text-orange-200 ">
                    {{ $data->wanita->nama_lengkap }}</h1>
                <p class="text-[13px] font-semibold">
                    {{ $data ? $data->wanita->nama_panggilan : 'Ajeng Febian' }} <span class="text-[12px]">(Nama
                        Panggilan)</p>
                <p class="font-semibold text-[13px] space-y-5">
                    {{ $data->wanita->deskripsi }}</p>
            </div>
        </div>
    </div>


</div>
