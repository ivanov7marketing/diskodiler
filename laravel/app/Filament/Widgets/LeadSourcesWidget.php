<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Widgets\Concerns\InteractsWithDashboardPeriod;
use App\Support\AdminDashboard\DashboardAnalytics;
use Filament\Widgets\Widget;

class LeadSourcesWidget extends Widget
{
    use InteractsWithDashboardPeriod;

    protected static bool $isLazy = false;

    protected static ?int $sort = 30;

    protected string $view = 'filament.widgets.lead-sources-widget';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 4,
    ];

    protected function getViewData(): array
    {
        $period = $this->getDashboardPeriodDays();
        $data = app(DashboardAnalytics::class)->leadSources($period);

        return [
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'total' => $data['total'],
            'segments' => collect($data['segments'])
                ->map(fn (array $segment): array => [
                    ...$segment,
                    'url' => LeadResource::getUrl('index', [
                        'filters' => [
                            'created_window' => ['period' => (string) $period],
                            'traffic_channel' => ['value' => $segment['channel']],
                        ],
                    ], isAbsolute: false),
                ])
                ->all(),
            'donutStyle' => $this->buildDonutStyle($data['segments']),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $segments
     */
    private function buildDonutStyle(array $segments): string
    {
        $total = collect($segments)->sum('count');

        if ($total === 0) {
            return 'background: conic-gradient(#e5e7eb 0deg 360deg);';
        }

        $start = 0.0;
        $parts = [];

        foreach ($segments as $segment) {
            $count = (int) $segment['count'];

            if ($count === 0) {
                continue;
            }

            $degrees = ($count / $total) * 360;
            $end = $start + $degrees;
            $parts[] = "{$segment['hex']} {$start}deg {$end}deg";
            $start = $end;
        }

        if ($parts === []) {
            $parts[] = '#e5e7eb 0deg 360deg';
        }

        return 'background: conic-gradient(' . implode(', ', $parts) . ');';
    }
}
