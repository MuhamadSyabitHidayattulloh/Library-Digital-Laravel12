<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowFactory extends Factory
{
    public function definition(): array
    {
        $borrowDate = fake()->dateTimeBetween('-2 months', 'now');
        $returnDate = fake()->dateTimeBetween($borrowDate, '+2 weeks');
        $status = fake()->randomElement(['pending', 'borrowed', 'returned', 'overdue']);

        return [
            'user_id' => \App\Models\User::factory(),
            'book_id' => \App\Models\Book::factory(),
            'borrow_date' => $borrowDate,
            'return_date' => $returnDate,
            'actual_return_date' => $status === 'returned' ? fake()->dateTimeBetween($borrowDate, 'now') : null,
            'approved_at' => in_array($status, ['borrowed', 'returned', 'overdue']) ? fake()->dateTimeBetween($borrowDate, 'now') : null,
            'status' => $status,
            'notes' => fake()->optional()->sentence()
        ];
    }
}
