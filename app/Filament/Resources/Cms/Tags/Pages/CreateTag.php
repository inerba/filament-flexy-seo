<?php

namespace App\Filament\Resources\Cms\Tags\Pages;

use App\Filament\Resources\Cms\Tags\TagResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;
}
