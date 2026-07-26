<?php

namespace App\Services;

use Illuminate\Support\Str;

class YouTubeUrlParser
{
    private const ALLOWED_HOSTS = [
        'youtube.com',
        'www.youtube.com',
        'm.youtube.com',
        'youtu.be',
        'www.youtu.be',
    ];

    public function toEmbedUrl(?string $url, int $start = 0): ?string
    {
        $videoId = $this->videoId($url);

        if (! $videoId) {
            return null;
        }

        return 'https://www.youtube.com/embed/'.$videoId.($start > 0 ? '?start='.$start : '');
    }

    public function videoId(?string $url): ?string
    {
        if (! $url || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $host = Str::lower(parse_url($url, PHP_URL_HOST) ?? '');

        if (! in_array($host, self::ALLOWED_HOSTS, true)) {
            return null;
        }

        $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        $query = [];
        parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $query);

        $videoId = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $videoId = strtok($path, '/');
        } elseif ($path === 'watch') {
            $videoId = $query['v'] ?? null;
        } elseif (Str::startsWith($path, 'shorts/')) {
            $videoId = explode('/', $path)[1] ?? null;
        } elseif (Str::startsWith($path, 'embed/')) {
            $videoId = explode('/', $path)[1] ?? null;
        }

        return is_string($videoId) && preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId) ? $videoId : null;
    }
}
