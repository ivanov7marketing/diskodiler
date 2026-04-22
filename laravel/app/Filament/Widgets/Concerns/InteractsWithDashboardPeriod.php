<?php

namespace App\Filament\Widgets\Concerns;

use Filament\Widgets\Concerns\InteractsWithPageFilters;

trait InteractsWithDashboardPeriod
{
    use InteractsWithPageFilters;

    protected function getDashboardPeriodDays(): int
    {
        return match ((int) data_get($this->pageFilters, 'period')) {
            24 => 24,
            7 => 7,
            default => 30,
        };
    }

    protected function getDashboardPeriodLabel(): string
    {
        return match ($this->getDashboardPeriodDays()) {
            24 => '24 часа',
            7 => '7 дней',
            default => '30 дней',
        };
    }
}
