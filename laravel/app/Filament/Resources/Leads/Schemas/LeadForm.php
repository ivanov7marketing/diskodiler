<?php

namespace App\Filament\Resources\Leads\Schemas;

use App\Models\Lead;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Статус обработки')
                    ->description('Рабочее состояние заявки и заметка менеджера.')
                    ->schema([
                        Select::make('status')
                            ->label('Статус')
                            ->options(Lead::STATUS_OPTIONS)
                            ->required()
                            ->default('new'),
                        Select::make('contact_method')
                            ->label('Удобный способ связи')
                            ->options(Lead::CONTACT_METHOD_OPTIONS)
                            ->searchable(),
                        DateTimePicker::make('handled_at')
                            ->label('Дата обработки')
                            ->seconds(false),
                        Textarea::make('manager_comment')
                            ->label('Комментарий менеджера')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Контакт клиента')
                    ->description('Данные, по которым менеджер связывается с клиентом.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Имя'),
                        TextInput::make('phone')
                            ->label('Телефон')
                            ->tel(),
                        TextInput::make('telegram')
                            ->label('Telegram'),
                        TextInput::make('vin')
                            ->label('VIN'),
                        Textarea::make('message')
                            ->label('Сообщение')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Источник')
                    ->description('Откуда пришла заявка и какой сценарий ее отправил.')
                    ->schema([
                        Select::make('type')
                            ->label('Тип')
                            ->options(Lead::TYPE_OPTIONS)
                            ->required()
                            ->default('lead'),
                        TextInput::make('goal')
                            ->label('Цель'),
                        TextInput::make('source_page')
                            ->label('Страница')
                            ->columnSpanFull(),
                        Select::make('traffic_channel')
                            ->label('РљР°РЅР°Р»')
                            ->options(Lead::TRAFFIC_CHANNEL_OPTIONS),
                        TextInput::make('referer_host')
                            ->label('Referer host'),
                        TextInput::make('referer_url')
                            ->label('Referer URL')
                            ->columnSpanFull(),
                        DateTimePicker::make('created_at')
                            ->label('Дата создания')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Технические данные')
                    ->description('Полный payload формы и UTM для диагностики.')
                    ->schema([
                        KeyValue::make('utm')
                            ->label('UTM')
                            ->columnSpanFull(),
                        KeyValue::make('payload')
                            ->label('Payload')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),
            ]);
    }
}
