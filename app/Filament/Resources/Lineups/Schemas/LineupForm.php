<?php

namespace App\Filament\Resources\Lineups\Schemas;

use App\Models\Fixture;
use App\Models\Player;
use App\Models\Team;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;

class LineupForm
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
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('team_id', null);
                    }),

                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->required()
                    ->live()
                    ->options(function (Get $get) {
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

                TextInput::make('formation')
                    ->maxLength(255),

                Repeater::make('startingPlayers')
                    ->label('Starting Players')
                    ->relationship('startingPlayerDetails')
                    ->schema([
                        Select::make('player_id')
                            ->relationship('player', 'first_name')
                            ->getOptionLabelFromRecordUsing(fn (Player $record) => $record->first_name . ' ' . $record->last_name . ' (#' . $record->shirt_number . ')')
                            ->searchable()
                            ->required()
                            ->options(function (Get $get) {
                                $teamId = $get('../../team_id');
                                if (! $teamId) {
                                    return [];
                                }

                                return Player::where('team_id', $teamId)
                                    ->where('is_active', true)
                                    ->get()
                                    ->mapWithKeys(function ($player) {
                                        $label = $player->first_name . ' ' . $player->last_name . ' (#' . $player->shirt_number . ')';
                                        if ($player->is_injured) {
                                            $label .= ' - INJURED';
                                        }
                                        if ($player->is_suspended) {
                                            $label .= ' - SUSPENDED';
                                        }

                                        return [$player->id => $label];
                                    });
                            })
                            ->disableOptionWhen(function (Get $get, $value) {
                                $teamId = $get('../../team_id');
                                if (! $teamId) {
                                    return false;
                                }

                                $player = Player::find($value);

                                return $player && ($player->is_injured || $player->is_suspended);
                            }),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => Player::find($state['player_id'])?->first_name . ' ' . Player::find($state['player_id'])?->last_name ?? null),

                Repeater::make('benchPlayers')
                    ->label('Bench Players')
                    ->relationship('benchPlayerDetails')
                    ->schema([
                        Select::make('player_id')
                            ->relationship('player', 'first_name')
                            ->getOptionLabelFromRecordUsing(fn (Player $record) => $record->first_name . ' ' . $record->last_name . ' (#' . $record->shirt_number . ')')
                            ->searchable()
                            ->required()
                            ->options(function (Get $get) {
                                $teamId = $get('../../team_id');
                                if (! $teamId) {
                                    return [];
                                }

                                return Player::where('team_id', $teamId)
                                    ->where('is_active', true)
                                    ->get()
                                    ->mapWithKeys(function ($player) {
                                        $label = $player->first_name . ' ' . $player->last_name . ' (#' . $player->shirt_number . ')';
                                        if ($player->is_injured) {
                                            $label .= ' - INJURED';
                                        }
                                        if ($player->is_suspended) {
                                            $label .= ' - SUSPENDED';
                                        }

                                        return [$player->id => $label];
                                    });
                            }),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => Player::find($state['player_id'])?->first_name . ' ' . Player::find($state['player_id'])?->last_name ?? null),
            ]);
    }
}
