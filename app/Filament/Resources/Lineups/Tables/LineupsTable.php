<?php

namespace App\Filament\Resources\Lineups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LineupsTable
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

                TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('formation')
                    ->searchable(),

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
