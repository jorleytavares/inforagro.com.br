<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()
            ->with(['author', 'category'])
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('categories.show', compact('category', 'posts'));
    }
}
