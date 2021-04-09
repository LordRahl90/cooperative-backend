<?php

namespace Database\Factories;

use App\Models\OrgAccountCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrgAccountCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrgAccountCategory::class;

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
        'slug' => $this->faker->word,
        'account_type' => $this->faker->randomElement(['0:Select']),
        'prefix_digit' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
