<?php

namespace App\Filament\Resources\FixtureCoaches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FixtureCoachesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fixture.homeTeam.name')
                    ->label('Home Team')
                    ->formatStateUsing(function ($record) {
                        return $record->fixture->homeTeam->name;
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('fixture.awayTeam.name')
                    ->label('Away Team')
                    ->formatStateUsing(function ($record) {
                        return $record->fixture->awayTeam->name;
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('coach.first_name')
                    ->label('Coach')
                    ->formatStateUsing(function ($record) {
                        return $record->coach->first_name . ' ' . $record->coach->last_name;
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
