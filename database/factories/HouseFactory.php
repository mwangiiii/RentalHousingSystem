<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\House;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseFactory extends Factory
{
    protected $model = House::class;

    public function definition()
    {
        // Ensure there is at least one user in the database
        if (User::count() === 0) {
            User::factory()->create();
        }

        // Ensure there is at least one category in the database
        if (Category::count() === 0) {
            Category::factory()->create();
        }

        return [
            'user_id' => User::factory(),
            'lister_id' => User::inRandomOrder()->first()->id,
            'location' => $this->faker->address,
            'price' => $this->faker->randomFloat(2, 10000, 500000),
            'description' => $this->faker->paragraph,
            'availability' => $this->faker->randomElement(['available', 'unavailable']),
            'contact' => $this->faker->phoneNumber,
            'rules_and_regulations' => $this->faker->optional()->sentence,
            'amenities' => $this->faker->words(3, true),
            'category_id' => Category::inRandomOrder()->first()->id, // Assigning a random existing category
            'main_image' => 'path/to/main_image.jpg', // Replace with actual path or use faker for images
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
