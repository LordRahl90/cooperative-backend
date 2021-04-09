<?php

namespace Database\Factories;

use App\Models\LoanCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanCategory::class;

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
        'category_id' => $this->faker->randomDigitNotNull,
        'slug' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
