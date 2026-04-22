<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Widgets\Concerns\InteractsWithDashboardPeriod;
use App\Support\AdminDashboard\DashboardAnalytics;
use Filament\Widgets\Widget;

class LeadFunnelWidget extends Widget
{
    use InteractsWithDashboardPeriod;

    protected static bool $isLazy = false;

    protected static ?int $sort = 20;

    protected string $view = 'filament.widgets.lead-funnel-widget';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 8,
    ];

    protected function getViewData(): array
    {
        $period = $this->getDashboardPeriodDays();
        $data = app(DashboardAnalytics::class)->leadFunnel($period);

        return [
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'steps' => collect($data['steps'])
                ->map(fn (array $step): array => [
                    ...$step,
                    'url' => LeadResource::getUrl('index', [
                        'filters' => [
                            'created_window' => ['period' => (string) $period],
                            'status' => ['value' => $step['status']],
                        ],
                    ], isAbsolute: false),
                ])
                ->all(),
            'noAnswer' => [
                'count' => $data['no_answer'],
                'url' => LeadResource::getUrl('index', [
                    'filters' => [
                        'created_window' => ['period' => (string) $period],
                        'status' => ['value' => 'no_answer'],
                    ],
                ], isAbsolute: false),
            ],
        ];
    }
}
