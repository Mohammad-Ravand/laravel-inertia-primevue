<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\News;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategoryNewsSeeder;
use Database\Seeders\CategoryPostSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        User::factory(10)->create();

        Category::factory(10)->create();

        Post::factory(10)->create();

        // set some category to posts
        $this->call(CategoryPostSeeder::class);


        News::factory(10)->create();

        // set some category to news
        $this->call(CategoryNewsSeeder::class);


    }
}
