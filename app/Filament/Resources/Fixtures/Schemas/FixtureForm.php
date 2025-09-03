<?php

namespace App\Filament\Resources\Fixtures\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use App\Models\Team;
use App\Models\League;
use Filament\Schemas\Schema;

class FixtureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('home_team_id')
                    ->relationship('homeTeam', 'name')
                    ->required(),
                Select::make('away_team_id')
                    ->relationship('awayTeam', 'name')
                    ->required(),
                Select::make('league_id')
                    ->relationship('league', 'name')
                    ->required(),
                DateTimePicker::make('kickoff_time')
                    ->required(),
                TextInput::make('venue')
                    ->required()
                    ->maxLength(255),
                TextInput::make('home_score')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('away_score')
                    ->numeric()
                    ->minValue(0),
                Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'live' => 'Live',
                        'finished' => 'Finished',
                        'postponed' => 'Postponed',
                    ])
                    ->required(),
                Textarea::make('match_summary')
                    ->columnSpanFull(),
            ]);
    }
}
