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
        $departure = Departure::inRandomOrder()->first();
        $destination = Destination::where('country', '!=', $departure->country)->inRandomOrder()->first();

        $departureDate = $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d');
        $arrivalDate = $this->faker->dateTimeBetween($departureDate, $departureDate . ' +1 day')->format('Y-m-d');

        $tripStatus = $this->faker->randomElement(
            array_merge(
                array_fill(0, 80, 'Scheduled'),
                array_fill(0, 15, 'Completed'),
                array_fill(0, 5, 'Cancelled')
            )
        );

        if ($tripStatus === 'Completed') {
            $departureDate = $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
            $arrivalDate = $this->faker->dateTimeBetween($departureDate, $departureDate . ' +1 day')->format('Y-m-d');
        }

        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'departure_id' => $departure->id,
            'destination_id' => $destination->id,
            'flight_number' => strtoupper($this->faker->bothify('??###')),
            'departure_time' => $this->faker->time,
            'departure_date' => $departureDate,
            'arrival_date' => $arrivalDate,
            'arrival_time' => function (array $attributes) {
                $departureTime = new \DateTime($attributes['departure_time']);
                $arrivalTime = clone $departureTime;
                $arrivalTime->modify('+' . rand(1, 5) . ' hours'); // Adjust the range as needed
                return $arrivalTime->format('H:i:s');
            },
            'trip_status' => $tripStatus,
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
