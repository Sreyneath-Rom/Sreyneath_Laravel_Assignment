<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // example: "The Silent Forest"
            'author_id' => Author::factory(),     // automatically creates a new author if not provided
            'isbn' => $this->faker->unique()->isbn13(),
            'published_year' => $this->faker->year(),
            'genre' => $this->faker->word(),
            'summary' => $this->faker->paragraph(),
        ];
    }
}