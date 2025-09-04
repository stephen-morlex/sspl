<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('short_name')
                    ->maxLength(10),
                FileUpload::make('logo_path')
                    ->image()
                    ->directory('teams')
                    ->disk('public')
                    ->visibility('public'),
                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                TextInput::make('stadium')
                    ->required()
                    ->maxLength(255),
                TextInput::make('founded_year')
                    ->numeric()
                    ->minValue(1800)
                    ->maxValue(date('Y')),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
