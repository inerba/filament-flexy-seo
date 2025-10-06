<?php

namespace App\Filament\Resources\Cms\Menus\Pages;

use App\Filament\Resources\Cms\Menus\MenuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class ListMenus extends ListRecords
{
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Phosphor::Plus)
                ->iconPosition('after'),
        ];
    }
}
