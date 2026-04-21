<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class CatalogDemoSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'brand' => ['name' => 'BMW', 'slug' => 'bmw'],
                'model' => ['name' => 'X5 G05', 'slug' => 'x5-g05'],
                'product' => [
                    'slug' => '20-double-spoke-699-jet-black-oem-36118089896',
                    'title' => '20" Double Spoke 699 Jet Black',
                    'oem' => '36118089896',
                    'price' => 190000,
                    'price_label' => null,
                    'fitment' => 'BMW X5 G05',
                    'stock' => 'Осталось 2 шт.',
                    'stock_status' => 'in_stock',
                    'specs' => '5x112 • ET35 • DIA 66.6',
                    'year' => '2024',
                    'size' => 'R20',
                    'style' => 'Double Spoke',
                    'color' => 'Jet Black',
                    'description' => 'Оригинальный комплект BMW Group с проверкой маркировки и совместимости по VIN.',
                    'sort' => 10,
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1603386329225-868f9b1ee6c9?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80',
                ],
            ],
            [
                'brand' => ['name' => 'BMW', 'slug' => 'bmw'],
                'model' => ['name' => 'X3 G01', 'slug' => 'x3-g01'],
                'product' => [
                    'slug' => '19-y-spoke-898m-performance-oem-36118091508',
                    'title' => '19" Y-Spoke 898M Performance',
                    'oem' => '36118091508',
                    'price' => 269000,
                    'price_label' => null,
                    'fitment' => 'BMW X3 G01',
                    'stock' => 'Осталось 4 шт.',
                    'stock_status' => 'in_stock',
                    'specs' => '5x112 • ET32 • DIA 66.6',
                    'year' => '2023',
                    'size' => 'R19',
                    'style' => 'Y-Spoke',
                    'color' => 'Ferricgrey',
                    'description' => 'Оригинальные диски BMW для X3 G01 с дилерской проверкой состояния.',
                    'sort' => 20,
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1603386329225-868f9b1ee6c9?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1485291571150-772bcfc10da5?auto=format&fit=crop&w=900&q=80',
                ],
            ],
            [
                'brand' => ['name' => 'BMW', 'slug' => 'bmw'],
                'model' => ['name' => '3/4 G20', 'slug' => '3-4-g20'],
                'product' => [
                    'slug' => '19-style-793-individual-oem-36118089896',
                    'title' => '19" Style 793 Individual',
                    'oem' => '36118089896 / 36118089897',
                    'price' => 259000,
                    'price_label' => null,
                    'fitment' => 'BMW 3 / 4 G20 G22 G23',
                    'stock' => 'Осталось 2 шт.',
                    'stock_status' => 'in_stock',
                    'specs' => '5x112 • ET27/40 • DIA 66.6',
                    'year' => '2022',
                    'size' => 'R19',
                    'style' => 'Double Spoke',
                    'color' => 'Night Gold',
                    'description' => 'Оригинальный комплект BMW Group с проверкой маркировки, посадочных параметров и совместимости по VIN.',
                    'sort' => 30,
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1603386329225-868f9b1ee6c9?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=900&q=80',
                ],
            ],
            [
                'brand' => ['name' => 'Mercedes-Benz', 'slug' => 'mercedes-benz'],
                'model' => ['name' => 'GLE W167', 'slug' => 'gle-w167'],
                'product' => [
                    'slug' => '21-amg-v-spoke-bicolor-oem-a1674012700',
                    'title' => '21" AMG V-Spoke Bicolor',
                    'oem' => 'A1674012700',
                    'price' => null,
                    'price_label' => 'Цена по запросу',
                    'fitment' => 'Mercedes-Benz GLE W167',
                    'stock' => 'Осталось 1 комплект',
                    'stock_status' => 'in_stock',
                    'specs' => '5x112 • ET49 • DIA 66.6',
                    'year' => '2024',
                    'size' => 'R21',
                    'style' => 'V-Spoke',
                    'color' => 'Bicolor',
                    'description' => 'OEM-комплект AMG для Mercedes-Benz GLE W167 с подбором по VIN.',
                    'sort' => 40,
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1485291571150-772bcfc10da5?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1609521263047-f8f205293f24?auto=format&fit=crop&w=900&q=80',
                ],
            ],
            [
                'brand' => ['name' => 'Porsche', 'slug' => 'porsche'],
                'model' => ['name' => 'Cayenne', 'slug' => 'cayenne'],
                'product' => [
                    'slug' => '22-cayenne-rs-spyder-design-oem-9y0601025',
                    'title' => '22" Cayenne RS Spyder Design',
                    'oem' => '9Y0601025',
                    'price' => 330000,
                    'price_label' => null,
                    'fitment' => 'Porsche Cayenne',
                    'stock' => 'Осталось 2 шт.',
                    'stock_status' => 'in_stock',
                    'specs' => '5x130 • ET50 • DIA 71.6',
                    'year' => '2023',
                    'size' => 'R22',
                    'style' => 'Y-Spoke',
                    'color' => 'Jet Black',
                    'description' => 'Оригинальный комплект Porsche Cayenne с проверкой по маркировке и VIN.',
                    'sort' => 50,
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=900&q=80',
                ],
            ],
            [
                'brand' => ['name' => 'Range Rover', 'slug' => 'range-rover'],
                'model' => ['name' => 'Sport', 'slug' => 'sport'],
                'product' => [
                    'slug' => '23-range-rover-style-1075-oem-lr161547',
                    'title' => '23" Range Rover Style 1075',
                    'oem' => 'LR161547',
                    'price' => 310000,
                    'price_label' => null,
                    'fitment' => 'Range Rover Sport',
                    'stock' => 'Осталось 2 шт.',
                    'stock_status' => 'in_stock',
                    'specs' => '5x120 • ET47 • DIA 72.6',
                    'year' => '2024',
                    'size' => 'R23',
                    'style' => 'Double Spoke',
                    'color' => 'Bicolor',
                    'description' => 'Оригинальные диски Range Rover Sport с подтверждением OEM-партномера.',
                    'sort' => 60,
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=900&q=80',
                    'https://images.unsplash.com/photo-1609521263047-f8f205293f24?auto=format&fit=crop&w=900&q=80',
                ],
            ],
        ];

        foreach ($items as $item) {
            $brand = Brand::updateOrCreate(
                ['slug' => $item['brand']['slug']],
                $this->brandPayload($item['brand'])
            );

            $model = VehicleModel::updateOrCreate(
                ['brand_id' => $brand->id, 'slug' => $item['model']['slug']],
                $this->modelPayload($brand, $item['model'])
            );

            $product = Product::updateOrCreate(
                ['slug' => $item['product']['slug']],
                array_merge($item['product'], [
                    'brand_id' => $brand->id,
                    'vehicle_model_id' => $model->id,
                    'active' => true,
                ])
            );

            foreach ($item['images'] ?? [$item['image']] as $imageIndex => $imageUrl) {
                $product->images()->updateOrCreate(
                    ['sort' => ($imageIndex + 1) * 10],
                    [
                        'url' => $imageUrl,
                        'alt' => $item['product']['title'] . ($imageIndex === 0 ? '' : ' фото ' . ($imageIndex + 1)),
                        'is_primary' => $imageIndex === 0,
                    ]
                );
            }
        }

        foreach ([
            ['name' => 'Lamborghini', 'slug' => 'lamborghini'],
            ['name' => 'Rolls-Royce', 'slug' => 'rolls-royce'],
            ['name' => 'RAM', 'slug' => 'ram'],
        ] as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']],
                $this->brandPayload($brand)
            );
        }

        $this->seedStandaloneModels();
    }

    /**
     * @param array{name: string, slug: string} $brand
     * @return array<string, mixed>
     */
    private function brandPayload(array $brand): array
    {
        $seo = $this->brandSeo()[$brand['slug']] ?? [
            'title' => "Оригинальные диски {$brand['name']} | ДискоДилер",
            'description' => "Оригинальные OEM диски {$brand['name']} в Санкт-Петербурге: подбор по VIN, проверка параметров, цена и доставка по России.",
            'h1' => "Оригинальные диски {$brand['name']}",
            'text' => "Подбираем оригинальные комплекты {$brand['name']} по кузову, параметрам и VIN. Перед покупкой подтверждаем OEM-маркировку, посадочные параметры и совместимость.\n\nЕсли нужного комплекта нет в каталоге, проверим наличие на складах и предложим поставку под заказ с доставкой по России.",
            'sort' => 70,
        ];

        return [
            'name' => $brand['name'],
            'meta_title' => $seo['title'],
            'meta_description' => $seo['description'],
            'h1' => $seo['h1'],
            'seo_text' => $seo['text'],
            'active' => true,
            'sort' => $seo['sort'],
        ];
    }

    /**
     * @param array{name: string, slug: string} $model
     * @return array<string, mixed>
     */
    private function modelPayload(Brand $brand, array $model): array
    {
        return [
            'name' => $model['name'],
            'meta_title' => "Оригинальные диски {$brand->name} {$model['name']} купить | ДискоДилер",
            'meta_description' => "OEM диски {$brand->name} {$model['name']} в Санкт-Петербурге: цена, наличие, фото, проверка по VIN, парт-номерам и посадочным параметрам.",
            'h1' => "Оригинальные диски {$brand->name} {$model['name']}",
            'seo_text' => "На странице собраны комплекты для {$brand->name} {$model['name']} с OEM-номерами, размерами и фото. Проверяем совместимость по VIN, чтобы купить диски без ошибки по вылету, ширине, PCD и DIA.\n\nЕсли нужного варианта нет в выдаче, отправьте VIN и желаемый диаметр. Менеджер проверит дилерские склады, поставку под заказ и доставку по России.",
            'active' => true,
            'sort' => 10,
        ];
    }

    private function seedStandaloneModels(): void
    {
        foreach ([
            'bmw' => [
                ['name' => 'M3 / M4 G80 G82', 'slug' => 'm3-m4-g80-g82', 'sort' => 40],
            ],
        ] as $brandSlug => $models) {
            $brand = Brand::where('slug', $brandSlug)->first();

            if (! $brand) {
                continue;
            }

            foreach ($models as $model) {
                VehicleModel::updateOrCreate(
                    ['brand_id' => $brand->id, 'slug' => $model['slug']],
                    array_merge($this->modelPayload($brand, $model), [
                        'sort' => $model['sort'],
                    ])
                );
            }
        }
    }

    /**
     * @return array<string, array{title: string, description: string, h1: string, text: string, sort: int}>
     */
    private function brandSeo(): array
    {
        return [
            'bmw' => [
                'title' => 'Оригинальные диски BMW купить в СПб | ДискоДилер',
                'description' => 'Оригинальные диски BMW R17-R22 в Санкт-Петербурге: G05, G20, G30, G01, стиль 793. Цена, наличие, подбор по VIN и доставка по России.',
                'h1' => 'Оригинальные диски BMW',
                'text' => "Подбираем оригинальные диски BMW по VIN, кузову и заводскому стилю: G05, G20, G30, G01, F30, F10 и другие популярные поколения BMW. Проверяем OEM-номер, разноширокость, вылет, PCD и DIA перед оплатой.\n\nВ каталоге есть комплекты BMW R19-R20, а размеры R17-R22 и редкие заводские стили проверяем по складам и поставкам. Можно купить комплект в Санкт-Петербурге, заказать шиномонтаж или доставку по России.",
                'sort' => 10,
            ],
            'mercedes-benz' => [
                'title' => 'Оригинальные диски Mercedes-Benz купить | ДискоДилер',
                'description' => 'OEM диски Mercedes-Benz AMG, GLE, GLC, GLB, Sprinter в СПб: R16-R21, цена, наличие, проверка по VIN и доставка по России.',
                'h1' => 'Оригинальные диски Mercedes-Benz',
                'text' => "Подбираем оригинальные диски Mercedes-Benz и AMG по VIN, кузову и заводским параметрам. Часто работаем с GLE, GLC, GLB, Sprinter, W212, W205, W124 и разноширокими комплектами.\n\nПеред продажей сверяем парт-номер, ширину, вылет, PCD, DIA и допустимый диаметр R16-R21. Если нужного комплекта нет в каталоге, проверим поставку под заказ, цену и доставку по России.",
                'sort' => 20,
            ],
            'porsche' => [
                'title' => 'Оригинальные диски Porsche купить в СПб | ДискоДилер',
                'description' => 'Оригинальные диски Porsche Cayenne, Macan, Panamera и 911: R18-R22, цена, наличие, разболтовка, проверка OEM и подбор по VIN.',
                'h1' => 'Оригинальные диски Porsche',
                'text' => "Подбираем оригинальные диски Porsche для Cayenne, Macan, Panamera и 911: размеры R18-R22, разболтовку и совместимость по VIN. Для каждого комплекта проверяем OEM-маркировку и соответствие конкретной модели.\n\nМожно купить диски Porsche из наличия в Санкт-Петербурге или оставить заявку на поиск комплекта под заказ. Перед оплатой отправим фото, параметры и подтвердим совместимость без догадок.",
                'sort' => 30,
            ],
            'range-rover' => [
                'title' => 'Оригинальные диски Range Rover купить | ДискоДилер',
                'description' => 'OEM диски Range Rover Sport, Velar, Evoque, Vogue: R19-R23, параметры, цена, наличие, подбор по VIN и доставка по России.',
                'h1' => 'Оригинальные диски Range Rover',
                'text' => "Подбираем оригинальные диски Range Rover для Sport, Velar, Evoque, Vogue, L322, L405, L460 и других кузовов. Часто проверяем размеры R19-R23, посадочные параметры, черные комплекты и варианты в стиле Kahn/Overfinch.\n\nМы не заменяем проверку совместимости общими таблицами: сверяем VIN, OEM-номер, PCD, DIA, ширину и вылет. Если нужного размера нет в каталоге, проверим цену и ближайшую поставку.",
                'sort' => 40,
            ],
            'lamborghini' => [
                'title' => 'Оригинальные диски Lamborghini купить | ДискоДилер',
                'description' => 'Диски Lamborghini Urus и Gallardo: оригинальные OEM комплекты, подбор по VIN, проверка параметров, цена под заказ и доставка по России.',
                'h1' => 'Оригинальные диски Lamborghini',
                'text' => "Подбираем оригинальные диски Lamborghini для Urus, Gallardo и других моделей бренда. Для таких автомобилей важна точная проверка параметров, потому что ошибка по вылету или ширине быстро становится дорогой.\n\nПодберем комплект Lamborghini по VIN, проверим OEM-маркировку, состояние, цену и сроки поставки. Если комплекта нет в наличии, найдем вариант под заказ и организуем доставку по России.",
                'sort' => 50,
            ],
            'rolls-royce' => [
                'title' => 'Оригинальные диски Rolls-Royce купить | ДискоДилер',
                'description' => 'Диски Rolls-Royce и Cullinan: OEM комплекты под заказ, проверка оригинальности, подбор по VIN, цена и доставка по России.',
                'h1' => 'Оригинальные диски Rolls-Royce',
                'text' => "Подбираем оригинальные диски Rolls-Royce, включая редкие комплекты для Cullinan. Здесь особенно важны происхождение, состояние, OEM-номер и точная совместимость с конкретным автомобилем.\n\nПодберем диски Rolls-Royce по VIN, согласуем фото, параметры, цену и сроки поставки. Работаем с редкими комплектами аккуратно: без обещаний наличия, пока менеджер не подтвердит склад.",
                'sort' => 60,
            ],
            'ram' => [
                'title' => 'Оригинальные диски RAM купить под заказ | ДискоДилер',
                'description' => 'Диски RAM 1500 и TRX под заказ: подбор по VIN, проверка PCD, DIA, вылета и нагрузки, цена и доставка по России.',
                'h1' => 'Оригинальные диски RAM',
                'text' => "Подбираем оригинальные диски RAM 1500, TRX и другие комплекты под заказ. Не обещаем наличие заранее: сначала проверяем склад, параметры и возможность поставки.\n\nДля RAM особенно важны PCD, DIA, вылет, ширина и допустимая нагрузка. Подберем комплект по VIN, сверим параметры и предложим поставку с доставкой по России.",
                'sort' => 70,
            ],
        ];
    }
}
