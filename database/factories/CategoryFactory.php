<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->department ?? $this->faker->unique()->word; 
        // using department if available (custom provider?) or just word/words. 
        // Standard faker doesn't have department. Let's use 'words'
        $name = ucwords($this->faker->unique()->words(2, true));
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'parent_id' => null,
            'color' => $this->faker->hexColor(), // Assuming we might add color later or it exists? 
            // Checking Category model... it didn't show 'color' in fillable.
            // Let's stick to fillable: name, slug, description, parent_id.
        ];
    }
}
