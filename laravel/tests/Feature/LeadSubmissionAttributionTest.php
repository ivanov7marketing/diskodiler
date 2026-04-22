<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadSubmissionAttributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_lead_submission_stores_normalized_source_page_referer_and_channel(): void
    {
        $response = $this->postJson('/leads', [
            'type' => 'lead',
            'goal' => 'dashboard_test',
            'page' => 'https://diskodiler.ru/services/?utm_source=yandex#cta',
            'referer_url' => 'https://www.google.com/search?q=diskodiler',
            'fields' => [
                'name' => 'Maxim',
                'phone' => '+7 900 000-00-00',
            ],
            'utm' => [],
        ]);

        $response->assertCreated()->assertJson(['ok' => true]);

        $this->assertDatabaseHas(Lead::class, [
            'phone' => '+7 900 000-00-00',
            'source_page' => '/services',
            'referer_url' => 'https://www.google.com/search?q=diskodiler',
            'referer_host' => 'www.google.com',
            'traffic_channel' => 'seo',
        ]);
    }
}
