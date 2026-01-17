<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'subtitle' => $this->faker->sentence(10),
            'content' => $this->faker->paragraphs(5, true),
            'meta_description' => $this->faker->text(160),
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'author_id' => User::factory(), // Auto-create user if not provided
            'featured_image' => null, // We can maybe use a placeholder service URL if desired, but null is safer for now.
        ];
    }

    /**
     * Indicate that the post is scheduled.
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'scheduled',
            'published_at' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
        ]);
    }

    /**
     * Indicate that the post is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
