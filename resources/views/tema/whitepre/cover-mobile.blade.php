<style>
    #cover-mobile {
        isolation: isolate;
        overflow: hidden;
        background-color: #1f1820;
    }

    #cover-mobile::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg,
                rgba(17, 14, 22, 0.18) 0%,
                rgba(17, 14, 22, 0.08) 28%,
                rgba(17, 14, 22, 0.42) 62%,
                rgba(17, 14, 22, 0.86) 100%);
        z-index: 1;
    }

    #cover-mobile::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 24%, rgba(255, 255, 255, 0.2), transparent 34%);
        z-index: 1;
        pointer-events: none;
    }

    #cover-mobile>.whitepre-cover-content {
        position: relative;
        z-index: 2;
        min-height: 100dvh;
        padding: clamp(2.5rem, 9vh, 5rem) 1.25rem 6.5rem;
        text-shadow: 0 3px 16px rgba(0, 0, 0, 0.58);
    }

    .whitepre-cover-content h3 {
        padding: 0.65rem 1.2rem;
        border: 1px solid rgba(255, 255, 255, 0.52);
        border-radius: 999px;
        background: rgba(20, 16, 24, 0.34);
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.2), inset 0 1px rgba(255, 255, 255, 0.25);
        letter-spacing: 0.08em;
        font-size: clamp(1rem, 4.8vw, 1.5rem);
    }

    .whitepre-cover-title {
        max-width: 100%;
        color: #fffaf5;
        text-shadow: 0 4px 22px rgba(0, 0, 0, 0.72);
    }

    .whitepre-cover-date {
        margin-top: 0.75rem;
        padding: 0.35rem 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.55);
        border-bottom: 1px solid rgba(255, 255, 255, 0.55);
        letter-spacing: 0.18em;
        font-weight: 600;
    }

    .whitepre-cover-content .whitepre-cover-guest {
        margin-top: clamp(7rem, 19vh, 10rem) !important;
        max-width: 22rem;
        padding: 0.7rem 1rem;
        border-radius: 1rem;
        background: rgba(20, 16, 24, 0.28);
        border: 1px solid rgba(255, 255, 255, 0.24);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.16);
    }

    #open-cover {
        position: absolute;
        left: 50%;
        bottom: clamp(2.5rem, 7vh, 4.5rem);
        min-width: 12rem;
        transform: translateX(-50%);
        padding: 0.85rem 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.9);
        border-radius: 999px;
        color: #2b1c1b !important;
        background: linear-gradient(135deg, #fffdf9 0%, #f4dfcb 100%) !important;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.32), 0 0 0 5px rgba(255, 255, 255, 0.12);
        text-shadow: none;
        animation: whitepre-cover-breathe 2.4s ease-in-out infinite;
        transition: transform 180ms ease, box-shadow 180ms ease;
    }

    #open-cover:hover,
    #open-cover:focus-visible {
        transform: translateX(-50%) translateY(-3px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.36), 0 0 0 6px rgba(255, 255, 255, 0.18);
    }

    @keyframes whitepre-cover-breathe {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(-5px); }
    }

    @media (prefers-reduced-motion: reduce) {
        #open-cover { animation: none; }
    }
</style>
<div id="cover-mobile" class="h-full w-full  fixed lg:hidden block z-50 text-white"
    style="background-image: url(' {{ asset('storage/' . ($thumbnailWa?->thumbnail ?? '')) }}'); background-size: cover; background-position: center;">
    <div class="whitepre-cover-content w-full text-shadow flex justify-center items-center flex-col">
        <h3 class="text-center font-semibold text-2xl pt-10" data-aos="fade-down" data-aos-easing="linear"
            data-aos-duration="1500">{{ $data->setting?->acara ?? 'The Wedding' }}</h3>
        <h1 class="whitepre-cover-title mt-8 text-center text-[50px] font-light " data-aos="fade-up"
            data-aos-anchor-placement="top-bottom">
            {{ $data->pria?->nama_panggilan ?? '' }}<span class=" text-[25px]"> & </span>
            {{ $data->wanita?->nama_panggilan ?? '' }}
        </h1>
        @php
            $firstAcaraDate = ($data->acara[0] ?? null)?->date;
        @endphp
        <p class="whitepre-cover-date text-center text-[20px]" data-aos="fade-up"
            data-aos-anchor-placement="bottom-bottom">
            {{ $firstAcaraDate ? date('d', strtotime($firstAcaraDate)) : '10' }}
            {{ $firstAcaraDate ? date('m', strtotime($firstAcaraDate)) : '10' }}
            {{ $firstAcaraDate ? date('Y', strtotime($firstAcaraDate)) : '2024' }}
        </p>

        <p style="margin-top:150px" class="whitepre-cover-guest text-center text-[20px]" data-aos="fade-up"
            data-aos-anchor-placement="bottom-bottom">
            {{ $tamu }}
        </p>
        <p class="text-center text-[13px]">Tanpa Mengurangi Rasa Hormat, Kami Mengundang Bapak/Ibu/Saudara/i
            untuk
            Hadir di
            Acara Kami.</p>

        <button id="open-cover" class="font-semibold">
            Buka Undangan
        </button>
    </div>
</div>
