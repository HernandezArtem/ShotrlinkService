<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LinkResource;
use App\Models\Click;
use App\Models\Link;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LinksOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id();

        $linksCount = Link::where('user_id', $userId)->count();
        $clicksCount = Click::whereHas('link', fn ($q) => $q->where('user_id', $userId))->count();

        return [
            Stat::make('Мои ссылки', $linksCount)
                ->description('Всего создано')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->icon('heroicon-o-link')
                ->url(LinkResource::getUrl('index')),
            Stat::make('Переходы', $clicksCount)
                ->description('Всего кликов')
                ->icon('heroicon-o-cursor-arrow-rays'),
        ];
    }
}