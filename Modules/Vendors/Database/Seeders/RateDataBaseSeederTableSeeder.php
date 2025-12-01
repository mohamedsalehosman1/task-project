<?php

namespace Modules\Vendors\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\User;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductVariance;
use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Vendor;
use Faker\Factory as Faker;

class RateDataBaseSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $users = User::all();
        $products = Product::all();
        $vendors = Vendor::all();

        if ($users->isEmpty() || ($products->isEmpty() && $vendors->isEmpty())) {
            $this->command->info('No users, products, or vendors found. Skipping RateSeeder.');
            return;
        }

        foreach ($users as $user) {
            if ($faker->boolean(50) && $products->isNotEmpty()) {
                $rateable = $products->random();
            } else if ($vendors->isNotEmpty()) {
                $rateable = $vendors->random();
            } else {
                continue;
            }

            Rate::firstOrCreate([
                'user_id' => $user->id,
                'rateable_id' => $rateable->id,
                'rateable_type' => get_class($rateable),
            ], [
                'value' => $faker->numberBetween(1, 5),
                'comment' => $faker->sentence,
            ]);
        }
    }
}
