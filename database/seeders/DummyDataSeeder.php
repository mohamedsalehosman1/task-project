<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Accounts\Database\Seeders\UsersTableSeeder;
use Modules\Categories\Database\Seeders\CategoriesDatabaseSeeder;
use Modules\Employees\Database\Seeders\EmployeesDatabaseSeeder;
use Modules\HowKnow\Database\Seeders\ReasonSeederTableSeeder;
use Modules\Packages\Database\Seeders\PackagesDatabaseSeeder;
use Modules\Projects\Database\Seeders\ProjectsDatabaseSeeder;
use Modules\Services\Database\Seeders\ServicesDatabaseSeeder;
use Modules\Settings\Database\Seeders\ContactusTableSeeder;
use Modules\Settings\Database\Seeders\SettingsDatabaseSeeder;
use Modules\Sliders\Database\Seeders\SlidersTableSeeder;
use Modules\Testimonials\Database\Seeders\TestimonialsTableSeeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(LaratrustSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(SlidersTableSeeder::class);
        // $this->call(TestimonialsTableSeeder::class);
        // $this->call(SettingsDatabaseSeeder::class);
        // $this->call(ContactusTableSeeder::class);
        $this->call(CategoriesDatabaseSeeder::class);
        // $this->call(EmployeesDatabaseSeeder::class);
        // $this->call(ServicesDatabaseSeeder::class);
        // $this->call(ProjectsDatabaseSeeder::class);
        // $this->call(ReasonSeederTableSeeder::class);
        // $this->call(PackagesDatabaseSeeder::class);
    }
}
