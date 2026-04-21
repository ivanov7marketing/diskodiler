<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\VehicleModel;
use App\Support\SeoSchema;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        return $this->catalog($request);
    }

    public function brand(Request $request, Brand $brand): View
    {
        abort_unless($brand->active, 404);

        return $this->catalog($request, $brand);
    }

    public function model(Request $request, Brand $brand, string $vehicleModel): View
    {
        abort_unless($brand->active, 404);

        $model = $brand->vehicleModels()->active()->where('slug', $vehicleModel)->firstOrFail();

        return $this->catalog($request, $brand, $model);
    }

    public function product(Product $product): View
    {
        abort_unless($product->active && $product->brand?->active && $product->vehicleModel?->active, 404);

        $product->loadMissing(['brand', 'vehicleModel', 'images']);

        $relatedProducts = Product::query()
            ->with(['brand', 'vehicleModel', 'primaryImage'])
            ->active()
            ->whereKeyNot($product->getKey())
            ->whereHas('brand', fn (Builder $query) => $query->active())
            ->whereHas('vehicleModel', fn (Builder $query) => $query->active())
            ->where(function (Builder $query) use ($product) {
                $query
                    ->whereBelongsTo($product->vehicleModel)
                    ->orWhereBelongsTo($product->brand);
            })
            ->orderByRaw('case when vehicle_model_id = ? then 0 else 1 end', [$product->vehicle_model_id])
            ->orderBy('sort')
            ->orderBy('title')
            ->limit(4)
            ->get();

        $productFaqItems = $this->productFaqItems($product);

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'productJsonLd' => $this->productJsonLd($product),
            'productBreadcrumbJsonLd' => $this->productBreadcrumbJsonLd($product),
            'productFaqItems' => $productFaqItems,
            'productFaqJsonLd' => SeoSchema::faqPage($productFaqItems),
        ]);
    }

    private function catalog(Request $request, ?Brand $brand = null, ?VehicleModel $vehicleModel = null): View
    {
        $filters = $request->only(['brand', 'model', 'year', 'size', 'style', 'color']);

        if ($brand) {
            $filters['brand'] = $brand->name;
        }

        if ($vehicleModel) {
            $filters['model'] = $vehicleModel->name;
        }

        $products = Product::query()
            ->with(['brand', 'vehicleModel', 'primaryImage'])
            ->active()
            ->whereHas('brand', fn (Builder $query) => $query->active())
            ->whereHas('vehicleModel', fn (Builder $query) => $query->active())
            ->when($brand, fn (Builder $query) => $query->whereBelongsTo($brand))
            ->when($vehicleModel, fn (Builder $query) => $query->whereBelongsTo($vehicleModel))
            ->when($filters['brand'] ?? null, function (Builder $query, string $value) use ($brand) {
                if ($brand) {
                    return;
                }

                $query->whereHas('brand', fn (Builder $brandQuery) => $brandQuery->where('name', $value));
            })
            ->when($filters['model'] ?? null, function (Builder $query, string $value) use ($vehicleModel) {
                if ($vehicleModel) {
                    return;
                }

                $query->whereHas('vehicleModel', fn (Builder $modelQuery) => $modelQuery->where('name', $value));
            })
            ->when($filters['year'] ?? null, fn (Builder $query, string $value) => $query->where('year', $value))
            ->when($filters['size'] ?? null, fn (Builder $query, string $value) => $query->where('size', $value))
            ->when($filters['style'] ?? null, fn (Builder $query, string $value) => $query->where('style', $value))
            ->when($filters['color'] ?? null, fn (Builder $query, string $value) => $query->where('color', $value))
            ->orderBy('sort')
            ->orderBy('title')
            ->get();

        $title = $vehicleModel?->meta_title
            ?? $brand?->meta_title
            ?? 'Оригинальные диски купить в Санкт-Петербурге | ДискоДилер';

        $description = $vehicleModel?->meta_description
            ?? $brand?->meta_description
            ?? 'Каталог оригинальных OEM дисков для BMW, Mercedes-Benz, Porsche, Range Rover и других марок: цена, наличие, подбор по VIN и доставка по России.';

        $h1 = $vehicleModel?->h1
            ?? $brand?->h1
            ?? 'Каталог оригинальных дисков';

        $pageModels = $brand
            ? $brand->vehicleModels()->active()->withCount(['products' => fn (Builder $query) => $query->active()])->get()
            : collect();

        $faqItems = $brand
            ? $this->faqItems($brand, $vehicleModel)
            : $this->catalogRootFaqItems();

        $brandSemantics = $brand
            ? $this->brandSemantics($brand, $vehicleModel)
            : null;

        $breadcrumbJsonLd = $this->breadcrumbJsonLd($brand, $vehicleModel);

        return view('catalog.index', [
            'brands' => Brand::active()->orderBy('sort')->orderBy('name')->get(),
            'vehicleModels' => VehicleModel::query()
                ->with('brand')
                ->active()
                ->whereHas('brand', fn (Builder $query) => $query->active())
                ->when($brand, fn (Builder $query) => $query->whereBelongsTo($brand))
                ->orderBy('sort')
                ->orderBy('name')
                ->get(),
            'years' => Product::active()->whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year'),
            'sizes' => Product::active()->whereNotNull('size')->distinct()->orderBy('size')->pluck('size'),
            'styles' => Product::active()->whereNotNull('style')->distinct()->orderBy('style')->pluck('style'),
            'colors' => Product::active()->whereNotNull('color')->distinct()->orderBy('color')->pluck('color'),
            'products' => $products,
            'filters' => $filters,
            'currentBrand' => $brand,
            'currentVehicleModel' => $vehicleModel,
            'pageTitle' => $title,
            'pageDescription' => $description,
            'pageH1' => $h1,
            'seoText' => $vehicleModel?->seo_text ?? $brand?->seo_text,
            'pageModels' => $pageModels,
            'faqItems' => $faqItems,
            'faqJsonLd' => SeoSchema::faqPage($faqItems),
            'brandSemantics' => $brandSemantics,
            'breadcrumbJsonLd' => $breadcrumbJsonLd,
            'canonicalUrl' => $vehicleModel
                ? url("/diski/{$brand->slug}/{$vehicleModel->slug}")
                : ($brand ? url("/diski/{$brand->slug}") : url('/diski')),
        ]);
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function catalogRootFaqItems(): array
    {
        return [
            [
                'question' => 'Как выбрать оригинальные диски без ошибки по посадке?',
                'answer' => 'Нужно сверить марку, кузов, год, диаметр, ширину, вылет, PCD, DIA и OEM-номер. Если есть сомнения, менеджер проверит комплект по VIN до оплаты.',
            ],
            [
                'question' => 'Можно ли купить комплект с доставкой по России?',
                'answer' => 'Да. Перед отправкой фиксируем состояние дисков на фото, согласуем транспортную компанию и аккуратно упаковываем каждый диск.',
            ],
            [
                'question' => 'Что делать, если нужного комплекта нет в каталоге?',
                'answer' => 'Оставьте заявку с VIN, маркой, моделью и желаемым диаметром. Мы проверим наличие, ближайшие поставки и предложим подходящие OEM-комплекты.',
            ],
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function faqItems(Brand $brand, ?VehicleModel $vehicleModel = null): array
    {
        $subject = $vehicleModel
            ? "{$brand->name} {$vehicleModel->name}"
            : $brand->name;

        return [
            [
                'question' => "Как проверить, что диски {$subject} оригинальные?",
                'answer' => 'Перед покупкой сверяем OEM-артикулы, маркировку на диске, посадочные параметры, фото состояния и совместимость по VIN. По запросу отправляем дополнительные фото и видео осмотра.',
            ],
            [
                'question' => "Можно ли подобрать диски {$subject} по VIN?",
                'answer' => 'Да. VIN помогает проверить допустимые диаметры, ширину, вылет, PCD, DIA и совместимость с комплектацией автомобиля до оплаты.',
            ],
            [
                'question' => 'Что делать, если подходящего комплекта нет в каталоге?',
                'answer' => 'Оставьте заявку с VIN и желаемым диаметром. Менеджер проверит дилерские склады, центральный склад и ближайшие поставки, а затем предложит варианты под ваш автомобиль.',
            ],
        ];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function productFaqItems(Product $product): array
    {
        $fitment = $product->fitment ?: "{$product->brand->name} {$product->vehicleModel->name}";
        $oem = $product->oem ?: 'маркировке на диске';

        return [
            [
                'question' => "Как проверить оригинальность комплекта {$product->title}?",
                'answer' => "Перед продажей сверяем OEM-номер {$oem}, заводскую маркировку, посадочные параметры и состояние комплекта. По запросу отправим дополнительные фото или видео осмотра.",
            ],
            [
                'question' => "Подойдет ли этот комплект для {$fitment}?",
                'answer' => 'Совместимость лучше проверить по VIN: менеджер сверит допустимый диаметр, ширину, вылет, PCD, DIA и комплектацию автомобиля до оплаты.',
            ],
            [
                'question' => 'Можно ли осмотреть или зарезервировать комплект?',
                'answer' => 'Да. Оставьте заявку на странице товара, и менеджер подтвердит наличие, состояние, условия резерва, самовывоза в Санкт-Петербурге или доставки по России.',
            ],
        ];
    }

    /**
     * @return array{queries: array<int, string>, factors: array<int, array{title: string, text: string}>, sizing: string}
     */
    private function brandSemantics(Brand $brand, ?VehicleModel $vehicleModel = null): array
    {
        $subject = $vehicleModel
            ? "{$brand->name} {$vehicleModel->name}"
            : $brand->name;

        $core = [
            'bmw' => [
                'queries' => ['оригинальные диски BMW', 'диски BMW R20', 'диски BMW G05', 'диски BMW G20', 'разноширокие диски BMW', 'диски BMW стиль 793'],
                'sizing' => 'Чаще всего подбираем для BMW размеры R17-R22, кузова G05, G20, G30, G01, F30, F10 и комплекты по заводским стилям.',
            ],
            'mercedes-benz' => [
                'queries' => ['диски Mercedes-Benz купить', 'диски Mercedes AMG', 'диски Mercedes GLE', 'диски Mercedes GLC', 'диски Mercedes R19', 'разноширокие диски Mercedes'],
                'sizing' => 'Подбираем комплекты для GLE, GLC, GLB, Sprinter, AMG, W212/W205/W124 и ходовые размеры R16-R21.',
            ],
            'porsche' => [
                'queries' => ['диски Porsche оригинал', 'диски Porsche Cayenne', 'диски Porsche Macan', 'диски Porsche Panamera', 'диски Porsche R22', 'разболтовка Porsche Cayenne'],
                'sizing' => 'Чаще всего проверяем комплекты для Cayenne, Macan, Panamera и 911: размеры R18-R22, разболтовку и оригинальные OEM-номера.',
            ],
            'range-rover' => [
                'queries' => ['диски Range Rover', 'диски Range Rover Sport', 'диски Range Rover Velar', 'диски Range Rover R22', 'диски Range Rover R23', 'параметры дисков Range Rover'],
                'sizing' => 'Для Range Rover часто подбираем диски на Sport, Evoque, Velar, Vogue, L322/L405/L460 и размеры R19-R23.',
            ],
            'rolls-royce' => [
                'queries' => ['диски Rolls-Royce', 'диски Rolls-Royce Cullinan', 'оригинальные диски Rolls-Royce', 'диски Rolls-Royce под заказ'],
                'sizing' => 'Подбираем редкие OEM-комплекты Rolls-Royce, в том числе для Cullinan, с проверкой происхождения и состояния.',
            ],
            'lamborghini' => [
                'queries' => ['диски Lamborghini', 'диски Lamborghini Urus', 'диски Lamborghini Gallardo', 'оригинальные диски Lamborghini'],
                'sizing' => 'Чаще всего ищем оригинальные комплекты Lamborghini для Urus и Gallardo с точной проверкой параметров по VIN.',
            ],
            'ram' => [
                'queries' => ['диски RAM', 'диски RAM 1500', 'диски RAM TRX', 'оригинальные диски RAM', 'диски RAM под заказ'],
                'sizing' => 'Подбираем диски RAM 1500 и TRX под заказ: сверяем VIN, посадочные параметры, нагрузку и сроки поставки.',
            ],
        ];

        $data = $core[$brand->slug] ?? [
            'queries' => ["оригинальные диски {$brand->name}", "диски {$brand->name} купить", "диски {$brand->name} по VIN"],
            'sizing' => "Подбираем размеры и параметры {$brand->name} по VIN и заводской спецификации.",
        ];

        if ($vehicleModel) {
            array_unshift($data['queries'], "диски {$subject}", "оригинальные диски {$subject}");
        }

        return [
            'queries' => array_slice(array_values(array_unique($data['queries'])), 0, 8),
            'sizing' => $data['sizing'],
            'factors' => [
                [
                    'title' => 'Цена и наличие',
                    'text' => "Показываем комплекты в каталоге, а если нужного размера {$subject} нет на странице, проверяем склад и поставку под заказ.",
                ],
                [
                    'title' => 'Санкт-Петербург и доставка',
                    'text' => 'Можно забрать комплект в Санкт-Петербурге, оформить шиномонтаж или заказать доставку по России транспортной компанией.',
                ],
                [
                    'title' => 'Подбор без ошибки',
                    'text' => 'Сверяем OEM-номер, ширину, вылет, PCD, DIA и допустимый диаметр по VIN до оплаты, чтобы комплект встал без проставок и сюрпризов.',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function breadcrumbJsonLd(?Brand $brand = null, ?VehicleModel $vehicleModel = null): array
    {
        $items = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Главная',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Диски',
                'item' => url('/diski'),
            ],
        ];

        if ($brand) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $brand->name,
                'item' => route('catalog.brand', $brand),
            ];
        }

        if ($brand && $vehicleModel) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => 4,
                'name' => $vehicleModel->name,
                'item' => route('catalog.model', [$brand, $vehicleModel->slug]),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function productJsonLd(Product $product): array
    {
        $offers = [
            '@type' => 'Offer',
            'url' => route('products.show', $product),
            'priceCurrency' => 'RUB',
            'availability' => $product->schema_availability,
            'itemCondition' => $product->schema_item_condition,
        ];

        if ($product->price !== null) {
            $offers['price'] = $product->price;
        }

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->title,
            'category' => 'Автомобильные диски',
            'description' => $product->seoDescription(),
            'sku' => $product->oem,
            'brand' => [
                '@type' => 'Brand',
                'name' => $product->brand->name,
            ],
            'model' => $product->vehicleModel->name,
            'image' => $product->images
                ->map(fn ($image) => $image->media_url)
                ->filter()
                ->values()
                ->all(),
            'additionalProperty' => $this->productAdditionalProperties($product),
            'offers' => $offers,
        ]);
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function productAdditionalProperties(Product $product): array
    {
        return collect([
            'OEM' => $product->oem,
            'Диаметр' => $product->diameter ?: $product->size,
            'Ширина перед' => $product->width_front,
            'Ширина зад' => $product->width_rear,
            'ET перед' => $product->et_front,
            'ET зад' => $product->et_rear,
            'PCD' => $product->pcd,
            'DIA' => $product->dia,
            'Совместимость' => $product->fitment,
            'Год' => $product->year,
            'Состояние' => $product->set_condition_label,
        ])
            ->filter(fn ($value) => filled($value))
            ->map(fn ($value, string $name) => [
                '@type' => 'PropertyValue',
                'name' => $name,
                'value' => (string) $value,
            ])
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function productBreadcrumbJsonLd(Product $product): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Главная',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Диски',
                    'item' => route('catalog.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $product->brand->name,
                    'item' => route('catalog.brand', $product->brand),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 4,
                    'name' => $product->vehicleModel->name,
                    'item' => route('catalog.model', [$product->brand, $product->vehicleModel->slug]),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 5,
                    'name' => $product->title,
                    'item' => route('products.show', $product),
                ],
            ],
        ];
    }
}
