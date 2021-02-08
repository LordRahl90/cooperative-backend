<?php

namespace Database\Factories;

use App\Models\PaymentVoucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentVoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentVoucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payee' => $this->faker->word,
        'address' => $this->faker->word,
        'email' => $this->faker->word,
        'website' => $this->faker->word,
        'phone' => $this->faker->word,
        'pv_id' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
