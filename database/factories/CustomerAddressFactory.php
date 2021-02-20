<?php

namespace Database\Factories;

use App\Models\CustomerAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
            'customer_id' => $this->faker->randomDigitNotNull,
            'street' => $this->faker->streetAddress,
            'street2' => $this->faker->streetName,
            'state' => $this->faker->randomDigitNotNull,
            'country' => $this->faker->randomDigitNotNull,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
