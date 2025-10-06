<?php

namespace App\Filament\Resources\Cms\Authors\Pages;

use App\Filament\Resources\Cms\Authors\AuthorResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = $data['user_id'] ?? auth()->id();

        return $data;
    }

    // solo gli admin e super admin possono creare nuovi autori
    public function canCreateAnother(): bool
    {
        return Auth::user()->isAdmin();
    }
}
