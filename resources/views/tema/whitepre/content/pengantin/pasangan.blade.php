<div class="bg-orange-50 relative  font-great_vibes section"
    style="background-image: url(' {{ asset('tema/whitepre/src/img/bg_1.png') }}'); background-position: center; background-size: contain;">
    <p class="text-center text-[12px] font-semibold font-poppins" style="margin-bottom: 15px; color: #313131"
        ata-aos="fade-down" data-aos-easing="ease-out" data-aos-duration="2000">{{ $data->teksUndangan->pembuka }}
    </p>
    <!-- card 2 -->
    <div class=" flex flex-col justify-center items-center">
        <div class="" data-aos="flip-right" data-aos-easing="ease-out-cubic" data-aos-duration="2000"><img
                src="{{ asset('storage/' . $data->pria->image) }}" alt=""
                class="object-cover object-center aspect-square rounded-full max-w-[350px] ">
        </div>
        <h3 class="text-[40px] text-center text-pink-800 font-semibold pt-5">
            {{ $data ? $data->pria->nama_lengkap : 'Teddy Prakarsa' }} </h3>
        <div class="flex flex-col text-center items-center justify-center  font-poppins">
            <div class="text-pink-800">
                <p class="font-semibold text-[13px] space-y-5">{{ $data->pria->deskripsi }}</p>
            </div>
        </div>
    </div>
    <!-- card 1 -->

    <div class=" flex flex-col justify-center items-center"
        style="background-image: url('{{ asset('tema/whitepre/src/img/bunga.png') }}'); background-position: center; background-size: contain;">
        <div class="" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000"><img
                src="{{ asset('storage/' . $data->wanita->image) }}" alt=""
                class="object-cover object-center aspect-square rounded-full max-w-[350px] ">
        </div>

        <h3 class="text-[40px] text-center text-pink-800 font-semibold pt-5">
            {{ $data ? $data->wanita->nama_lengkap : 'Ajeng Febian' }}
        </h3>
        <div class="flex flex-col text-center items-center justify-center space-x-4 font-poppins">

            <div class="text-pink-800">
                <p class="font-semibold text-[13px] space-y-5">{{ $data->wanita->deskripsi }}</p>
            </div>
        </div>
    </div>

    <div class="text-center text-4xl font-poppins text-pink-800 py-5 pb-8 font-semibold">&</div>



</div>
