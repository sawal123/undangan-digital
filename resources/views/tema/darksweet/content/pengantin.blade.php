<section id="pengantin" class="darksweet-section darksweet-section--soft">
    <div class="darksweet-section__header" data-aos="fade-up">
        <p class="darksweet-eyebrow">Dengan penuh rasa syukur</p>
        <h2 class="darksweet-section__title">Tentang Kami</h2>
        <p class="darksweet-section__subtitle">Dua hati, satu cerita, dan perjalanan baru yang ingin kami rayakan bersama.</p>
    </div>

    @if ($data->teksUndangan?->pembuka)
        <p class="darksweet-lead" data-aos="fade-up">{{ $data->teksUndangan->pembuka }}</p>
    @endif

    @include('tema.darksweet.content.pengantin.pengantin')
</section>

@include('tema.darksweet.content.pengantin.hitunganhari')

<section id="savethedate" class="darksweet-section darksweet-section--soft">
    @include('tema.darksweet.content.pengantin.acara')
</section>

@if ($data->kisah?->isNotEmpty())
    <section id="story" class="darksweet-section darksweet-section--accent">
        @include('tema.darksweet.content.pengantin.kisah')
    </section>
@endif

@if (!empty($poto))
    <section id="gallery" class="darksweet-section darksweet-section--soft">
        @include('tema.darksweet.content.pengantin.gallery')
    </section>
@endif

@if ($data->kado?->isNotEmpty())
    <section id="hadiah" class="darksweet-section darksweet-section--accent">
        <div class="darksweet-section__header" data-aos="fade-up">
            <p class="darksweet-eyebrow">Tanda kasih</p>
            <h2 class="darksweet-section__title">Titip Hadiah</h2>
            <p class="darksweet-section__subtitle">Doa dan kehadiran Anda adalah hadiah terindah. Jika berkenan, Anda dapat mengirimkan tanda kasih melalui pilihan berikut.</p>
        </div>

        <div class="darksweet-gift-list">
            @foreach ($data->kado as $kado)
                <article class="darksweet-gift-card" data-aos="fade-up">
                    <div class="darksweet-gift-card__icon" aria-hidden="true">
                        @if ($kado->giftPay?->icon && (file_exists(public_path('storage/' . $kado->giftPay->icon)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($kado->giftPay->icon)))
                            <img src="{{ asset('storage/' . $kado->giftPay->icon) }}" alt="{{ $kado->giftPay?->nama_pay ?? 'Bank' }}">
                        @else
                            <i class="fa-solid fa-building-columns"></i>
                        @endif
                    </div>
                    <div>
                        @if ($kado->giftPay?->nama_pay)
                            <p class="darksweet-gift-card__bank">{{ $kado->giftPay->nama_pay }}</p>
                        @endif
                        <p class="darksweet-gift-card__number">{{ $kado->nomorPay }}</p>
                        @php
                            $ownerName = trim($kado->namaPay ?? '');
                            $isPrefixed = preg_match('/^a[\.\/\s]*n[\.\/\s]*/i', $ownerName);
                            $displayOwner = $isPrefixed ? $ownerName : ($ownerName ? 'a.n. ' . $ownerName : '');
                        @endphp
                        @if ($displayOwner)
                            <p class="darksweet-gift-card__name">{{ $displayOwner }}</p>
                        @endif
                    </div>
                    <button type="button" class="darksweet-copy-button" data-copy="{{ $kado->nomorPay }}">Salin</button>
                </article>
                @if ($kado->qris)
                    <div class="darksweet-gift-card" data-aos="fade-up">
                        <div class="darksweet-gift-card__icon" aria-hidden="true"><i class="fa-solid fa-qrcode"></i></div>
                        <div>
                            <p class="darksweet-gift-card__bank">QRIS</p>
                            <p class="darksweet-gift-card__name">Scan untuk mengirim tanda kasih.</p>
                        </div>
                        <a class="darksweet-copy-button" href="{{ asset('storage/' . $kado->qris) }}" target="_blank" rel="noopener">Lihat</a>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endif

<section id="absen" class="darksweet-section darksweet-section--soft">
    @include('tema.darksweet.content.pengantin.ucapan')
</section>

@php
    $endingImage = $thumbnailWa?->thumbnail
        ? asset('storage/' . $thumbnailWa->thumbnail)
        : asset('tema/darksweet/img/pasangan.jpg');
@endphp
<section class="darksweet-ending" style="background-image: url('{{ $endingImage }}');">
    <div class="darksweet-ending__content" data-aos="fade-up">
        <div class="darksweet-ending__image">
            <img src="{{ $endingImage }}" alt="Foto kedua mempelai">
        </div>
        <h2 class="darksweet-ending__title">Terima Kasih</h2>
        <p class="darksweet-ending__text">{{ $data->teksUndangan?->penutup ?? 'Sampai jumpa di hari bahagia kami.' }}</p>
    </div>
</section>

<script>
    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-copy]');
        if (!button) return;

        navigator.clipboard?.writeText(button.dataset.copy).then(() => {
            const originalText = button.textContent;
            button.textContent = 'Tersalin';
            window.setTimeout(() => { button.textContent = originalText; }, 1400);
        });
    });
</script>
