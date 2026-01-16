<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// View Counter API (via Web for simplicity)
Route::post('/api/view', [PostController::class, 'incrementView'])->name('api.view');

// Search
Route::get('/buscar', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');

// Utility to fix storage link (Run once then remove)
Route::get('/fix-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Storage Linked!';
});

// Post Show (specific category/post)
Route::get('/{category:slug}/{post:slug}', [PostController::class, 'show'])->name('post.show');

// Category Show
Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
