<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;
use App\Models\Team;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::all();
        
        // Common player names for realistic data
        $firstNames = [
            'James', 'John', 'Robert', 'Michael', 'William', 'David', 'Richard', 'Joseph', 'Thomas', 'Charles',
            'Christopher', 'Daniel', 'Matthew', 'Anthony', 'Mark', 'Donald', 'Steven', 'Paul', 'Andrew', 'Joshua',
            'Mary', 'Patricia', 'Jennifer', 'Linda', 'Elizabeth', 'Barbara', 'Susan', 'Jessica', 'Sarah', 'Karen'
        ];
        
        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
            'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'
        ];
        
        $positions = ['GK', 'DEF', 'MID', 'FWD'];
        
        foreach ($teams as $team) {
            // Create 20 players for each team
            for ($i = 1; $i <= 20; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                
                Player::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'team_id' => $team->id,
                    'position' => $positions[array_rand($positions)],
                    'shirt_number' => $i,
                    'date_of_birth' => now()->subYears(rand(18, 35))->subDays(rand(1, 365)),
                    'nationality' => 'English',
                    'height' => rand(170, 200),
                    'weight' => rand(65, 90),
                    'bio' => "Professional footballer playing for {$team->name}.",
                    'is_active' => true,
                ]);
            }
        }
    }
}
