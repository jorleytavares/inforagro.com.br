<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')->get(); // Main categories

        $postsQuery = Post::with(['category', 'author'])
            ->where('status', 'published')
            ->orderByDesc('published_at');

        $featuredPosts = $postsQuery->clone()->take(3)->get();
        $latestPosts = $postsQuery->clone()->skip(3)->take(6)->get();

        return view('home', compact('categories', 'featuredPosts', 'latestPosts'));
    }
}
