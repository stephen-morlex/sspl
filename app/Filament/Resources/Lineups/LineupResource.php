<?php

namespace App\Filament\Resources\Lineups;

use App\Filament\Resources\Lineups\Pages\CreateLineup;
use App\Filament\Resources\Lineups\Pages\EditLineup;
use App\Filament\Resources\Lineups\Pages\ListLineups;
use App\Filament\Resources\Lineups\Schemas\LineupForm;
use App\Filament\Resources\Lineups\Tables\LineupsTable;
use App\Models\Lineup;
use App\Models\LineupPlayer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LineupResource extends Resource
{
    protected static ?string $model = Lineup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'formation';

    public static function form(Schema $schema): Schema
    {
        return LineupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LineupsTable::configure($table);
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
            'index' => ListLineups::route('/'),
            'create' => CreateLineup::route('/create'),
            'edit' => EditLineup::route('/{record}/edit'),
        ];
    }

    public static function afterCreate(mixed $record, array $data): void
    {
        static::saveLineupPlayers($record, $data);
    }

    public static function afterEdit(mixed $record, array $data): void
    {
        static::saveLineupPlayers($record, $data);
    }

    protected static function saveLineupPlayers(Lineup $lineup, array $data): void
    {
        // Delete existing lineup players
        $lineup->lineupPlayers()->delete();

        // Save starting players
        if (isset($data['startingPlayers'])) {
            foreach ($data['startingPlayers'] as $startingPlayer) {
                if (isset($startingPlayer['player_id'])) {
                    LineupPlayer::create([
                        'lineup_id' => $lineup->id,
                        'player_id' => $startingPlayer['player_id'],
                        'role' => 'starting',
                    ]);
                }
            }
        }

        // Save bench players
        if (isset($data['benchPlayers'])) {
            foreach ($data['benchPlayers'] as $benchPlayer) {
                if (isset($benchPlayer['player_id'])) {
                    LineupPlayer::create([
                        'lineup_id' => $lineup->id,
                        'player_id' => $benchPlayer['player_id'],
                        'role' => 'bench',
                    ]);
                }
            }
        }
    }
}
