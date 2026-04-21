<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $brandCards = [
            'bmw' => [
                'models' => 'X5 G05, X3 G01, M-серия',
                'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800&q=80',
            ],
            'mercedes-benz' => [
                'models' => 'GLE, GLS, E, S, AMG',
                'image' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=800&q=80',
            ],
            'porsche' => [
                'models' => 'Cayenne, Macan, Panamera',
                'image' => 'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=800&q=80',
            ],
            'range-rover' => [
                'models' => 'Sport, Vogue, Velar',
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=800&q=80',
            ],
            'lamborghini' => [
                'models' => 'Urus OEM',
                'image' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=800&q=80',
            ],
            'rolls-royce' => [
                'models' => 'Cullinan, Ghost, Phantom',
                'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=800&q=80',
            ],
            'ram' => [
                'models' => '1500, TRX, Limited',
                'image' => 'https://images.unsplash.com/photo-1609521263047-f8f205293f24?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        $brands = Brand::active()
            ->orderBy('sort')
            ->orderBy('name')
            ->get()
            ->map(function (Brand $brand) use ($brandCards) {
                return [
                    'brand' => $brand,
                    'models' => $brandCards[$brand->slug]['models'] ?? 'OEM комплекты под заказ',
                    'image' => $brandCards[$brand->slug]['image'] ?? 'https://images.unsplash.com/photo-1485291571150-772bcfc10da5?auto=format&fit=crop&w=800&q=80',
                ];
            });

        $popularModelCards = $this->popularModelCards();

        return view('pages.home', [
            'brandCards' => $brands,
            'popularModelCards' => $popularModelCards,
        ]);
    }

    private function popularModelCards(): array
    {
        $cards = [
            ['brand' => 'bmw', 'model' => 'x5-g05', 'code' => 'G05', 'title' => 'BMW X5', 'text' => 'R19-R22, M Performance'],
            ['brand' => 'bmw', 'model' => 'x3-g01', 'code' => 'G01', 'title' => 'BMW X3', 'text' => 'R18-R21, Y-Spoke'],
            ['brand' => 'bmw', 'model' => '3-4-g20', 'code' => 'G20', 'title' => 'BMW 3 / 4', 'text' => 'Style 793 Individual'],
            ['brand' => 'bmw', 'model' => 'm3-m4-g80-g82', 'code' => 'G80', 'title' => 'BMW M3 / M4', 'text' => 'Double Spoke 829M'],
            ['brand' => 'porsche', 'model' => 'cayenne', 'code' => '9Y0', 'title' => 'Porsche Cayenne', 'text' => 'RS Spyder Design'],
            ['brand' => 'mercedes-benz', 'model' => 'gle-w167', 'code' => 'W167', 'title' => 'Mercedes GLE', 'text' => 'AMG, Bicolor'],
            ['brand' => 'range-rover', 'model' => 'sport', 'code' => 'L461', 'title' => 'Range Rover Sport', 'text' => 'R22-R23 upgrades'],
        ];

        $models = VehicleModel::query()
            ->with('brand')
            ->active()
            ->whereHas('brand', fn ($query) => $query->active())
            ->whereIn('slug', collect($cards)->pluck('model'))
            ->get()
            ->keyBy(fn (VehicleModel $model) => "{$model->brand->slug}:{$model->slug}");

        return collect($cards)
            ->map(function (array $card) use ($models) {
                $model = $models->get("{$card['brand']}:{$card['model']}");

                if (! $model) {
                    return null;
                }

                return [
                    'model' => $model,
                    'code' => $card['code'],
                    'title' => $card['title'],
                    'text' => $card['text'],
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
