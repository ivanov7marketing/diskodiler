<?php

namespace App\Support\AdminDashboard;

use App\Models\Lead;
use App\Models\Product;
use App\Support\LeadAttribution;
use Illuminate\Support\Facades\Cache;

class DashboardAnalytics
{
    public function leadPeriodStats(): array
    {
        return $this->remember('lead-period-stats', function (): array {
            return [
                'today' => $this->buildLeadPeriodStat('today', 'Лиды сегодня', 'С 00:00 по текущий момент'),
                '7' => $this->buildLeadPeriodStat('7', 'Лиды за 7 дней', 'Текущий день и 6 предыдущих'),
                '30' => $this->buildLeadPeriodStat('30', 'Лиды за 30 дней', 'Текущий день и 29 предыдущих'),
                'generated_at' => now()->toIso8601String(),
            ];
        });
    }

    public function leadFunnel(int $days = 30): array
    {
        $window = $this->resolveRollingWindow($days);

        return $this->remember("lead-funnel:{$window['key']}", function () use ($window): array {
            $counts = Lead::query()
                ->whereBetween('created_at', [$window['start'], $window['end']])
                ->selectRaw('status, COUNT(*) as aggregate_count')
                ->groupBy('status')
                ->pluck('aggregate_count', 'status');

            $newCount = (int) ($counts['new'] ?? 0);

            $steps = collect([
                'new' => ['label' => 'Новые', 'color' => 'amber'],
                'in_progress' => ['label' => 'В работе', 'color' => 'sky'],
                'contacted' => ['label' => 'Связались', 'color' => 'emerald'],
                'done' => ['label' => 'Закрыты', 'color' => 'gray'],
            ])->map(function (array $step, string $status) use ($counts, $newCount): array {
                $count = (int) ($counts[$status] ?? 0);

                return [
                    'status' => $status,
                    'label' => $step['label'],
                    'count' => $count,
                    'percentage' => $newCount > 0 ? (int) round(($count / $newCount) * 100) : 0,
                    'color' => $step['color'],
                ];
            })->values()->all();

            return [
                'period' => $window,
                'steps' => $steps,
                'no_answer' => (int) ($counts['no_answer'] ?? 0),
                'generated_at' => now()->toIso8601String(),
            ];
        });
    }

    public function leadSources(int $days = 30): array
    {
        $window = $this->resolveRollingWindow($days);

        return $this->remember("lead-sources:{$window['key']}", function () use ($window): array {
            $counts = Lead::query()
                ->whereBetween('created_at', [$window['start'], $window['end']])
                ->whereNotNull('traffic_channel')
                ->selectRaw('traffic_channel, COUNT(*) as aggregate_count')
                ->groupBy('traffic_channel')
                ->pluck('aggregate_count', 'traffic_channel');

            $total = (int) $counts->sum();

            $segments = collect([
                LeadAttribution::CHANNEL_SEO => ['label' => 'SEO', 'hex' => '#2563eb'],
                LeadAttribution::CHANNEL_DIRECT => ['label' => 'Прямой', 'hex' => '#14b8a6'],
                LeadAttribution::CHANNEL_YANDEX_DIRECT => ['label' => 'Директ', 'hex' => '#f59e0b'],
                LeadAttribution::CHANNEL_OTHER => ['label' => 'Другие', 'hex' => '#8b5cf6'],
            ])->map(function (array $segment, string $channel) use ($counts, $total): array {
                $count = (int) ($counts[$channel] ?? 0);

                return [
                    'channel' => $channel,
                    'label' => $segment['label'],
                    'count' => $count,
                    'share' => $total > 0 ? round(($count / $total) * 100, 1) : 0.0,
                    'hex' => $segment['hex'],
                ];
            })->values()->all();

            return [
                'period' => $window,
                'total' => $total,
                'segments' => $segments,
                'generated_at' => now()->toIso8601String(),
            ];
        });
    }

    public function topLeadPages(int $days = 30): array
    {
        $window = $this->resolveRollingWindow($days);

        return $this->remember("top-lead-pages:{$window['key']}", function () use ($window): array {
            $pages = Lead::query()
                ->whereBetween('created_at', [$window['start'], $window['end']])
                ->pluck('source_page');

            $total = $pages->count();

            $topPages = $pages
                ->map(fn (?string $sourcePage): string => LeadAttribution::normalizeSourcePage($sourcePage) ?? 'Не определено')
                ->countBy()
                ->sortDesc()
                ->take(7)
                ->map(function (int $count, string $path) use ($total): array {
                    return [
                        'path' => $path,
                        'count' => $count,
                        'share' => $total > 0 ? round(($count / $total) * 100, 1) : 0.0,
                    ];
                })
                ->values()
                ->all();

            return [
                'period' => $window,
                'total' => $total,
                'pages' => $topPages,
                'generated_at' => now()->toIso8601String(),
            ];
        });
    }

    public function catalogHealth(): array
    {
        return $this->remember('catalog-health', function (): array {
            $activeProducts = Product::query()->active();

            return [
                'total_products' => Product::query()->count(),
                'active_products' => (clone $activeProducts)->count(),
                'missing_images' => (clone $activeProducts)->whereDoesntHave('images')->count(),
                'missing_price' => (clone $activeProducts)
                    ->whereNull('price')
                    ->where(fn ($query) => $query->whereNull('price_label')->orWhere('price_label', ''))
                    ->count(),
                'missing_seo' => (clone $activeProducts)
                    ->where(fn ($query) => $query
                        ->whereNull('meta_title')
                        ->orWhere('meta_title', '')
                        ->orWhereNull('meta_description')
                        ->orWhere('meta_description', ''))
                    ->count(),
                'missing_video' => (clone $activeProducts)
                    ->where(fn ($query) => $query
                        ->where(fn ($query) => $query->whereNull('video_path')->orWhere('video_path', ''))
                        ->where(fn ($query) => $query->whereNull('video_url')->orWhere('video_url', '')))
                    ->count(),
                'generated_at' => now()->toIso8601String(),
            ];
        });
    }

    private function buildLeadPeriodStat(string $preset, string $label, string $description): array
    {
        $window = $this->resolvePresetWindow($preset);

        return [
            'key' => $preset,
            'label' => $label,
            'description' => $description,
            'count' => Lead::query()
                ->whereBetween('created_at', [$window['start'], $window['end']])
                ->count(),
        ];
    }

    private function resolvePresetWindow(string $preset): array
    {
        $now = now();

        return match ($preset) {
            'today' => [
                'key' => 'today',
                'days' => 1,
                'start' => $now->copy()->startOfDay(),
                'end' => $now,
                'label' => 'Сегодня',
            ],
            '7' => $this->resolveRollingWindow(7),
            default => $this->resolveRollingWindow(30),
        };
    }

    private function resolveRollingWindow(int $days): array
    {
        $now = now();

        return match ($days) {
            24 => [
                'key' => '24',
                'days' => 1,
                'start' => $now->copy()->subDay(),
                'end' => $now,
                'label' => '24 часа',
            ],
            7 => [
                'key' => '7',
                'days' => 7,
                'start' => $now->copy()->startOfDay()->subDays(6),
                'end' => $now,
                'label' => '7 дней',
            ],
            default => [
                'key' => '30',
                'days' => 30,
                'start' => $now->copy()->startOfDay()->subDays(29),
                'end' => $now,
                'label' => '30 дней',
            ],
        };
    }

    private function remember(string $suffix, callable $callback): mixed
    {
        return Cache::remember(
            "admin-dashboard:{$suffix}",
            now()->addMinutes(5),
            $callback,
        );
    }
}
