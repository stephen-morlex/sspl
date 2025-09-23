<?php

namespace App\Filament\Resources\MatchEvents\Tables;

use App\Filament\Resources\MatchEvents\Pages\EditMatchEvent;
use App\Models\Fixture;
use App\Models\MatchEvent;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;

class MatchEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fixture.homeTeam.name')
                    ->label('Match')
                    ->formatStateUsing(function (MatchEvent $record) {
                        return $record->fixture->homeTeam->name . ' vs ' . $record->fixture->awayTeam->name;
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('player.first_name')
                    ->label('Player')
                    ->formatStateUsing(function (MatchEvent $record) {
                        if ($record->player) {
                            return $record->player->first_name . ' ' . $record->player->last_name;
                        }

                        return 'N/A';
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('event_type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('minute')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('period')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('match_id')
                    ->relationship('fixture', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Fixture $record) => $record->homeTeam->name . ' vs ' . $record->awayTeam->name)
                    ->searchable(),

                SelectFilter::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable(),

                SelectFilter::make('event_type')
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

                SelectFilter::make('period')
                    ->options([
                        '1H' => 'First Half',
                        'HT' => 'Half Time',
                        '2H' => 'Second Half',
                        'ET' => 'Extra Time',
                        'FT' => 'Full Time',
                        'PENALTIES' => 'Penalties',
                    ]),

                Filter::make('minute_range')
                    ->form([
                        TextInput::make('minute_from')
                            ->label('From Minute')
                            ->numeric(),
                        TextInput::make('minute_to')
                            ->label('To Minute')
                            ->numeric(),
                    ])
                    ->query(function (Filter $filter, $query, array $data) {
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
            ->recordActions([
                EditAction::make(),
                Action::make('reprocess')
                    ->label('Reprocess Stats')
                    ->icon('heroicon-o-arrow-path')
                    ->url(fn (MatchEvent $record): string => EditMatchEvent::getUrl(['record' => $record]))
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
}
