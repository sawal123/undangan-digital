<section id="couple" class="darkpre-section darkpre-couple-section" aria-label="Kedua mempelai">
    <p class="darkpre-section-lead" data-aos="fade-down">
        {{ $data->teksUndangan?->pembuka ?? '' }}
    </p>

    <div class="darkpre-couple-grid">
        <article class="darkpre-couple-card" data-aos="fade-right">
            <img src="{{ asset('storage/' . ($data->pria?->image ?? 'images/placeholder.jpg')) }}"
                alt="Foto {{ $data->pria?->nama_lengkap ?? 'mempelai pria' }}">
            <h2 class="darkpre-couple-name">{{ $data->pria?->nama_lengkap ?? 'Mempelai pria' }}</h2>
            <p class="darkpre-couple-bio">{{ $data->pria?->deskripsi ?? '' }}</p>
        </article>

        <div class="darkpre-couple-ampersand" aria-hidden="true">&amp;</div>

        <article class="darkpre-couple-card" data-aos="fade-left">
            <img src="{{ asset('storage/' . ($data->wanita?->image ?? 'images/placeholder.jpg')) }}"
                alt="Foto {{ $data->wanita?->nama_lengkap ?? 'mempelai wanita' }}">
            <h2 class="darkpre-couple-name">{{ $data->wanita?->nama_lengkap ?? 'Mempelai wanita' }}</h2>
            <p class="darkpre-couple-bio">{{ $data->wanita?->deskripsi ?? '' }}</p>
        </article>
    </div>
</section>
