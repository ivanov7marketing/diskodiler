<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Widgets\Concerns\InteractsWithDashboardPeriod;
use App\Support\AdminDashboard\DashboardAnalytics;
use Filament\Widgets\Widget;

class TopLeadPagesWidget extends Widget
{
    use InteractsWithDashboardPeriod;

    protected static bool $isLazy = false;

    protected static ?int $sort = 40;

    protected string $view = 'filament.widgets.top-lead-pages-widget';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 8,
    ];

    protected function getViewData(): array
    {
        $period = $this->getDashboardPeriodDays();
        $data = app(DashboardAnalytics::class)->topLeadPages($period);

        return [
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'total' => $data['total'],
            'pages' => collect($data['pages'])
                ->map(fn (array $page): array => [
                    ...$page,
                    'url' => LeadResource::getUrl('index', [
                        'filters' => [
                            'created_window' => ['period' => (string) $period],
                            'source_page_path' => ['path' => $page['path']],
                        ],
                    ], isAbsolute: false),
                ])
                ->all(),
        ];
    }
}
