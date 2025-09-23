<?php

namespace App\Filament\Resources\FixtureCoaches\Pages;

use App\Filament\Resources\FixtureCoaches\FixtureCoachResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFixtureCoach extends CreateRecord
{
    protected static string $resource = FixtureCoachResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
