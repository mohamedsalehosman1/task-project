<?php

namespace Modules\Services\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Services\Entities\Service;
use Modules\Support\Traits\ImageFakerTrait;
use Modules\Support\Traits\AttrLangTrait;


class ServicesTableSeeder extends Seeder
{
    use ImageFakerTrait, AttrLangTrait;


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runFaker($this->services());
    }

    private function runFaker($items, $model = null)
    {
        foreach ($items as $item) {
            // $image = data_get($item, 'image');

            if ($model) {
                $service = $model->subServices()->create([
                    'name:ar' => $item['name:ar'],
                    'name:en' => $item['name:en'],
                ]);
            } else {
                $service = Service::create([
                    'name:ar' => $item['name:ar'],
                    'name:en' => $item['name:en'],
                ]);
            }

            // if ($image) {
            //     $service->addMediaFromUrl($image)->toMediaCollection('images');
            // }else{
            //     $this->createImage($service);
            // }

            if (isset($item['sub_services'])) {
                $this->runFaker($item['sub_services'], $service);
            }
        }
    }

    private function services()
    {
        return [
            [
                'name:ar' => 'ملابس',
                'name:en' => 'Clothes',
                'sub_services' => [
                    [
                        'name:ar' => 'قمصان',
                        'name:en' => 'Shirts',
                        // "image" => asset('images/clothes/shirts.svg'),
                    ],
                    [
                        'name:ar' => 'بنطلونات',
                        'name:en' => 'Pants',
                        // "image" => asset('images/clothes/pants.svg'),
                    ],
                    [
                        'name:ar' => 'فساتين',
                        'name:en' => 'Dresses',
                        // "image" => asset('images/clothes/dresses.svg'),
                    ],
                    [
                        'name:ar' => 'معاطف',
                        'name:en' => 'Coats',
                        // "image" => asset('images/clothes/coats.svg'),
                    ],
                    [
                        'name:ar' => 'ملابس رياضية',
                        'name:en' => 'Sportswear',
                        // "image" => asset('images/clothes/sportswear.svg'),
                    ],
                    [
                        'name:ar' => 'ملابس داخلية',
                        'name:en' => 'Underwear',
                        // "image" => asset('images/clothes/underwear.svg'),
                    ],
                    [
                        'name:ar' => 'ملابس سهرة',
                        'name:en' => 'Evening Wear',
                        // "image" => asset('images/clothes/eveningwear.svg'),
                    ],
                    [
                        'name:ar' => 'ملابس سباحة',
                        'name:en' => 'Swimwear',
                        // "image" => asset('images/clothes/swimwear.svg'),
                    ],
                ],
            ],
            [
                'name:ar' => 'إكسسوارات',
                'name:en' => 'Accessories',
                'sub_services' => [
                    [
                        'name:ar' => 'حقائب',
                        'name:en' => 'Bags',
                        // "image" => asset('images/accessories/bags.svg'),
                    ],
                    [
                        'name:ar' => 'أحذية',
                        'name:en' => 'Shoes',
                        // "image" => asset('images/accessories/shoes.svg'),
                    ],
                    [
                        'name:ar' => 'قبعات',
                        'name:en' => 'Hats',
                        // "image" => asset('images/accessories/hats.svg'),
                    ],
                    [
                        'name:ar' => 'نظارات شمسية',
                        'name:en' => 'Sunglasses',
                        // "image" => asset('images/accessories/sunglasses.svg'),
                    ],
                    [
                        'name:ar' => 'أحزمة',
                        'name:en' => 'Belts',
                        // "image" => asset('images/accessories/belts.svg'),
                    ],
                    [
                        'name:ar' => 'مجوهرات',
                        'name:en' => 'Jewelry',
                        // "image" => asset('images/accessories/jewelry.svg'),
                    ],
                    [
                        'name:ar' => 'أوشحة',
                        'name:en' => 'Scarves',
                        // "image" => asset('images/accessories/scarves.svg'),
                    ],
                ],
            ],
        ];
    }
}
