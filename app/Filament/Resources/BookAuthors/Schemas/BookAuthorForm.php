<?php

namespace App\Filament\Resources\BookAuthors\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookAuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()

                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        RichEditor::make('bio')
                            ->label('Biografia')
                            ->required()
                            ->columnSpanFull(),
                    ])->columnSpan(4),

                SpatieMediaLibraryFileUpload::make('avatar')
                    ->collection('avatars')
                    ->hiddenLabel(),

            ]);
    }
}
