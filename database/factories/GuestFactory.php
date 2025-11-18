<?php

namespace Database\Factories;

use App\Models\Party;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'party_id' => Party::factory(),
            'status' => $this->faker->randomElement(['pending', 'attending', 'declined']),
        ];
    }
}
