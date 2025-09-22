<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;
use App\Models\Category;
use App\Models\Tag;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('featured_image')
                    ->disk('public') // Store in storage/app/public
                    ->directory('news') // Inside the news folder
                    ->visibility('public')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->label('Featured Image'),
                Toggle::make('is_published')
                    ->default(false),
                DateTimePicker::make('published_at'),
            ]);
    }
}