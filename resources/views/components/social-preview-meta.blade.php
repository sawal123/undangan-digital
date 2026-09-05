@props([
    'data' => null,
    'title' => null,
    'description' => null,
])

@php
    // Thumbnail WA — absolute HTTPS URL, never empty path
    $thumbnailPath = $data?->thumbnailWas?->thumbnail;
    $ogImage = null;
    if ($thumbnailPath) {
        $ogImage = secure_asset('storage/' . ltrim($thumbnailPath, '/'));
    }

    // Fallback: default invitation image (always accessible)
    $fallbackImage = secure_asset('images/default-invitation.png');
    $finalImage = $ogImage ?? $fallbackImage;

    $finalTitle = $title ?? ($data?->title ?? 'WayaeNikah');
    $finalDescription = $description ?? ($data?->teksUndangan?->acara ?? 'Undangan digital WayaeNikah');
    $currentUrl = url()->current();
@endphp

{{-- Open Graph --}}
<meta property="og:image" content="{{ $finalImage }}" />
<meta property="og:image:secure_url" content="{{ $finalImage }}" />
<meta property="og:image:type" content="image/png" />
<meta property="og:image:width" content="1024" />
<meta property="og:image:height" content="1024" />

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="{{ $finalImage }}" />