<div id="cover-mobile" class="darkpre-mobile-cover fixed inset-0 z-50 text-white lg:hidden"
    style="background-image: url('{{ asset('storage/' . ($thumbnailWa?->thumbnail ?? 'images/placeholder.jpg')) }}'); background-position: center; background-size: cover;">
    <div class="darkpre-hero-content">
        <p class="darkpre-hero-eyebrow" data-aos="fade-down">{{ $data->setting?->acara ?? 'The Wedding' }}</p>
        <h1 class="darkpre-hero-title" data-aos="fade-up" data-aos-delay="120">
            @if ($isWanitaFirst ?? $data->is_wanita_first)
                {{ $data->wanita?->nama_panggilan ?? '' }}
                <span class="font-poppins text-[25px]">&amp;</span>
                {{ $data->pria?->nama_panggilan ?? '' }}
            @else
                {{ $data->pria?->nama_panggilan ?? '' }}
                <span class="font-poppins text-[25px]">&amp;</span>
                {{ $data->wanita?->nama_panggilan ?? '' }}
            @endif
        </h1>
        @php
            $firstAcaraDate = ($data->acara[0] ?? null)?->date;
        @endphp
        <p class="darkpre-hero-date" data-aos="fade-up" data-aos-delay="220">
            {{ $firstAcaraDate ? date('d', strtotime($firstAcaraDate)) : '10' }}
            . {{ $firstAcaraDate ? date('m', strtotime($firstAcaraDate)) : '10' }}
            . {{ $firstAcaraDate ? date('Y', strtotime($firstAcaraDate)) : '2024' }}
        </p>

        @if ($tamu)
            <p class="mt-5 max-w-xs text-center text-sm text-white/85" data-aos="fade-up" data-aos-delay="300">
                Untuk {{ $tamu }}
            </p>
        @endif

        <button id="open-cover" type="button" class="darkpre-submit-button mt-8 min-w-48">
            Buka Undangan
        </button>
    </div>
</div>
