<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->withCount('images'))
            ->defaultSort('updated_at', 'desc')
            ->columns([
                ImageColumn::make('primaryImage.media_url')
                    ->label('Фото')
                    ->square(),
                TextColumn::make('images_count')
                    ->label('Фото')
                    ->badge()
                    ->sortable(),
                TextColumn::make('brand.name')
                    ->label('Бренд')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vehicleModel.name')
                    ->label('Модель')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Товар')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('oem')
                    ->label('OEM')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Цена')
                    ->formatStateUsing(fn ($state): ?string => $state === null ? null : number_format((int) $state, 0, '.', ' ') . ' ₽')
                    ->sortable(),
                TextColumn::make('price_label')
                    ->label('Текст цены')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('stock_status_label')
                    ->label('Статус')
                    ->badge(),
                TextColumn::make('stock')
                    ->label('Остаток')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Кол-во')
                    ->sortable(),
                TextColumn::make('set_condition_label')
                    ->label('Состояние')
                    ->badge(),
                TextColumn::make('year')
                    ->label('Год')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('diameter')
                    ->label('Диаметр')
                    ->searchable(),
                TextColumn::make('size')
                    ->label('Диаметр legacy')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('pcd')
                    ->label('PCD')
                    ->searchable(),
                TextColumn::make('dia')
                    ->label('DIA')
                    ->searchable(),
                TextColumn::make('style')
                    ->label('Стиль')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('color')
                    ->label('Цвет')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('fitment')
                    ->label('Подходит')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('specs')
                    ->label('Параметры legacy')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('meta_title')
                    ->label('SEO title')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('meta_description')
                    ->label('SEO description')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                IconColumn::make('active')
                    ->label('Активен')
                    ->boolean(),
                TextColumn::make('sort')
                    ->label('Сортировка')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Обновлен')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('brand_id')
                    ->label('Бренд')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('vehicle_model_id')
                    ->label('Модель')
                    ->relationship('vehicleModel', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('stock_status')
                    ->label('Статус наличия')
                    ->options([
                        'in_stock' => 'В наличии',
                        'reserved' => 'В резерве',
                        'sold' => 'Продано',
                        'on_request' => 'Под заказ',
                    ]),
                SelectFilter::make('set_condition')
                    ->label('Состояние')
                    ->options([
                        'new' => 'Новый',
                        'used_excellent' => 'Б/у, отличное',
                        'used_good' => 'Б/у, хорошее',
                        'refurbished' => 'После восстановления',
                    ]),
                SelectFilter::make('diameter')
                    ->label('Диаметр')
                    ->options(fn (): array => Product::query()
                        ->whereNotNull('diameter')
                        ->where('diameter', '!=', '')
                        ->distinct()
                        ->orderBy('diameter')
                        ->pluck('diameter', 'diameter')
                        ->all()),
                SelectFilter::make('year')
                    ->label('Год')
                    ->options(fn (): array => Product::query()
                        ->whereNotNull('year')
                        ->where('year', '!=', '')
                        ->distinct()
                        ->orderByDesc('year')
                        ->pluck('year', 'year')
                        ->all()),
                TernaryFilter::make('active')
                    ->label('Активен'),
                Filter::make('missing_images')
                    ->label('Без фото')
                    ->query(fn (Builder $query): Builder => $query->whereDoesntHave('images')),
                Filter::make('missing_price')
                    ->label('Без цены')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereNull('price')
                        ->where(fn (Builder $query): Builder => $query->whereNull('price_label')->orWhere('price_label', ''))),
                Filter::make('missing_oem')
                    ->label('Без OEM')
                    ->query(fn (Builder $query): Builder => $query->where(fn (Builder $query): Builder => $query
                        ->whereNull('oem')
                        ->orWhere('oem', ''))),
                Filter::make('missing_seo')
                    ->label('Без SEO title/description')
                    ->query(fn (Builder $query): Builder => $query->where(fn (Builder $query): Builder => $query
                        ->whereNull('meta_title')
                        ->orWhere('meta_title', '')
                        ->orWhereNull('meta_description')
                        ->orWhere('meta_description', ''))),
                Filter::make('missing_video')
                    ->label('Без видео')
                    ->query(fn (Builder $query): Builder => $query->where(fn (Builder $query): Builder => $query
                        ->where(fn (Builder $query): Builder => $query->whereNull('video_path')->orWhere('video_path', ''))
                        ->where(fn (Builder $query): Builder => $query->whereNull('video_url')->orWhere('video_url', '')))),
                Filter::make('has_video')
                    ->label('С видео')
                    ->query(fn (Builder $query): Builder => $query->where(fn (Builder $query): Builder => $query
                        ->where(fn (Builder $query): Builder => $query->whereNotNull('video_path')->where('video_path', '!=', ''))
                        ->orWhere(fn (Builder $query): Builder => $query->whereNotNull('video_url')->where('video_url', '!=', '')))),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
            ]);
    }
}
