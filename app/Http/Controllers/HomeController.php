<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // 1. Featured/Hero Post (The very last published one)
        $heroPost = Post::with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->first();

        // 2. Featured Grid (Next 4 posts)
        $latestPosts = collect();
        if ($heroPost) {
            $latestPosts = Post::with(['category', 'author'])
                ->where('status', 'published')
                ->where('id', '!=', $heroPost->id)
                ->latest('published_at')
                ->take(4)
                ->get();
        }

        // 3. Category specific sections
        // We define key slugs we want to show on homepage. Adjust these based on actual DB slugs.
        // Assuming 'agricultura', 'pecuaria', 'mercado' exist. If not, they will be empty.
        $categorySections = Category::whereIn('slug', ['agricultura', 'pecuaria', 'tecnologia', 'mercado'])
            ->with(['posts' => function($query) use ($heroPost) {
                $query->where('status', 'published')
                      ->when($heroPost, function($q) use ($heroPost) {
                          $q->where('id', '!=', $heroPost->id);
                      })
                      ->latest('published_at')
                      ->take(3);
            }])
            ->get();

        // 4. Sidebar "Most Read" (simulated by random or latest for now as views might be low)
        // In the future use ->orderByDesc('views')
        $mostReadPosts = Post::where('status', 'published')
            ->latest('published_at') // Placeholder until views populate
            ->take(5)
            ->get();

        return view('home', compact('heroPost', 'latestPosts', 'categorySections', 'mostReadPosts'));
    }
}
