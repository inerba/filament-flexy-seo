<?php

namespace App\Filament\Resources\Cms\Pages\CustomPages;

use Filament\Forms\Components\TextInput;

class ChiSiamo 
{
    public static function fields(): array
    {
        return [
            TextInput::make('extras.test')
                ->label('Testo extra')
                ->required()
        ];
    }
}
