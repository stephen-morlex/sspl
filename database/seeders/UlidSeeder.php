<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Team;
use App\Models\League;
use App\Models\Player;
use App\Models\Fixture;
use App\Models\Standing;
use App\Models\Statistics;

class UlidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate all tables
        DB::table('statistics')->delete();
        DB::table('standings')->delete();
        DB::table('fixtures')->delete();
        DB::table('players')->delete();
        DB::table('teams')->delete();
        DB::table('leagues')->delete();

        // Create leagues with ULID
        $leagues = [
            [
                'id' => (string) Str::ulid(),
                'name' => 'Premier League',
                'country' => 'England',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'The Premier League, often referred to as the English Premier League or the EPL, is the top level of the English football league system.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'La Liga',
                'country' => 'Spain',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'La Liga, officially known as LaLiga Santander for sponsorship reasons, is the top professional association football division of the Spanish football league system.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Bundesliga',
                'country' => 'Germany',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'The Bundesliga is a professional association football league in Germany.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Serie A',
                'country' => 'Italy',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'Serie A, officially known as Serie A TIM for sponsorship reasons, is a professional league competition for football clubs located at the top of the Italian football league system.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Ligue 1',
                'country' => 'France',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'Ligue 1, officially known as Ligue 1 Uber Eats for sponsorship reasons, is a French professional league for men\'s association football clubs.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('leagues')->insert($leagues);
        $leagueIds = array_column($leagues, 'id');

        // Create teams with ULID
        $teamsData = [
            [
                'id' => (string) Str::ulid(),
                'name' => 'Manchester United',
                'short_name' => 'MUN',
                'city' => 'Manchester',
                'stadium' => 'Old Trafford',
                'founded_year' => 1878,
                'description' => 'Manchester United Football Club is a professional football club based in Manchester, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Liverpool FC',
                'short_name' => 'LIV',
                'city' => 'Liverpool',
                'stadium' => 'Anfield',
                'founded_year' => 1892,
                'description' => 'Liverpool Football Club is a professional football club based in Liverpool, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Arsenal FC',
                'short_name' => 'ARS',
                'city' => 'London',
                'stadium' => 'Emirates Stadium',
                'founded_year' => 1886,
                'description' => 'Arsenal Football Club is a professional football club based in London, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Chelsea FC',
                'short_name' => 'CHE',
                'city' => 'London',
                'stadium' => 'Stamford Bridge',
                'founded_year' => 1905,
                'description' => 'Chelsea Football Club is a professional football club based in London, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Manchester City',
                'short_name' => 'MCI',
                'city' => 'Manchester',
                'stadium' => 'Etihad Stadium',
                'founded_year' => 1880,
                'description' => 'Manchester City Football Club is a professional football club based in Manchester, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Tottenham Hotspur',
                'short_name' => 'TOT',
                'city' => 'London',
                'stadium' => 'Tottenham Hotspur Stadium',
                'founded_year' => 1882,
                'description' => 'Tottenham Hotspur Football Club is a professional football club based in London, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Newcastle United',
                'short_name' => 'NEW',
                'city' => 'Newcastle upon Tyne',
                'stadium' => 'St. James\' Park',
                'founded_year' => 1892,
                'description' => 'Newcastle United Football Club is a professional football club based in Newcastle upon Tyne, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Aston Villa',
                'short_name' => 'AVL',
                'city' => 'Birmingham',
                'stadium' => 'Villa Park',
                'founded_year' => 1874,
                'description' => 'Aston Villa Football Club is a professional football club based in Birmingham, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'West Ham United',
                'short_name' => 'WHU',
                'city' => 'London',
                'stadium' => 'London Stadium',
                'founded_year' => 1895,
                'description' => 'West Ham United Football Club is a professional football club based in London, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Brighton & Hove Albion',
                'short_name' => 'BHA',
                'city' => 'Brighton and Hove',
                'stadium' => 'Amex Stadium',
                'founded_year' => 1901,
                'description' => 'Brighton & Hove Albion Football Club is a professional football club based in Brighton and Hove, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Wolverhampton Wanderers',
                'short_name' => 'WOL',
                'city' => 'Wolverhampton',
                'stadium' => 'Molineux Stadium',
                'founded_year' => 1877,
                'description' => 'Wolverhampton Wanderers Football Club is a professional football club based in Wolverhampton, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Leicester City',
                'short_name' => 'LEI',
                'city' => 'Leicester',
                'stadium' => 'King Power Stadium',
                'founded_year' => 1884,
                'description' => 'Leicester City Football Club is a professional football club based in Leicester, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Everton FC',
                'short_name' => 'EVE',
                'city' => 'Liverpool',
                'stadium' => 'Goodison Park',
                'founded_year' => 1878,
                'description' => 'Everton Football Club is a professional football club based in Liverpool, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Southampton FC',
                'short_name' => 'SOU',
                'city' => 'Southampton',
                'stadium' => 'St. Mary\'s Stadium',
                'founded_year' => 1885,
                'description' => 'Southampton Football Club is a professional football club based in Southampton, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Crystal Palace',
                'short_name' => 'CRY',
                'city' => 'London',
                'stadium' => 'Selhurst Park',
                'founded_year' => 1905,
                'description' => 'Crystal Palace Football Club is a professional football club based in London, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Leeds United',
                'short_name' => 'LEE',
                'city' => 'Leeds',
                'stadium' => 'Elland Road',
                'founded_year' => 1904,
                'description' => 'Leeds United Football Club is a professional football club based in Leeds, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Burnley FC',
                'short_name' => 'BUR',
                'city' => 'Burnley',
                'stadium' => 'Turf Moor',
                'founded_year' => 1882,
                'description' => 'Burnley Football Club is a professional football club based in Burnley, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Watford FC',
                'short_name' => 'WAT',
                'city' => 'Watford',
                'stadium' => 'Vicarage Road',
                'founded_year' => 1881,
                'description' => 'Watford Football Club is a professional football club based in Watford, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Norwich City',
                'short_name' => 'NOR',
                'city' => 'Norwich',
                'stadium' => 'Carrow Road',
                'founded_year' => 1902,
                'description' => 'Norwich City Football Club is a professional football club based in Norwich, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Sheffield United',
                'short_name' => 'SHU',
                'city' => 'Sheffield',
                'stadium' => 'Bramall Lane',
                'founded_year' => 1889,
                'description' => 'Sheffield United Football Club is a professional football club based in Sheffield, England.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('teams')->insert($teamsData);
        $teamIds = array_column($teamsData, 'id');

        // Create players with ULID
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
        $playersData = [];
        
        foreach ($teamIds as $teamId) {
            // Create 20 players for each team
            for ($i = 1; $i <= 20; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                
                $playersData[] = [
                    'id' => (string) Str::ulid(),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'team_id' => $teamId,
                    'position' => $positions[array_rand($positions)],
                    'shirt_number' => $i,
                    'date_of_birth' => now()->subYears(rand(18, 35))->subDays(rand(1, 365)),
                    'nationality' => 'English',
                    'height' => rand(170, 200),
                    'weight' => rand(65, 90),
                    'bio' => "Professional footballer.",
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('players')->insert($playersData);
        $playerIds = array_column($playersData, 'id');

        // Create fixtures with ULID
        $fixturesData = [];
        $statuses = ['scheduled', 'live', 'finished', 'postponed'];
        
        // Create fixtures for each league
        foreach ($leagueIds as $leagueId) {
            // Create 20 fixtures for each league
            for ($i = 0; $i < 20; $i++) {
                // Select two random different teams
                $homeTeamId = $teamIds[array_rand($teamIds)];
                $awayTeamId = $homeTeamId;
                while ($awayTeamId === $homeTeamId) {
                    $awayTeamId = $teamIds[array_rand($teamIds)];
                }
                
                // Find the home team to get the stadium
                $homeTeam = null;
                foreach ($teamsData as $team) {
                    if ($team['id'] === $homeTeamId) {
                        $homeTeam = $team;
                        break;
                    }
                }
                
                $fixturesData[] = [
                    'id' => (string) Str::ulid(),
                    'home_team_id' => $homeTeamId,
                    'away_team_id' => $awayTeamId,
                    'league_id' => $leagueId,
                    'kickoff_time' => now()->addDays(rand(0, 30))->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                    'venue' => $homeTeam ? $homeTeam['stadium'] : 'Unknown Stadium',
                    'home_score' => rand(0, 5),
                    'away_score' => rand(0, 5),
                    'status' => $statuses[array_rand($statuses)],
                    'match_summary' => 'An exciting match',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('fixtures')->insert($fixturesData);
        $fixtureIds = array_column($fixturesData, 'id');

        // Create standings with ULID
        $standingsData = [];
        
        // Create standings for each league
        foreach ($leagueIds as $leagueId) {
            // Create standings for each team in the league
            foreach ($teamIds as $teamId) {
                $standingsData[] = [
                    'id' => (string) Str::ulid(),
                    'team_id' => $teamId,
                    'league_id' => $leagueId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('standings')->insert($standingsData);

        // Create statistics with ULID
        $statisticsData = [];
        
        // Create statistics for each player in some fixtures
        foreach (array_slice($playerIds, 0, 50) as $playerId) {
            // Create 5 statistics records for each player
            foreach (array_slice($fixtureIds, 0, 5) as $fixtureId) {
                $statisticsData[] = [
                    'id' => (string) Str::ulid(),
                    'player_id' => $playerId,
                    'match_id' => $fixtureId,
                    'goals' => rand(0, 3),
                    'assists' => rand(0, 2),
                    'penalties' => rand(0, 1),
                    'penalties_scored' => rand(0, 1),
                    'shots_on_goal' => rand(0, 5),
                    'woodwork_hits' => rand(0, 2),
                    'tackles_won' => rand(0, 10),
                    'aerial_duels_won' => rand(0, 15),
                    'fouls_committed' => rand(0, 5),
                    'yellow_cards' => rand(0, 1),
                    'sprints' => rand(10, 50),
                    'intensive_runs' => rand(5, 30),
                    'distance_km' => rand(5, 15),
                    'top_speed_kmh' => rand(20, 35),
                    'crosses' => rand(0, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('statistics')->insert($statisticsData);
    }
}