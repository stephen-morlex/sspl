<?php

namespace App\Filament\Resources\FixtureCoaches\Schemas;

use App\Models\Coach;
use App\Models\Fixture;
use App\Models\Team;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class FixtureCoachForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('fixture_id')
                    ->relationship('fixture', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Fixture $record) => $record->homeTeam->name . ' vs ' . $record->awayTeam->name)
                    ->searchable()
                    ->required(),

                Select::make('coach_id')
                    ->relationship('coach', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn (Coach $record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable()
                    ->required(),

                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->required()
                    ->options(function ($get) {
                        $fixtureId = $get('fixture_id');
                        if (! $fixtureId) {
                            return [];
                        }

                        $fixture = Fixture::find($fixtureId);
                        if (! $fixture) {
                            return [];
                        }

                        return Team::whereIn('id', [$fixture->home_team_id, $fixture->away_team_id])
                            ->pluck('name', 'id');
                    }),
            ]);
    }
}
