<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Person;
use App\Models\Customer;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    public function definition()
    {
        $person = Person::factory()->create();

        $user = User::create([
            'person_id' => $person->id,
            'name' => $this->faker->userName,
            'password' => static::$password ??= Hash::make('password'),
            'is_logged_in' => false,
            'logged_in' => null,
            'logged_out' => null,
            'is_active' => true,
            'note' => null,
            'remember_token' => Str::random(10),
        ]);

        $customer = Customer::factory()->create([
            'person_id' => $person->id,
            'relation_number' => $this->faker->unique()->numberBetween(100000, 999999),
        ]);

        Contact::create([
            'customer_id' => $customer->id,
            'email' => $this->faker->unique()->safeEmail,
            'mobile' => $this->faker->phoneNumber,
            // ...other required fields for Contact model...
        ]);

        $employee = [
            'person_id' => $person->id,
            'number' => $this->faker->unique()->numberBetween(100000, 999999),
            'employee_type' => $this->faker->randomElement(['Manager', 'Administrator', 'Desk Employee']),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];

        Role::factory()->create([
            'user_id' => $user->id,
            'role' => in_array($employee['employee_type'], ['Manager', 'Administrator']) ? 'Admin' : 'Editor',
            'is_active' => $employee['is_active'],
            'note' => $employee['note'],
        ]);

        return $employee;
    }
}
