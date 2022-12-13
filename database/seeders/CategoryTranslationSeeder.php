<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class CategoryTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            if (! $category->category_name) {
                $name = $category->getRawOriginal('category_name');
                $category->setTranslation('category_name', 'en', $name)->save();
            }
        }

        $subCategories = SubCategory::all();
        foreach ($subCategories as $subCategory) {
            if (! $category->subcat_name) {
                $name = $subCategory->getRawOriginal('subcat_name');
                $subCategory->setTranslation('subcat_name', 'en', $name)->save();
            }
        }
    }
}
