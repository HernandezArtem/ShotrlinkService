<?php

namespace App\Filament\Resources\LinkResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ClicksRelationManager extends RelationManager
{
    protected static string $relationship = 'clicks';

    protected static ?string $title = 'Переходы';

    protected static ?string $modelLabel = 'переход';

    protected static ?string $pluralModelLabel = 'переходы';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP-адрес')
                    ->searchable(),
                Tables\Columns\TextColumn::make('clicked_at')
                    ->label('Дата и время')
                    ->dateTime('d.m.Y H:i:s')
                    ->timezone(fn () => auth()->user()->displayTimezone())
                    ->sortable(),
            ])
            ->defaultSort('clicked_at', 'desc')
            ->filters([])
            ->headerActions([])
            ->actions([])
            ->bulkActions([])
            ->emptyStateHeading('Переходов пока нет')
            ->emptyStateDescription('Когда кто-то перейдёт по ссылке, переход появится здесь.');
    }
}
