<?php

namespace App\Filament\Resources\LineupPlayers\Pages;

use App\Filament\Resources\LineupPlayers\LineupPlayerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLineupPlayer extends CreateRecord
{
    protected static string $resource = LineupPlayerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
