<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' => $this->faker->randomElement([1, 2, 3]),
            'name' => $this->faker->unique()->company,
            'logo' => $this->faker->imageUrl(),
            'slogan' => $this->faker->catchPhrase,
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'website' => $this->faker->unique()->url,
            'address' => $this->faker->address,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
