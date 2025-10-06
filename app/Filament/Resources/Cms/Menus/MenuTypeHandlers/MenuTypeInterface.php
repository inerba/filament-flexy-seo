<?php

namespace App\Filament\Resources\Cms\Menus\MenuTypeHandlers;

interface MenuTypeInterface
{
    /**
     * Get the name of the menu type.
     */
    public function getName(): string;

    /**
     * @return array<mixed, mixed>
     */
    public static function getFields(): array;
}
