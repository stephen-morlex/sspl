<?php

namespace App\Filament\Resources\LineupResource\Pages;

use App\Filament\Resources\LineupResource;
use App\Models\Fixture;
use App\Models\Lineup;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLineup extends EditRecord
{
    protected static string $resource = LineupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing lineup data for the fixture
        $fixture = Fixture::find($data['fixture_id']);
        if (!$fixture) {
            return $data;
        }

        // Get existing lineups for home team
        $homeTeamLineups = Lineup::where('fixture_id', $fixture->id)
            ->where('team_id', $fixture->home_team_id)
            ->get();

        $data['home_team_players'] = $homeTeamLineups->map(function ($lineup) {
            return [
                'player_id' => $lineup->player_id,
                'status' => $lineup->status,
                'position' => $lineup->position,
            ];
        })->toArray();

        // Get existing lineups for away team
        $awayTeamLineups = Lineup::where('fixture_id', $fixture->id)
            ->where('team_id', $fixture->away_team_id)
            ->get();

        $data['away_team_players'] = $awayTeamLineups->map(function ($lineup) {
            return [
                'player_id' => $lineup->player_id,
                'status' => $lineup->status,
                'position' => $lineup->position,
            ];
        })->toArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Get the fixture
        $fixture = Fixture::find($data['fixture_id']);
        if (!$fixture) {
            return $record;
        }

        // Delete existing lineups for this fixture
        Lineup::where('fixture_id', $fixture->id)->delete();

        // Process home team players
        if (isset($data['home_team_players']) && is_array($data['home_team_players'])) {
            foreach ($data['home_team_players'] as $playerData) {
                Lineup::create([
                    'fixture_id' => $fixture->id,
                    'team_id' => $fixture->home_team_id,
                    'player_id' => $playerData['player_id'],
                    'position' => $playerData['position'] ?? null,
                    'is_starting' => $playerData['status'] === 'starting',
                    'status' => $playerData['status'],
                ]);
            }
        }

        // Process away team players
        if (isset($data['away_team_players']) && is_array($data['away_team_players'])) {
            foreach ($data['away_team_players'] as $playerData) {
                Lineup::create([
                    'fixture_id' => $fixture->id,
                    'team_id' => $fixture->away_team_id,
                    'player_id' => $playerData['player_id'],
                    'position' => $playerData['position'] ?? null,
                    'is_starting' => $playerData['status'] === 'starting',
                    'status' => $playerData['status'],
                ]);
            }
        }

        return $record;
    }
}