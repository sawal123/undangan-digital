@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'author' => null,
    'image' => null,
    'type' => 'website',
    'canonical' => null,
    'robots' => null,
    'siteName' => null,
])

@php
    $settings = \App\Models\SystemSetting::current();
    
    $appName = $siteName ?? ($settings->app_name ?: 'WayaeNikah');
    
    // Title
    $finalTitle = $title ? ($title . ' | ' . $appName) : ($settings->seo_title ?: $appName);
    
    // Description
    $finalDescription = $description ?: ($settings->seo_description ?: 'Platform pembuatan undangan digital & undangan cetak fisik premium dengan desain elegan, fitur lengkap, dan responsif.');
    
    // Keywords
    $finalKeywords = $keywords ?: ($settings->seo_keywords ?: 'undangan digital, undangan pernikahan, undangan cetak, wayaenikah');
    
    // Author
    $finalAuthor = $author ?: ($settings->seo_author ?: $appName);
    
    // Robots
    if ($robots) {
        $finalRobots = $robots;
    } else {
        $index = ($settings->seo_robots_index ?? true) ? 'index' : 'noindex';
        $follow = ($settings->seo_robots_follow ?? true) ? 'follow' : 'nofollow';
        $finalRobots = "{$index},{$follow}";
    }
    
    // Canonical URL
    $finalCanonical = $canonical ?: url()->current();
    
    // Favicon & Apple Icon
    $faviconUrl = $settings->favicon_url;
    $appleTouchUrl = $settings->apple_touch_icon_url;
    
    // Social Sharing Image
    $finalImage = $image ?: $settings->og_image_url;
    
    // OG & Twitter Title/Description
    $ogTitle = $settings->og_title ?: $finalTitle;
    $ogDescription = $settings->og_description ?: $finalDescription;
    $twitterTitle = $settings->twitter_title ?: $finalTitle;
    $twitterDescription = $settings->twitter_description ?: $finalDescription;
    $twitterCard = $settings->twitter_card ?: 'summary_large_image';
@endphp

<!-- Primary Meta Tags -->
<title>{{ $finalTitle }}</title>
<meta name="title" content="{{ $finalTitle }}">
<meta name="description" content="{{ e($finalDescription) }}">
@if($finalKeywords)
    <meta name="keywords" content="{{ e($finalKeywords) }}">
@endif
<meta name="author" content="{{ e($finalAuthor) }}">
<meta name="robots" content="{{ $finalRobots }}">
<link rel="canonical" href="{{ $finalCanonical }}">

<!-- Icons -->
<link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
@if($appleTouchUrl)
    <link rel="apple-touch-icon" href="{{ $appleTouchUrl }}">
@endif

@if(!empty($settings->google_site_verification))
    <meta name="google-site-verification" content="{{ e($settings->google_site_verification) }}">
@endif

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $finalCanonical }}">
<meta property="og:title" content="{{ e($ogTitle) }}">
<meta property="og:description" content="{{ e($ogDescription) }}">
<meta property="og:site_name" content="{{ e($appName) }}">
@if($finalImage)
    <meta property="og:image" content="{{ $finalImage }}">
@endif

<!-- Twitter -->
<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:url" content="{{ $finalCanonical }}">
<meta name="twitter:title" content="{{ e($twitterTitle) }}">
<meta name="twitter:description" content="{{ e($twitterDescription) }}">
@if($settings->twitter_image_url || $finalImage)
    <meta name="twitter:image" content="{{ $settings->twitter_image_url ?: $finalImage }}">
@endif
