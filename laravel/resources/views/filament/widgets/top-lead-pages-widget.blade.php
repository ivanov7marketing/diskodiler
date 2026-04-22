<x-filament-widgets::widget>
    <section class="admin-dashboard-card admin-dashboard-card--pages">
        <header class="admin-dashboard-card__header">
            <div class="admin-dashboard-card__header-copy">
                <span class="admin-dashboard-card__eyebrow">Performance</span>
                <div class="admin-dashboard-card__title-row">
                    <div>
                        <h3 class="admin-dashboard-card__title">Топ страниц по лидам</h3>
                        <p class="admin-dashboard-card__subtitle">Страницы, которые реально приводят заявки</p>
                    </div>

                    <span class="admin-dashboard-card__badge admin-dashboard-card__badge--emerald">
                        {{ $periodLabel }}
                    </span>
                </div>
            </div>
        </header>

        @if ($total > 0 && count($pages))
            <div class="admin-dashboard-ranking-list">
                @foreach ($pages as $page)
                    <a href="{{ $page['url'] }}" class="admin-dashboard-ranking-row" title="{{ $page['path'] }}">
                        <div class="admin-dashboard-ranking-row__top">
                            <div class="admin-dashboard-ranking-row__main">
                                <span class="admin-dashboard-ranking-row__rank">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                                <div class="admin-dashboard-ranking-row__copy">
                                    <div class="admin-dashboard-ranking-row__path">{{ $page['path'] }}</div>
                                    <div class="admin-dashboard-ranking-row__share">{{ number_format($page['share'], 1) }}% от всех лидов за период</div>
                                </div>
                            </div>

                            <div class="admin-dashboard-ranking-row__metrics">
                                <div class="admin-dashboard-ranking-row__value">{{ number_format($page['count']) }}</div>
                                <div class="admin-dashboard-ranking-row__caption">лидов</div>
                            </div>
                        </div>

                        <div class="admin-dashboard-progress">
                            <div class="admin-dashboard-progress__bar" style="width: min({{ $page['share'] }}, 100%)%"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="admin-dashboard-empty">
                Пока нет данных по страницам за выбранный период.
            </div>
        @endif
    </section>
</x-filament-widgets::widget>
