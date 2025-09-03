<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Team;

class ApiTeamsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_all_teams(): void
    {
        Team::factory()->count(3)->create();

        $response = $this->get('/api/teams');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_create_a_team(): void
    {
        $teamData = [
            'name' => 'Test Team',
            'city' => 'Test City',
            'stadium' => 'Test Stadium',
        ];

        $response = $this->post('/api/teams', $teamData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('teams', $teamData);
    }

    public function test_can_fetch_a_single_team(): void
    {
        $team = Team::factory()->create();

        $response = $this->get("/api/teams/{$team->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('name', $team->name);
    }

    public function test_can_update_a_team(): void
    {
        $team = Team::factory()->create();
        $updatedData = ['name' => 'Updated Team Name'];

        $response = $this->put("/api/teams/{$team->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('teams', $updatedData);
    }

    public function test_can_delete_a_team(): void
    {
        $team = Team::factory()->create();

        $response = $this->delete("/api/teams/{$team->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
