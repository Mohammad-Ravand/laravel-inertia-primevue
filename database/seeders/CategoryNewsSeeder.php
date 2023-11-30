<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newses = News::all();
        $categories = Category::get()->pluck('id');

        foreach($newses as $news){

            $categoryCount = random_int(2,$categories->count());
            $random_categories = array_rand($categories->toArray(),$categoryCount);


            $category_ids = array_map(function($category_index)use($categories){
                $category = $categories->toArray()[$category_index];
                return $category;

            },$random_categories);


            $news->categories()->saveMany(Category::whereIn('id',$category_ids)->get());

        }
    }
}
