<?php

namespace App\Filament\Resources\BookSeries\Pages;

use App\Filament\Resources\BookSeries\BookSeriesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookSeries extends EditRecord
{
    protected static string $resource = BookSeriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
