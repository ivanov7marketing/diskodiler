<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основное')
                    ->description('Базовая карточка товара и привязка к посадочным страницам каталога.')
                    ->schema([
                        Toggle::make('active')
                            ->label('Активен')
                            ->required()
                            ->default(true),
                        TextInput::make('sort')
                            ->label('Сортировка')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Select::make('brand_id')
                            ->label('Бренд')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('vehicle_model_id')
                            ->label('Модель авто')
                            ->relationship('vehicleModel', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('title')
                            ->label('Название')
                            ->helperText('Например: 20" Double Spoke 699 Jet Black.')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->helperText('Не меняйте после публикации, чтобы не ломать URL товара.')
                            ->required(),
                        TextInput::make('fitment')
                            ->label('Подходит для')
                            ->placeholder('BMW X5 G05')
                            ->helperText('Короткая совместимость для карточки, SEO и менеджера.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Цена и наличие')
                    ->description('То, что менеджер должен быстро подтвердить перед заявкой.')
                    ->schema([
                        TextInput::make('price')
                            ->label('Цена')
                            ->numeric()
                            ->prefix('₽'),
                        TextInput::make('price_label')
                            ->label('Текст цены')
                            ->helperText('Если заполнено, публичная карточка покажет этот текст вместо числа.'),
                        Select::make('stock_status')
                            ->label('Статус наличия')
                            ->options([
                                'in_stock' => 'В наличии',
                                'reserved' => 'В резерве',
                                'sold' => 'Продано',
                                'on_request' => 'Под заказ',
                            ])
                            ->default('in_stock')
                            ->required(),
                        TextInput::make('stock')
                            ->label('Текст остатка')
                            ->placeholder('Осталось 2 шт.')
                            ->helperText('Показывается вместе со статусом наличия.'),
                        TextInput::make('quantity')
                            ->label('Кол-во')
                            ->numeric(),
                        Select::make('set_condition')
                            ->label('Состояние комплекта')
                            ->options([
                                'new' => 'Новый',
                                'used_excellent' => 'Б/у, отличное',
                                'used_good' => 'Б/у, хорошее',
                                'refurbished' => 'После восстановления',
                            ])
                            ->helperText('Важно для доверия на карточке товара.'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Параметры дисков')
                    ->description('Размеры и совместимость, которые покупатель сверяет перед заявкой.')
                    ->schema([
                        TextInput::make('diameter')
                            ->label('Диаметр')
                            ->placeholder('R20'),
                        TextInput::make('width_front')
                            ->label('Ширина перед')
                            ->placeholder('9J'),
                        TextInput::make('width_rear')
                            ->label('Ширина зад')
                            ->placeholder('10.5J'),
                        TextInput::make('et_front')
                            ->label('ET перед')
                            ->placeholder('35'),
                        TextInput::make('et_rear')
                            ->label('ET зад')
                            ->placeholder('40'),
                        TextInput::make('pcd')
                            ->label('PCD')
                            ->placeholder('5x112'),
                        TextInput::make('dia')
                            ->label('DIA')
                            ->placeholder('66.6'),
                        TextInput::make('year')
                            ->label('Год')
                            ->placeholder('2020'),
                        TextInput::make('oem')
                            ->label('OEM')
                            ->helperText('Номер нужен для проверки оригинальности и SEO.'),
                        TextInput::make('style')
                            ->label('Стиль'),
                        TextInput::make('color')
                            ->label('Цвет'),
                        TextInput::make('size')
                            ->label('Диаметр legacy')
                            ->helperText('Старое поле, заполняйте только если нет отдельного диаметра.'),
                        TextInput::make('specs')
                            ->label('Параметры legacy')
                            ->helperText('Старое поле для общей строки параметров.')
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->columnSpanFull(),

                Section::make('Медиа')
                    ->description('Фото, видео и запасные внешние URL. Фото лучше загружать квадратом 1:1.')
                    ->schema([
                        Repeater::make('images')
                            ->label('Изображения')
                            ->relationship()
                            ->schema([
                                FileUpload::make('path')
                                    ->label('Загрузить фото')
                                    ->disk(fn (): string => config('filesystems.product_media_disk', 'public'))
                                    ->directory('products/images')
                                    ->visibility('public')
                                    ->image()
                                    ->imageEditor()
                                    ->imageCropAspectRatio('1:1')
                                    ->imageEditorAspectRatios(['1:1'])
                                    ->maxSize(8192)
                                    ->helperText('Основной вариант: загрузка в S3/public disk. Кадрируйте фото в квадрат 1:1.')
                                    ->columnSpanFull(),
                                TextInput::make('url')
                                    ->label('Внешний URL')
                                    ->url()
                                    ->helperText('Запасной вариант, если файл не загружается в S3.')
                                    ->columnSpanFull(),
                                TextInput::make('alt')
                                    ->label('Alt')
                                    ->helperText('Обязателен: коротко опишите диск, бренд, модель и ракурс.')
                                    ->required(),
                                TextInput::make('sort')
                                    ->label('Сортировка')
                                    ->numeric()
                                    ->default(0),
                                Toggle::make('is_primary')
                                    ->label('Главное'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                        FileUpload::make('video_path')
                            ->label('Видео файл')
                            ->disk(fn (): string => config('filesystems.product_media_disk', 'public'))
                            ->directory('products/videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->maxSize(102400)
                            ->helperText('Если видео загружено, публичная карточка покажет его вместо внешнего URL.')
                            ->columnSpanFull(),
                        TextInput::make('video_url')
                            ->label('Внешний URL видео')
                            ->url()
                            ->columnSpanFull(),
                        FileUpload::make('video_poster_path')
                            ->label('Poster для видео')
                            ->disk(fn (): string => config('filesystems.product_media_disk', 'public'))
                            ->directory('products/video-posters')
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageEditorAspectRatios(['1:1'])
                            ->maxSize(8192),
                        TextInput::make('video_poster_url')
                            ->label('Внешний URL poster')
                            ->url(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->columnSpanFull(),

                Section::make('SEO и описание')
                    ->description('Текст должен помогать покупателю принять решение, а не повторять ключи.')
                    ->schema([
                        Textarea::make('description')
                            ->label('Описание')
                            ->rows(4)
                            ->helperText('Коротко: что за комплект, состояние, проверка, доставка.')
                            ->columnSpanFull(),
                        TextInput::make('h1')
                            ->label('H1')
                            ->helperText('Необязательно. Если пусто, используется название товара.')
                            ->columnSpanFull(),
                        TextInput::make('meta_title')
                            ->label('SEO title')
                            ->maxLength(70)
                            ->helperText('До 70 символов: название, бренд/модель, OEM при необходимости.')
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('SEO description')
                            ->maxLength(165)
                            ->rows(3)
                            ->helperText('До 165 символов: цена/наличие, проверка OEM/VIN, доставка.')
                            ->columnSpanFull(),
                        Textarea::make('seo_text')
                            ->label('SEO текст для карточки')
                            ->rows(6)
                            ->helperText('Пишите для покупателя: совместимость, состояние, проверка, как уточнить детали.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
