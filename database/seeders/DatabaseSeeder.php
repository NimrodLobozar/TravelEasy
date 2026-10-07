<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Invoice;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Contact;
use App\Models\Employee;
use App\Models\Departure;
use App\Models\Destination;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Communication;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Maak een admin en testgebruiker (specifieke users)
        $person = Person::factory()->create([
            'first_name' => fake()->firstName,
            'middle_name' => fake()->optional()->lastName,
            'last_name' => fake()->lastName,
        ]);

        $customer = Customer::create([
            'person_id' => $person->id,
            'relation_number' => fake()->unique()->numberBetween(100000, 999999),
        ]);

        Contact::create([
            'customer_id' => $customer->id,
            'email' => 'test@gmail.com',
            'mobile' => fake()->phoneNumber,
            // ...other required fields for Contact model...
        ]);

        User::create([
            'person_id' => $person->id,
            'name' => 'TestUser',
            'password' => Hash::make('Test1234'),
        ]);

        $adminPerson = Person::factory()->create([
            'first_name' => fake()->firstName,
            'middle_name' => fake()->optional()->lastName,
            'last_name' => fake()->lastName,
        ]);

        $adminCustomer = Customer::create([
            'person_id' => $adminPerson->id,
            'relation_number' => fake()->unique()->numberBetween(100000, 999999),
        ]);

        Contact::create([
            'customer_id' => $adminCustomer->id,
            'email' => 'admin@gmail.com',
            'mobile' => fake()->phoneNumber,
            // ...other required fields for Contact model...
        ]);

        $adminUser = User::create([
            'person_id' => $adminPerson->id,
            'name' => 'AdminUser',
            'password' => Hash::make('Admin1234'),
        ]);

        $adminRole = Role::create([
            'user_id' => $adminUser->id,
            'name' => 'Admin',
        ]);

        // Associate the role with the user
        $adminUser->roles()->save($adminRole);

        Employee::create([
            'person_id' => $adminPerson->id,
            'number' => fake()->unique()->numberBetween(100000, 999999),
            'employee_type' => 'Administrator',
        ]);

        // Nu de rest van de gebruikers (gekoppeld aan een persoon)
        User::factory()->count(300)->create();

        // Werknemers aanmaken (gekoppeld aan een persoon)
        $employees = Employee::factory()->count(10)->create();

        // Luchthavens en bestemmingen
        $departures = Departure::factory()->count(20)->create();
        $destinations = Destination::factory()->count(20)->create();

        // Reizen genereren (gekoppeld aan medewerkers, luchthavens)
        $trips = Trip::factory()->count(500)->create();

        // Boekingen (gekoppeld aan klanten en reizen)
        $bookings = Booking::factory()->count(20)->create();

        // Facturen (gekoppeld aan boekingen)
        Invoice::factory()->count(30)->create();

        // Communicatie tussen klanten en medewerkers
        // Communication::factory()->count(20)->create();
    }
}
