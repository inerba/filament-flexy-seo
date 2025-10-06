<?php

namespace App\Filament\Resources\Cms\Articles;

use App\Filament\Resources\Cms\Articles\Pages\CreateArticle;
use App\Filament\Resources\Cms\Articles\Pages\EditArticle;
use App\Filament\Resources\Cms\Articles\Pages\ListArticles;
use App\Filament\Resources\Cms\Articles\Schemas\ArticleForm;
use App\Filament\Resources\Cms\Articles\Tables\ArticlesTable;
use App\Models\Cms\Article;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::ArticleNyTimesDuotone;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Articolo';

    protected static ?string $pluralModelLabel = 'Articoli';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'Contenuti';
    }

    public static function form(Schema $schema): Schema
    {
        return ArticleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArticlesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Personalizza i dettagli mostrati nei risultati della ricerca globale.
     *
     * @return array<string, mixed>
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $data = [
            // @phpstan-ignore property.notFound
            'Autore' => Auth::user()->isAdmin() ? $record->user?->name : null,
            // @phpstan-ignore property.notFound
            'Data di pubblicazione' => $record->published_at?->format('d/m/Y'),
            // @phpstan-ignore property.notFound
            'Categoria' => $record->category?->name,
        ];

        return array_filter($data);
    }

    public static function getGlobalSearchResultActions(Model $record): array
    {
        // Visualizza l'azione solo se l'articolo è pubblicato
        // @phpstan-ignore property.notFound
        if (! $record->is_published) {
            return [];
        }

        // @phpstan-ignore property.notFound
        $link = $record->permalink;

        // remove website url from label
        // $label = str_replace(config('app.url'), '', $link);
        $label = 'Apri sul sito';

        return [
            Action::make('view_permalink')
                ->label($label)
                // ->extraAttributes(['class' => 'line-clamp-1 inline-block'])
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url($link, true),
        ];
    }

    // Eager load relationships to avoid poor performance in global search results
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user', 'category']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit' => EditArticle::route('/{record}/edit'),
        ];
    }
}
