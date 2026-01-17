<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'tavaresjorley@gmail.com'],
            [
                'name' => 'Jorley Tavares',
                'slug' => 'jorley-tavares',
                'password' => bcrypt('password'), // Should change in production
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Editors
        User::factory(5)->create(['role' => 'editor']);

        // 3. Create Categories
        $categories = [
            'Agricultura',
            'Pecuária',
            'Mundo Pet',
            'Economia',
            'Tecnologia',
            'Sustentabilidade',
        ];

        foreach ($categories as $catName) {
            Category::firstOrCreate(
                ['slug' => Str::slug($catName)],
                [
                    'name' => $catName,
                    'description' => "Tudo sobre $catName no agronegócio.",
                ]
            );
        }

        // 4. Create Tags
        $tags = Tag::factory(20)->create();

        // 5. Create Posts
        $allCategories = Category::all();
        $allUsers = User::all();

        // Featured Posts (Recent)
        Post::factory(5)->create()->each(function ($post) use ($allCategories, $allUsers, $tags) {
            $post->update([
                'category_id' => $allCategories->random()->id,
                'author_id' => $allUsers->random()->id,
                'published_at' => now()->subDays(rand(0, 7)), // Very recent
            ]);
            $post->tags()->attach($tags->random(3));
        });

        // Detailed Posts (Older)
        Post::factory(30)->create()->each(function ($post) use ($allCategories, $allUsers, $tags) {
            $post->update([
                'category_id' => $allCategories->random()->id,
                'author_id' => $allUsers->random()->id,
                'published_at' => now()->subDays(rand(8, 365)),
            ]);
            $post->tags()->attach($tags->random(rand(2, 5)));
        });
    }
}
