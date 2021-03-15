<?php

namespace Database\Factories;

use App\Models\LoanRepayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanRepaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanRepayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'loan_application_id' => $this->faker->randomDigitNotNull,
        'customer_id' => $this->faker->randomDigitNotNull,
        'count' => $this->faker->randomDigitNotNull,
        'amount' => $this->faker->word,
        'loan_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}