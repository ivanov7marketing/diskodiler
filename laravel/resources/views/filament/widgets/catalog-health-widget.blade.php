<x-filament-widgets::widget>
    <section class="admin-dashboard-card admin-dashboard-card--catalog">
        <header class="admin-dashboard-card__header">
            <div class="admin-dashboard-card__header-copy">
                <span class="admin-dashboard-card__eyebrow">Catalog</span>
                <div class="admin-dashboard-card__title-row">
                    <div>
                        <h3 class="admin-dashboard-card__title">Состояние каталога</h3>
                        <p class="admin-dashboard-card__subtitle">Проблемные плитки ведут сразу в нужный фильтр каталога</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="admin-dashboard-health-grid">
            @foreach ($items as $item)
                @if ($item['url'])
                    <a
                        href="{{ $item['url'] }}"
                        @class([
                            'admin-dashboard-health-tile',
                            'admin-dashboard-health-tile--summary' => $loop->index < 2,
                        ])
                        data-tone="{{ $item['tone'] }}"
                    >
                        <div class="admin-dashboard-health-tile__label">{{ $item['label'] }}</div>
                        <div class="admin-dashboard-health-tile__value">{{ number_format($item['count']) }}</div>
                        <div class="admin-dashboard-health-tile__hint">Открыть фильтр</div>
                    </a>
                @else
                    <div
                        @class([
                            'admin-dashboard-health-tile',
                            'admin-dashboard-health-tile--summary' => $loop->index < 2,
                        ])
                        data-tone="{{ $item['tone'] }}"
                    >
                        <div class="admin-dashboard-health-tile__label">{{ $item['label'] }}</div>
                        <div class="admin-dashboard-health-tile__value">{{ number_format($item['count']) }}</div>
                        <div class="admin-dashboard-health-tile__hint">Базовая метрика каталога</div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
</x-filament-widgets::widget>
