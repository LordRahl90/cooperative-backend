<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'surname' => $this->faker->word,
        'othernames' => $this->faker->word,
        'reference' => $this->faker->word,
        'email' => $this->faker->word,
        'phone' => $this->faker->word,
        'gender' => $this->faker->randomElement(['FEMALE', 'MALE']),
        'password' => $this->faker->word,
        'religion' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
