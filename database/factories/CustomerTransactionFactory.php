<?php

namespace Database\Factories;

use App\Models\CustomerTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerTransaction::class;

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
        'savings_id' => $this->faker->randomDigitNotNull,
        'loan_id' => $this->faker->randomDigitNotNull,
        'narration' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
