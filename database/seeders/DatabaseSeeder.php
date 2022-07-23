<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "name" => "Programming",
            "slug" => "programming"
        ]);
        Category::create([
            "name" => "Travelling",
            "slug" => "travelling"
        ]);
        Category::create([
            "name" => "Culinary",
            "slug" => "culinary"
        ]);


        User::factory(10)->create();
        Blog::factory(10)->create();
    }
}
