<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(string $categorySlug, string $slug): View
    {
        $post = Post::with(['author', 'category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Verify category match (Optional strictly, but good for SEO)
        if ($post->category->slug !== $categorySlug) {
            abort(404);
        }

        $relatedPosts = Post::with('category')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function incrementView(\Illuminate\Http\Request $request)
    {
        $request->validate(['post_id' => 'required|integer']);
        $post = Post::find($request->post_id);
        if ($post) {
            $post->increment('views');
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
