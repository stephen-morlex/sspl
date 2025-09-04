<?php

namespace App\Filament\Resources\Standings\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class StandingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('position')
                    ->label('Position')
                    ->formatStateUsing(fn ($record) => $record->position),
                TextColumn::make('team.name')
                    ->searchable(),
                    // ->sortable(),
                // TextColumn::make('league.name')
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make('played')
                    ->label('P')
                    ->formatStateUsing(fn ($record) => $record->played),
                TextColumn::make('won')
                    ->label('W')
                    ->formatStateUsing(fn ($record) => $record->won),
                TextColumn::make('drawn')
                    ->label('D')
                    ->formatStateUsing(fn ($record) => $record->drawn),
                TextColumn::make('lost')
                    ->label('L')
                    ->formatStateUsing(fn ($record) => $record->lost),
                TextColumn::make('goals_for')
                    ->label('GF')
                    ->formatStateUsing(fn ($record) => $record->goals_for),
                TextColumn::make('goals_against')
                    ->label('GA')
                    ->formatStateUsing(fn ($record) => $record->goals_against),
                TextColumn::make('goal_difference')
                    ->label('GD')
                    ->formatStateUsing(fn ($record) => $record->goal_difference),
                TextColumn::make('points')
                    ->label('Pts')
                    ->formatStateUsing(fn ($record) => $record->points),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->defaultSort('points', 'desc')
            ;
    }
}