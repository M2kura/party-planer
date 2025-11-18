<?php

namespace Database\Factories;

use App\Models\Party;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'party_id' => Party::factory(),
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'guest_id' => null, // Default to unclaimed
        ];
    }
}
