<?php

namespace Database\Factories;

use App\Models\Hunter;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class HunterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hunter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $houseHunterRoleId = Role::where('role_name', 'house hunter')->value('id');

        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'contact' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'identification_number' => $this->faker->unique()->randomNumber(8),
            'password' => bcrypt('password'), // Default password
            'role_id' => $houseHunterRoleId, // Assign role ID 8 (house hunter)
        ];
    }
}
