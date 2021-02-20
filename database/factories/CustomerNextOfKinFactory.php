<?php

namespace Database\Factories;

use App\Models\CustomerNextOfKin;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerNextOfKinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerNextOfKin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->numberBetween(1, 1),
            'customer_id' => $this->faker->randomDigitNotNull,
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'address' => $this->faker->address,
            'phone' => $this->faker->unique()->phoneNumber,
            'email' => $this->faker->unique()->email,
            'relationship' => $this->faker->randomElement(['Brother', 'Wife', 'Son', 'Daughter']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
