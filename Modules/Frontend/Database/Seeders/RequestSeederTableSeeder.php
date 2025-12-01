<?php

namespace Modules\Frontend\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\Entities\ContactRequest;

class RequestSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            ContactRequest::create([
                "name" => $faker->name,
                "nationality" => "Egyptian",
                "email" => $faker->email,
                "phone_number" => $faker->phoneNumber,
                "profession" => $faker->jobTitle,
                "reference_num" => rand(1000000, 9999999),
                // "reason_id" => rand(1, 5)
            ]);
        }
    }
}
