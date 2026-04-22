<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Support\AdminDashboard\DashboardAnalytics;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadPeriodStatsWidget extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 10;

    protected int | string | array $columnSpan = [
        'default' => 'full',
    ];

    protected ?string $heading = 'Лиды за период';

    protected ?string $description = 'Фиксированные срезы входящих заявок';

    protected int | array | null $columns = [
        'default' => 1,
        'md' => 3,
    ];

    protected function getStats(): array
    {
        $stats = app(DashboardAnalytics::class)->leadPeriodStats();

        return [
            $this->makeStat($stats['today'], 'warning', Heroicon::OutlinedCalendarDays, 'today'),
            $this->makeStat($stats['7'], 'info', Heroicon::OutlinedChartBarSquare, '7'),
            $this->makeStat($stats['30'], 'success', Heroicon::OutlinedPresentationChartLine, '30'),
        ];
    }

    private function makeStat(array $data, string $color, string | \BackedEnum $icon, string $period): Stat
    {
        return Stat::make($data['label'], number_format($data['count']))
            ->description($data['description'])
            ->descriptionIcon(Heroicon::ArrowTopRightOnSquare, IconPosition::After)
            ->color($color)
            ->icon($icon)
            ->extraAttributes([
                'class' => 'admin-dashboard-kpi-card',
                'data-tone' => $color,
            ])
            ->url(LeadResource::getUrl('index', [
                'filters' => [
                    'created_window' => ['period' => $period],
                ],
            ], isAbsolute: false));
    }
}
