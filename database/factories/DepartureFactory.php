<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Departure;

class DepartureFactory extends Factory
{
    protected $model = Departure::class;

    private static $index = 0;

    private static $departures = [
        [
            'country' => 'United States',
            'airport' => 'Los Angeles International Airport',
            'is_active' => true,
            'note' => 'Main hub for international flights',
        ],
        [
            'country' => 'United Kingdom',
            'airport' => 'Heathrow Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Europe',
        ],
        [
            'country' => 'Japan',
            'airport' => 'Narita International Airport',
            'is_active' => false,
            'note' => 'Major gateway for international travelers',
        ],
        [
            'country' => 'Australia',
            'airport' => 'Sydney Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Australia',
        ],
        [
            'country' => 'Germany',
            'airport' => 'Frankfurt Airport',
            'is_active' => true,
            'note' => 'Largest airport in Germany',
        ],
        [
            'country' => 'France',
            'airport' => 'Charles de Gaulle Airport',
            'is_active' => true,
            'note' => 'Largest airport in France',
        ],
        [
            'country' => 'China',
            'airport' => 'Beijing Capital International Airport',
            'is_active' => true,
            'note' => 'Main hub for international flights',
        ],
        [
            'country' => 'South Korea',
            'airport' => 'Incheon International Airport',
            'is_active' => true,
            'note' => 'Largest airport in South Korea',
        ],
        [
            'country' => 'Singapore',
            'airport' => 'Changi Airport',
            'is_active' => true,
            'note' => 'One of the busiest airports in the world',
        ],
        [
            'country' => 'United Arab Emirates',
            'airport' => 'Dubai International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in the world by international passenger traffic',
        ],
        [
            'country' => 'Qatar',
            'airport' => 'Hamad International Airport',
            'is_active' => true,
            'note' => 'Main hub for international flights',
        ],
        [
            'country' => 'Turkey',
            'airport' => 'Istanbul Airport',
            'is_active' => true,
            'note' => 'Largest airport in Turkey',
        ],
        [
            'country' => 'Netherlands',
            'airport' => 'Amsterdam Airport Schiphol',
            'is_active' => true,
            'note' => 'Main hub for international flights',
        ],
        [
            'country' => 'Spain',
            'airport' => 'Adolfo Suárez Madrid–Barajas Airport',
            'is_active' => true,
            'note' => 'Largest airport in Spain',
        ],
        [
            'country' => 'Italy',
            'airport' => 'Leonardo da Vinci–Fiumicino Airport',
            'is_active' => true,
            'note' => 'Largest airport in Italy',
        ],
        [
            'country' => 'Brazil',
            'airport' => 'Guarulhos International Airport',
            'is_active' => true,
            'note' => 'Largest airport in Brazil',
        ],
        /////////////
        [
            'country' => 'Canada',
            'airport' => 'Toronto Pearson International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Canada',
        ],
        [
            'country' => 'Russia',
            'airport' => 'Sheremetyevo International Airport',
            'is_active' => true,
            'note' => 'Largest airport in Russia',
        ],
        [
            'country' => 'India',
            'airport' => 'Indira Gandhi International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in India',
        ],
        [
            'country' => 'South Africa',
            'airport' => 'O. R. Tambo International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Africa',
        ],
        [
            'country' => 'Mexico',
            'airport' => 'Mexico City International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Mexico',
        ],
        [
            'country' => 'Argentina',
            'airport' => 'Ministro Pistarini International Airport',
            'is_active' => true,
            'note' => 'Largest airport in Argentina',
        ],
        [
            'country' => 'Chile',
            'airport' => 'Comodoro Arturo Merino Benítez International Airport',
            'is_active' => true,
            'note' => 'Largest airport in Chile',
        ],
        [
            'country' => 'Peru',
            'airport' => 'Jorge Chávez International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Peru',
        ],
        [
            'country' => 'Colombia',
            'airport' => 'El Dorado International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Colombia',
        ],
        [
            'country' => 'Venezuela',
            'airport' => 'Simón Bolívar International Airport',
            'is_active' => true,
            'note' => 'Largest airport in Venezuela',
        ],
        [
            'country' => 'Ecuador',
            'airport' => 'Mariscal Sucre International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Ecuador',
        ],
        [
            'country' => 'Panama',
            'airport' => 'Tocumen International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Panama',
        ],
        [
            'country' => 'Costa Rica',
            'airport' => 'Juan Santamaría International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Costa Rica',
        ],
        [
            'country' => 'Dominican Republic',
            'airport' => 'Las Américas International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in the Dominican Republic',
        ],
        [
            'country' => 'Puerto Rico',
            'airport' => 'Luis Muñoz Marín International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Puerto Rico',
        ],
        [
            'country' => 'Jamaica',
            'airport' => 'Norman Manley International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Jamaica',
        ],
        [
            'country' => 'Trinidad and Tobago',
            'airport' => 'Piarco International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Trinidad and Tobago',
        ],
        [
            'country' => 'Barbados',
            'airport' => 'Grantley Adams International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Barbados',
        ],
        [
            'country' => 'Bahamas',
            'airport' => 'Lynden Pindling International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in the Bahamas',
        ],
        [
            'country' => 'Cuba',
            'airport' => 'José Martí International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Cuba',
        ],
        [
            'country' => 'Haiti',
            'airport' => 'Toussaint Louverture International Airport',
            'is_active' => true,
            'note' => 'Busiest airport in Haiti',
        ],
        [
            'country' => 'Hungary',
            'airport' => 'Budapest Ferenc Liszt International Airport',
            'is_active' => true,
            'note' => 'Largest airport in Hungary',
        ]
    ];

    public function definition(): array
    {
        $departure = self::$departures[self::$index];
        self::$index = (self::$index + 1) % count(self::$departures);
        return $departure;
    }
}
