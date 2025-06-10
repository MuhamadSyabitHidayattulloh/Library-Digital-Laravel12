<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin and default user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'role' => 'user',
        ]);

        // Create regular users
        User::factory(8)->create();

        // Create categories
        Category::factory(10)->create();

        // Create books with existing categories
        Book::factory(50)->create([
            'category_id' => fn() => Category::inRandomOrder()->first()->id
        ]);

        // Create borrows with existing users and books
        Borrow::factory(30)->create([
            'user_id' => fn() => User::where('role', 'user')->inRandomOrder()->first()->id,
            'book_id' => fn() => Book::inRandomOrder()->first()->id
        ]);
    }
}
