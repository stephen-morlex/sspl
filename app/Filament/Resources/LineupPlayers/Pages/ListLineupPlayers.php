<?php

namespace App\Filament\Resources\LineupPlayers\Pages;

use App\Filament\Resources\LineupPlayers\LineupPlayerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLineupPlayers extends ListRecords
{
    protected static string $resource = LineupPlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
