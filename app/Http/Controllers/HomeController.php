<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')->take(6)->get(); // Main categories for "silos"

        $featuredPosts = Post::with(['category', 'author'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();
            
        // Latest posts (skip the featured ones)
        $latestPosts = Post::with(['category', 'author'])
            ->where('status', 'published')
            ->whereNotIn('id', $featuredPosts->pluck('id'))
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('home', compact('categories', 'featuredPosts', 'latestPosts'));
    }
}
