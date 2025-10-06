<?php

namespace App\Filament\Resources\Cms\Menus\MenuTypeHandlers;

class PlaceholderType implements MenuTypeInterface
{
    public function getName(): string
    {
        return __('menu-manager.handlers.placeholder.name');
    }

    /**
     * @return array<mixed, mixed>
     */
    public static function getFields(): array
    {
        return [];
    }
}
