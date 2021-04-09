<?php

namespace Database\Factories;

use App\Models\OrgAccountHead;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrgAccountHeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrgAccountHead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomDigitNotNull,
        'category_id' => $this->faker->randomDigitNotNull,
        'name' => $this->faker->word,
        'slug' => $this->faker->word,
        'code' => $this->faker->word,
        'active' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
