<?php

namespace Modules\Advertisements\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Advertisements\Entities\Advertisement;
use Faker\Factory as Faker;
use Modules\Support\Traits\AttrLangTrait;
use Modules\Support\Traits\ImageFakerTrait;
use Modules\Vendors\Entities\Vendor;

class AdvertisementsTableSeeder extends Seeder
{
    use ImageFakerTrait, AttrLangTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 50; $i++) {

            $vendor = [
                // "0" => null,
                "0" => Vendor::inRandomOrder()->first()->id,
                "1" => Vendor::inRandomOrder()->first()->id
            ];

            $advertisement = [
                ...$this->getAttribute("title", "name"),
                ...$this->getAttribute("description", "text"),
                "vendor_id"     => $vendor[$faker->numberBetween(0, 1)],
                "active"        => $faker->numberBetween(0, 1),
                "auto_popup"    => $faker->numberBetween(0, 1),
                "defined"       => $defined = $faker->numberBetween(0, 1),
                "start_at"      => $defined ? Carbon::today()->addDays($faker->numberBetween(0, 5)) : null,
                "end_at"        => $defined ? Carbon::today()->addDays($faker->numberBetween(20, 30)) : null,
            ];

            $ad = Advertisement::create($advertisement);
            $this->createImage($ad);
        }
    }
}
