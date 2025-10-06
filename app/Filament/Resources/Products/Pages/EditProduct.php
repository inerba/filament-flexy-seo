<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     dump($data['price']);
    //     $data['price'] = $data['price'];
    //     dump($data['price']);

    //     return $data;
    // }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
