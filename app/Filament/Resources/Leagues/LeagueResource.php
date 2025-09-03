<?php

namespace App\Filament\Resources\Leagues;

use App\Filament\Resources\Leagues\Pages\CreateLeague;
use App\Filament\Resources\Leagues\Pages\EditLeague;
use App\Filament\Resources\Leagues\Pages\ListLeagues;
use App\Filament\Resources\Leagues\Schemas\LeagueForm;
use App\Filament\Resources\Leagues\Tables\LeaguesTable;
use App\Models\League;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LeagueResource extends Resource
{
    protected static ?string $model = League::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LeagueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeaguesTable::configure($table);
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
            'index' => ListLeagues::route('/'),
            'create' => CreateLeague::route('/create'),
            'edit' => EditLeague::route('/{record}/edit'),
        ];
    }
}
