<?php

namespace App\Filament\Resources\FixtureCoaches\Pages;

use App\Filament\Resources\FixtureCoaches\FixtureCoachResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFixtureCoaches extends ListRecords
{
    protected static string $resource = FixtureCoachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
