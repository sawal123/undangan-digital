<main class="darkpre-content-panel relative z-10">
    @include('tema.darkpre.content.cover-kanan')

    <section class="darkpre-section" aria-label="Kutipan pernikahan">
        <div class="darkpre-quote-card" data-aos="fade-up">
            @if ($data->qoute?->title)
                <p class="mb-3 font-semibold">{{ $data->qoute->title }}</p>
            @endif
            <p>{{ $data->qoute?->qoute ?? '' }}</p>
            @if ($data->qoute?->subtitle)
                <span class="mt-3 block text-sm not-italic">{{ $data->qoute->subtitle }}</span>
            @endif
        </div>
    </section>

    <div class="darkpre-divider" aria-hidden="true">
        <img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" alt="">
    </div>

    @include('tema.darkpre.content.pengantin.opening')

    <div class="darkpre-divider" aria-hidden="true">
        <img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" alt="">
    </div>

    @include('tema.darkpre.content.pengantin.himbauan-1')
    @include('tema.darkpre.content.pengantin.acara')

    @php
        $activeRundowns = $rundowns ?? ($data->rundowns ? $data->rundowns->where('is_active', true)->values() : collect());
    @endphp
    @if ($activeRundowns->isNotEmpty())
        @include('tema.partials.rundown', ['rundowns' => $activeRundowns, 'variant' => 'darkpre'])
    @endif

    <div class="darkpre-divider" aria-hidden="true">
        <img src="{{ asset('tema/darkpre/src/img/pembatas.png') }}" alt="">
    </div>

    @include('tema.darkpre.content.pengantin.story')
    @include('tema.darkpre.content.pengantin.album')
    @include('tema.darkpre.content.pengantin.ucapan')

    <footer class="darkpre-footer">
        presented by<br>
        <span class="font-semibold">Wayae Nikah</span>
    </footer>

    <nav class="darkpre-mobile-nav navbar block lg:hidden" id="mobile-navbar" aria-label="Navigasi undangan">
        <div>
            <div>
                <a aria-label="Pasangan" class="nav-link couple" href="#couple"><i class="fa-regular fa-heart"></i><span class="ml-2 hidden">Pasangan</span></a>
                <a aria-label="Acara" class="nav-link date" href="#date"><i class="fa-regular fa-calendar"></i><span class="ml-2 hidden">Acara</span></a>
                <a aria-label="Lokasi" class="nav-link location" href="#location"><i class="fa-solid fa-map-location-dot"></i><span class="ml-2 hidden">Lokasi</span></a>
                @if ($poto)
                    <a aria-label="Galeri" class="nav-link gallery" href="#gallery"><i class="fa-regular fa-images"></i><span class="ml-2 hidden">Galeri</span></a>
                @endif
                <a aria-label="Ucapan" class="nav-link wishes" href="#wishes"><i class="fa-regular fa-note-sticky"></i><span class="ml-2 hidden">Ucapan</span></a>
            </div>
        </div>
    </nav>
</main>
