<?php

namespace App\Filament\Resources\Cms\Pages;

use App\Filament\Resources\Cms\Pages\Pages\CreatePage;
use App\Filament\Resources\Cms\Pages\Pages\EditPage;
use App\Filament\Resources\Cms\Pages\Pages\ListPages;
use App\Filament\Resources\Cms\Pages\Schemas\PageForm;
use App\Filament\Resources\Cms\Pages\Tables\PagesTable;
use App\Models\Cms\Page;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::FileTextDuotone;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Pagina';

    protected static ?string $pluralModelLabel = 'Pagine';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Contenuti';
    }

    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
