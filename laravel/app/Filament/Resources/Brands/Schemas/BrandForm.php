<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Название')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                TextInput::make('meta_title')
                    ->label('SEO title'),
                Textarea::make('meta_description')
                    ->label('SEO description')
                    ->columnSpanFull(),
                TextInput::make('h1')
                    ->label('H1'),
                Textarea::make('seo_text')
                    ->label('SEO текст')
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->label('Активен')
                    ->required(),
                TextInput::make('sort')
                    ->label('Сортировка')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
