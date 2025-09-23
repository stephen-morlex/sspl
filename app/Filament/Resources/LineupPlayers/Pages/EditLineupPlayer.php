<?php

namespace App\Filament\Resources\LineupPlayers\Pages;

use App\Filament\Resources\LineupPlayers\LineupPlayerResource;
use Filament\Resources\Pages\EditRecord;

class EditLineupPlayer extends EditRecord
{
    protected static string $resource = LineupPlayerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
