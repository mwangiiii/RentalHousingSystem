<?php

namespace Database\Factories;

use App\Models\Booking; // Ensure this is the correct model
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingsFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_id' => \App\Models\House::factory(), // Ensure you have a House factory or use an existing house_id
            'name' => $this->faker->name,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'check_in_date' => $this->faker->dateTimeBetween('+1 day', '+1 month')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'canceled']),
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'refunded']),
            'payment_method' => $this->faker->creditCardType,
            'transaction_id' => $this->faker->uuid,
            'additional_notes' => $this->faker->text,
        ];
    }
}
