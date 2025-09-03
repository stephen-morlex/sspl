<?php

namespace App\Filament\Resources\Standings\Schemas;

use Filament\Forms\Components\Select;
use App\Models\Team;
use App\Models\League;
use Filament\Schemas\Schema;

class StandingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->required(),
                Select::make('league_id')
                    ->relationship('league', 'name')
                    ->required(),
                // All statistics fields are calculated dynamically from fixtures
            ]);
    }
}
