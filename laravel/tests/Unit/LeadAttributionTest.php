<?php

namespace Tests\Unit;

use App\Support\LeadAttribution;
use Tests\TestCase;

class LeadAttributionTest extends TestCase
{
    public function test_source_page_normalization_handles_urls_queries_and_trailing_slashes(): void
    {
        $this->assertSame('/services', LeadAttribution::normalizeSourcePage('https://diskodiler.ru/services/?utm_source=yandex#form'));
        $this->assertSame('/diski/bmw', LeadAttribution::normalizeSourcePage('/diski/bmw/'));
        $this->assertSame('/', LeadAttribution::normalizeSourcePage('https://diskodiler.ru'));
        $this->assertNull(LeadAttribution::normalizeSourcePage(null));
    }

    public function test_extract_referer_host_normalizes_the_host_name(): void
    {
        $this->assertSame('www.google.com', LeadAttribution::extractRefererHost('https://www.google.com/search?q=wheel'));
        $this->assertNull(LeadAttribution::extractRefererHost(null));
    }

    public function test_traffic_channel_detection_covers_direct_yandex_seo_and_other(): void
    {
        $this->assertSame(
            LeadAttribution::CHANNEL_YANDEX_DIRECT,
            LeadAttribution::determineTrafficChannel([
                'utm_source' => 'yandex',
                'utm_medium' => 'cpc',
            ], 'yandex.ru'),
        );

        $this->assertSame(
            LeadAttribution::CHANNEL_SEO,
            LeadAttribution::determineTrafficChannel([], 'www.google.com'),
        );

        $this->assertSame(
            LeadAttribution::CHANNEL_DIRECT,
            LeadAttribution::determineTrafficChannel([], null),
        );

        $this->assertSame(
            LeadAttribution::CHANNEL_OTHER,
            LeadAttribution::determineTrafficChannel(['utm_source' => 'telegram'], 't.me'),
        );
    }
}
