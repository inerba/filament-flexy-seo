<?php

namespace App\Filament\Resources\Cms\Categories\Pages;

use App\Filament\Resources\Cms\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected static ?string $title = 'Crea Categoria';

    protected static ?string $breadcrumb = 'Nuova';
}
