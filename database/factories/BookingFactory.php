<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Trip;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'trip_id' => Trip::inRandomOrder()->first()->id,
            'seat_number' => $this->faker->bothify('##?'),
            'purchase_date' => $this->faker->date,
            'purchase_time' => $this->faker->time,
            'booking_status' => $this->faker->randomElement(['Confirmed', 'Pending', 'Cancelled']),
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'quantity' => $this->faker->numberBetween(1, 5),
            'is_active' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
