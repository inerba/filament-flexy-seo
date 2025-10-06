<?php

namespace App\Filament\Resources\Cms\Tags;

use App\Filament\Resources\Cms\Tags\Pages\CreateTag;
use App\Filament\Resources\Cms\Tags\Pages\EditTag;
use App\Filament\Resources\Cms\Tags\Pages\ListTags;
use App\Filament\Resources\Cms\Tags\Schemas\TagForm;
use App\Filament\Resources\Cms\Tags\Tables\TagsTable;
use App\Models\Cms\Tag;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::TagSimpleDuotone;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Tag';

    protected static ?string $pluralModelLabel = 'Tag';

    protected static ?int $navigationSort = 6;

    public static function getNavigationGroup(): ?string
    {
        return 'Contenuti';
    }

    public static function form(Schema $schema): Schema
    {
        return TagForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagsTable::configure($table);
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
            'index' => ListTags::route('/'),
            // 'create' => CreateTag::route('/create'),
            // 'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
