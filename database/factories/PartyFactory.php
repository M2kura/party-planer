<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'host_id' => User::factory(), // Automatically creates a user for the host
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'party_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'location' => $this->faker->address(),
        ];
    }
}
