<?php

namespace App\Filament\Resources\MatchEvents\Schemas;

use App\Models\Fixture;
use App\Models\Player;
use App\Models\Team;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class MatchEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('match_id')
                    ->label('Match')
                    ->searchable()
                    ->required()
                    ->live()
                    ->getOptionLabelFromRecordUsing(fn (Fixture $record) => $record->homeTeam->name . ' vs ' . $record->awayTeam->name)
                    ->getSearchResultsUsing(function (string $search) {
                        return Fixture::where('status', 'live')
                            ->where(function ($query) use ($search) {
                                $query->whereHas('homeTeam', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                                    ->orWhereHas('awayTeam', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                            })
                            ->with(['homeTeam', 'awayTeam'])
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn ($fixture) => [
                                $fixture->id => $fixture->homeTeam->name . ' vs ' . $fixture->awayTeam->name,
                            ])
                            ->toArray();
                    })
                    ->options(function () {
                        return Fixture::where('status', 'live')
                            ->with(['homeTeam', 'awayTeam'])
                            ->get()
                            ->mapWithKeys(fn ($fixture) => [
                                $fixture->id => $fixture->homeTeam->name . ' vs ' . $fixture->awayTeam->name,
                            ])
                            ->toArray();
                    })
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        // Reset team and player when match changes
                        $set('team_id', null);
                        $set('player_id', null);
                    }),

                Select::make('team_id')
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('player_id', null))
                    ->options(function (Get $get) {
                        $matchId = $get('match_id');
                        if (! $matchId) {
                            return [];
                        }

                        $match = Fixture::find($matchId);
                        if (! $match) {
                            return [];
                        }

                        return Team::whereIn('id', [$match->home_team_id, $match->away_team_id])
                            ->pluck('name', 'id');
                    })
                    ->required(),

                Select::make('player_id')
                    ->searchable()
                    ->options(function (Get $get) {
                        $teamId = $get('team_id');
                        if (! $teamId) {
                            return [];
                        }

                        return Player::where('team_id', $teamId)
                            ->get()
                            ->mapWithKeys(function ($player) {
                                return [$player->id => $player->first_name . ' ' . $player->last_name];
                            });
                    })
                    ->validationAttribute('Player')
                    ->rules([
                        fn (Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                            $teamId = $get('team_id');
                            $playerId = $value;

                            if ($teamId && $playerId) {
                                $player = Player::find($playerId);
                                if ($player && $player->team_id != $teamId) {
                                    $fail('The selected player does not belong to the selected team.');
                                }
                            }
                        },
                    ]),

                Select::make('event_type')
                    ->options([
                        'goal' => 'Goal',
                        'penalty_goal' => 'Penalty Goal',
                        'own_goal' => 'Own Goal',
                        'yellow_card' => 'Yellow Card',
                        'red_card' => 'Red Card',
                        'second_yellow' => 'Second Yellow Card',
                        'substitution' => 'Substitution',
                        'corner' => 'Corner',
                        'offside' => 'Offside',
                        'foul' => 'Foul',
                        'penalty_missed' => 'Penalty Missed',
                        'injury' => 'Injury',
                        'VAR_review' => 'VAR Review',
                    ])
                    ->required()
                    ->live(),

                TextInput::make('minute')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(120)
                    ->required(),

                Select::make('period')
                    ->options([
                        '1H' => 'First Half',
                        'HT' => 'Half Time',
                        '2H' => 'Second Half',
                        'ET' => 'Extra Time',
                        'FT' => 'Full Time',
                        'PENALTIES' => 'Penalties',
                    ])
                    ->required()
                    ->default('1H'),

                KeyValue::make('details')
                    ->keyLabel('Key')
                    ->valueLabel('Value')
                    ->columnSpan('full'),

                Grid::make(2)
                    ->schema([
                        TextInput::make('pitch_position.x')
                            ->label('Pitch Position X')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('pitch_position.y')
                            ->label('Pitch Position Y')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                    ]),

                Grid::make(2)
                    ->schema([
                        TextInput::make('updated_score.home')
                            ->label('Home Score')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('updated_score.away')
                            ->label('Away Score')
                            ->numeric()
                            ->minValue(0),
                    ]),

                TextInput::make('source')
                    ->maxLength(255),

                TextInput::make('created_by')
                    ->maxLength(255),
            ]);
    }
}
