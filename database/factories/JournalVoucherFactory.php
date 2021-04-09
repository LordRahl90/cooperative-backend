<?php

namespace Database\Factories;

use App\Models\JournalVoucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalVoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JournalVoucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'reference' => $this->faker->word,
        'narration' => $this->faker->word,
        'total_amount' => $this->faker->word,
        'created_by' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
