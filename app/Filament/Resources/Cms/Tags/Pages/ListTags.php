<?php

namespace App\Filament\Resources\Cms\Tags\Pages;

use App\Filament\Resources\Cms\Tags\TagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Phosphor::Plus)
                ->iconPosition('after'),
        ];
    }
}
