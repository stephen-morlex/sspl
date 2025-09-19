<?php

namespace App\Filament\Resources\MatchEvents;

use App\Filament\Resources\MatchEvents\Pages\CreateMatchEvent;
use App\Filament\Resources\MatchEvents\Pages\EditMatchEvent;
use App\Filament\Resources\MatchEvents\Pages\ListMatchEvents;
use App\Models\Fixture;
use App\Models\MatchEvent;
use App\Models\Player;
use App\Models\Team;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;

class MatchEventResource extends Resource
{
    protected static ?string $model = MatchEvent::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->schema([
                Select::make('match_id')
                    ->relationship('fixture', 'id', fn ($query) => $query->where('status', 'live'))
                    ->getOptionLabelFromRecordUsing(fn (Fixture $record) => $record->homeTeam->name . ' vs ' . $record->awayTeam->name)
                    ->searchable()
                    ->required()
                    ->live()
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
                        if (!$matchId) {
                            return [];
                        }

                        $match = Fixture::find($matchId);
                        if (!$match) {
                            return [];
                        }

                        return Team::whereIn('id', [$match->home_team_id, $match->away_team_id])
                            ->pluck('name', 'id');
                    })
                    ->required(),

                Forms\Components\Select::make('player_id')
                    ->searchable()
                    ->options(function (Get $get) {
                        $teamId = $get('team_id');
                        if (!$teamId) {
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

                Forms\Components\Select::make('event_type')
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

                Forms\Components\TextInput::make('minute')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(120)
                    ->required(),

                Forms\Components\Select::make('period')
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

                Forms\Components\KeyValue::make('details')
                    ->keyLabel('Key')
                    ->valueLabel('Value')
                    ->columnSpan('full'),

               Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('pitch_position.x')
                            ->label('Pitch Position X')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('pitch_position.y')
                            ->label('Pitch Position Y')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                    ]),

                Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('updated_score.home')
                            ->label('Home Score')
                            ->numeric()
                            ->minValue(0),
                        Forms\Components\TextInput::make('updated_score.away')
                            ->label('Away Score')
                            ->numeric()
                            ->minValue(0),
                    ]),

                Forms\Components\TextInput::make('source')
                    ->maxLength(255),

                Forms\Components\TextInput::make('created_by')
                    ->maxLength(255),
            ]);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fixture.homeTeam.name')
                    ->label('Match')
                    ->formatStateUsing(function (MatchEvent $record) {
                        return $record->fixture->homeTeam->name . ' vs ' . $record->fixture->awayTeam->name;
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('player.first_name')
                    ->label('Player')
                    ->formatStateUsing(function (MatchEvent $record) {
                        if ($record->player) {
                            return $record->player->first_name . ' ' . $record->player->last_name;
                        }
                        return 'N/A';
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event_type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('minute')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('period')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('match_id')
                    ->relationship('fixture', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Fixture $record) => $record->homeTeam->name . ' vs ' . $record->awayTeam->name)
                    ->searchable(),

                Tables\Filters\SelectFilter::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable(),

                Tables\Filters\SelectFilter::make('event_type')
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
                    ]),

                Tables\Filters\SelectFilter::make('period')
                    ->options([
                        '1H' => 'First Half',
                        'HT' => 'Half Time',
                        '2H' => 'Second Half',
                        'ET' => 'Extra Time',
                        'FT' => 'Full Time',
                        'PENALTIES' => 'Penalties',
                    ]),

                Tables\Filters\Filter::make('minute_range')
                    ->form([
                        Forms\Components\TextInput::make('minute_from')
                            ->label('From Minute')
                            ->numeric(),
                        Forms\Components\TextInput::make('minute_to')
                            ->label('To Minute')
                            ->numeric(),
                    ])
                    ->query(function (Tables\Filters\Filter $filter, $query, array $data) {
                        return $query
                            ->when(
                                $data['minute_from'],
                                fn ($query, $minute) => $query->where('minute', '>=', $minute)
                            )
                            ->when(
                                $data['minute_to'],
                                fn ($query, $minute) => $query->where('minute', '<=', $minute)
                            );
                    }),
            ])
            ->actions([
               EditAction::make(),
               Action::make('reprocess')
                    ->label('Reprocess Stats')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (MatchEvent $record) {
                        // Dispatch job to reprocess stats
                        Artisan::call('queue:work', [
                            '--once' => true,
                        ]);

                        Notification::make()
                            ->title('Stats Reprocessed')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
             BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMatchEvents::route('/'),
            'create' => CreateMatchEvent::route('/create'),
            'edit' => EditMatchEvent::route('/{record}/edit'),
        ];
    }
}