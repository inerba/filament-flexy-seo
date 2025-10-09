<?php

namespace App\Filament\Resources\BookSeries\Pages;

use App\Filament\Resources\BookSeries\BookSeriesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookSeries extends ListRecords
{
    protected static string $resource = BookSeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
