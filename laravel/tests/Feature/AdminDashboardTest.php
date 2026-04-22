<?php

namespace Tests\Feature;

use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Resources\Products\ProductResource;
use App\Models\Brand;
use App\Models\Lead;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Models\VehicleModel;
use App\Support\AdminDashboard\DashboardAnalytics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_lead_period_stats_respect_moscow_boundaries(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-04-21 12:00:00', 'Europe/Moscow'));

        $leadToday = Lead::create([
            'type' => 'lead',
            'status' => 'new',
            'source_page' => '/',
        ]);

        $leadPreviousDay = Lead::create([
            'type' => 'lead',
            'status' => 'new',
            'source_page' => '/',
        ]);

        $leadToday->forceFill([
            'created_at' => Carbon::parse('2026-04-21 08:00:00', 'Europe/Moscow'),
            'updated_at' => Carbon::parse('2026-04-21 08:00:00', 'Europe/Moscow'),
        ])->saveQuietly();

        $leadPreviousDay->forceFill([
            'created_at' => Carbon::parse('2026-04-20 23:30:00', 'Europe/Moscow'),
            'updated_at' => Carbon::parse('2026-04-20 23:30:00', 'Europe/Moscow'),
        ])->saveQuietly();

        Cache::flush();

        $stats = app(DashboardAnalytics::class)->leadPeriodStats();

        $this->assertSame(1, $stats['today']['count']);
        $this->assertSame(2, $stats['7']['count']);
        $this->assertSame(2, $stats['30']['count']);
    }

    public function test_dashboard_funnel_excludes_no_answer_from_main_sequence(): void
    {
        foreach ([
            'new' => 4,
            'in_progress' => 3,
            'contacted' => 2,
            'done' => 1,
            'no_answer' => 5,
        ] as $status => $count) {
            for ($index = 0; $index < $count; $index++) {
                Lead::create([
                    'type' => 'lead',
                    'status' => $status,
                    'source_page' => '/',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Cache::flush();

        $funnel = app(DashboardAnalytics::class)->leadFunnel(30);

        $this->assertSame([4, 3, 2, 1], array_column($funnel['steps'], 'count'));
        $this->assertSame(5, $funnel['no_answer']);
    }

    public function test_dashboard_24_hour_window_is_rolling_and_not_calendar_day(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-04-21 12:00:00', 'Europe/Moscow'));

        $recentLead = Lead::create([
            'type' => 'lead',
            'status' => 'new',
            'source_page' => '/',
        ]);

        $olderLead = Lead::create([
            'type' => 'lead',
            'status' => 'new',
            'source_page' => '/',
        ]);

        $recentLead->forceFill([
            'created_at' => Carbon::parse('2026-04-20 13:00:00', 'Europe/Moscow'),
            'updated_at' => Carbon::parse('2026-04-20 13:00:00', 'Europe/Moscow'),
        ])->saveQuietly();

        $olderLead->forceFill([
            'created_at' => Carbon::parse('2026-04-18 08:00:00', 'Europe/Moscow'),
            'updated_at' => Carbon::parse('2026-04-18 08:00:00', 'Europe/Moscow'),
        ])->saveQuietly();

        Cache::flush();

        $funnel = app(DashboardAnalytics::class)->leadFunnel(24);

        $this->assertSame('24 часа', $funnel['period']['label']);
        $this->assertSame(1, $funnel['steps'][0]['count']);
    }

    public function test_dashboard_top_pages_rank_normalized_paths_and_compute_share(): void
    {
        foreach ([
            'https://diskodiler.ru/services/?utm=1',
            '/services/',
            '/',
            null,
        ] as $sourcePage) {
            Lead::create([
                'type' => 'lead',
                'status' => 'new',
                'source_page' => $sourcePage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Cache::flush();

        $pages = app(DashboardAnalytics::class)->topLeadPages(30);

        $this->assertSame(4, $pages['total']);
        $this->assertSame('/services', $pages['pages'][0]['path']);
        $this->assertSame(2, $pages['pages'][0]['count']);
        $this->assertSame(50.0, $pages['pages'][0]['share']);
    }

    public function test_dashboard_catalog_health_counts_only_active_problem_products(): void
    {
        [$brand, $vehicleModel] = $this->makeCatalogContext();

        $healthy = Product::create([
            'brand_id' => $brand->id,
            'vehicle_model_id' => $vehicleModel->id,
            'slug' => 'healthy-product',
            'title' => 'Healthy Product',
            'price' => 100000,
            'meta_title' => 'Healthy title',
            'meta_description' => 'Healthy description',
            'video_url' => 'https://example.com/video.mp4',
            'active' => true,
        ]);

        ProductImage::create([
            'product_id' => $healthy->id,
            'url' => 'https://example.com/image.jpg',
            'sort' => 1,
            'is_primary' => true,
        ]);

        Product::create([
            'brand_id' => $brand->id,
            'vehicle_model_id' => $vehicleModel->id,
            'slug' => 'broken-active-product',
            'title' => 'Broken Active Product',
            'active' => true,
        ]);

        Product::create([
            'brand_id' => $brand->id,
            'vehicle_model_id' => $vehicleModel->id,
            'slug' => 'broken-inactive-product',
            'title' => 'Broken Inactive Product',
            'active' => false,
        ]);

        Cache::flush();

        $health = app(DashboardAnalytics::class)->catalogHealth();

        $this->assertSame(3, $health['total_products']);
        $this->assertSame(2, $health['active_products']);
        $this->assertSame(1, $health['missing_images']);
        $this->assertSame(1, $health['missing_price']);
        $this->assertSame(1, $health['missing_seo']);
        $this->assertSame(1, $health['missing_video']);
    }

    public function test_admin_dashboard_renders_widgets_and_deep_links(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        [$brand, $vehicleModel] = $this->makeCatalogContext();

        Product::create([
            'brand_id' => $brand->id,
            'vehicle_model_id' => $vehicleModel->id,
            'slug' => 'dashboard-product',
            'title' => 'Dashboard Product',
            'active' => true,
        ]);

        Lead::create([
            'type' => 'lead',
            'status' => 'new',
            'source_page' => '/services',
            'traffic_channel' => 'seo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::flush();

        $response = $this->actingAs($user)->get('/admin');

        $response
            ->assertOk()
            ->assertSee('Дашборд')
            ->assertSee('24 часа')
            ->assertSee('Воронка лидов')
            ->assertSee('Источники лидов')
            ->assertSee('Состояние каталога')
            ->assertSee(LeadResource::getUrl('index', [
                'filters' => [
                    'created_window' => ['period' => 'today'],
                ],
            ], isAbsolute: false), false)
            ->assertSee(str_replace('&', '&amp;', ProductResource::getUrl('index', [
                'filters' => [
                    'active' => ['value' => 1],
                    'missing_images' => ['isActive' => true],
                ],
            ], isAbsolute: false)), false);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    /**
     * @return array{Brand, VehicleModel}
     */
    private function makeCatalogContext(): array
    {
        $brand = Brand::create([
            'name' => 'BMW',
            'slug' => 'bmw',
            'active' => true,
        ]);

        $vehicleModel = VehicleModel::create([
            'brand_id' => $brand->id,
            'name' => 'X5',
            'slug' => 'x5',
            'active' => true,
        ]);

        return [$brand, $vehicleModel];
    }
}
