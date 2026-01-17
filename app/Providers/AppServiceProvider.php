<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Torna as categorias disponíveis globalmente para o layout, sem sujar o Blade
        \Illuminate\Support\Facades\View::composer('components.layout', function ($view) {
            $view->with('globalCategories', \App\Models\Category::all());
        });
    }
}
