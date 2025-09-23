<?php

namespace App\Filament\Resources\Lineups\Pages;

use App\Filament\Resources\Lineups\LineupResource;
use Filament\Resources\Pages\EditRecord;

class EditLineup extends EditRecord
{
    protected static string $resource = LineupResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lineup = $this->getRecord();

        // Load starting players
        $data['startingPlayers'] = $lineup->startingPlayerDetails->map(function ($lineupPlayer) {
            return [
                'player_id' => $lineupPlayer->player_id,
            ];
        })->toArray();

        // Load bench players
        $data['benchPlayers'] = $lineup->benchPlayerDetails->map(function ($lineupPlayer) {
            return [
                'player_id' => $lineupPlayer->player_id,
            ];
        })->toArray();

        return $data;
    }
}
