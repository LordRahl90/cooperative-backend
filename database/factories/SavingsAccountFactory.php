<?php

namespace Database\Factories;

use App\Models\SavingsAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingsAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SavingsAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'savings_category_id' => $this->faker->randomDigitNotNull,
        'account_head_id' => $this->faker->randomDigitNotNull,
        'name' => $this->faker->word,
        'slug' => $this->faker->word,
        'description' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
