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
        \Illuminate\Database\Eloquent\Model::shouldBeStrict(!app()->isProduction());

        // Share categories with layout globally
        \Illuminate\Support\Facades\View::composer('components.layout', function ($view) {
            $categories = \Illuminate\Support\Facades\Schema::hasTable('categories') 
                ? \App\Models\Category::whereNull('parent_id')->get() 
                : collect();
            $view->with('globalCategories', $categories);
        });
    }
}
