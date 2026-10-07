<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Trip;
use App\Models\Employee;
use App\Models\Departure;
use App\Models\Destination;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition()
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'departure_id' => Departure::inRandomOrder()->first()->id,
            'destination_id' => Destination::inRandomOrder()->first()->id,
            'flight_number' => strtoupper($this->faker->bothify('??###')),
            // 'departure_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'departure_time' => $this->faker->time,
            'departure_date' => $departureDate = $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'arrival_date' => $this->faker->dateTimeBetween($departureDate, $departureDate . ' +1 day')->format('Y-m-d'),
            'arrival_time' => function (array $attributes) {
                $departureTime = new \DateTime($attributes['departure_time']);
                $arrivalTime = clone $departureTime;
                $arrivalTime->modify('+' . rand(1, 5) . ' hours'); // Adjust the range as needed
                return $arrivalTime->format('H:i:s');
            },
            'trip_status' => $this->faker->randomElement(['Scheduled', 'Completed', 'Cancelled']),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
