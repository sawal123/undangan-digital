<div class="darksweet-section__header" data-aos="fade-up">
    <p class="darksweet-eyebrow">Susunan Kegiatan</p>
    <h2 class="darksweet-section__title">Rundown Acara</h2>
    <p class="darksweet-section__subtitle">Rangkaian agenda kegiatan yang akan berlangsung.</p>
</div>

<div class="darksweet-rundown-list" style="display: flex; flex-direction: column; gap: 1rem; max-width: 680px; margin: 0 auto; width: 100%;">
    @foreach ($rundowns as $item)
        <article class="darksweet-rundown-card" data-aos="fade-up" style="background: linear-gradient(135deg, rgba(240, 200, 143, 0.08), rgba(199, 124, 145, 0.05)); border: 1px solid var(--ds-line); border-radius: 1.25rem; padding: 1.25rem 1.4rem; position: relative; overflow: hidden; box-sizing: border-box;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.5rem; margin-bottom: 0.6rem;">
                <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.85rem; border-radius: 9999px; background: var(--ds-gold); color: var(--ds-ink); font-weight: 700; font-size: 0.8rem; letter-spacing: 0.02em;">
                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                    {{ $item->waktu_mulai }}{{ $item->waktu_selesai ? ' - ' . $item->waktu_selesai : '' }}
                </span>
                @if ($item->acara?->nama_acara)
                    <span style="display: inline-flex; align-items: center; padding: 0.3rem 0.75rem; border-radius: 9999px; background: rgba(255, 255, 255, 0.08); color: var(--ds-gold); font-size: 0.75rem; border: 1px solid var(--ds-line); font-weight: 500;">
                        <i class="fa-solid fa-tag" style="margin-right: 0.35rem; font-size: 0.65rem;"></i>
                        {{ $item->acara->nama_acara }}
                    </span>
                @endif
            </div>

            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem; line-height: 1.4;">
                {{ $item->nama_kegiatan }}
            </h3>

            @if ($item->keterangan)
                <p style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.75); line-height: 1.5; margin-bottom: 0.5rem;">
                    {{ $item->keterangan }}
                </p>
            @endif

            @if ($item->lokasi)
                <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.825rem; color: var(--ds-gold); margin-top: 0.4rem;">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    <span>{{ $item->lokasi }}</span>
                </div>
            @endif
        </article>
    @endforeach
</div>
