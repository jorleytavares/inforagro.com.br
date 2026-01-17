<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/api/view', [PostController::class, 'incrementView'])
    ->middleware('throttle:60,1')
    ->name('api.view');

Route::get('/buscar', [\App\Http\Controllers\SearchController::class, 'index'])
    ->middleware('throttle:30,1')
    ->name('search');

// Static Pages
Route::controller(\App\Http\Controllers\PageController::class)->group(function () {
    Route::get('/sobre', 'about')->name('page.about');
    Route::get('/contato', 'contact')->name('page.contact');
    Route::post('/contato', 'sendContact')
        ->middleware('throttle:5,1')
        ->name('page.contact.send');
    Route::get('/politica-de-privacidade', 'privacy')->name('page.privacy');
    Route::get('/termos-de-uso', 'terms')->name('page.terms');
});


if (app()->environment('local')) {
    Route::get('/wipe-data', function () {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        $tables = ['post_tag', 'tags', 'posts', 'categories'];

        foreach ($tables as $table) {
            if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
                \Illuminate\Support\Facades\DB::table($table)->truncate();
            }
        }

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        return 'Database wiped successfully (Users preserved). <a href="/">Go Home</a>';
    });
}

Route::get('/fix-admin-access', function () {
    $email = 'tavaresjorley@gmail.com';
    $password = 'password';

    $user = \App\Models\User::withTrashed()->where('email', $email)->first();

    if ($user) {
        if ($user->trashed()) {
            $user->restore();
        }
        $user->password = \Illuminate\Support\Facades\Hash::make($password);
        $user->role = 'admin';
        $user->save();
        return "Usuário $email restaurado com sucesso! Senha redefinida para: $password. <a href='/admin/login'>Fazer Login</a>";
    }

    \App\Models\User::create([
        'name' => 'Jorley Tavares',
        'email' => $email,
        'password' => \Illuminate\Support\Facades\Hash::make($password),
        'role' => 'admin',
        'slug' => 'jorley-tavares-' . uniqid(), 
    ]);

    return "Usuário Admin criado com sucesso! Email: $email / Senha: $password. <a href='/admin/login'>Fazer Login</a>";
});






Route::post('/newsletter', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])
    ->middleware('throttle:10,1')
    ->name('newsletter.subscribe');

// Archives
Route::get('/tag/{tag:slug}', [\App\Http\Controllers\TagController::class, 'show'])->name('tag.show');
Route::get('/autor/{user:slug}', [\App\Http\Controllers\AuthorController::class, 'show'])->name('author.show');

// Post Show (specific category/post)
Route::get('/{category:slug}/{post:slug}', [PostController::class, 'show'])->name('post.show');

// Category Show
Route::get('/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
