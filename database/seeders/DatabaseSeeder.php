<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 categories first
        $categories = Category::factory(5)->create();

        // Create 5 authors, each with 3 books
        $authors = Author::factory()
            ->count(5)
            ->has(Book::factory()->count(3))
            ->create();

        // Attach categories to each book of each author
        foreach ($authors as $author) {
            foreach ($author->books as $book) {
                $book->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());
            }
        }

        // Create 10 standalone books and attach categories
        Book::factory(10)->create()->each(function ($book) use ($categories) {
            $book->categories()->attach($categories->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}