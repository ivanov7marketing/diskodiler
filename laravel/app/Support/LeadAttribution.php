<?php

namespace App\Support;

use Illuminate\Support\Str;

class LeadAttribution
{
    public const CHANNEL_SEO = 'seo';

    public const CHANNEL_DIRECT = 'direct';

    public const CHANNEL_YANDEX_DIRECT = 'yandex_direct';

    public const CHANNEL_OTHER = 'other';

    /**
     * @var array<int, string>
     */
    private const SEARCH_ENGINE_HOSTS = [
        'google.',
        'yandex.',
        'bing.com',
        'search.yahoo.com',
        'duckduckgo.com',
        'go.mail.ru',
        'search.mail.ru',
        'rambler.ru',
    ];

    /**
     * @var array<int, string>
     */
    private const PAID_MEDIUM_MARKERS = [
        'cpc',
        'ppc',
        'paid',
        'paid_search',
        'cpm',
        'cpv',
        'cpa',
    ];

    public static function normalizeSourcePage(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (self::looksLikeUrl($value)) {
            $path = parse_url(self::qualifyUrl($value), PHP_URL_PATH);

            if (($path === false) || ($path === null) || ($path === '')) {
                return '/';
            }

            $value = $path;
        } else {
            $value = Str::before(Str::before($value, '#'), '?');

            if ($value === '') {
                return '/';
            }
        }

        if (! str_starts_with($value, '/')) {
            $value = '/' . $value;
        }

        $value = preg_replace('#/+#', '/', $value) ?: $value;

        if ($value !== '/') {
            $value = rtrim($value, '/');
        }

        return $value === '' ? '/' : $value;
    }

    public static function normalizeRefererUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (! self::looksLikeUrl($value)) {
            return null;
        }

        return self::qualifyUrl($value);
    }

    public static function extractRefererHost(?string $refererUrl): ?string
    {
        $refererUrl = self::normalizeRefererUrl($refererUrl);

        if ($refererUrl === null) {
            return null;
        }

        $host = parse_url($refererUrl, PHP_URL_HOST);

        if (! is_string($host) || ($host === '')) {
            return null;
        }

        return self::normalizeHost($host);
    }

    /**
     * @param  array<string, mixed>  $utm
     */
    public static function determineTrafficChannel(array $utm = [], ?string $refererHost = null): ?string
    {
        $utm = self::normalizeUtm($utm);
        $refererHost = self::normalizeHost($refererHost);

        if (self::isYandexDirect($utm)) {
            return self::CHANNEL_YANDEX_DIRECT;
        }

        if (self::isSearchEngineHost($refererHost) && self::isExternalReferer($refererHost)) {
            return self::CHANNEL_SEO;
        }

        if (! self::hasAnyUtm($utm) && ! self::isExternalReferer($refererHost)) {
            return self::CHANNEL_DIRECT;
        }

        if (self::hasAnyUtm($utm) || filled($refererHost)) {
            return self::CHANNEL_OTHER;
        }

        return null;
    }

    private static function looksLikeUrl(string $value): bool
    {
        if (str_starts_with($value, '//')) {
            return true;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:\/\//i', $value) === 1) {
            return true;
        }

        return preg_match('/^[^\/\s]+\.[^\/\s]+(?:\/.*)?$/', $value) === 1;
    }

    private static function qualifyUrl(string $value): string
    {
        if (str_starts_with($value, '//')) {
            return 'https:' . $value;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:\/\//i', $value) === 1) {
            return $value;
        }

        return 'https://' . $value;
    }

    private static function normalizeHost(?string $host): ?string
    {
        $host = trim(Str::lower((string) $host));

        if ($host === '') {
            return null;
        }

        return ltrim($host, '.');
    }

    /**
     * @param  array<string, mixed>  $utm
     * @return array<string, string>
     */
    private static function normalizeUtm(array $utm): array
    {
        $normalized = [];

        foreach ($utm as $key => $value) {
            if (is_array($value) || is_object($value)) {
                continue;
            }

            $key = Str::lower(trim((string) $key));
            $value = Str::lower(trim((string) $value));

            if (($key === '') || ($value === '')) {
                continue;
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }

    /**
     * @param  array<string, string>  $utm
     */
    private static function hasAnyUtm(array $utm): bool
    {
        return $utm !== [];
    }

    /**
     * @param  array<string, string>  $utm
     */
    private static function isYandexDirect(array $utm): bool
    {
        if (filled($utm['yclid'] ?? null)) {
            return true;
        }

        $source = $utm['utm_source'] ?? '';
        $medium = $utm['utm_medium'] ?? '';
        $campaign = $utm['utm_campaign'] ?? '';

        if (Str::contains($campaign, 'direct')) {
            return true;
        }

        if (! Str::contains($source, 'yandex')) {
            return false;
        }

        foreach (self::PAID_MEDIUM_MARKERS as $marker) {
            if (Str::contains($medium, $marker)) {
                return true;
            }
        }

        return false;
    }

    private static function isSearchEngineHost(?string $host): bool
    {
        if (blank($host)) {
            return false;
        }

        foreach (self::SEARCH_ENGINE_HOSTS as $needle) {
            if (Str::contains($host, $needle)) {
                return true;
            }
        }

        return false;
    }

    private static function isExternalReferer(?string $refererHost): bool
    {
        if (blank($refererHost)) {
            return false;
        }

        $appHost = self::normalizeHost((string) parse_url((string) config('app.url'), PHP_URL_HOST));

        if (blank($appHost)) {
            return true;
        }

        if ($refererHost === $appHost) {
            return false;
        }

        return ! str_ends_with($refererHost, '.' . $appHost);
    }
}
