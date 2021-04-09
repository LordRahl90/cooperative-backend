<?php

namespace Database\Factories;

use App\Models\CustomerSaving;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerSavingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerSaving::class;

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
        'savings_account_id' => $this->faker->randomDigitNotNull,
        'amount' => $this->faker->word,
        'narration' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
