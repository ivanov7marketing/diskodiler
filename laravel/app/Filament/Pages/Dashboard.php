<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CatalogHealthWidget;
use App\Filament\Widgets\LeadFunnelWidget;
use App\Filament\Widgets\LeadPeriodStatsWidget;
use App\Filament\Widgets\LeadSourcesWidget;
use App\Filament\Widgets\TopLeadPagesWidget;
use Filament\Forms\Components\ToggleButtons;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected static string | \BackedEnum | null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $title = 'Дашборд';

    protected Width | string | null $maxContentWidth = Width::Full;

    public function getTitle(): string | Htmlable
    {
        return 'Дашборд';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Лиды, источники и состояние каталога в одном экране. Данные обновляются каждые 5 минут.';
    }

    /**
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            LeadPeriodStatsWidget::class,
            LeadFunnelWidget::class,
            LeadSourcesWidget::class,
            TopLeadPagesWidget::class,
            CatalogHealthWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'md' => 12,
        ];
    }

    public function getPageClasses(): array
    {
        return ['admin-dashboard-page'];
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->columns([
                'default' => 1,
                'md' => 1,
            ])
            ->extraAttributes([
                'class' => 'admin-dashboard-toolbar',
            ], merge: true)
            ->components([
                ToggleButtons::make('period')
                    ->label('Окно аналитики')
                    ->options([
                        '24' => '24 часа',
                        '7' => '7 дней',
                        '30' => '30 дней',
                    ])
                    ->default('30')
                    ->inline()
                    ->grouped()
                    ->extraFieldWrapperAttributes([
                        'class' => 'admin-dashboard-period-switcher',
                    ])
                    ->extraAttributes([
                        'class' => 'admin-dashboard-period-switcher__buttons',
                    ]),
            ]);
    }
}
