<?php

namespace Database\Factories;

use App\Models\CustomerLoan;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerLoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerLoan::class;

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
        'approved_by' => $this->faker->word,
        'status' => $this->faker->randomElement(['COMPLETED', 'RUNNING']),
        'total_repaid' => $this->faker->word,
        'narration' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
