<?php

namespace App\Filament\Resources\BookAuthors\Pages;

use App\Filament\Resources\BookAuthors\BookAuthorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookAuthor extends EditRecord
{
    protected static string $resource = BookAuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
