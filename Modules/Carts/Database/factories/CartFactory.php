<?php

namespace Modules\Carts\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Accounts\Entities\User;
use Modules\Carts\Entities\Cart;
use Modules\Vendors\Entities\Vendor;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cart_id' => Vendor::factory()->create()->id,
            'cart_type' => 'Vendor',
            'user_id' => User::factory()->create()->id,
        ];
    }
}

