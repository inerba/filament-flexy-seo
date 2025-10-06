<?php

namespace App\Filament\Resources\Cms\Categories;

use App\Filament\Resources\Cms\Categories\Pages\CreateCategory;
use App\Filament\Resources\Cms\Categories\Pages\EditCategory;
use App\Filament\Resources\Cms\Categories\Pages\ListCategories;
use App\Filament\Resources\Cms\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Cms\Categories\Tables\CategoriesTable;
use App\Models\Cms\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::TagDuotone;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Categoria';

    protected static ?string $pluralModelLabel = 'Categorie';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return 'Contenuti';
    }

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
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
            'index' => ListCategories::route('/'),
            // 'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
