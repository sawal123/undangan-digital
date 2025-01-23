<div class="reveal mt-10 mb-10">
    @if ($video)
        <div class="relative w-auto h-96 mx-4" data-aos="fade-up" data-aos-duration="1500">
            <div class="col-12" style="height: 250px;">
                <iframe src="{{ $video[0] }}" class="absolute top-0 left-0 w-full h-full" frameborder="0"></iframe>
            </div>
        </div>
    @endif
</div>

<div class="bg-stone-500 rounded-lg  flex flex-col items-center my-2 justify-center mx-6 relative w-auto py-5 mt-6">
    <p class="text-center text-white " data-aos="fade-up" data-aos-duration="1500">
        Tanpa mengurangi rasa hormat, untuk melengkapi kebahagiaan pengantin, Anda dapat memberikan tanda
        kasih dengan transfer ke rekening/emoney berikut :
    </p>
    @foreach ($data->kado as $kado)
        <p class="mt-6 text-[12px] md:text-lg text-center font-bold text-white" data-aos="fade-up"
            data-aos-duration="1500">
            {{ $kado->giftPay->nama_pay }} <br>No.Rek/Emoney :
            {{ $kado->nomorPay }} <br> a.n : {{ $kado->namaPay }}</p>
    @endforeach
</div>
<!-- Daftar Nama -->
<!-- Judul Turut Mengundang -->
@if ($data->teksPenutup->mengundang)
    <div class="mt-8">
        <h3 class="text-center text-xl mb-5 text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">Turut Mengundang
        </h3>
        <div class="text-center flex flex-col items-center text-sm md:text-lg space-y-2 text-[#755f4B]"
            data-aos="fade-up" data-aos-duration="1500">
            <p>
                {!! nl2br(e($data->teksPenutup->mengundang)) !!}
            </p>
        </div>
    </div>
@endif
