<section id="standHadiah" class="stand-section stand-section--soft">
    <div class="stand-section__header" data-aos="fade-up">
        <p class="stand-eyebrow">Tanda kasih</p>
        <h2 class="stand-section__title">Titip Hadiah</h2>
        <p class="stand-section__subtitle">Doa dan kehadiran Anda adalah hadiah terindah. Jika berkenan, tanda kasih dapat disampaikan melalui pilihan berikut.</p>
    </div>

    @if (!empty($video[0]))
        <div class="stand-video" data-aos="fade-up"><iframe src="{{ $video[0] }}" title="Video pernikahan" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>
    @endif

    @if ($data->kado?->isNotEmpty())
        <div class="stand-gift-list">
            @foreach ($data->kado as $kado)
                <article class="stand-gift-card" data-aos="fade-up">
                    <p class="stand-gift-card__bank">{{ $kado->giftPay?->nama_pay ?? 'Pembayaran' }}</p>
                    <p class="stand-gift-card__name">{{ $kado->namaPay }}</p>
                    <p class="stand-gift-card__number">{{ $kado->nomorPay }}</p>
                    <button type="button" class="stand-button stand-gift-card__button" data-copy="{{ $kado->nomorPay }}"><i class="fa-regular fa-copy"></i>Salin Nomor</button>
                </article>
                @if ($kado->qris)
                    <article class="stand-gift-card" data-aos="fade-up"><p class="stand-gift-card__bank">QRIS</p><p class="stand-gift-card__name">Scan untuk mengirim tanda kasih</p><img src="{{ asset('storage/' . $kado->qris) }}" alt="QRIS" style="display:block;width:min(70%,14rem);margin:1rem auto 0;border-radius:.75rem;"></article>
                @endif
            @endforeach
        </div>
    @endif

    @if ($data->teksPenutup?->mengundang)
        <div class="stand-quote" data-aos="fade-up">{!! nl2br(e($data->teksPenutup->mengundang)) !!}</div>
    @endif
</section>
