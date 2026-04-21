<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls = collect([
            $this->sitemapUrl(route('home'), now(), '1.0'),
            $this->sitemapUrl(route('catalog.index'), now(), '0.9'),
            $this->sitemapUrl(route('services.index'), now(), '0.8'),
            $this->sitemapUrl(route('services.premium-tire-fitting'), now(), '0.7'),
            $this->sitemapUrl(route('services.wheel-restoration'), now(), '0.7'),
            $this->sitemapUrl(route('services.vin-selection'), now(), '0.7'),
            $this->sitemapUrl(route('delivery'), now(), '0.5'),
            $this->sitemapUrl(route('warranty'), now(), '0.5'),
            $this->sitemapUrl(route('privacy'), now(), '0.2'),
            $this->sitemapUrl(route('about'), now(), '0.5'),
        ]);

        Brand::query()
            ->active()
            ->orderBy('sort')
            ->orderBy('name')
            ->get()
            ->each(fn (Brand $brand) => $urls->push($this->sitemapUrl(route('catalog.brand', $brand), $brand->updated_at, '0.8')));

        VehicleModel::query()
            ->with('brand')
            ->active()
            ->whereHas('brand', fn (Builder $query) => $query->active())
            ->orderBy('sort')
            ->orderBy('name')
            ->get()
            ->each(fn (VehicleModel $model) => $urls->push($this->sitemapUrl(route('catalog.model', [$model->brand, $model->slug]), $model->updated_at, '0.8')));

        Product::query()
            ->with(['brand', 'vehicleModel'])
            ->active()
            ->whereHas('brand', fn (Builder $query) => $query->active())
            ->whereHas('vehicleModel', fn (Builder $query) => $query->active())
            ->orderBy('sort')
            ->orderBy('title')
            ->get()
            ->each(fn (Product $product) => $urls->push($this->sitemapUrl(route('products.show', $product), $product->updated_at, '0.7')));

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        return response()
            ->view('seo.robots')
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * @return array{loc: string, lastmod: string, priority: string}
     */
    private function sitemapUrl(string $loc, ?Carbon $lastmod, string $priority): array
    {
        return [
            'loc' => $loc,
            'lastmod' => ($lastmod ?: now())->toDateString(),
            'priority' => $priority,
        ];
    }
}
