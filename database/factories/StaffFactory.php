<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create(['role' => 'STAFF']);
        return [
            'user_id' => $user->id,
            'company_id' => $this->faker->randomElement([1]),
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $user->password,
            'role' => $this->faker->randomElement(['REGULAR', 'SUPERVISOR', 'MANAGER', 'ADMIN']),
            'address' => $this->faker->address,
            'active' => $this->faker->randomElement([true, false]),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
