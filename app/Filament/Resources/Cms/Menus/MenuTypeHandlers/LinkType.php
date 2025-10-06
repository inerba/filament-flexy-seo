<?php

namespace App\Filament\Resources\Cms\Menus\MenuTypeHandlers;

use App\Filament\Resources\Cms\Menus\Traits\CommonFieldsTrait;
use Filament\Forms\Components\TextInput;

class LinkType implements MenuTypeInterface
{
    use CommonFieldsTrait;

    public function getName(): string
    {
        return __('menu-manager.handlers.link.name');
    }

    /**
     * Restituisce i campi specifici per il tipo di menu "link".
     *
     * @return array<int, mixed>
     */
    public static function getFields(): array
    {
        return [
            TextInput::make('url')
                ->label('URL')
                ->required()
                ->columnSpanFull(),

            // Includi sempre i campi comuni per i link
            ...self::commonLinkFields(),
        ];
    }
}
