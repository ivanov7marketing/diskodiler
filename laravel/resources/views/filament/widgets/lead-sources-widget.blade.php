<x-filament-widgets::widget>
    <section class="admin-dashboard-card admin-dashboard-card--sources">
        <header class="admin-dashboard-card__header">
            <div class="admin-dashboard-card__header-copy">
                <span class="admin-dashboard-card__eyebrow">Attribution</span>
                <div class="admin-dashboard-card__title-row">
                    <div>
                        <h3 class="admin-dashboard-card__title">Источники лидов</h3>
                        <p class="admin-dashboard-card__subtitle">Каналы для лидов с новой атрибуцией</p>
                    </div>

                    <span class="admin-dashboard-card__badge admin-dashboard-card__badge--sky">
                        {{ $periodLabel }}
                    </span>
                </div>
            </div>
        </header>

        @if ($total > 0)
            <div class="admin-dashboard-sources-layout">
                <div class="admin-dashboard-donut-shell">
                    <div class="admin-dashboard-donut" style="{{ $donutStyle }}">
                        <div class="admin-dashboard-donut__center">
                            <div class="admin-dashboard-donut__value">{{ number_format($total) }}</div>
                            <div class="admin-dashboard-donut__label">лидов</div>
                        </div>
                    </div>
                </div>

                <div class="admin-dashboard-source-list">
                    @foreach ($segments as $segment)
                        @php($isActive = $segment['count'] > 0)

                        @if ($isActive)
                            <a href="{{ $segment['url'] }}" class="admin-dashboard-source-row">
                                <div class="admin-dashboard-source-row__main">
                                    <span class="admin-dashboard-source-row__rank">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="admin-dashboard-source-row__swatch" style="background-color: {{ $segment['hex'] }}"></span>

                                    <div class="admin-dashboard-source-row__copy">
                                        <span class="admin-dashboard-source-row__label">{{ $segment['label'] }}</span>
                                        <span class="admin-dashboard-source-row__hint">Доля в текущем окне аналитики</span>
                                    </div>
                                </div>

                                <div class="admin-dashboard-source-row__metrics">
                                    <div class="admin-dashboard-source-row__value">{{ number_format($segment['count']) }}</div>
                                    <div class="admin-dashboard-source-row__share">{{ number_format($segment['share'], 1) }}%</div>
                                </div>
                            </a>
                        @else
                            <div class="admin-dashboard-source-row admin-dashboard-source-row--muted">
                                <div class="admin-dashboard-source-row__main">
                                    <span class="admin-dashboard-source-row__rank">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="admin-dashboard-source-row__swatch" style="background-color: {{ $segment['hex'] }}"></span>

                                    <div class="admin-dashboard-source-row__copy">
                                        <span class="admin-dashboard-source-row__label">{{ $segment['label'] }}</span>
                                        <span class="admin-dashboard-source-row__hint">Пока без лидов в выбранном периоде</span>
                                    </div>
                                </div>

                                <div class="admin-dashboard-source-row__metrics">
                                    <div class="admin-dashboard-source-row__value">0</div>
                                    <div class="admin-dashboard-source-row__share">0.0%</div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <div class="admin-dashboard-empty">
                Пока нет классифицированных данных. Полная атрибуция начнет заполняться после публикации обновленной формы лидов.
            </div>
        @endif
    </section>
</x-filament-widgets::widget>
