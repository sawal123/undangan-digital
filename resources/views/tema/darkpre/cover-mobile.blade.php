<style>
 

    #cover-mobile::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Sesuaikan transparansi */
        z-index: 1;
    }

    #cover-mobile>* {
        position: relative;
        z-index: 2;
    }
    #open-cover {
        position: absolute;
        bottom: -200px
    }
</style>
<div id="cover-mobile" class="h-full w-full font-poppins fixed lg:hidden block z-50 text-white"
    style="background-image: url(' {{ asset('storage/' . $thumbnailWa->thumbnail) }}'); background-size: cover; background-position: center;">
    <div class="w-full flex justify-center items-center flex-col">
        <h3 class="text-center font-semibold text-2xl pt-10" data-aos="fade-down" data-aos-easing="linear"
            data-aos-duration="1500">{{$data->setting->acara ?? 'The Wedding'}}</h3>
        <h2 class="mt-8 text-center text-[50px] font-light font-corinthia" data-aos="fade-up"
            data-aos-anchor-placement="top-bottom">
            {{ $data->pria->nama_panggilan }}<span class="font-poppins text-[25px]">&</span>
            {{ $data->wanita->nama_panggilan }}
        </h2>
        <p class="text-center text-[20px]" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">
            {{ $data ? date('d', strtotime($data->acara[0]->date)) : '10' }}
            {{ $data ? date('m', strtotime($data->acara[0]->date)) : '10' }}
            {{ $data ? date('Y', strtotime($data->acara[0]->date)) : '2024' }}
        </p>

        <p style="margin-top:150px" class="text-center text-[20px]" data-aos="fade-up"
            data-aos-anchor-placement="bottom-bottom">
            {{ $tamu }}
        </p>
        <p class="text-center text-[13px]">Tanpa Mengurangi Rasa Hormat, Kami Mengundang Bapak/Ibu/Saudara/i
            untuk
            Hadir di
            Acara Kami.</p>

        <button id="open-cover" style="background: #313131"
            class=" px-4 py-2 font-semibold rounded-full  border-white border-2 animate-bounce">
            Buka Undangan
        </button>
    </div>
</div>
