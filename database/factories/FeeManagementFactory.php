<?php

namespace Database\Factories;

use App\Models\FeeManagement;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeeManagementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FeeManagement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'name' => $this->faker->word,
        'description' => $this->faker->word,
        'duration' => $this->faker->word,
        'deadline' => $this->faker->word,
        'amount' => $this->faker->word,
        'account_head_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
