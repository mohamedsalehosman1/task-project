<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Colors\Entities\Color;
use Modules\Products\Entities\Product;
use Modules\Services\Entities\Service;
use Modules\Sizes\Entities\Size;
use Modules\Support\Traits\AttrLangTrait;
use Modules\Support\Traits\ImageFakerTrait;
use Modules\Vendors\Entities\Vendor;

class ProductsTableSeeder extends Seeder
{
    use ImageFakerTrait, AttrLangTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Vendor::get() as $vendor) {

            for ($i = 0; $i < 10; $i++) {

                $product = Product::create([
                    ...$this->getAttribute("name", "lastName"),
                    ...$this->getAttribute("description", "text", true),
                    'vendor_id' => $vendor->id,
                    'service_id' => Service::childService()->inRandomOrder()->first()->id,
                    'old_price' => rand(100, 200),
                    'price' => rand(0, 100),
                    'is_recommended' => rand(0, 1),
                    'count_of_sold' => rand(0, 50),
                    'made_in' => "Egypt",
                ]);


                for ($k = 0; $k < 5; $k++) {
                    $product->materials()->create([
                        'material' => "Material " . $k,
                    ]);
                }


                $this->createImage($product, "images/fakers", 5, "images");
                $this->createImage($product, "images/fakers", 1, "covers");

                for ($j = 0; $j < 15; $j++) {
                    $product->productVariances()->updateOrCreate(
                        [
                            'size_id' => Size::inRandomOrder()->first()->id,
                            'color_id' => Color::inRandomOrder()->first()->id,
                        ],
                        [
                            'quantity' => rand(0, 100),
                        ]
                    );
                }
            }
        }
    }
}
