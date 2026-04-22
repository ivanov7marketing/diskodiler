<?php

namespace App\Filament\Resources\Leads\Tables;

use App\Models\Lead;
use App\Support\LeadAttribution;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => Lead::STATUS_OPTIONS[$state] ?? $state ?? 'Новая')
                    ->color(fn (?string $state): string => Lead::statusColor($state))
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => Lead::TYPE_OPTIONS[$state] ?? $state ?? 'Заявка')
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->copyable()
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('contact_method')
                    ->label('Способ связи')
                    ->formatStateUsing(fn (?string $state): string => Lead::CONTACT_METHOD_OPTIONS[$state] ?? $state ?? 'Не указан')
                    ->badge()
                    ->color('info'),
                TextColumn::make('telegram')
                    ->label('Telegram')
                    ->copyable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('vin')
                    ->label('VIN')
                    ->copyable()
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('message')
                    ->label('Сообщение')
                    ->limit(48)
                    ->wrap()
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('source_page')
                    ->label('Страница')
                    ->copyable()
                    ->limit(42)
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('traffic_channel')
                    ->label('Канал')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => Lead::TRAFFIC_CHANNEL_OPTIONS[$state] ?? $state ?? 'Не определено')
                    ->color(fn (?string $state): string => Lead::trafficChannelColor($state))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('referer_host')
                    ->label('Referer host')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),
                TextColumn::make('referer_url')
                    ->label('Referer URL')
                    ->copyable()
                    ->limit(42)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('—'),
                TextColumn::make('manager_comment')
                    ->label('Заметка')
                    ->limit(42)
                    ->wrap()
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('goal')
                    ->label('Цель')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('handled_at')
                    ->label('Обработана')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Обновлена')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('created_window')
                    ->label('Период')
                    ->options([
                        'today' => 'Сегодня',
                        '24' => '24 часа',
                        '7' => '7 дней',
                        '30' => '30 дней',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $period = $data['value'] ?? null;

                        if ($period === 'today') {
                            return $query->whereBetween('created_at', [now()->startOfDay(), now()]);
                        }

                        if ($period === '24') {
                            return $query->whereBetween('created_at', [
                                now()->subDay(),
                                now(),
                            ]);
                        }

                        if (in_array($period, ['7', '30'], true)) {
                            $days = (int) $period;

                            return $query->whereBetween('created_at', [
                                now()->startOfDay()->subDays($days - 1),
                                now(),
                            ]);
                        }

                        return $query;
                    }),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(Lead::STATUS_OPTIONS),
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(Lead::TYPE_OPTIONS),
                SelectFilter::make('traffic_channel')
                    ->label('Канал')
                    ->options(Lead::TRAFFIC_CHANNEL_OPTIONS),
                SelectFilter::make('contact_method')
                    ->label('Способ связи')
                    ->options(Lead::CONTACT_METHOD_OPTIONS),
                Filter::make('source_page_path')
                    ->label('Страница')
                    ->schema([
                        TextInput::make('path')
                            ->label('Путь страницы')
                            ->placeholder('/services'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $rawPath = trim((string) ($data['path'] ?? ''));

                        if ($rawPath === '') {
                            return $query;
                        }

                        if ($rawPath === 'Не определено') {
                            return $query->where(fn (Builder $query): Builder => $query
                                ->whereNull('source_page')
                                ->orWhere('source_page', ''));
                        }

                        $path = LeadAttribution::normalizeSourcePage($rawPath);

                        if ($path === null) {
                            return $query;
                        }

                        return $query->where('source_page', $path);
                    }),
                Filter::make('source_page_path')
                    ->label('Страница')
                    ->schema([
                        TextInput::make('path')
                            ->label('Путь страницы')
                            ->placeholder('/services'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $rawPath = trim((string) ($data['path'] ?? ''));

                        if ($rawPath === '') {
                            return $query;
                        }

                        if ($rawPath === 'Не определено') {
                            return $query->where(fn (Builder $query): Builder => $query
                                ->whereNull('source_page')
                                ->orWhere('source_page', ''));
                        }

                        $path = LeadAttribution::normalizeSourcePage($rawPath);

                        if ($path === null) {
                            return $query;
                        }

                        return $query->where('source_page', $path);
                    }),
                Filter::make('created_at_range')
                    ->label('Дата создания')
                    ->schema([
                        DatePicker::make('created_from')
                            ->label('С'),
                        DatePicker::make('created_until')
                            ->label('По'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['created_from'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '>=', $date))
                        ->when($data['created_until'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '<=', $date))),
                Filter::make('new_only')
                    ->label('Новые')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'new')),
                Filter::make('in_progress_only')
                    ->label('В работе')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'in_progress')),
                Filter::make('missing_phone')
                    ->label('Без телефона')
                    ->query(fn (Builder $query): Builder => $query->where(fn (Builder $query): Builder => $query
                        ->whereNull('phone')
                        ->orWhere('phone', ''))),
                Filter::make('has_vin')
                    ->label('С VIN')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('vin')->where('vin', '!=', '')),
                Filter::make('unhandled')
                    ->label('Не обработаны')
                    ->query(fn (Builder $query): Builder => $query->whereNull('handled_at')),
            ])
            ->recordActions([
                Action::make('mark_in_progress')
                    ->label('В работу')
                    ->color('info')
                    ->action(fn (Lead $record): bool => $record->update([
                        'status' => 'in_progress',
                    ])),
                Action::make('mark_contacted')
                    ->label('Связались')
                    ->color('success')
                    ->action(fn (Lead $record): bool => $record->update([
                        'status' => 'contacted',
                        'handled_at' => now(),
                    ])),
                Action::make('mark_no_answer')
                    ->label('Не дозвонились')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Lead $record): bool => $record->update([
                        'status' => 'no_answer',
                        'handled_at' => now(),
                    ])),
                Action::make('mark_done')
                    ->label('Закрыть')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(fn (Lead $record): bool => $record->update([
                        'status' => 'done',
                        'handled_at' => now(),
                    ])),
                EditAction::make()
                    ->label('Открыть'),
            ])
            ->toolbarActions(self::bulkStatusActions());
    }

    private static function bulkStatusActions(): array
    {
        if (! extension_loaded('intl')) {
            return [];
        }

        return [
            BulkActionGroup::make([
                BulkAction::make('bulk_in_progress')
                    ->label('В работу')
                    ->color('info')
                    ->action(fn ($records) => $records->each(fn (Lead $record): bool => $record->update([
                        'status' => 'in_progress',
                    ]))),
                BulkAction::make('bulk_contacted')
                    ->label('Связались')
                    ->color('success')
                    ->action(fn ($records) => $records->each(fn (Lead $record): bool => $record->update([
                        'status' => 'contacted',
                        'handled_at' => now(),
                    ]))),
                BulkAction::make('bulk_no_answer')
                    ->label('Не дозвонились')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each(fn (Lead $record): bool => $record->update([
                        'status' => 'no_answer',
                        'handled_at' => now(),
                    ]))),
                BulkAction::make('bulk_done')
                    ->label('Закрыть')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each(fn (Lead $record): bool => $record->update([
                        'status' => 'done',
                        'handled_at' => now(),
                    ]))),
            ]),
        ];
    }
}
