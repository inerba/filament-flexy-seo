<?php

namespace App\Filament\Resources\Cms\Categories\Pages;

use App\Filament\Resources\Cms\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuova')
                ->icon(Phosphor::Plus)
                ->iconPosition('after'),
        ];
    }
}
