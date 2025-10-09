<?php

namespace App\Filament\Resources\Cms\Articles\Pages;

use App\Filament\Resources\Cms\Articles\ArticleResource;
use App\Models\Cms\Article;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;
use ToneGabes\Filament\Icons\Enums\Phosphor;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Phosphor::Plus)
                ->iconPosition('after'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tutti')
                ->icon(Phosphor::ListBulletsDuotone),
            'published' => Tab::make('Pubblicati')
                ->badgeColor('success')
                ->icon(Phosphor::SealCheckDuotone)
                // ->badge(Article::query()->published()->count() ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->published()),
            'scheduled' => Tab::make('Programmati')
                ->badgeColor('warning')
                ->icon(Phosphor::ClockDuotone)
                ->badge(Article::query()->scheduled()->count() ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->scheduled()),
            'draft' => Tab::make('Bozze')
                ->badgeColor('gray')
                ->icon(Phosphor::FileDashedDuotone)
                ->badge(Article::query()->drafts()->count() ?: null)
                ->modifyQueryUsing(fn (Builder $query) => $query->drafts()),
        ];
    }
}
