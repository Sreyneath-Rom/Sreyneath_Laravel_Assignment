<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 authors, each with 3 books
        Author::factory()
            ->count(5)
            ->has(Book::factory()->count(3)) // each author gets 3 books
            ->create();

        // Optionally, if you want to also create some books without author or extra books:
        // Book::factory()->count(5)->create();
    }
}