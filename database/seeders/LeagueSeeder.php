<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\League;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = [
            [
                'name' => 'Premier League',
                'country' => 'England',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'The Premier League, often referred to as the English Premier League or the EPL, is the top level of the English football league system.',
                'is_active' => true,
            ],
            [
                'name' => 'La Liga',
                'country' => 'Spain',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'La Liga, officially known as LaLiga Santander for sponsorship reasons, is the top professional association football division of the Spanish football league system.',
                'is_active' => true,
            ],
            [
                'name' => 'Bundesliga',
                'country' => 'Germany',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'The Bundesliga is a professional association football league in Germany.',
                'is_active' => true,
            ],
            [
                'name' => 'Serie A',
                'country' => 'Italy',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'Serie A, officially known as Serie A TIM for sponsorship reasons, is a professional league competition for football clubs located at the top of the Italian football league system.',
                'is_active' => true,
            ],
            [
                'name' => 'Ligue 1',
                'country' => 'France',
                'season_start_year' => 2025,
                'season_end_year' => 2026,
                'description' => 'Ligue 1, officially known as Ligue 1 Uber Eats for sponsorship reasons, is a French professional league for men\'s association football clubs.',
                'is_active' => true,
            ],
        ];

        foreach ($leagues as $league) {
            League::create($league);
        }
    }
}
