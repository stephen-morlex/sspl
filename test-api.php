<?php

// Simple script to test API endpoints
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://localhost:8000']);

try {
    // Test teams endpoint
    $response = $client->get('/api/teams');
    $teams = json_decode($response->getBody(), true);
    echo "Teams count: " . count($teams) . "\n";
    
    // Test players endpoint
    $response = $client->get('/api/players');
    $players = json_decode($response->getBody(), true);
    echo "Players count: " . count($players) . "\n";
    
    // Test leagues endpoint
    $response = $client->get('/api/leagues');
    $leagues = json_decode($response->getBody(), true);
    echo "Leagues count: " . count($leagues) . "\n";
    
    // Test fixtures endpoint
    $response = $client->get('/api/fixtures');
    $fixtures = json_decode($response->getBody(), true);
    echo "Fixtures count: " . count($fixtures) . "\n";
    
    // Test standings endpoint
    $response = $client->get('/api/standings');
    $standings = json_decode($response->getBody(), true);
    echo "Standings count: " . count($standings) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}