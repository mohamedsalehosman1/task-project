<?php

namespace Modules\Vendors\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Support\Traits\AttrLangTrait;
use Modules\Support\Traits\ImageFakerTrait;
use Modules\Vendors\Entities\Vendor;
use Str;

class VendorsDatabaseSeeder extends Seeder
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

        for ($i = 1; $i < 10; $i++) {
            $data = [
                ...$this->getAttribute("name", "lastName"),
                ...$this->getAttribute("description", "text", true),
                'address' => $faker->address,
                'lat' => 23.15 + $i,
                'long' => 22.15 + $i,
                'email' => $faker->unique()->safeEmail,
                'phone' => '05430884' . $i,
                'preferred_locale' => "ar",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ];
            $vendor = Vendor::create($data);

            $vendor->setVerified();


            // $this->createImage($vendor, "images/vendors", 1, "images");
            // $this->createImage($vendor, "images/fakers", 5, "banners");

            /** create admin **/
            $admin = $vendor->admin()->create([
                'name' => $data['name:en'],
                'email' => $data['email'],
                'password' => $data['password'],
                'belongs_to_vendor' => true,
            ]);

            $admin->attachRole('vendor');
        }
    }
}
