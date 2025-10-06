<?php

namespace App\Filament\Resources\Cms\Menus\Pages;

use App\Filament\Resources\Cms\Menus\MenuResource;
use App\Filament\Resources\Cms\Menus\Widgets\MenuItemsTree;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMenu extends EditRecord
{
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            MenuItemsTree::class,
        ];
    }
}
