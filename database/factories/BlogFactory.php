<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $blog = Blog::all();
        return [
            "title" => $this->faker->sentence(3),
            "slug" => $this->faker->slug(),
            "body" => $this->faker->paragraph(),
            "excerpt" => "Lorem ipsum...",
            "author_id" => mt_rand(1, 20),
            "category_id" => mt_rand(1, 3),
            "tags" => ['Programming', 'Java', 'Informatika', 'Coding']
        ];
    }
}
