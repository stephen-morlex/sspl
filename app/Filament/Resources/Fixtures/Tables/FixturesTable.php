<?php

namespace App\Filament\Resources\Fixtures\Tables;

use App\Enums\FixtureStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class FixturesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('homeTeam.name')
                    ->label('Home Team')
                    ->searchable(),
                TextColumn::make('awayTeam.name')
                    ->label('Away Team')
                    ->searchable(),
                TextColumn::make('league.name')
                    ->label('League')
                    ->searchable(),
                TextColumn::make('kickoff_time')
                    ->dateTime(),
                TextColumn::make('venue'),
                TextColumn::make('home_score'),
                TextColumn::make('away_score'),
                SelectColumn::make('status')
                    ->options(collect(FixtureStatus::cases())->mapWithKeys(fn ($c) => [$c->value => ucfirst($c->value)])->toArray()),
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
            ]);
    }
}
