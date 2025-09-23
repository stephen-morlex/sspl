<?php

namespace App\Filament\Resources\FixtureCoaches;

use App\Filament\Resources\FixtureCoaches\Pages\CreateFixtureCoach;
use App\Filament\Resources\FixtureCoaches\Pages\EditFixtureCoach;
use App\Filament\Resources\FixtureCoaches\Pages\ListFixtureCoaches;
use App\Filament\Resources\FixtureCoaches\Schemas\FixtureCoachForm;
use App\Filament\Resources\FixtureCoaches\Tables\FixtureCoachesTable;
use App\Models\FixtureCoach;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FixtureCoachResource extends Resource
{
    protected static ?string $model = FixtureCoach::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    public static function form(Schema $schema): Schema
    {
        return FixtureCoachForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FixtureCoachesTable::configure($table);
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
            'index' => ListFixtureCoaches::route('/'),
            'create' => CreateFixtureCoach::route('/create'),
            'edit' => EditFixtureCoach::route('/{record}/edit'),
        ];
    }
}
