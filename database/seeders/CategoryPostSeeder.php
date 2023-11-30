<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //set category for post

        $posts = Post::all();
        $categories = Category::get()->pluck('id');

        foreach($posts as $post){

            $categoryCount = random_int(2,$categories->count());
            $random_categories = array_rand($categories->toArray(),$categoryCount);


            $category_ids = array_map(function($category_index)use($categories){
                $category = $categories->toArray()[$category_index];
                return $category;

            },$random_categories);


            $post->categories()->saveMany(Category::whereIn('id',$category_ids)->get());

        }

    }
}
