<?php

namespace Database\Factories;

use App\Models\PaymentVoucherDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentVoucherDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentVoucherDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'pv_id' => $this->faker->randomDigitNotNull,
        'account_head_id' => $this->faker->randomDigitNotNull,
        'amount' => $this->faker->word,
        'narration' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
