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
            'company_id' => $this->faker->randomDigitNotNull,
        'customer_id' => $this->faker->randomDigitNotNull,
        'name' => $this->faker->word,
        'address' => $this->faker->word,
        'phone' => $this->faker->word,
        'email' => $this->faker->word,
        'relationship' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
