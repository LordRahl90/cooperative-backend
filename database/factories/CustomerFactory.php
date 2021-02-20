<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create(['role' => 'CUSTOMER']);

        return [
            'user_id' => $user->id,
            'company_id' => $this->faker->numberBetween(1, 2),
            'surname' => $this->faker->unique()->lastName,
            'other_names' => $this->faker->unique()->lastName,
            'dob' => $this->faker->date('Y-m-d'),
            'reference' => strtoupper(uniqid('CUS-')),
            'email' => $user->email,
            'phone' => $user->phone,
            'gender' => $this->faker->randomElement(['FEMALE', 'MALE']),
            'password' => $user->password,
            'religion' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
