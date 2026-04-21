<?php

namespace App\Filament\Resources\VehicleModels\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class VehicleModelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                TextColumn::make('brand.name')
                    ->label('Бренд')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                TextColumn::make('meta_title')
                    ->label('SEO title')
                    ->searchable(),
                TextColumn::make('h1')
                    ->label('H1')
                    ->searchable(),
                IconColumn::make('active')
                    ->label('Активна')
                    ->boolean(),
                TextColumn::make('sort')
                    ->label('Сортировка')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('brand_id')->label('Бренд')->relationship('brand', 'name'),
                TernaryFilter::make('active')->label('Активна'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
            ]);
    }
}
