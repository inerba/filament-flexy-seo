<?php

namespace App\Filament\Resources\BookAuthors;

use App\Filament\Resources\BookAuthors\Pages\CreateBookAuthor;
use App\Filament\Resources\BookAuthors\Pages\EditBookAuthor;
use App\Filament\Resources\BookAuthors\Pages\ListBookAuthors;
use App\Filament\Resources\BookAuthors\Schemas\BookAuthorForm;
use App\Filament\Resources\BookAuthors\Tables\BookAuthorsTable;
use App\Models\BookAuthor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookAuthorResource extends Resource
{
    protected static ?string $model = BookAuthor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Autore';

    protected static ?string $pluralModelLabel = 'Autori libri';

    protected static ?string $navigationLabel = 'Autori libri';

    public static function getNavigationGroup(): string
    {
        return config('cluster-a.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return BookAuthorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookAuthorsTable::configure($table);
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
            'index' => ListBookAuthors::route('/'),
            'create' => CreateBookAuthor::route('/create'),
            'edit' => EditBookAuthor::route('/{record}/edit'),
        ];
    }
}
