<?php

namespace App\Filament\Resources\BookAuthors\Pages;

use App\Filament\Resources\BookAuthors\BookAuthorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookAuthor extends CreateRecord
{
    protected static string $resource = BookAuthorResource::class;
}
