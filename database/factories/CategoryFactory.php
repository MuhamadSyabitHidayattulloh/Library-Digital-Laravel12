<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Fiction', 'Non-Fiction', 'Science', 'Technology',
                'History', 'Biography', 'Literature', 'Psychology',
                'Business', 'Self-Help', 'Romance', 'Mystery'
            ])
        ];
    }
}
