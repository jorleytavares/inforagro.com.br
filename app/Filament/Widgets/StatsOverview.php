<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total de Posts', Post::count())
                ->description('Artigos publicados')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart(
                    Post::selectRaw('DATE(created_at) as date, count(*) as count')
                        ->groupBy('date')
                        ->orderBy('date', 'desc')
                        ->limit(7)
                        ->pluck('count')
                        ->toArray()
                ),

            Stat::make('Posts Publicados', Post::where('status', 'published')->count())
                ->description('Visíveis no site')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Rascunhos', Post::where('status', 'draft')->count())
                ->description('Em edição')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('warning'),
        ];
    }
}
