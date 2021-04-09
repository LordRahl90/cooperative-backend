<?php

namespace Database\Factories;

use App\Models\LoanAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'loan_category_id' => $this->faker->randomDigitNotNull,
        'account_head_id' => $this->faker->randomDigitNotNull,
        'name' => $this->faker->word,
        'slug' => $this->faker->word,
        'code' => $this->faker->word,
        'description' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
