<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'league_id',
    ];

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

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function getPlayedAttribute(): int
    {
        return $this->calculatePlayed();
    }

    public function getWonAttribute(): int
    {
        return $this->calculateWins();
    }

    public function getDrawnAttribute(): int
    {
        return $this->calculateDraws();
    }

    public function getLostAttribute(): int
    {
        return $this->calculateLosses();
    }

    public function getGoalsForAttribute(): int
    {
        return $this->calculateGoalsFor();
    }

    public function getGoalsAgainstAttribute(): int
    {
        return $this->calculateGoalsAgainst();
    }

    public function getGoalDifferenceAttribute(): int
    {
        return $this->calculateGoalsFor() - $this->calculateGoalsAgainst();
    }

    public function getPointsAttribute(): int
    {
        return ($this->calculateWins() * 3) + $this->calculateDraws();
    }

    public function getPositionAttribute(): int
    {
        $standings = self::where('league_id', $this->league_id)->get();

        $sortedStandings = $standings->sortByDesc(function ($standing) {
            return [
                $standing->points,
                $standing->goal_difference,
                $standing->goals_for,
            ];
        })->values();

        foreach ($sortedStandings as $index => $standing) {
            if ($standing->id === $this->id) {
                return $index + 1;
            }
        }

        return (int) (count($sortedStandings) + 1);
    }

    private function calculatePlayed(): int
    {
        return Fixture::where('league_id', $this->league_id)
            ->whereIn('status', ['live', 'finished'])
            ->where(function ($query) {
                $query->where('home_team_id', $this->team_id)
                    ->orWhere('away_team_id', $this->team_id);
            })
            ->count();
    }

    private function calculateWins(): int
    {
        $homeWins = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->whereColumn('home_score', '>', 'away_score')
            ->count();

        $awayWins = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->whereColumn('away_score', '>', 'home_score')
            ->count();

        return $homeWins + $awayWins;
    }

    private function calculateDraws(): int
    {
        $homeDraws = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->whereColumn('home_score', '=', 'away_score')
            ->count();

        $awayDraws = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->whereColumn('away_score', '=', 'home_score')
            ->count();

        return $homeDraws + $awayDraws;
    }

    private function calculateLosses(): int
    {
        $homeLosses = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->whereColumn('home_score', '<', 'away_score')
            ->count();

        $awayLosses = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->whereColumn('away_score', '<', 'home_score')
            ->count();

        return $homeLosses + $awayLosses;
    }

    private function calculateGoalsFor(): int
    {
        $homeGoals = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->sum('home_score');

        $awayGoals = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->sum('away_score');

        return (int) ($homeGoals + $awayGoals);
    }

    private function calculateGoalsAgainst(): int
    {
        $homeGoals = Fixture::where('league_id', $this->league_id)
            ->where('home_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->sum('away_score');

        $awayGoals = Fixture::where('league_id', $this->league_id)
            ->where('away_team_id', $this->team_id)
            ->whereIn('status', ['live', 'finished'])
            ->sum('home_score');

        return (int) ($homeGoals + $awayGoals);
    }
}
