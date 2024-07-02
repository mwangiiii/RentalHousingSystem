<?php

namespace Database\Factories;

use App\Models\Lister;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ListerFactory extends Factory
{
    protected $model = Lister::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Generates a new user if not already provided
            'name' => $this->faker->name,
            'contact' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'identification_number' => $this->faker->unique()->numerify('#########'),
            'password' => Hash::make('password'), // Example password hashing
        ];
    }
}
