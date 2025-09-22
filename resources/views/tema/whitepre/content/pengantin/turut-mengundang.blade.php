<div class="w-full text-center text-pink-800 bg-orange-50"
    style="background-image: url('{{ asset('tema/whitepre/src/img/bunga.png') }}' ); background-position: center; background-size: contain;">
    <div class="text-center w-full pt-14 pb-10 font-light lg:text-sm ">
      {{$data->teksUndangan->penutup}}
    </div>
    @if ($data->teksPenutup->mengundang)
    <div
        class="flex flex-col lg:absolute lg:inset-x-0 lg:-bottom-14 justify-center items-center space-y-3 pt-10 text-sm">
        <p class="text-xl font-semibold">Turut Mengundang:</p>
        <p>{!! nl2br(e($data->teksPenutup->mengundang)) !!}</p>

    </div>
@endif
</div>
