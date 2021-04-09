<?php

namespace Database\Factories;

use App\Models\Configuration;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Configuration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'income_category' => $this->faker->randomDigitNotNull,
        'expense_category' => $this->faker->randomDigitNotNull,
        'cash_account_categories' => $this->faker->randomDigitNotNull,
        'fixed_asset_categories' => $this->faker->randomDigitNotNull,
        'current_assets_category' => $this->faker->randomDigitNotNull,
        'account_payable_category' => $this->faker->randomDigitNotNull,
        'account_recieveable_category' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
