<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewLink extends ViewRecord
{
    protected static string $resource = LinkResource::class;

    public function getTitle(): string
    {
        return 'Статистика ссылки';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Удалить'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Информация о ссылке')
                    ->schema([
                        Infolists\Components\TextEntry::make('code')
                            ->label('Код'),
                        Infolists\Components\TextEntry::make('short_url')
                            ->label('Короткая ссылка')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('original_url')
                            ->label('Оригинальный URL')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('clicks_count')
                            ->label('Всего переходов')
                            ->state(fn ($record) => $record->clicks()->count()),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Создана')
                            ->dateTime('d.m.Y H:i')
                            ->timezone(fn () => auth()->user()->displayTimezone()),
                    ])
                    ->columns(2),
            ]);
    }
}
