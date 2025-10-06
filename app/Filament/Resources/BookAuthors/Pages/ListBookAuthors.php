<?php

namespace App\Filament\Resources\BookAuthors\Pages;

use App\Filament\Resources\BookAuthors\BookAuthorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBookAuthors extends ListRecords
{
    protected static string $resource = BookAuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
