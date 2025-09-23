<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->required(),
                Select::make('position')
                    ->options([
                        'GK' => 'Goalkeeper',
                        'DEF' => 'Defender',
                        'MID' => 'Midfielder',
                        'FWD' => 'Forward',
                    ])
                    ->required(),
                TextInput::make('shirt_number')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(99)
                    ->required(),
                DatePicker::make('date_of_birth'),
                TextInput::make('nationality')
                    ->maxLength(255),
                TextInput::make('height')
                    ->numeric()
                    ->suffix('cm'),
                TextInput::make('weight')
                    ->numeric()
                    ->suffix('kg'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                FileUpload::make('photo_path')
                    ->image(),
                Toggle::make('is_active')
                    ->default(true),
                Toggle::make('is_injured')
                    ->default(false),
                Toggle::make('is_suspended')
                    ->default(false),
            ]);
    }
}
