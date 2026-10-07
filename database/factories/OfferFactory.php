<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Trip;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trip_id' => Trip::inRandomOrder()->first()->id,
            'offer_code' => $this->faker->unique()->word,
            'discount_percentage' => $this->faker->numberBetween(5, 50),
            'valid_from' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'valid_until' => $this->faker->dateTimeBetween('now', '+1 month'),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(200),
        ];
    }
}
