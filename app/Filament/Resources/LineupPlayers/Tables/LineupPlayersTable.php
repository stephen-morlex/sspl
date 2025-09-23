<?php

namespace App\Filament\Resources\LineupPlayers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LineupPlayersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lineup.team.name')
                    ->label('Team')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('player.first_name')
                    ->label('Player')
                    ->formatStateUsing(function ($record) {
                        return $record->player->first_name . ' ' . $record->player->last_name;
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('entered_at_minute')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('substituted_out_minute')
                    ->numeric()
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
