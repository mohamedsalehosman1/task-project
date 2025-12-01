<?php

namespace Modules\Orders\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderTaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Orders\Entities\OrderTax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total' => $this->faker->numberBetween(1, 5),
        ];
    }
}

