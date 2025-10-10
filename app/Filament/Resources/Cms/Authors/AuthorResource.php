<?php

namespace App\Filament\Resources\Cms\Authors;

use App\Filament\Resources\Cms\Authors\Pages\CreateAuthor;
use App\Filament\Resources\Cms\Authors\Pages\EditAuthor;
use App\Filament\Resources\Cms\Authors\Pages\ListAuthors;
use App\Filament\Resources\Cms\Authors\Schemas\AuthorForm;
use App\Filament\Resources\Cms\Authors\Tables\AuthorsTable;
use App\Models\Cms\Author;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::UserFocusDuotone;

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static ?string $modelLabel = 'Autore';

    protected static ?string $pluralModelLabel = 'Autori articoli';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return 'Contenuti';
    }

    public static function getNavigationLabel(): string
    {
        $user = Auth::user();

        // i super admin vedono sempre la tabella degli autori
        if ($user->isAdmin()) {
            return 'Autori articoli';
        }

        if ($user->author()->first() === null) {
            return 'Crea profilo autore';
        } else {
            return 'Profilo autore';
        }
    }

    public static function form(Schema $schema): Schema
    {
        return AuthorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuthorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthors::route('/'),
            'create' => CreateAuthor::route('/create'),
            'edit' => EditAuthor::route('/{record}/edit'),
        ];
    }
}
