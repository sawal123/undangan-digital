<aside class="darkpre-left-panel" aria-label="Panel foto undangan">
    <div class="darkpre-left-image"
        style="background-image: url('{{ asset('storage/' . ($thumbnailWa?->thumbnail ?? 'images/placeholder.jpg')) }}');"></div>
    <h2 class="darkpre-left-title">
        @if ($isWanitaFirst ?? $data->is_wanita_first)
            {{ $data->wanita?->nama_panggilan ?? '' }}
            <span class="font-poppins text-[25px]">&amp;</span>
            {{ $data->pria?->nama_panggilan ?? '' }}
        @else
            {{ $data->pria?->nama_panggilan ?? '' }}
            <span class="font-poppins text-[25px]">&amp;</span>
            {{ $data->wanita?->nama_panggilan ?? '' }}
        @endif
    </h2>

    @include('tema.darkpre.content.music')
    @include('tema.darkpre.content.pengantin.kado')

    <nav class="darkpre-side-nav navbar hidden lg:block" id="desktop-navbar" aria-label="Navigasi undangan">
        <div>
            <div>
                <a aria-label="Pasangan" class="nav-link couple" href="#couple">
                    <i class="fa-regular fa-heart"></i>
                    <span class="ml-2 hidden">Pasangan</span>
                </a>
                <a aria-label="Acara" class="nav-link date" href="#date">
                    <i class="fa-regular fa-calendar"></i>
                    <span class="ml-2 hidden">Acara</span>
                </a>
                <a aria-label="Lokasi" class="nav-link location" href="#location">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span class="ml-2 hidden">Lokasi</span>
                </a>
                <a aria-label="Galeri" class="nav-link gallery" href="#gallery">
                    <i class="fa-regular fa-images"></i>
                    <span class="ml-2 hidden">Galeri</span>
                </a>
                <a aria-label="Ucapan" class="nav-link wishes" href="#wishes">
                    <i class="fa-regular fa-note-sticky"></i>
                    <span class="ml-2 hidden">Ucapan</span>
                </a>
            </div>
        </div>
    </nav>
</aside>
