<section id="couple" class="whitepre-section whitepre-couple-section"
    style="background-image: url('{{ asset('tema/whitepre/src/img/bg_1.png') }}');">
    <p class="whitepre-section-lead" data-aos="fade-down">
        {{ $data->teksUndangan?->pembuka ?? '' }}
    </p>

    <div class="whitepre-couple-grid">
        <article class="whitepre-couple-card" data-aos="fade-right">
            <img src="{{ asset('storage/' . ($data->pria?->image ?? 'images/placeholder.jpg')) }}"
                alt="Foto {{ $data->pria?->nama_lengkap ?? 'mempelai pria' }}">
            <h2 class="whitepre-couple-name">{{ $data->pria?->nama_lengkap ?? 'Teddy Prakarsa' }}</h2>
            <p class="whitepre-couple-bio">{{ $data->pria?->deskripsi ?? '' }}</p>
        </article>

        <div class="whitepre-couple-ampersand" aria-hidden="true">&amp;</div>

        <article class="whitepre-couple-card" data-aos="fade-left">
            <img src="{{ asset('storage/' . ($data->wanita?->image ?? 'images/placeholder.jpg')) }}"
                alt="Foto {{ $data->wanita?->nama_lengkap ?? 'mempelai wanita' }}">
            <h2 class="whitepre-couple-name">{{ $data->wanita?->nama_lengkap ?? 'Ajeng Febian' }}</h2>
            <p class="whitepre-couple-bio">{{ $data->wanita?->deskripsi ?? '' }}</p>
        </article>
    </div>
</section>
