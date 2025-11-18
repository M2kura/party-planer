<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_party()
    {
        // 1. Create a user (host)
        $user = User::factory()->create();

        // 2. Define party data
        $partyData = [
            'host_id' => $user->id,
            'name' => 'Birthday Bash',
            'party_date' => '2025-12-25 18:00:00',
            'location' => 'My House',
            'description' => 'Fun times',
        ];

        // 3. Send POST request to API
        $response = $this->postJson('/api/parties', $partyData);

        // 4. Assert: Check for 201 Created status and data in DB
        $response->assertStatus(201);
        $this->assertDatabaseHas('parties', ['name' => 'Birthday Bash']);
    }
}
