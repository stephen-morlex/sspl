<?php

namespace App\Filament\Resources;

use App\Enums\LineupStatus;
use App\Filament\Resources\LineupResource\Pages;
use App\Models\Fixture;
use App\Models\Lineup;
use App\Models\Player;
use App\Models\Team;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LineupResource extends Resource
{
    protected static ?string $model = Lineup::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('fixture_id')
                ->relationship('fixture', 'id')
                ->getOptionLabelFromRecordUsing(fn (Fixture $record) => $record->homeTeam->name . ' vs ' . $record->awayTeam->name)
                ->searchable()
                ->live()
                ->required()
                ->columnSpanFull(),

            Tabs::make('Teams')
                ->tabs([
                    Tab::make('Home Team')
                        ->schema([
                            Select::make('home_team_id')
                                ->label('Home Team')
                                ->options(function (Forms\Get $get) {
                                    $fixtureId = $get('../../fixture_id');
                                    if (!$fixtureId) {
                                        return [];
                                    }
                                    $fixture = Fixture::find($fixtureId);
                                    if (!$fixture) {
                                        return [];
                                    }
                                    return Team::where('id', $fixture->home_team_id)
                                        ->pluck('name', 'id');
                                })
                                ->live()
                                ->disabled(fn (Forms\Get $get) => !$get('../../fixture_id'))
                                ->dehydrated(false)
                                ->columnSpanFull(),

                            Repeater::make('home_team_players')
                                ->label('Home Team Players')
                                ->schema([
                                    Select::make('player_id')
                                        ->options(function (Forms\Get $get) {
                                            $fixtureId = $get('../../../../fixture_id');
                                            if (!$fixtureId) {
                                                return [];
                                            }
                                            $fixture = Fixture::find($fixtureId);
                                            if (!$fixture) {
                                                return [];
                                            }
                                            return Player::where('team_id', $fixture->home_team_id)
                                                ->get()
                                                ->mapWithKeys(fn (Player $player) => [
                                                    $player->id => $player->first_name . ' ' . $player->last_name
                                                ])
                                                ->toArray();
                                        })
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2),

                                    Select::make('status')
                                        ->options(LineupStatus::cases())
                                        ->default('starting')
                                        ->required(),

                                    TextInput::make('position')
                                        ->maxLength(255),
                                ])
                                ->columns(4)
                                ->columnSpanFull()
                                ->collapsible()
                                ->itemLabel(function (array $state): ?string {
                                    $player = Player::find($state['player_id'] ?? null);
                                    return $player ? ($player->first_name . ' ' . $player->last_name) : null;
                                }),
                        ]),

                    Tab::make('Away Team')
                        ->schema([
                            Select::make('away_team_id')
                                ->label('Away Team')
                                ->options(function (Forms\Get $get) {
                                    $fixtureId = $get('../../fixture_id');
                                    if (!$fixtureId) {
                                        return [];
                                    }
                                    $fixture = Fixture::find($fixtureId);
                                    if (!$fixture) {
                                        return [];
                                    }
                                    return Team::where('id', $fixture->away_team_id)
                                        ->pluck('name', 'id');
                                })
                                ->live()
                                ->disabled(fn (Forms\Get $get) => !$get('../../fixture_id'))
                                ->dehydrated(false)
                                ->columnSpanFull(),

                            Repeater::make('away_team_players')
                                ->label('Away Team Players')
                                ->schema([
                                    Select::make('player_id')
                                        ->options(function (Forms\Get $get) {
                                            $fixtureId = $get('../../../../fixture_id');
                                            if (!$fixtureId) {
                                                return [];
                                            }
                                            $fixture = Fixture::find($fixtureId);
                                            if (!$fixture) {
                                                return [];
                                            }
                                            return Player::where('team_id', $fixture->away_team_id)
                                                ->get()
                                                ->mapWithKeys(fn (Player $player) => [
                                                    $player->id => $player->first_name . ' ' . $player->last_name
                                                ])
                                                ->toArray();
                                        })
                                        ->searchable()
                                        ->required()
                                        ->columnSpan(2),

                                    Select::make('status')
                                        ->options(LineupStatus::cases())
                                        ->default('starting')
                                        ->required(),

                                    TextInput::make('position')
                                        ->maxLength(255),
                                ])
                                ->columns(4)
                                ->columnSpanFull()
                                ->collapsible()
                                ->itemLabel(function (array $state): ?string {
                                    $player = Player::find($state['player_id'] ?? null);
                                    return $player ? ($player->first_name . ' ' . $player->last_name) : null;
                                }),
                        ]),
                ])
                ->columnSpanFull()
                ->persistTabInQueryString(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fixture.homeTeam.name')
                    ->label('Match')
                    ->formatStateUsing(function (Lineup $record) {
                        return $record->fixture->homeTeam->name . ' vs ' . $record->fixture->awayTeam->name;
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('player.first_name')
                    ->label('Player')
                    ->formatStateUsing(function (Lineup $record) {
                        return $record->player->first_name . ' ' . $record->player->last_name;
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('position')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_starting')
                    ->boolean(),

                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'starting' => 'success',
                        'substituted' => 'warning',
                        'bench' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('fixture')
                    ->relationship('fixture', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Fixture $record) => $record->homeTeam->name . ' vs ' . $record->awayTeam->name),

                Tables\Filters\SelectFilter::make('team')
                    ->relationship('team', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->options(array_column(LineupStatus::cases(), 'value', 'value')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\FixtureResource\RelationManagers\LineupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLineups::route('/'),
            'create' => Pages\CreateLineup::route('/create'),
            'edit' => Pages\EditLineup::route('/{record}/edit'),
        ];
    }
}