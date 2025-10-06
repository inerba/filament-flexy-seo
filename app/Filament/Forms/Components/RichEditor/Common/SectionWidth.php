<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components\RichEditor\Common;

use Filament\Forms\Components\Select;

class SectionWidth
{
    public static function make(array $data = []): array
    {
        return [
            Select::make('section_width')
                ->label('larghezza sezione')
                ->options([
                    'max-w-full' => 'Full',
                    'max-w-7xl' => '7XL',
                    'max-w-6xl' => '6XL',
                    'max-w-5xl' => '5XL (larghezza testo)',
                    'max-w-3xl' => '3XL',
                    'max-w-2xl' => '2XL',
                    'max-w-xl' => 'XL',
                    'max-w-lg' => 'LG',
                    'max-w-md' => 'MD',
                    'max-w-sm' => 'SM',
                ])
                ->columnSpanFull(),
        ];
    }
}
