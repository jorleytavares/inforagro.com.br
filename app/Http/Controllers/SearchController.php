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
        
        $posts = Post::query()
            ->when($query, function ($builder) use ($query) {
                $builder->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
            })
            ->published() // Ensure scope exists or use where status/published_at
            ->latest()
            ->paginate(12);

        if ($query) {
            \App\Models\SearchLog::create([
                'query' => $query,
                'results_count' => $posts->total(),
                'ip_address' => $request->ip(),
            ]);
        }

        return view('search.index', compact('posts', 'query'));
    }
}
