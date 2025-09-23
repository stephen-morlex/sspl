<?php

namespace App\Filament\Resources\FixtureCoaches\Pages;

use App\Filament\Resources\FixtureCoaches\FixtureCoachResource;
use Filament\Resources\Pages\EditRecord;

class EditFixtureCoach extends EditRecord
{
    protected static string $resource = FixtureCoachResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
