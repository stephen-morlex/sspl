<?php

namespace App\Filament\Resources\Lineups\Pages;

use App\Filament\Resources\Lineups\LineupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLineups extends ListRecords
{
    protected static string $resource = LineupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
