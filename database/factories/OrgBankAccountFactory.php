<?php

namespace Database\Factories;

use App\Models\OrgBankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrgBankAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrgBankAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bank_id' => $this->faker->randomDigitNotNull,
        'account_name' => $this->faker->word,
        'slug' => $this->faker->word,
        'account_number' => $this->faker->word,
        'account_head_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
