<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Listar posts por autor
     */
    public function show(User $author)
    {
        // Se usar binding por slug, certifique-se de configurar getRouteKeyName no model
        // ou usar explicit binding no Provider.
        // Vou assumir que faremos binding explicito ou configuraremos no Model.
        
        $posts = $author->posts()
            ->published()
            ->with(['category'])
            ->latest('published_at')
            ->paginate(12);

        return view('posts.author', [
            'author' => $author,
            'posts' => $posts,
            'pageTitle' => $author->name . ' | InfoRagro',
            'canonical' => url('/autor/' . $author->slug),
        ]);
    }
}
