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
                ->description('Artigos publicados no blog')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total de Usuários', User::count())
                ->description('Membros cadastrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Categorias', Category::count())
                ->description('Tópicos ativos')
                ->descriptionIcon('heroicon-m-tag')
                ->color('warning'),
        ];
    }
}
