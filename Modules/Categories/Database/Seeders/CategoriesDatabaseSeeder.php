<?php

namespace Modules\Categories\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Categories\Entities\Category;

class CategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'logo1' => [
                'name:en' => 'Category 1',
                'name:ar' => 'شريك 1',
            ],
            'logo2' => [
                'name:en' => 'Category 2',
                'name:ar' => 'شريك 2',
            ],
            'logo3' => [
                'name:en' => 'Category 3',
                'name:ar' => 'شريك 3',
            ],
            'logo4' => [
                'name:en' => 'Category 4',
                'name:ar' => 'شريك 4',
            ],
            'logo5' => [
                'name:en' => 'Category 5',
                'name:ar' => 'شريك 5',
            ],
            'logo6' => [
                'name:en' => 'Category 6',
                'name:ar' => 'شريك 6',
            ],
            'logo7' => [
                'name:en' => 'Category 7',
                'name:ar' => 'شريك 7',
            ]
        ];
        $rank = 0 ;
        foreach ($categories as $key => $category) {
            $category["rank"] = ++$rank;
            $category = Category::create($category);
            // add logo image
            $category->addMedia(__DIR__ . '/images/' . $key . '.png')
                ->preservingOriginal()
                ->toMediaCollection('images');
        }
    }
}
