<?php

namespace Tests\Unit;

use App\Models\Guest;
use App\Models\Party;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // Use the main TestCase to access DB helpers

class PartyModelTest extends TestCase
{
    use RefreshDatabase; // Resets DB after every test

    public function test_a_party_has_guests()
    {
        // 1. Arrange: Create a party and a user
        $party = Party::factory()->create();
        $user = User::factory()->create();

        // 2. Act: Add the user as a guest to the party
        Guest::factory()->create([
            'party_id' => $party->id,
            'user_id' => $user->id,
            'status' => 'attending'
        ]);

        // 3. Assert: Check if the party now has 1 guest
        $party->refresh(); // Refresh to load the relationship
        $this->assertTrue($party->guests->where('user_id', $user->id)->isNotEmpty());
        $this->assertEquals(1, $party->guests->count());
    }
}
