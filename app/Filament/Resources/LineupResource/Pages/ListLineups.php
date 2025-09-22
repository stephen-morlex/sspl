<?php

namespace App\Filament\Resources\LineupResource\Pages;

use App\Filament\Resources\LineupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLineups extends ListRecords
{
    protected static string $resource = LineupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}