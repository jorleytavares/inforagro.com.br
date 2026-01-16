<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->input('q');
        
        $posts = Post::with(['category', 'author'])
            ->where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('subtitle', 'like', "%{$query}%");
            })
            ->orderByDesc('published_at')
            ->paginate(12);

        $posts->appends(['q' => $query]);

        return view('search.index', compact('posts', 'query'));
    }
}
