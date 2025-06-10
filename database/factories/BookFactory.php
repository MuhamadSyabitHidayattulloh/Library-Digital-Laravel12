<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'publication_year' => fake()->year(),
            'description' => fake()->paragraph(),
            'isbn' => fake()->isbn13(),
            'stock' => fake()->numberBetween(1, 20),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
