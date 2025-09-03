<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Team;
use App\Models\Player;
use App\Models\League;
use App\Models\Fixture;
use App\Models\Standing;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_all_teams()
    {
        Team::factory()->count(5)->create();

        $response = $this->get('/api/teams');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_can_fetch_all_players()
    {
        Player::factory()->count(5)->create();

        $response = $this->get('/api/players');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_can_fetch_all_leagues()
    {
        League::factory()->count(3)->create();

        $response = $this->get('/api/leagues');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_fetch_all_fixtures()
    {
        Fixture::factory()->count(4)->create();

        $response = $this->get('/api/fixtures');

        $response->assertStatus(200);
        $response->assertJsonCount(4);
    }

    public function test_can_fetch_all_standings()
    {
        Standing::factory()->count(6)->create();

        $response = $this->get('/api/standings');

        $response->assertStatus(200);
        $response->assertJsonCount(6);
    }
}