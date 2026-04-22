<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->text('referer_url')->nullable()->after('source_page');
            $table->string('referer_host')->nullable()->after('referer_url');
            $table->string('traffic_channel')->nullable()->after('referer_host');

            $table->index('created_at', 'leads_created_at_dashboard_index');
            $table->index('status', 'leads_status_dashboard_index');
            $table->index('traffic_channel', 'leads_traffic_channel_dashboard_index');
        });

        DB::table('leads')
            ->select(['id', 'source_page'])
            ->orderBy('id')
            ->chunkById(100, function ($leads): void {
                foreach ($leads as $lead) {
                    $normalizedSourcePage = $this->normalizeSourcePage($lead->source_page);

                    if ($normalizedSourcePage === $lead->source_page) {
                        continue;
                    }

                    DB::table('leads')
                        ->where('id', $lead->id)
                        ->update(['source_page' => $normalizedSourcePage]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex('leads_created_at_dashboard_index');
            $table->dropIndex('leads_status_dashboard_index');
            $table->dropIndex('leads_traffic_channel_dashboard_index');

            $table->dropColumn([
                'referer_url',
                'referer_host',
                'traffic_channel',
            ]);
        });
    }

    private function normalizeSourcePage(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if ($this->looksLikeUrl($value)) {
            $path = parse_url($this->qualifyUrl($value), PHP_URL_PATH);

            if (($path === false) || ($path === null) || ($path === '')) {
                return '/';
            }

            $value = $path;
        } else {
            $value = strtok($value, '?#') ?: '/';
        }

        if (! str_starts_with($value, '/')) {
            $value = '/' . $value;
        }

        $value = preg_replace('#/+#', '/', $value) ?: $value;

        if ($value !== '/') {
            $value = rtrim($value, '/');
        }

        return $value === '' ? '/' : $value;
    }

    private function looksLikeUrl(string $value): bool
    {
        if (str_starts_with($value, '//')) {
            return true;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:\/\//i', $value) === 1) {
            return true;
        }

        return preg_match('/^[^\/\s]+\.[^\/\s]+(?:\/.*)?$/', $value) === 1;
    }

    private function qualifyUrl(string $value): string
    {
        if (str_starts_with($value, '//')) {
            return 'https:' . $value;
        }

        if (preg_match('/^[a-z][a-z0-9+.-]*:\/\//i', $value) === 1) {
            return $value;
        }

        return 'https://' . $value;
    }
};
