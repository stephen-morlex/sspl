<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MatchControls extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-play';

    protected string $view = 'filament.pages.match-controls';

    protected static string | \UnitEnum | null $navigationGroup = 'Match Management';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return true; // Adjust based on your authorization logic
    }
}