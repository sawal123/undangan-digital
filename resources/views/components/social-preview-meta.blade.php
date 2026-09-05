@props([
    'data' => null,
    'title' => null,
    'description' => null,
])

@php
    // Thumbnail WA — absolute HTTPS URL, never empty path
    $thumbnailPath = $data?->thumbnailWas?->thumbnail;
    $ogImage = null;
    $ogImageType = null;
    if ($thumbnailPath) {
        $ogImage = secure_asset('storage/' . ltrim($thumbnailPath, '/'));
        // Derive MIME from extension safely
        $ext = strtolower(pathinfo($thumbnailPath, PATHINFO_EXTENSION));
        $ogImageType = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            default => null,
        };
    }

    // Fallback: default invitation image (always accessible, real PNG 1024x1024)
    $fallbackImage = secure_asset('images/default-invitation.png');
    $finalImage = $ogImage ?? $fallbackImage;
    if (! $thumbnailPath) {
        $ogImageType = 'image/png';
    }

    $finalTitle = $title ?? ($data?->title ?? 'WayaeNikah');
    $finalDescription = $description ?? ($data?->teksUndangan?->acara ?? 'Undangan digital WayaeNikah');
    $currentUrl = url()->current();
@endphp

{{-- Open Graph --}}
<meta property="og:image" content="{{ $finalImage }}" />
<meta property="og:image:secure_url" content="{{ $finalImage }}" />
@if ($ogImageType)
<meta property="og:image:type" content="{{ $ogImageType }}" />
@endif
{{-- Only render width/height for known fallback image — dynamic thumbnail dimensions unknown --}}
@if (! $thumbnailPath)
<meta property="og:image:width" content="1024" />
<meta property="og:image:height" content="1024" />
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="{{ $finalImage }}" />