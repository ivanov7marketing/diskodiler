<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Products\ProductResource;
use App\Support\AdminDashboard\DashboardAnalytics;
use Filament\Widgets\Widget;

class CatalogHealthWidget extends Widget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 50;

    protected string $view = 'filament.widgets.catalog-health-widget';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 'full',
    ];

    protected function getViewData(): array
    {
        $data = app(DashboardAnalytics::class)->catalogHealth();

        return [
            'items' => [
                [
                    'label' => 'Всего товаров',
                    'count' => $data['total_products'],
                    'tone' => 'neutral',
                    'url' => null,
                ],
                [
                    'label' => 'Активные товары',
                    'count' => $data['active_products'],
                    'tone' => 'success',
                    'url' => ProductResource::getUrl('index', [
                        'filters' => [
                            'active' => ['value' => 1],
                        ],
                    ], isAbsolute: false),
                ],
                [
                    'label' => 'Без фото',
                    'count' => $data['missing_images'],
                    'tone' => 'warning',
                    'url' => $this->productFilterUrl('missing_images'),
                ],
                [
                    'label' => 'Без цены',
                    'count' => $data['missing_price'],
                    'tone' => 'warning',
                    'url' => $this->productFilterUrl('missing_price'),
                ],
                [
                    'label' => 'Без SEO',
                    'count' => $data['missing_seo'],
                    'tone' => 'danger',
                    'url' => $this->productFilterUrl('missing_seo'),
                ],
                [
                    'label' => 'Без видео',
                    'count' => $data['missing_video'],
                    'tone' => 'danger',
                    'url' => $this->productFilterUrl('missing_video'),
                ],
            ],
        ];
    }

    private function productFilterUrl(string $filter): string
    {
        return ProductResource::getUrl('index', [
            'filters' => [
                'active' => ['value' => 1],
                $filter => ['isActive' => true],
            ],
        ], isAbsolute: false);
    }
}
