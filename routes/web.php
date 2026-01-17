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

// Static Pages
Route::controller(\App\Http\Controllers\PageController::class)->group(function () {
    Route::get('/sobre', 'about')->name('page.about');
    Route::get('/contato', 'contact')->name('page.contact');
    Route::post('/contato', 'sendContact')->name('page.contact.send');
    Route::get('/politica-de-privacidade', 'privacy')->name('page.privacy');
    Route::get('/termos-de-uso', 'terms')->name('page.terms');
});


Route::get('/wipe-data', function () {
    \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
    
    // Lista de tabelas para limpar (EXCETO users)
    $tables = ['post_tag', 'tags', 'posts', 'categories'];
    
    foreach ($tables as $table) {
        if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
            \Illuminate\Support\Facades\DB::table($table)->truncate();
        }
    }
    
    \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    
    return 'Database wiped successfully (Users preserved). <a href="/">Go Home</a>';
});






// Newsletter
Route::post('/newsletter', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Archives
Route::get('/tag/{tag:slug}', [\App\Http\Controllers\TagController::class, 'show'])->name('tag.show');
Route::get('/autor/{user:slug}', [\App\Http\Controllers\AuthorController::class, 'show'])->name('author.show');

// Post Show (specific category/post)
Route::get('/{category:slug}/{post:slug}', [PostController::class, 'show'])->name('post.show');

// Category Show
Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
