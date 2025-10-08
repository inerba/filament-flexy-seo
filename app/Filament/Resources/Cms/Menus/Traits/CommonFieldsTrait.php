<?php

namespace App\Filament\Resources\Cms\Menus\Traits;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

trait CommonFieldsTrait
{
    /**
     * Campi comuni per i link.
     *
     * @return array<int, mixed> Un array di componenti dei campi comuni.
     */
    public static function commonLinkFields(): array
    {
        return [
            Section::make(__('menu-manager.common.advanced_settings'))
                ->schema([
                    Select::make('target')
                        ->label('Target')
                        ->options([
                            '' => 'Predefinito',
                            '_blank' => 'Nuova Finestra',
                            '_parent' => 'Genitore',
                            '_top' => 'Inizio',
                        ]),
                    CheckboxList::make('extras.rel')
                        ->columnSpan(1)
                        ->columns(3)
                        ->options([
                            'nofollow' => 'No follow',
                            'noopener' => 'No opener',
                            'noreferrer' => 'No referrer',
                        ]),

                ])
                ->columnSpanFull()
                ->collapsed(),
        ];
    }
}
