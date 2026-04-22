<x-filament-widgets::widget>
    <section class="admin-dashboard-card admin-dashboard-card--funnel">
        <header class="admin-dashboard-card__header">
            <div class="admin-dashboard-card__header-copy">
                <span class="admin-dashboard-card__eyebrow">Pipeline</span>
                <div class="admin-dashboard-card__title-row">
                    <div>
                        <h3 class="admin-dashboard-card__title">Воронка лидов</h3>
                        <p class="admin-dashboard-card__subtitle">Статусы за выбранный период</p>
                    </div>

                    <span class="admin-dashboard-card__badge admin-dashboard-card__badge--amber">
                        {{ $periodLabel }}
                    </span>
                </div>
            </div>
        </header>

        <div class="admin-dashboard-funnel">
            @foreach ($steps as $step)
                <a
                    href="{{ $step['url'] }}"
                    @class([
                        'admin-dashboard-funnel-step',
                        'admin-dashboard-funnel-step--linked' => ! $loop->last,
                    ])
                    data-tone="{{ $step['status'] }}"
                >
                    <div class="admin-dashboard-funnel-step__meta">
                        <span class="admin-dashboard-funnel-step__index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="admin-dashboard-funnel-step__share">{{ $step['percentage'] }}%</span>
                    </div>

                    <div class="admin-dashboard-funnel-step__value">{{ number_format($step['count']) }}</div>
                    <div class="admin-dashboard-funnel-step__label">{{ $step['label'] }}</div>
                    <div class="admin-dashboard-funnel-step__caption">от первого шага</div>
                </a>
            @endforeach
        </div>

        <div class="admin-dashboard-callout admin-dashboard-callout--muted">
            <div>
                <div class="admin-dashboard-callout__label">Не дозвонились</div>
                <div class="admin-dashboard-callout__caption">Служебный показатель вне основной линейной воронки</div>
            </div>

            <a href="{{ $noAnswer['url'] }}" class="admin-dashboard-callout__value">
                {{ number_format($noAnswer['count']) }}
            </a>
        </div>
    </section>
</x-filament-widgets::widget>
