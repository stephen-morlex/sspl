<?php

namespace App\Filament\Resources\Lineups\Pages;

use App\Filament\Resources\Lineups\LineupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLineup extends CreateRecord
{
    protected static string $resource = LineupResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
