<?php

namespace App\Filament\Resources\BookSeries;

use App\Filament\Resources\BookSeries\Pages\CreateBookSeries;
use App\Filament\Resources\BookSeries\Pages\EditBookSeries;
use App\Filament\Resources\BookSeries\Pages\ListBookSeries;
use App\Filament\Resources\BookSeries\Schemas\BookSeriesForm;
use App\Filament\Resources\BookSeries\Tables\BookSeriesTable;
use App\Models\BookSeries;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class BookSeriesResource extends Resource
{
    protected static ?string $model = BookSeries::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::BooksDuotone;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Collana';

    protected static ?string $pluralModelLabel = 'Collane';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return config('cluster-a.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return BookSeriesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookSeriesTable::configure($table);
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
            'index' => ListBookSeries::route('/'),
            // 'create' => CreateBookSeries::route('/create'),
            // 'edit' => EditBookSeries::route('/{record}/edit'),
        ];
    }
}
