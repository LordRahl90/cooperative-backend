<?php

namespace Database\Factories;

use App\Models\LoanApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanApplication::class;

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
        'loan_account_id' => $this->faker->randomDigitNotNull,
        'principal' => $this->faker->word,
        'rate' => $this->faker->word,
        'interest_type' => $this->faker->randomElement(['FLAT_RATE', 'FLAT']),
        'tenor' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->randomElement(['APPROVED', 'DISAPPROVED', 'PENDING']),
        'staff_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
