<?php

namespace App\Filament\Resources\Cms\Authors\Pages;

use App\Filament\Resources\Cms\Authors\AuthorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;

    public function makeTable(): Table
    {
        $user = Auth::user();

        // i super admin vedono sempre la tabella dei dealer
        if ($user->isAdmin()) {
            return parent::makeTable();
        }

        if ($user->author()->first() === null) {
            // se l'utente non ha un profilo autore, lo reindirizzo alla creazione
            $page = AuthorResource::getUrl('create');

            redirect($page);
        } else {
            // se l'utente ha un profilo autore, lo reindirizzo alla modifica

            // @phpstan-ignore property.notFound
            $page = AuthorResource::getUrl('edit', ['record' => $user->author()->first()->id]);

            redirect($page);
        }

        return parent::makeTable();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
