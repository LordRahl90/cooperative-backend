<?php

namespace Database\Factories;

use App\Models\CustomerBankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerBankAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerBankAccount::class;

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
        'bank_id' => $this->faker->randomDigitNotNull,
        'account_name' => $this->faker->word,
        'account_number' => $this->faker->word,
        'sort_code' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
