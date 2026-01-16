<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// View Counter API (via Web for simplicity)
Route::post('/api/view', [PostController::class, 'incrementView'])->name('api.view');

// Post Show (specific category/post)
Route::get('/{category:slug}/{post:slug}', [PostController::class, 'show'])->name('post.show');

// Category Show
Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
