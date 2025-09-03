<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'league_id',
    ];

    // Remove all the statistics fields since they'll be calculated dynamically
    protected $appends = [
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
        'position',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    // Accessor to calculate games played dynamically
    public function getPlayedAttribute()
    {
        return $this->calculatePlayed();
    }

    // Accessor to calculate games won dynamically
    public function getWonAttribute()
    {
        return $this->calculateWins();
    }

    // Accessor to calculate games drawn dynamically
    public function getDrawnAttribute()
    {
        return $this->calculateDraws();
    }

    // Accessor to calculate games lost dynamically
    public function getLostAttribute()
    {
        return $this->calculateLosses();
    }

    // Accessor to calculate goals for dynamically
    public function getGoalsForAttribute()
    {
        return $this->calculateGoalsFor();
    }

    // Accessor to calculate goals against dynamically
    public function getGoalsAgainstAttribute()
    {
        return $this->calculateGoalsAgainst();
    }

    // Accessor to calculate goal difference dynamically
    public function getGoalDifferenceAttribute()
    {
        return $this->calculateGoalsFor() - $this->calculateGoalsAgainst();
    }

    // Accessor to calculate points dynamically
    public function getPointsAttribute()
    {
        return ($this->calculateWins() * 3) + $this->calculateDraws();
    }

    // Accessor to calculate the position dynamically
    public function getPositionAttribute()
    {
        // Get all standings in this league ordered by points, goal difference, and goals for
        $standings = self::where('league_id', $this->league_id)->get();

        // Sort standings by the standard football criteria
        $sortedStandings = $standings->sortByDesc(function ($standing) {
            return [
                $standing->points,
                $standing->goal_difference,
                $standing->goals_for,
            ];
        })->values();

        // Find the position of this standing
        foreach ($sortedStandings as $index => $standing) {
            if ($standing->id === $this->id) {
                return $index + 1;
            }
        }

        return count($sortedStandings) + 1;
    }

    // Calculate games played
    private function calculatePlayed()
    {
        // Count finished fixtures where this team played (either home or away)
        return Fixture::where('league_id', $this->league_id)
            ->where('status', 'finished')
            ->where(function ($query) {
                $query->where('home_team_id', $this->team_id)
                    ->orWhere('away_team_id', $this->team_id);
            })
            ->count();
    }

    // Calculate wins
    private function calculateWins()
    {
        // Count wins as home team
        $homeWins = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->where('status', 'finished')
            ->whereColumn('home_score', '>', 'away_score')
            ->count();

        // Count wins as away team
        $awayWins = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->where('status', 'finished')
            ->whereColumn('away_score', '>', 'home_score')
            ->count();

        return $homeWins + $awayWins;
    }

    // Calculate draws
    private function calculateDraws()
    {
        // Count draws as home team
        $homeDraws = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->where('status', 'finished')
            ->whereColumn('home_score', '=', 'away_score')
            ->count();

        // Count draws as away team
        $awayDraws = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->where('status', 'finished')
            ->whereColumn('away_score', '=', 'home_score')
            ->count();

        return $homeDraws + $awayDraws;
    }

    // Calculate losses
    private function calculateLosses()
    {
        // Count losses as home team
        $homeLosses = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->where('status', 'finished')
            ->whereColumn('home_score', '<', 'away_score')
            ->count();

        // Count losses as away team
        $awayLosses = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->where('status', 'finished')
            ->whereColumn('away_score', '<', 'home_score')
            ->count();

        return $homeLosses + $awayLosses;
    }

    // Calculate goals for
    private function calculateGoalsFor()
    {
        // Sum goals scored as home team
        $homeGoals = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->where('status', 'finished')
            ->sum('home_score');

        // Sum goals scored as away team
        $awayGoals = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->where('status', 'finished')
            ->sum('away_score');

        return $homeGoals + $awayGoals;
    }

    // Calculate goals against
    private function calculateGoalsAgainst()
    {
        // Sum goals conceded as home team
        $homeGoals = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->where('status', 'finished')
            ->sum('away_score');

        // Sum goals conceded as away team
        $awayGoals = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->where('status', 'finished')
            ->sum('home_score');

        return $homeGoals + $awayGoals;
    }
}
