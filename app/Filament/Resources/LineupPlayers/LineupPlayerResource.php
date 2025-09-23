<?php

namespace App\Filament\Resources\LineupPlayers;

use App\Filament\Resources\LineupPlayers\Pages\CreateLineupPlayer;
use App\Filament\Resources\LineupPlayers\Pages\EditLineupPlayer;
use App\Filament\Resources\LineupPlayers\Pages\ListLineupPlayers;
use App\Filament\Resources\LineupPlayers\Schemas\LineupPlayerForm;
use App\Filament\Resources\LineupPlayers\Tables\LineupPlayersTable;
use App\Models\LineupPlayer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LineupPlayerResource extends Resource
{
    protected static ?string $model = LineupPlayer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    public static function form(Schema $schema): Schema
    {
        return LineupPlayerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LineupPlayersTable::configure($table);
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
            'index' => ListLineupPlayers::route('/'),
            'create' => CreateLineupPlayer::route('/create'),
            'edit' => EditLineupPlayer::route('/{record}/edit'),
        ];
    }
}
