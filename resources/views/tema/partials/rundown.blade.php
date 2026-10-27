@php
    $items = $rundowns ?? ($data->rundowns ? $data->rundowns->where('is_active', true)->values() : collect());
    $themeVariant = $variant ?? 'default';
@endphp

@if ($items->isNotEmpty())
    <div class="wayae-rundown-wrapper" style="width: 100%; max-width: 680px; margin: 0 auto; padding: 1.5rem 1rem; box-sizing: border-box;">
        @if (!isset($hideHeader) || !$hideHeader)
            <div style="text-align: center; margin-bottom: 2rem;">
                <p style="text-transform: uppercase; letter-spacing: 0.15em; font-size: 0.8rem; font-weight: 600; opacity: 0.8; margin-bottom: 0.35rem;">
                    {{ $eyebrow ?? 'Susunan Kegiatan' }}
                </p>
                <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; line-height: 1.2;">
                    {{ $title ?? 'Rundown Acara' }}
                </h2>
                <p style="font-size: 0.875rem; opacity: 0.85; max-width: 480px; margin: 0 auto;">
                    {{ $subtitle ?? 'Rangkaian agenda kegiatan yang akan berlangsung.' }}
                </p>
            </div>
        @endif

        <div class="wayae-rundown-timeline" style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach ($items as $item)
                @php
                    $isDark = in_array($themeVariant, ['dark', 'darkpre', 'gold', 'spiderman']);
                    $cardBg = match($themeVariant) {
                        'dark', 'darkpre' => 'rgba(255, 255, 255, 0.05)',
                        'gold', 'logangold' => 'rgba(255, 255, 245, 0.08)',
                        'light', 'whitepre' => '#ffffff',
                        'flower', 'flowerone' => '#ffffff',
                        'blue', 'wedding_blue' => '#ffffff',
                        'pink', 'deepone-pink' => '#ffffff',
                        'spiderman' => 'rgba(0, 0, 0, 0.45)',
                        default => 'rgba(255, 255, 255, 0.85)',
                    };
                    $cardBorder = match($themeVariant) {
                        'dark', 'darkpre' => 'rgba(255, 255, 255, 0.12)',
                        'gold', 'logangold' => 'rgba(212, 175, 55, 0.4)',
                        'light', 'whitepre' => 'rgba(244, 114, 182, 0.25)',
                        'flower', 'flowerone' => '#e8dfd8',
                        'blue', 'wedding_blue' => 'rgba(190, 215, 240, 0.6)',
                        'spiderman' => '#ff2d3f',
                        default => 'rgba(0, 0, 0, 0.08)',
                    };
                    $badgeBg = match($themeVariant) {
                        'dark', 'darkpre' => 'linear-gradient(135deg, #c5a059, #9e7d3b)',
                        'gold', 'logangold' => 'linear-gradient(135deg, #d4af37, #b8922a)',
                        'light', 'whitepre' => '#f472b6',
                        'flower', 'flowerone' => '#c29b7f',
                        'blue', 'wedding_blue' => '#4a7bb0',
                        'spiderman' => '#FFC300',
                        default => '#4f46e5',
                    };
                    $badgeText = match($themeVariant) {
                        'spiderman' => '#000000',
                        default => '#ffffff',
                    };
                    $titleColor = match($themeVariant) {
                        'dark', 'darkpre', 'gold', 'logangold' => '#ffffff',
                        'spiderman' => '#FFC300',
                        default => 'inherit',
                    };
                @endphp
                <article class="wayae-rundown-item" style="background: {{ $cardBg }}; border: 1px solid {{ $cardBorder }}; border-radius: 1.25rem; padding: 1.2rem 1.4rem; box-shadow: 0 4px 16px rgba(0,0,0,0.04); position: relative; overflow: hidden; box-sizing: border-box;">
                    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.5rem; margin-bottom: 0.6rem;">
                        <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.3rem 0.8rem; border-radius: 9999px; background: {{ $badgeBg }}; color: {{ $badgeText }}; font-weight: 700; font-size: 0.775rem; letter-spacing: 0.02em;">
                            <i class="far fa-clock" aria-hidden="true"></i>
                            {{ $item->waktu_mulai }}{{ $item->waktu_selesai ? ' - ' . $item->waktu_selesai : '' }}
                        </span>
                        @if ($item->acara?->nama_acara)
                            <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.65rem; border-radius: 9999px; background: rgba(128, 128, 128, 0.12); font-size: 0.725rem; font-weight: 500; opacity: 0.9;">
                                <i class="fas fa-tag" style="margin-right: 0.3rem; font-size: 0.65rem;"></i>
                                {{ $item->acara->nama_acara }}
                            </span>
                        @endif
                    </div>

                    <h3 style="font-size: 1.1rem; font-weight: 700; color: {{ $titleColor }}; margin: 0.4rem 0 0.3rem 0; line-height: 1.35;">
                        {{ $item->nama_kegiatan }}
                    </h3>

                    @if ($item->keterangan)
                        <p style="font-size: 0.85rem; opacity: 0.8; line-height: 1.5; margin: 0 0 0.4rem 0;">
                            {{ $item->keterangan }}
                        </p>
                    @endif

                    @if ($item->lokasi)
                        <div style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.8rem; opacity: 0.85; margin-top: 0.4rem;">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <span>{{ $item->lokasi }}</span>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
@endif
