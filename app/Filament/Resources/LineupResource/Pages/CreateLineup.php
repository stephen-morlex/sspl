<?php

namespace App\Filament\Resources\LineupResource\Pages;

use App\Filament\Resources\LineupResource;
use App\Models\Fixture;
use App\Models\Lineup;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLineup extends CreateRecord
{
    protected static string $resource = LineupResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // We don't want to save the form data directly as it contains repeater data
        // Instead, we'll handle the creation in the afterCreate method
        return [];
    }

    protected function afterCreate(): void
    {
        // Get the form data
        $formData = $this->form->getState();

        // Get the fixture
        $fixture = Fixture::find($formData['fixture_id']);
        if (!$fixture) {
            return;
        }

        // Process home team players
        if (isset($formData['home_team_players']) && is_array($formData['home_team_players'])) {
            foreach ($formData['home_team_players'] as $playerData) {
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
        if (isset($formData['away_team_players']) && is_array($formData['away_team_players'])) {
            foreach ($formData['away_team_players'] as $playerData) {
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
    }
}