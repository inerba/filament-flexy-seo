<?php

namespace App\Filament\Resources\BookSeries\Pages;

use App\Filament\Resources\BookSeries\BookSeriesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookSeries extends CreateRecord
{
    protected static string $resource = BookSeriesResource::class;
}
