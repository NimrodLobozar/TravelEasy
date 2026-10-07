<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use App\Models\User;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'role' => $this->faker->randomElement(['Admin', 'Editor', 'Viewer']),
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text(100),
        ];
    }
}
