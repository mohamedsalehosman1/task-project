<?php

namespace Modules\Orders\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Orders\Entities\Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shipping_company_notes' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'subtotal' => $this->faker->numberBetween(50, 500),
            'discount' => $this->faker->numberBetween(50, 500),
            'total' => $this->faker->numberBetween(50, 500),
        ];
    }
}

