<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\RelationManagers\ClicksRelationManager;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Мои ссылки';

    protected static ?string $modelLabel = 'Ссылка';

    protected static ?string $pluralModelLabel = 'Ссылки';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->withCount('clicks');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_url')
                    ->label('Оригинальный URL')
                    ->url()
                    ->required()
                    ->maxLength(2048)
                    ->placeholder('https://example.com/page')
                    ->helperText('Укажите полный URL с http:// или https://')
                    ->validationMessages([
                        'required' => 'Укажите URL, который нужно сократить.',
                        'url' => 'Введите корректный URL, например: https://example.com/page',
                        'max' => 'URL слишком длинный (максимум :max символов).',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Код')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Код скопирован'),
                Tables\Columns\TextColumn::make('short_url')
                    ->label('Короткая ссылка')
                    ->copyable()
                    ->copyMessage('Ссылка скопирована'),
                Tables\Columns\TextColumn::make('original_url')
                    ->label('Оригинал')
                    ->limit(50)
                    ->tooltip(fn (Link $record): string => $record->original_url)
                    ->searchable(),
                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Переходов')
                    ->counts('clicks')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m.Y H:i')
                    ->timezone(fn () => auth()->user()->displayTimezone())
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Статистика'),
                Tables\Actions\DeleteAction::make()->label('Удалить'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Удалить выбранные'),
                ]),
            ])
            ->emptyStateHeading('У вас пока нет ссылок')
            ->emptyStateDescription('Создайте первую короткую ссылку.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label('Создать ссылку'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ClicksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'view' => Pages\ViewLink::route('/{record}'),
        ];
    }

}
