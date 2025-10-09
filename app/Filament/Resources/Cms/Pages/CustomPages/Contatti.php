<?php

namespace App\Filament\Resources\Cms\Pages\CustomPages;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

class Contatti
{
    public static function fields(): array
    {
        return [

            Grid::make(7)
                ->schema([
                    TextInput::make('extras.lat')
                        ->label('Latitudine')
                        ->columnSpan(3)
                        ->required(),
                    TextInput::make('extras.lng')
                        ->label('Longitudine')
                        ->columnSpan(3)
                        ->required(),
                    TextInput::make('extras.map_zoom')
                        ->label('Zoom')
                        ->numeric()
                        ->required()
                        ->default(13),
                ]),
            Grid::make(2)
                ->schema([

                    TextInput::make('extras.address')
                        ->label('Indirizzo')
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('extras.email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    TextInput::make('extras.phone')
                        ->label('Telefono')
                        ->tel()
                        ->required(),
                ]),
        ];
    }
}
