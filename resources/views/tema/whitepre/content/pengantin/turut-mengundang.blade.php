<section class="whitepre-section" aria-label="Keluarga yang turut mengundang"
    style="background-image: url('{{ asset('tema/whitepre/src/img/bunga.png') }}'); background-position: center; background-size: contain;">
    <p class="whitepre-invitation-note" data-aos="fade-up">
        {{ $data->teksUndangan?->penutup ?? '' }}
    </p>

    @if ($data->teksPenutup?->mengundang)
        <div class="whitepre-guest-list" data-aos="fade-up">
            <p class="mb-2 font-semibold">Turut Mengundang</p>
            <p>{!! nl2br(e($data->teksPenutup->mengundang)) !!}</p>
        </div>
    @endif
</section>
