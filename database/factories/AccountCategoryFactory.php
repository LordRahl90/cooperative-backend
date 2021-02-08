<?php

namespace Database\Factories;

use App\Models\AccountCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'prefix_digit' => $this->faker->randomDigitNotNull,
            'account_type' => $this->faker->randomElement(['0:Select']),
            'slug' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
