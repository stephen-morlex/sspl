<?php

namespace App\Filament\Resources\Coaches\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CoachForm
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
                DatePicker::make('date_of_birth'),
                TextInput::make('nationality')
                    ->maxLength(255),
                Textarea::make('bio')
                    ->columnSpanFull(),
                FileUpload::make('photo_path')
                    ->disk('public') // Store in storage/app/public
                    ->directory('coach') // Inside the coach folder
                    ->visibility('public')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->label('Image'),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
