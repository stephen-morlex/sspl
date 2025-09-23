<?php

namespace App\Filament\Resources\LineupPlayers\Schemas;

use App\Models\Lineup;
use App\Models\Player;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LineupPlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('lineup_id')
                    ->relationship('lineup', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Lineup $record) => $record->team->name . ' - ' . $record->fixture->homeTeam->name . ' vs ' . $record->fixture->awayTeam->name)
                    ->searchable()
                    ->required(),

                Select::make('player_id')
                    ->relationship('player', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn (Player $record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable()
                    ->required(),

                Select::make('role')
                    ->options([
                        'starting' => 'Starting',
                        'bench' => 'Bench',
                    ])
                    ->required(),

                TextInput::make('position_on_pitch')
                    ->maxLength(255),

                TextInput::make('entered_at_minute')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(120),

                TextInput::make('substituted_out_minute')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(120),
            ]);
    }
}
