<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Listar posts por tag
     */
    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->published()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(12);

        return view('posts.tag', [
            'tag' => $tag,
            'posts' => $posts,
            'pageTitle' => 'Posts sobre ' . $tag->name . ' | InfoRagro',
            'canonical' => url('/tag/' . $tag->slug), // Assuming manual route handling or fixed prefix if not root
        ]);
    }
}
