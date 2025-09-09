<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'id' => (string) Str::ulid(),
                'name' => 'Manchester United',
                'short_name' => 'MUN',
                'city' => 'Manchester',
                'stadium' => 'Old Trafford',
                'founded_year' => 1878,
                'description' => 'Manchester United Football Club is a professional football club based in Manchester, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Liverpool FC',
                'short_name' => 'LIV',
                'city' => 'Liverpool',
                'stadium' => 'Anfield',
                'founded_year' => 1892,
                'description' => 'Liverpool Football Club is a professional football club based in Liverpool, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Arsenal FC',
                'short_name' => 'ARS',
                'city' => 'London',
                'stadium' => 'Emirates Stadium',
                'founded_year' => 1886,
                'description' => 'Arsenal Football Club is a professional football club based in London, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Chelsea FC',
                'short_name' => 'CHE',
                'city' => 'London',
                'stadium' => 'Stamford Bridge',
                'founded_year' => 1905,
                'description' => 'Chelsea Football Club is a professional football club based in London, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Manchester City',
                'short_name' => 'MCI',
                'city' => 'Manchester',
                'stadium' => 'Etihad Stadium',
                'founded_year' => 1880,
                'description' => 'Manchester City Football Club is a professional football club based in Manchester, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Tottenham Hotspur',
                'short_name' => 'TOT',
                'city' => 'London',
                'stadium' => 'Tottenham Hotspur Stadium',
                'founded_year' => 1882,
                'description' => 'Tottenham Hotspur Football Club is a professional football club based in London, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Newcastle United',
                'short_name' => 'NEW',
                'city' => 'Newcastle upon Tyne',
                'stadium' => 'St. James\' Park',
                'founded_year' => 1892,
                'description' => 'Newcastle United Football Club is a professional football club based in Newcastle upon Tyne, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Aston Villa',
                'short_name' => 'AVL',
                'city' => 'Birmingham',
                'stadium' => 'Villa Park',
                'founded_year' => 1874,
                'description' => 'Aston Villa Football Club is a professional football club based in Birmingham, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'West Ham United',
                'short_name' => 'WHU',
                'city' => 'London',
                'stadium' => 'London Stadium',
                'founded_year' => 1895,
                'description' => 'West Ham United Football Club is a professional football club based in London, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Brighton & Hove Albion',
                'short_name' => 'BHA',
                'city' => 'Brighton and Hove',
                'stadium' => 'Amex Stadium',
                'founded_year' => 1901,
                'description' => 'Brighton & Hove Albion Football Club is a professional football club based in Brighton and Hove, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Wolverhampton Wanderers',
                'short_name' => 'WOL',
                'city' => 'Wolverhampton',
                'stadium' => 'Molineux Stadium',
                'founded_year' => 1877,
                'description' => 'Wolverhampton Wanderers Football Club is a professional football club based in Wolverhampton, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Leicester City',
                'short_name' => 'LEI',
                'city' => 'Leicester',
                'stadium' => 'King Power Stadium',
                'founded_year' => 1884,
                'description' => 'Leicester City Football Club is a professional football club based in Leicester, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Everton FC',
                'short_name' => 'EVE',
                'city' => 'Liverpool',
                'stadium' => 'Goodison Park',
                'founded_year' => 1878,
                'description' => 'Everton Football Club is a professional football club based in Liverpool, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Southampton FC',
                'short_name' => 'SOU',
                'city' => 'Southampton',
                'stadium' => 'St. Mary\'s Stadium',
                'founded_year' => 1885,
                'description' => 'Southampton Football Club is a professional football club based in Southampton, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Crystal Palace',
                'short_name' => 'CRY',
                'city' => 'London',
                'stadium' => 'Selhurst Park',
                'founded_year' => 1905,
                'description' => 'Crystal Palace Football Club is a professional football club based in London, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Leeds United',
                'short_name' => 'LEE',
                'city' => 'Leeds',
                'stadium' => 'Elland Road',
                'founded_year' => 1904,
                'description' => 'Leeds United Football Club is a professional football club based in Leeds, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Burnley FC',
                'short_name' => 'BUR',
                'city' => 'Burnley',
                'stadium' => 'Turf Moor',
                'founded_year' => 1882,
                'description' => 'Burnley Football Club is a professional football club based in Burnley, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Watford FC',
                'short_name' => 'WAT',
                'city' => 'Watford',
                'stadium' => 'Vicarage Road',
                'founded_year' => 1881,
                'description' => 'Watford Football Club is a professional football club based in Watford, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Norwich City',
                'short_name' => 'NOR',
                'city' => 'Norwich',
                'stadium' => 'Carrow Road',
                'founded_year' => 1902,
                'description' => 'Norwich City Football Club is a professional football club based in Norwich, England.',
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Sheffield United',
                'short_name' => 'SHU',
                'city' => 'Sheffield',
                'stadium' => 'Bramall Lane',
                'founded_year' => 1889,
                'description' => 'Sheffield United Football Club is a professional football club based in Sheffield, England.',
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
