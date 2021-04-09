<?php

namespace Database\Factories;

use App\Models\CustomerLoanLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerLoanLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerLoanLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'customer' => $this->faker->randomDigitNotNull,
        'loan_id' => $this->faker->randomDigitNotNull,
        'debit' => $this->faker->word,
        'credit' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
